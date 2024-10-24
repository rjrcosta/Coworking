<?php


/**
 * Editado por Jose Sousa
 * 21/10/2024
 */

use App\Http\Controllers\UserController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PisoController;
use App\Models\User;
use Illuminate\Session\Middleware\AuthenticatedSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use User as GlobalUser;

Route::match(array('GET','POST'),'/', function () {
    return view('welcome');
});
Route::match(array('GET','POST'),'/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// rotas pessoais para os users comuns´

Route::get('/profile/users', [UserController::class, 'showProfile'])->name('users.profile')->middleware('auth');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('users.editProfile')->middleware('auth');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('users.updateProfile')->middleware('auth');




// rotas para os users /clientes 

Route::resources([

    'users' => UserController::class,


]);

Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    //**** Rota geral para os clientes, produtos, vendedores ****
    Route::resources([
        'edificios' => EdificioController::class,
        'cidades' => CidadeController::class,
        'msgcontactos' => ContactoController::class,

    ]);

    //Rota para fazer delete de mensagens
    Route::delete('/msgcontactos/{id}', [ContactoController::class, 'destroy'])->name('msgcontactos.destroy');

    // Rota para filtrar edifícios pela cidade
    Route::get('/edificios_filtrar', [EdificioController::class, 'filtrar'])->name('edificios.filtrar');
   
    // Rota para a modal de adição de cidades
    Route::post('/cidades', [CidadeController::class, 'store'])->name('cidades.store');

    // Rota para filtrar cidades pelo nome
    Route::get('/cidades_filtrar', [CidadeController::class, 'filtrar'])->name('cidades.filtrar');


    //Rota para enviar contacto
    Route::post('', [ContactoController::class, 'sendEmail'])->name('send.email');

//**** Rota geral para os clientes, produtos, vendedores ****
Route::resources([
    'edificios' => EdificioController::class,
    'cidades' => CidadeController::class,
    'pisos' => PisoController::class,

]);

// Rota para filtrar edifícios pela cidade
Route::get('/edificios_filtrar', [EdificioController::class, 'filtrar'])->name('edificios.filtrar');

// Rota para a modal de adição de cidades
Route::post('/cidades', [CidadeController::class, 'store'])->name('cidades.store');

// Rota para filtrar cidades pelo nome
Route::get('/cidades_filtrar', [CidadeController::class, 'filtrar'])->name('cidades.filtrar');

// Rota para filtrar pisos pelo andar
Route::get('/pisos_filtrar', [PisoController::class, 'filtrar'])->name('pisos.filtrar');

// Rota para a modal de adição de pisos
Route::get('/pisos_show_associate/{id}', [PisoController::class, 'show_associate'])->name('pisos.showAssociate');


// Rota para associar edifícios a um piso
Route::post('/pisos/associate', [PisoController::class, 'associate'])->name('pisos.associate');

require __DIR__ . '/auth.php';
