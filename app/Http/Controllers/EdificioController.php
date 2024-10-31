<?php

namespace App\Http\Controllers;

/**
 * Editado por Thiago França
 * 18/10/2024
 */

// Importações

use App\Models\Cidade;
use Illuminate\Support\Facades\DB;
use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtém os dados paginados dos edifícios, 20 itens por página
        $edificios = Edificio::paginate(10);

        return view('edificios.index', compact('edificios'), [
            'edificios' => DB::table('edificios')->orderBy('nome')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // toda a lista de edifícios
        $edificios = DB::table('edificios')->orderBy('nome')->get();

        // toda a lista de objetos cidades
        $cidades = DB::table('cidades')->orderBy('nome')->get();

        return view('edificios.create', [
            'edificios' => $edificios,
            'cidades' => $cidades,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        // Validação dos campos
        $request->validate([
            'nome' => 'required|string|max:255',
            'morada' => 'required|string|max:255',
            'contacto' => 'required|string|max:15',
            'cod_postal' => 'required|string|max:10',
            'lat' => 'required|string|max:15',
            'lng' => 'required|string|max:15',
            'cod_cidade' => 'required|not_in:Selecione',  // Aqui você valida que a cidade foi selecionada
        ], [
            'cod_cidade.not_in' => 'Por favor, selecione uma cidade válida.',  // Mensagem personalizada
        ]);

        // Se a validação passar, cria um novo edifício
        $edificio = new Edificio();
        $edificio->nome = $request->nome;
        $edificio->morada = $request->morada;
        $edificio->contacto = $request->contacto;
        $edificio->cod_postal = $request->cod_postal;
        $edificio->lat = $request->lat;
        $edificio->lng = $request->lng;
        $edificio->cod_cidade = $request->cod_cidade;  // Salva o código da cidade selecionada
        $edificio->save();

        return redirect()->route('edificios.index')->with('success', 'Edifício criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('edificios.show', [
            'edificios' => Edificio::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //dd($id);
        // buscar edificio pelo id
        $edificio = edificio::findOrFail($id);
        // buscar o respectivo objeto cidade
        $cidade = Cidade::findOrFail($edificio->cod_cidade);
        // toda a lista de objetos cidades
        $cidades = DB::table('cidades')->orderBy('nome')->get();

        return view('edificios.edit', [
            'edificio' => $edificio,
            'cidade' => $cidade,
            'cidades' => $cidades,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $edificio = Edificio::findOrFail($id);
        $edificio->update($request->all());
        return redirect()->route('edificios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Edificio::findOrFail($id)->delete();
        return redirect()->route('edificios.index');
    }


    //Função para filtrar edifícios pela localidade 
    public function filtrar(Request $request)
    {
        $nome = $request->input('pesquisa');

        $cidades = Cidade::where('nome', 'like', '%' . $nome . '%')->pluck('id');
        $edificios = Edificio::whereIn('cod_cidade', $cidades)->paginate(20);
        return view('edificios.index', ['edificios' => $edificios]);
    }

}
