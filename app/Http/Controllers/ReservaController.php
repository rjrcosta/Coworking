<?php

namespace App\Http\Controllers;
use App\Models\Mesa;
use App\Models\Reserva;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservas = Reserva::all();
        $mesas= Mesa::all();
       
        return view('reserva.index', compact('reservas','mesas')); // Retorna a view com as reservas
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

        $mesas= Mesa::all();
        return view('reserva.create', compact('mesas')); // Retorna a view para criar uma reserva
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'horario_inicio' => 'required|date_format:H:i',
            'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
        ]);

        $reserva = Reserva::create([
            'user_id' => Auth::id(),
            'mesa_id' => $request->input('mesa_id'),
            'horario_inicio' => $request->input('horario_inicio'),
            'horario_fim' => $request->input('horario_fim'),
            'status' => 'reserved',
        ]);

        return redirect()->route('reserva.index')->with('success', 'Reserva criada com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }

    public function failed()
{
    // Lógica para a página ou ação em caso de falha
    return view('reserva.failed'); // Exemplo de retorno para uma view
}

}
