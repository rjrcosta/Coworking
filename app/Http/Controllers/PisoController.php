<?php

namespace App\Http\Controllers;

use App\Models\Piso;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pisos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([

            'numero'=> 'required|numeric'
        ]);

        $piso= new Piso();
        $piso->numero=$request->input('numero');
        // criação do piso
        $piso->save();
        // redireciona para uma pagina de sucesso
        return redirect()->route('pisos.index')->with('successo', 'Piso criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Piso $piso)
    {
        //
        return view('pisos.show',compact('piso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piso $piso)
    {
        //
        return view ('pisos.edit',compact('piso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piso $piso)
    {
        //
        $request->validate([

            'numero'=> 'required|numeric'
        ]);

        $piso= new Piso();
        $piso->numero=$request->input('numero');
        // criação do piso
        $piso->save();
        // redireciona para uma pagina de sucesso
        return redirect()->route('pisos.index')->with('successo', 'Piso atualizado com sucesso');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piso $piso)
    {
        //
        $piso->delete();
        return redirect()->route('pisos.index')->with('sucesso','piso eliminado com sucesso');
    }
}
