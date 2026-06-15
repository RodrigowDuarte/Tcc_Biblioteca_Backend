<?php

use App\Http\Controllers\GeneroController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\Estante2Controller;
use App\Http\Controllers\PrateleiraController;

Route::post('login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Credenciais invalidas'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('tcc_frontend')->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('alunos', AlunoController::class);
    Route::get('alunos-inadimplentes', [AlunoController::class, 'inadimplentes']);
    Route::get('alunos/turma/{turma}', [AlunoController::class, 'porTurma']);
    Route::apiResource('livros', LivroController::class);
    Route::get('livros-disponiveis', [LivroController::class, 'disponiveis']);
    Route::get('emprestimos', [EmprestimoController::class, 'index']);
    Route::post('emprestar', [EmprestimoController::class, 'emprestar']);
    Route::post('devolver', [EmprestimoController::class, 'devolver']);
    Route::get('historico', [EmprestimoController::class, 'historico']);
    Route::delete('historico/limpar', [EmprestimoController::class, 'limparHistorico']);
    Route::delete('historico/{id}', [EmprestimoController::class, 'deletarHistorico']);
    Route::get('inadimplentes', [EmprestimoController::class, 'inadimplentes']);
    Route::apiResource('setores', SetorController::class);
    Route::apiResource('estantes', Estante2Controller::class);
    Route::apiResource('prateleiras', PrateleiraController::class);
    Route::apiResource('turmas', TurmaController::class);
    Route::get('turmas/{id}/membros', [TurmaController::class, 'membros']);
    Route::apiResource('categorias', CategoriaController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('generos', GeneroController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});