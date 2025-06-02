<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TablaOrigenController;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TablaOrigenController::class, 'mostrarComparacion'])
        ->name('dashboard');

    Route::post('/actualizar-tabla', [TablaOrigenController::class, 'actualizar'])
        ->name('actualizar.tabla');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/reset-destino', [TablaOrigenController::class, 'resetTablaDestino'])->name('reset.destino');

});

require __DIR__.'/auth.php';
