<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Sala;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mesas = Mesa::paginate(10);
        return view('mesa.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $salas = \App\Models\Sala::all(); // Obter todas as salas
        return view('mesa.create', compact('salas'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $validated = $request->validate([
            'cod_sala_piso' => 'required|exists:salas,id',
        ]);

        // Criação da nova mesa
        $mesa = new Mesa();
        $mesa->status = 'livre'; // Definindo o status inicial como 'livre'
        $mesa->cod_sala_piso = $validated['cod_sala_piso'];

        // Salvar a mesa no banco de dados
        $mesa->save(); // Salva a mesa primeiro para que o ID esteja disponível

        // Atualizar a lotação da sala correspondente
        $sala = \App\Models\Sala::find($validated['cod_sala_piso']);
        $sala->lotacao += 1; // Aumenta a lotação em 1
        $sala->save(); // Salva as alterações na sala

        // Gera o QR Code e salva o caminho na mesa
        $mesa->qrcode = $this->gerarQrCode($mesa->id); // Gera o QR Code e salva o caminho
        $mesa->save(); // Salva a mesa com o QR Code




        return redirect()->route('mesa.index')->with('success', 'Mesa criada com sucesso.');
    }


    // Método para gerar QR Code
    private function gerarQrCode($mesaId)
    {
        // Define o caminho onde o QR Code será salvo
        $qrcodePath = 'qrcodes/' . $mesaId . '.svg';

        // Gera o QR Code e salva na pasta pública
        QrCode::format('svg')->size(150)->generate(url("/checkin/{$mesaId}"), public_path($qrcodePath));

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
        // Obter a sala correspondente à mesa
        $salaPiso = $mesa->sala; // SalaPiso que contém a sala e o piso
        $sala = $salaPiso->sala; // A sala que a mesa está
        $piso = $salaPiso->edificioPiso->piso; // O piso relacionado ao SalaPiso
        $edificio = $salaPiso->edificioPiso->edificio; // O edifício relacionado ao SalaPiso
        $cidade = $edificio->cidade; // A cidade relacionada ao Edificio
      
        return view('mesa.show', compact('mesa', 'sala', 'piso', 'edificio', 'cidade'));
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
        // Verifique se a mesa existe
        if (!$mesa) {
            return redirect()->route('mesa.index')->with('error', 'Mesa não encontrada.');
        }

        // Antes de remover a mesa, atualize a lotação da sala
        $sala = \App\Models\Sala::find($mesa->cod_sala_piso);
        if ($sala) {
            $sala->lotacao -= 1; // Diminui a lotação em 1
            $sala->save(); // Salva as alterações na sala
        }

        // Remove a mesa
        $mesa->delete();

        return redirect()->route('mesa.index')->with('success', 'Mesa removida com sucesso.');
    }
}
