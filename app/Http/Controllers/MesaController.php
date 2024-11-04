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
    public function  create(){
         // toda a lista de objetos cidades
         $cidades = DB::table('cidades')->orderBy('nome')->get();
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
    $mesa->qrcode='qrtest';
     $mesa->save();

     // Gera o QR Code e salva o caminho na mesa
     $mesa->qrcode = $this->gerarQrCode($mesa->id);
     $mesa->save();
    

    // Atualizar a lotação da sala correspondente
    $salaModel = \App\Models\Sala::find($salaId); // Use o valor de $salaId em vez de 'sala_id'
    if ($salaModel) {
        $salaModel->lotacao += 1; // Aumenta a lotação em 1
        $salaModel->save(); // Salva as alterações na sala
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
    public function checkIn(Request $request, $mesaId)
    {
        $user = Auth::user();


        $mesa = Mesa::findOrFail($mesaId);

        //  Verificar se há uma reserva ativa para esta mesa e para este usuário
        $reserva = Reserva::where('mesa_id', $mesaId)
            ->where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString()) // Ajuste para o campo correto
            ->where('status', 'reserved')
            ->first();

        if ($reserva) {
            // Verificar se o check-in é feito até 15 minutos após o início da reserva
            $checkInDeadline = Carbon::createFromTimeString($reserva->horario_inicio)->addMinutes(15);

            if (now()->lessThanOrEqualTo($checkInDeadline)) {
                $reserva->status = 'checked-in';
                $reserva->check_in_time = now();
                $reserva->save();

                return redirect()->route('reserva.success')->with('success', 'Check-in efetuado com sucesso!');
            } else {
                return redirect()->route('reserva.failed')->with('error', 'Check-in expirado.');
            }
        } else {
            return redirect()->route('reserva.failed')->with('error', 'Nenhuma reserva ativa encontrada para esta mesa.');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        
    $mesa = Mesa::findOrFail($id);
    $salaPiso=SalaPiso::findOrFail($mesa->cod_sala_piso);
    $edificioPiso=EdificioPiso::findOrFail($salaPiso->cod_edificio_piso);
    $piso=Piso::findOrFail($edificioPiso->cod_piso);
    $edificio=Edificio::findOrFail($edificioPiso->cod_edificio);
    $cidade=Cidade::findOrFail($edificio->cod_cidade);
    $sala = $mesa->sala;
    // $edificio = $mesa->edificio; // Acessando o edifício
// dd($mesa);
    return view('mesa.show', [
        'mesa'=>$mesa,
        'sala' => $sala,
        'piso'=>$piso,
        'edificio' => $edificio, // Passando o edifício para a view
        'cidade'=>$cidade,
    ]);
   
    }
    // //     // Obter a sala correspondente à mesa


    //     $sala = $mesa->sala; // SalaPiso que contém a sala e o piso
    //     // $sala = $salaPiso->sala; // A sala que a mesa está
    //     $piso = $sala->edificioPiso->piso; // O piso relacionado ao SalaPiso
    //     $edificio = $sala->edificioPiso->edificio; // O edifício relacionado ao SalaPiso
    //     $cidade = $edificio->cidade; // A cidade relacionada ao Edificio
      
    //     return view('mesa.show', compact('mesa', 'sala', 'piso', 'edificio', 'cidade'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        //
        // Verifique se a mesa existe
        if (!$mesa) {
            return redirect()->route('mesa.index')->with('error', 'Mesa não encontrada.');
        }

        // Antes de remover a mesa, atualize a lotação da sala
        $sala = \App\Models\Sala::find($mesa->cod_sala_piso);
        if ($sala) {
            $sala->lotacao -= 1; // Diminui a lotação em 1
            $sala->save(); // Salva as alterações na sala
        }

        // Remove a mesa
        $mesa->delete();

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
        $salas = SalaPiso::where('id', $piso_id)
            ->with('sala')
            ->get()
            ->pluck('sala');  // Extrai apenas as salas relacionadas

        return response()->json($salas);
    }

}
