<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém os dados paginados das cidades, 10 itens por página
        $cidades = Cidade::paginate(10);

        return view('cidades.index', compact('cidades'), [
            'cidades' => DB::table('cidades')->orderBy('nome')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação do nome da cidade
        $request->validate([
            'nome' => 'required|string|max:255|unique:cidades,nome',
        ], [
            'nome.unique' => 'Já existe uma cidade com esse nome.',
        ]);

        try {
            // Criação da cidade
            $cidade = new Cidade();
            $cidade->nome = $request->nome;
            $cidade->save();

            // Retorna a resposta JSON ao invés de redirecionar
            return response()->json([
                'success' => true, 
                'message' => 'Cidade criada com sucesso!'
                
            ], 200);

          


        } catch (QueryException $e) {
            // Tratamento de exceção de chave duplicada
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Cidade já existente!'], 409); // Código 409: Conflito
            }

            // Lançar exceção para outros erros
            return response()->json(['success' => false, 'message' => 'Erro ao criar a cidade.'], 500);
        }
    }

    public function direct_store(Request $request)
    {
        // Validação do nome da cidade
        $request->validate([
            'nome' => 'required|string|max:255|unique:cidades,nome',
        ], [
            'nome.unique' => 'Já existe uma cidade com esse nome.',
        ]);

        try {
            // Criação da cidade
            $cidade = new Cidade();
            $cidade->nome = $request->nome;
            $cidade->save();

            // Retorna a resposta JSON ao invés de redirecionar
            return redirect()->route('cidades.index')->with('success', 'Cidade criada com sucesso!');
        } catch (QueryException $e) {
            // Tratamento de exceção de chave duplicada
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Cidade já existente!'], 409); // Código 409: Conflito
            }

            // Retorno da função
            return redirect()->route('cidades.index')->with('success', 'Cidade criada com sucesso!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('cidades.show', [
            'cidades' => Cidade::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('cidades.edit', [
            'cidades' => Cidade::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação para garantir que o nome seja único, exceto para a cidade atual
        $validatedData = $request->validate([
            'nome' => 'required|unique:cidades,nome,' . $id,
        ]);

        try {
            // Encontra a cidade e faz a atualização
            $cidade = Cidade::findOrFail($id);
            $cidade->update($validatedData);

            // Redireciona com sucesso
            return redirect()->route('cidades.index')->with('success', 'Cidade modificada com sucesso!');
        } catch (\Exception $e) {
            // Captura qualquer erro, incluindo violação de integridade
            return redirect()->route('cidades.index')->with('error', 'Erro ao modificar a cidade. O nome já existe.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cidade::findOrFail($id)->delete();
        return redirect()->route('cidades.index')->with('success', 'Cidade e edifícios associados foram apagados!');
    }

    //Função para filtrar edifícios pela localidade 
    public function filtrar(Request $request)
    {
        $nome = $request->input('pesquisa');

        $cidades = Cidade::where('nome', 'like', '%' . $nome . '%')->paginate(20);
        return view('cidades.index', ['cidades' => $cidades]);
    }
}
