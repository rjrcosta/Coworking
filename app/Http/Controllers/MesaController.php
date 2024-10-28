<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mesas = Mesa::all();
        return view('mesa.index', compact('mesas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('mesa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validação (descomentada se necessário)
        $request->validate([
            
        'status' => 'required|string',
        'descricao' => 'nullable|string',
        ]);
    
        // Cria a mesa sem o QR Code inicialmente
        $mesa = Mesa::create([
           
        'status' => $request->status,
        
        ]);
    
        // Gera o QR Code e salva o caminho na mesa
        $mesa->qrcode = $this->gerarQrCode($mesa->id); // Gera o QR Code e salva o caminho
        $mesa->save(); // Salva a mesa com o QR Code
    
        return redirect()->route('mesa.index')->with('success', 'Mesa criada com sucesso!');
    }

    // Método para gerar QR Code
    private function gerarQrCode($mesaId)
    {
        // Define o caminho onde o QR Code será salvo
        $qrcodePath = 'qrcodes/mesa_' . $mesaId . '.png';
        
        // Gera o QR Code e salva na pasta pública
        QrCode::format('png')->size(300)->generate(url("/checkin/{$mesaId}"), public_path($qrcodePath));
        
        // Retorna o caminho do QR Code para ser salvo no banco de dados
        return $qrcodePath;
    }

     // Função para check-in
     public function checkIn(Request $request, $mesaId)
     {
         $user = Auth::user();
       
         
         $mesa = Mesa::findOrFail($mesaId);
 
        //  Verificar se há uma reserva ativa para esta mesa e para este usuário
          $reserva = Reserva::where('mesa_id', $mesaId)
                            ->where('user_id', $user->id)
                            ->whereDate('created_at', now()->toDateString()) // Ajuste para o campo correto
                            ->where('status', 'reserved')
                            ->first();
 
         if ($reserva) {
             // Verificar se o check-in é feito até 15 minutos após o início da reserva
             $checkInDeadline = Carbon::createFromTimeString($reserva->horario_inicio)->addMinutes(15);
 
             if (now()->lessThanOrEqualTo($checkInDeadline)) {
                 $reserva->status = 'checked-in';
                 $reserva->check_in_time = now();
                 $reserva->save();
 
                 return redirect()->route('reserva.success')->with('success', 'Check-in efetuado com sucesso!');
             } else {
                 return redirect()->route('reserva.failed')->with('error', 'Check-in expirado.');
             }
         } else {
             return redirect()->route('reserva.failed')->with('error', 'Nenhuma reserva ativa encontrada para esta mesa.');
         }
 
     }
 
 


    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        //
    }
}
