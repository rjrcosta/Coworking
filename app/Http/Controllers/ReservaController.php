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

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtém os dados paginados das reservas, 20 itens por página
        $reservas = Reserva::with(['user', 'mesa.salaPiso.edificioPiso.edificio'])->paginate(20);

        return view('reservas.index', compact('reservas'));
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
        // Validação dos dados
        $request->validate([
            'cidade_id' => 'required|exists:cidades,id',
            'edificio_id' => 'required|exists:edificios,id',
            'data' => 'required|date',
            'periodo' => 'required|in:manha,tarde,ambos',
        ]);

        // Buscando mesas disponíveis no edifício
        $mesas = Mesa::whereHas('salaPiso.edificioPiso', function ($query) use ($request) {
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

        $reserva->status = 'reserved'; // Status inicial da reserva
        $reserva->save();

        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso! Mesa: ' . $mesaAleatoria->id);
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
}
