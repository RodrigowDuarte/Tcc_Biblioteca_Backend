<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('alunos', AlunoController::class);
    Route::resource('livros', LivroController::class);
    Route::post('emprestar', [EmprestimoController::class, 'emprestar'])->name('emprestar');
    Route::post('devolver', [EmprestimoController::class, 'devolver'])->name('devolver');
    Route::get('livros-alugados', [EmprestimoController::class, 'livrosAlugados'])->name('livros.alugados');

    Route::get('multas', [App\Http\Controllers\MultaController::class, 'index'])->name('multas.index');
Route::post('multas/{id}/pagar', [App\Http\Controllers\MultaController::class, 'pagar'])->name('multas.pagar');
Route::post('multas/valor', [App\Http\Controllers\MultaController::class, 'atualizarValor'])->name('multas.valor');
Route::get('historico', [App\Http\Controllers\EmprestimoController::class, 'historico'])->name('historico');
});

require __DIR__.'/auth.php';