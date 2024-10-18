<?php


/**
* Editado por Thiago França
* 18/10/2024
*/

use App\Http\Controllers\EdificioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Session\Middleware\AuthenticatedSession;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard_admin',function(){})->name('admin.dashboard');

// Route::get('/dashboard', function () {
//     // Página de dashboard do usuário
// })->name('user.dashboard');

Route::get('/dashboard_admin', function () {
    return view('dashboard_admin');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', [AuthenticatedSessionController::class, 'store'])->middleware('auth')->name('dashboard');

 

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //**** Rota geral para os clientes, produtos, vendedores ****
    Route::resources([
        'edificios' => EdificioController::class,
        
    ]);

    //Rota para filtrar edifícios pela cidade no index
    Route::get('/edificios_filtrar', [EdificioController::class, 'filtrar'])->name('edificios.filtrar');

});

require __DIR__.'/auth.php';
