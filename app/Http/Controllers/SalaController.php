<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Edificio;
use App\Models\Cidade;
use App\Models\Piso;
use App\Models\EdificioPiso;
use App\Models\SalaPiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtém os dados paginados das salas, 10 itens por página
        $salas = Sala::with('cidadeNome')->paginate(20);
        //dd($salas);

        return view('salas.index', compact('salas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // toda a lista de objetos cidades
        $cidades = DB::table('cidades')->orderBy('nome')->get();

        return view('salas.create', compact('cidades'));
    }

    // Rota para buscar os pisos de um determinado edifício (usado na criação de uma sala)
    public function buscarPisosPorEdificio($edificioId)
    {
        // Certifique-se de que o relacionamento entre Edificio e Piso está correto
        $pisos = Piso::whereHas('edificioPisos', function ($query) use ($edificioId) {
            $query->where('cod_edificio', $edificioId);
        })->get();

        return response()->json($pisos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'lotacao' => 'required|integer',
            'edificio_id' => 'required|exists:edificios,id',
            'cidade_id' => 'required|exists:cidades,id',
        ]);

        try {

            // Tentativa de update o edifício
            // Atualizar o edifício com a cidade selecionada
            $edificio = Edificio::findOrFail($request->edificio_id);
            $edificio->cod_cidade = $request->cidade_id;
            $edificio->save();

            // Tentativa de criar a sala
            $sala = Sala::create([
                'nome' => $request->nome,
                'lotacao' => $request->lotacao,
                'edificio_id' => $edificio->id
            ]);

            // Associar a sala ao edificio_piso
            $edificioPiso = EdificioPiso::where('cod_edificio', $request->edificio_id)
                ->where('cod_piso', $request->piso_id)
                ->first();

            if ($edificioPiso) {
                $salaPiso = new SalaPiso([
                    'cod_sala' => $sala->id,
                    'cod_edificio_piso' => $edificioPiso->id,
                    // Outros campos necessários...
                ]);
                $salaPiso->save();
            }



            // Redirecionar com mensagem de sucesso
            return redirect()->route('salas.index')->with('success', 'Sala criada com sucesso!');
        } catch (QueryException $e) {
            // Captura da exceção de chave única duplicada
            if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
                return redirect()->route('salas.index')->with('error', 'Sala já existente! Não foi possível criar a sala.');
            }
            // Se for outro erro, lança a exceção
            throw $e;
        }
    }
   

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $salas = Sala::findOrFail($id);

        return view('salas.show', compact('salas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('salas.edit', [
            'salas' => Sala::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação para garantir que o nome não esteja em branco
        $validatedData = $request->validate([
            'nome' => 'required|max:255|',
        ]);

        try {
            // Encontra a sala e faz a atualização
            $sala = Sala::findOrFail($id);
            $sala->update($request->all()); // Atualiza com todos os dados do request, inclusive os validados

            // Redireciona com sucesso
            return redirect()->route('salas.index')->with('success', 'Sala modificada com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
                return redirect()->route('salas.index')->with('error', 'Sala em brando! Não foi possível modificar a sala.');
            }

            // Se for outro erro, lança a exceção
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sala $sala)
    {
        $sala->delete();
        return redirect()->route('salas.index')->with('sucesso', 'sala eliminada com sucesso');
    }

    public function filtrar(Request $request)
    {
        $salas = Sala::where('lotacao', 'like', '%' . $request->pesquisa . '%')->paginate(20);
        return view('salas.index', compact('salas'));
    }
}
