<?php

namespace App\Http\Controllers;

/**
* Editado por Thiago França
* 18/10/2024
*/

// Importações
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
       $edificios = Edificio::paginate(20);

       return view('edificios.index', compact('edificios'), [
           'edificios' =>DB::table('edificios')->orderBy('nome')->get()
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $edificios = DB::table('edificios')->orderBy('nome')->get();
        return view('edificios.create', [
            'edificios' => $edificios
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Para guardar os dados
        $edificio = new edificio();

        $edificio->nome = $request->nome;
        $edificio->morada = $request->morada;
        $edificio->cidade = $request->cidade;
        $edificio->contacto = $request->contacto;
        $edificio->cod_postal = $request->cod_postal;
        $edificio->save();

        return redirect()->route('edificios.index');
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
    public function edit(Edificio $edificio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edificio $edificio)
    {
        //
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
        $edificios = Edificio::where('cidade', 'like', '%' . $nome . '%')->paginate(20);
        return view('edificios.index', ['edificios' => $edificios]);
    }
}
