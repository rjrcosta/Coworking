<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Controler para Enviar Emails no formulario contacto
    public function sendEmail(Request $request){
        
       
        $data = $request ->validate([
            'nomeContacto' => ['required'],
            'emailContacto' => ['required'],
            'mensagemContacto' => ['required'],
        ]);

        $contacto = new Contacto();
         $contacto->nome = $request->nomeContacto;
         $contacto->email = $request->emailContacto;
         $contacto->message = $request->mensagemContacto;
         $contacto->save();
        //  return redirect()->route('')->with('success', 'Mensagem enviada com sucesso!');

        return  view('welcome', $data);

        
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
