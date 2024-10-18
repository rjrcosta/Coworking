<?php

namespace App\Http\Controllers;

use App\Models\Salas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalasController extends Controller
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
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nome' => 'required',
            'lotacao'=>'required|integer',
        ]);

        Salas::create($request->all());
        return redirect()->route('salas.index')->with('sucesso','Sala criada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salas $salas)
    {
        //
        return view('salas.show',compact('sala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salas $salas)
    {
        //
        return view('salas.edit',compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salas $salas)
    {
        //
        $request->validate([
            'nome' => 'required',
            'lotacao'=>'required|integer',

        ]);
        $salas->update($request->all());
        return redirect()->route('salas.index')->with('sucesso','sala atualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salas $salas)
    {
        //
        $salas->delete();
        return redirect()->route('salas.index')->with('Sala eliminada com sucesso');
    }
}
