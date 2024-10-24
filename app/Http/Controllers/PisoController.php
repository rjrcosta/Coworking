<?php

namespace App\Http\Controllers;

use App\Models\Piso;
use App\Models\Cidade;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Edificio;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class PisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém os dados paginados dos pisos, 10 itens por página
        $pisos = Piso::paginate(10);

        return view('pisos.index', compact('pisos'), [
            'pisos' => DB::table('pisos')->orderBy('andar')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pisos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação do andar
        $request->validate([
            'andar' => 'required|string|max:255|unique:pisos,andar',
        ], [
            'andar.unique' => 'Já existe esse andar na tabela de pisos.', // Mensagem personalizada
        ]);


        try {
            // Tentativa de criar a piso
            $piso = new piso();
            $piso->andar = $request->andar;
            $piso->save();

            // Redirecionar com mensagem de sucesso
            return redirect()->route('pisos.index')->with('success', 'piso criado com sucesso!');
        } catch (QueryException $e) {
            // Captura da exceção de chave única duplicada
            if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
                return redirect()->route('pisos.index')->with('error', 'Andar já existente! Não foi possível criar a piso.');
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
        $pisos = Piso::findOrFail($id);
        $cidades = Cidade::all(); // Busque todas as cidades
        $edificios = Edificio::all(); // Busque todos os edifícios

        return view('pisos.show', compact('pisos', 'cidades', 'edificios'));
    }

    /**
     * Display the specified resource.
     */
    public function show_associate($id)
    {
        //dd($id);
        $pisos = Piso::findOrFail($id);
        $cidades = Cidade::all(); // Busque todas as cidades
        $edificios = Edificio::all(); // Busque todos os edifícios

        return view('pisos.showAssociate', compact('pisos', 'cidades', 'edificios'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pisos.edit', [
            'pisos' => Piso::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação para garantir que o andar seja único, exceto para o piso atual
        $validatedData = $request->validate([
            'andar' => 'required|unique:pisos,andar,' . $id,
        ]);

        try {
            // Encontra o piso e faz a atualização
            $piso = Piso::findOrFail($id);
            $piso->update($request->all()); // Atualiza com todos os dados do request, inclusive os validados

            // Redireciona com sucesso
            return redirect()->route('pisos.index')->with('success', 'Piso modificado com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {  // Código 23000 é para violação de integridade
                return redirect()->route('pisos.index')->with('error', 'Andar já existente! Não foi possível modificar o piso.');
            }

            // Se for outro erro, lança a exceção
            throw $e;
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piso $piso)
    {
        //
        $piso->delete();
        return redirect()->route('pisos.index')->with('sucesso', 'piso eliminado com sucesso');
    }

    //Função para filtrar edifícios pela localidade 
    public function filtrar(Request $request)
    {
        $nome = $request->input('pesquisa');

        $pisos = Piso::where('andar', 'like', '%' . $nome . '%')->paginate(20);
        return view('pisos.index', ['pisos' => $pisos]);
    }

    //Função para associar pisos a edifícios 
    public function associate(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'piso_id' => 'required|exists:pisos,id',         // Verifica se o piso existe
            'edificios' => 'required|array',                 // Verifica se foi enviado um array de edifícios
            'edificios.*' => 'exists:edificios,id'           // Verifica se os edifícios enviados existem
        ]);

        try {
            // Obter o piso pelo ID
            $piso = Piso::findOrFail($request->piso_id);

            // Associar os edifícios ao piso usando sync()
            // Isso substituirá as associações anteriores pelas novas
            $piso->edificios()->sync($request->edificios);

            // Retornar uma resposta de sucesso em JSON
            return response()->json(['success' => true, 'message' => 'Edifícios associados com sucesso!'], 200);
        } catch (\Exception $e) {
            // Caso ocorra um erro, capturá-lo e retornar uma resposta de erro
            return response()->json(['success' => false, 'message' => 'Erro ao associar os edifícios.'], 500);
        }
    }
}
