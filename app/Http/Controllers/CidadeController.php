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
        'nome.unique' => 'Já existe uma cidade com esse nome.', // Mensagem personalizada
    ]);

    try {
        // Tentativa de criar a cidade
        $cidade = new Cidade();
        $cidade->nome = $request->nome;
        $cidade->save();

        // Redirecionar com mensagem de sucesso
        return redirect()->route('cidades.index')->with('success', 'Cidade criada com sucesso!');
    } catch (QueryException $e) {
        // Captura da exceção de chave única duplicada
        if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
            return redirect()->route('cidades.index')->with('error', 'Cidade já existente! Não foi possível criar a cidade.');
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
        $cidade = Cidade::findOrFail($id);
        $cidade->update($request->all());
        return redirect()->route('cidades.index')->with('success', 'Cidade modificada com sucesso!');
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
