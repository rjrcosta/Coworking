<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailContacto;



class ContactoController extends Controller
{
    // Controler para Enviar Emails no formulario contacto
    public function sendmail(Request $request){
        //  dd($request);
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $nome = $_GET['nomeContacto']; 
            $email = $_GET['emailContacto'];  
            $mensagem = $_GET['mensagemContacto'];    
        }
        

        // Create a new instance of the Mailable
        Mail::to($email)->send(new MailContacto($nome, $email, $mensagem));


        return  view('welcome')->with('refresh', true);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('msgcontactos.index',[
        'contactos'=>DB::table('contactos') ->orderBy('id', 'desc')->paginate('10')
    ]);
            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         
         
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('msgcontactos.show', [
            'contacto' => contacto::findOrFail($id)
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(contacto $contacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, contacto $contacto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        contacto::findOrFail($id)->delete();
        return redirect()->route('msgcontactos.index')->with('successdestroy', 'Mensagem eliminada com sucesso!');
    }
}
