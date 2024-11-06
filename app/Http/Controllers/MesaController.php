<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\EdificioPiso;
use Database\Factories\EdificioFactory;
use App\Models\Edificio;
use App\Models\Piso;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Sala;
use App\Models\SalaPiso;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mesas = Mesa::paginate(10);
        return view('mesa.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    //     $salas = Sala::all(); // Obter todas as salas

    //     return view('mesa.create', compact('salas'));
    // }
    public function  create()
    {
        // toda a lista de objetos cidades
        $cidades = DB::table('cidades')->orderBy('nome')->get();
        //  $edificiopiso = DB::table('edificio_piso');

        return view('mesa.create', compact('cidades'));
    }


    public function store(Request $request)
    {
        // // Validação dos dados de entrada
        // $validated = $request->validate([
        //     'cidade_id' => 'required|exists:cidades,id',
        //     'edificio_id' => 'required|exists:edificios,id',
        //     'sala_id' => 'required|exists:salas,id',
        // ]);


        $salaId = $request->sala_id;
        $edificioId = $request->edificio_id;
        $cidadeId = $request->cidade_id;

        // Criação da nova mesa
        $salaPiso = SalaPiso::where('cod_sala', $salaId)
            ->whereHas('edificioPiso', function ($query) use ($edificioId) {
                $query->where('cod_edificio', $edificioId);
            })
            ->whereHas('edificioPiso.edificio', function ($query) use ($cidadeId) {
                $query->where('cod_cidade', $cidadeId);
            })
            ->first(); // Use first() para obter o primeiro resultado

        $mesa = new Mesa();
        $mesa->status = 'livre'; // Status inicial
        $mesa->cod_sala_piso = $salaPiso->id; // Acesse o id da salaPiso corretamente
        //$mesa->qrcode = 'qrtest';
        $mesa->save();

        // Gera o QR Code e salva o caminho na mesa
        $mesa->qrcode = $this->gerarQrCode($mesa->id);
        $mesa->save();

        // Atualizar a lotação da sala correspondente
        // Atualizar a lotação da sala correspondente
        $salaModel = \App\Models\Sala::find($salaId);
        if ($salaModel) {
            $salaModel->lotacao += 1; // Incrementa a lotação em 1
            $salaModel->save();
        }

        return redirect()->route('mesa.index')->with('success', 'Mesa criada com sucesso.');
    }



    // Método para gerar QR Code
    private function gerarQrCode($mesaId)
    {
        // Define o caminho onde o QR Code será salvo
        $qrcodePath = 'qrcodes/' . $mesaId . '.svg';

        // Gera o QR Code e salva na pasta pública
        QrCode::format('svg')->size(150)->generate(url("/checkin/{$mesaId}"), public_path($qrcodePath));

        // Retorna o caminho do QR Code para ser salvo no banco de dados
        return $qrcodePath;
    }



    // Função para check-in
    public function checkIn($id)
    {
        $user = Auth::user();

        $mesa = Mesa::findOrFail($id);

        //dd('mesa',$mesa);
        //dd('mesaID',$mesa->id);
        //dd('user', $user);
        //dd('userID', $user->id);



        //  Verificar se há uma reserva ativa para esta mesa e para este usuário
        $reserva = Reserva::where('cod_mesa', $mesa->id)
            ->where('user_id', $user->id)
            ->where('status', 'Reservado')
            ->first();


        //dd('Reserva', $reserva);

        if ($reserva) {
            // Verificar se o check-in é feito até 15 minutos após o início da reserva
            $checkInDeadline = Carbon::createFromTimeString($reserva->horario_inicio)->addMinutes(15);

            if (now()->lessThanOrEqualTo($checkInDeadline)) {
                //dd('Entrou no tempo');
                //$reserva->status = 'checked-in';
                $reserva->check_in_time = now();
                $reserva->save();

                return redirect()->route('mesa.sucesso', ['reserva' => $reserva])->with('success', 'Check-in efetuado com sucesso!');
            } else {
                //dd('Fora do tempo', $checkInDeadline);
                return redirect()->route('mesa.falha')->with('error', 'Check-in expirado.');
            }
        } else {
            //dd('Nenhuma reserva ativa');
            return redirect()->route('mesa.falha')->with('error', 'Nenhuma reserva ativa encontrada para esta mesa.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $mesa = Mesa::findOrFail($id);
        $salaPiso = SalaPiso::findOrFail($mesa->cod_sala_piso);
        $edificioPiso = EdificioPiso::findOrFail($salaPiso->cod_edificio_piso);
        $piso = Piso::findOrFail($edificioPiso->cod_piso);
        $edificio = Edificio::findOrFail($edificioPiso->cod_edificio);
        $cidade = Cidade::findOrFail($edificio->cod_cidade);
        $sala = $mesa->sala;
        // $edificio = $mesa->edificio; // Acessando o edifício
        // dd($mesa);
        return view('mesa.show', [
            'mesa' => $mesa,
            'sala' => $sala,
            'piso' => $piso,
            'edificio' => $edificio, // Passando o edifício para a view
            'cidade' => $cidade,
        ]);
    }

    public function destroy(Mesa $mesa)
    {
        // Carregar o objeto SalaPiso associado usando a relação
        $salaPiso = $mesa->salaPiso;  // Certifique-se de que a relação está definida corretamente no modelo Mesa
        if ($salaPiso) {
            $salaId = $salaPiso->cod_sala;  // Acessar o campo cod_sala de SalaPiso

            // Atualize a lotação da sala correspondente
            $salaModel = \App\Models\Sala::find($salaId);
            if ($salaModel) {
                $salaModel->lotacao -= 1; // Decrementa a lotação
                $salaModel->save();
            }
        }

        // Remove a mesa
        $mesa->delete();

        // Redireciona com sucesso
        return redirect()->route('mesa.index')->with('success', 'Mesa removida com sucesso.');
    }


    // Buscar edifícios de uma cidade específica
    public function getEdificios($cidade_id)
    {
        // Obtemos os edifícios com base na cidade
        $edificios = Edificio::whereHas('cidade', function ($query) use ($cidade_id) {
            $query->where('id', $cidade_id);
        })->get();

        return response()->json($edificios);
    }

    // Buscar pisos de um edifício específico
    public function getPisos($edificio_id)
    {
        // Obtemos os pisos de acordo com o edifício
        $pisos = EdificioPiso::where('cod_edificio', $edificio_id)->get();

        return response()->json($pisos);
        dd($pisos);
    }

    // Buscar salas de um piso específico
    public function getSalas($piso_id)
    {

        // Obtemos as salas associadas ao piso
        $salas = SalaPiso::where('cod_edificio_piso', $piso_id)
            ->with('sala')
            ->get()
            ->pluck('sala');  // Extrai apenas as salas relacionadas

        return response()->json($salas);
    }

    // Método no controlador
    public function devolverSalaPiso(Request $request)
    {
        $codPiso = $request->input('cod_piso');
        $codEdificio = $request->input('cod_edificio');

        // Buscar o registro único na tabela edificio_piso
        $edificio_piso = EdificioPiso::where('cod_piso', $codPiso)
            ->where('cod_edificio', $codEdificio)
            ->first(); // Usar first() para obter um único resultado

        if ($edificio_piso) {
            // Buscar as salas associadas ao edificio_piso encontrado
            $salasPiso = SalaPiso::where('cod_edificio_piso', $edificio_piso->id)
                ->with('sala') // Carrega o relacionamento com a tabela salas
                ->get();

            // Mapeia as salas para retornar apenas os nomes
            $salas = $salasPiso->map(function ($salaPiso) {
                return [
                    'id' => $salaPiso->sala->id,
                    'nome' => $salaPiso->sala->nome
                ];
            });
        } else {
            $salas = collect(); // Retorna uma coleção vazia se não houver resultados
        }

        // Retorna as salas como resposta JSON
        return response()->json($salas);
    }

    // Função para mostrar reservas success
    public function sucesso(Reserva $reserva)
    {
      dd($reserva->status);
        $reserva->update(['status' => 'Feito checked-in']);
        return view('mesa.sucesso');
    }

    // Função para mostrar reservas failed
    public function falha()
    {

        return view('mesa.falha');
    }
}
