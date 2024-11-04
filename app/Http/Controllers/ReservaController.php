<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reserva;
use App\Models\Cidade;
use App\Models\Edificio;
use App\Models\Mesa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index2()
    // {

    //     // Obtém os dados paginados das reservas, 20 itens por página
    //     $reservas = Reserva::with(['user', 'mesa.salaPiso.edificioPiso.edificio'])->paginate(20);

    //     return view('reservas.index', compact('reservas'));
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                // Obtém os dados paginados das reservas, 20 itens por página
                $reservas = Reserva::with(['user', 'mesa.salaPiso.edificioPiso.edificio'])->paginate(20);
            } else {
                // Usuário comum vê apenas as reservas que ele criou
                $reservas = Reserva::where('user_id', $user->id)->paginate(10);
            }

            return view('reservas.index', compact('reservas'));
        }

        return redirect()->route('login')->with('error', 'É necessário estar autenticado para acessar as reservas.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // toda a lista de objetos cidades
        $cidades = DB::table('cidades')->orderBy('nome')->get();

        $usuarioLogado = Auth::user();

        return view('reservas.create', compact('usuarioLogado'), [
            'cidades' => $cidades,
        ]);
    }

    // Função para buscar edifícios por cidade
    public function buscarEdificiosPorCidade($cidadeId)
    {
        $edificios = Edificio::where('cod_cidade', $cidadeId)->get();
        return response()->json($edificios);
    }

    // Função para calcular a disponibilidade e mostrar na tela
    public function showAvailability(Request $request)
    {
        $edificioId = $request->input('edificio_id');
        $data = Carbon::parse($request->input('data'));
        $periodo = $request->input('periodo');

        Log::info('Verificando disponibilidade', [
            'edificio_id' => $edificioId,
            'data' => $data,
            'periodo' => $periodo
        ]);

        $edificio = Edificio::find($edificioId);

        if (!$edificio) {
            Log::warning('Edifício não encontrado', ['edificio_id' => $edificioId]);
            return response()->json(['error' => 'Edifício não encontrado'], 404);
        }

        try {
            $disponibilidade = $edificio->calcularDisponibilidade($data, $periodo);
            Log::info('Disponibilidade calculada', ['disponibilidade' => $disponibilidade]);
            return response()->json(['disponibilidade' => $disponibilidade]);
        } catch (\Exception $e) {
            Log::error('Erro ao calcular disponibilidade', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao calcular disponibilidade'], 500);
        }
    }


    /**
     * Submit the ew resource to the storage.
     */
    public function store(Request $request)
    {
        
        Log::info('Método store chamado', $request->all()); // Log para ver os dados recebidos

        // Validação dos dados
        // $request->validate([
        //     'cidade_id' => 'required|exists:cidades,id',
        //     'edificio_id' => 'required|exists:edificios,id',
        //     'data' => 'required|date',
        //     'periodo' => 'required|in:manha,tarde,ambos',
        //     'user_id' => 'required',
        // ]);

        // Buscando mesas disponíveis no edifício com status 'Livre'
        $mesas = Mesa::where('status', 'Livre') // Filtra mesas com status 'Livre'
            ->whereHas('salaPiso.edificioPiso', function ($query) use ($request) {
                $query->where('cod_edificio', $request->input('edificio_id'));
            })->get();

        // Verificar se há mesas disponíveis
        if ($mesas->isEmpty()) {
            return redirect()->back()->with('error', 'Não há mesas disponíveis para o edifício selecionado.')->withInput();
        }

        // Seleciona uma mesa aleatoriamente
        $mesaAleatoria = $mesas->random();

        // Criação da nova reserva
        $reserva = new Reserva();
        $reserva->user_id = Auth::id(); // ID do usuário logado
        $reserva->cod_mesa = $mesaAleatoria->id; // ID da mesa aleatória
        $reserva->date = $request->input('data'); // Adicione esta linha

        // Definindo horário com base no período selecionado
        if ($request->periodo == 'manha') {
            $reserva->horario_inicio = $request->input('data') . ' 08:00:00';
            $reserva->horario_fim = $request->input('data') . ' 12:00:00';
        } elseif ($request->periodo == 'tarde') {
            $reserva->horario_inicio = $request->input('data') . ' 14:00:00';
            $reserva->horario_fim = $request->input('data') . ' 18:00:00';
        } elseif ($request->periodo == 'ambos') {
            $reserva->horario_inicio = $request->input('data') . ' 08:00:00';
            $reserva->horario_fim = $request->input('data') . ' 18:00:00';
        }

        $reserva->status = 'Reservado'; // Status inicial da reserva
        $reserva->save();

        // Atualiza o status da mesa para 'Ocupada'
        $mesaAleatoria->status = 'Ocupada';
        $mesaAleatoria->save();

        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso! Mesa: ' . $mesaAleatoria->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Encontra a reserva pelo ID
        $reserva = Reserva::findOrFail($id);

        // Encontra a mesa associada à reserva
        $mesa = Mesa::findOrFail($reserva->cod_mesa);

        // Recupera a sala associada à mesa
        $sala = $mesa->sala;

        // Retorna a view com os dados da reserva e da sala
        return view('reservas.show', [
            'reserva' => $reserva, // Já está armazenada em $reserva
            'sala' => $sala,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('reservas.edit', [
            'reservas' => Reserva::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação para garantir que o nome não esteja em branco
        $validatedData = $request->validate([
            'date' => 'required',
        ]);

        try {
            // Encontra a reserva e faz a atualização
            $reserva = Reserva::findOrFail($id);
            $reserva->update($request->all()); // Atualiza com todos os dados do request, inclusive os validados

            // Redireciona com sucesso
            return redirect()->route('reservas.index')->with('success', 'Reserva modificada com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
                return redirect()->route('reservas.index')->with('error', 'Reserva a faltar dados! Não foi possível modificar a reserva.');
            }

            // Se for outro erro, lança a exceção
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
        $reserva->delete();
        return redirect()->route('reserva.index')->with('sucesso', 'reserva eliminada com sucesso');
    }

    // Função para filtrar reservas pela localidade
    public function filtrar(Request $request)
    {
        $nome = $request->input('pesquisa');

        // Obtenha as cidades que correspondem ao nome de pesquisa
        $cidades = Cidade::where('nome', 'like', '%' . $nome . '%')->pluck('id');

        // Filtre as reservas baseando-se nas cidades
        $reservas = Reserva::whereHas('edificio.cidade', function ($query) use ($cidades) {
            $query->whereIn('id', $cidades);
        })->paginate(20);

        return view('reservas.index', ['reservas' => $reservas]);
    }

    // ****************** Fazer as reservas funcionarem no modal ********************

    // Função para buscar as cidades
    public function buscarCidades()
    {
        // Retorna json para a modal
        return response()->json(Cidade::all());
    }
}
