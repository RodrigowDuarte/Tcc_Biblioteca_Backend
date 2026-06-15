@extends('layouts.app')

@section('content')
<div class="row text-center">
    <h2 class="mb-4">Sistema de Biblioteca</h2>

    <div class="col-md-4">
        <div class="card p-4 mb-3">
            <h5>Alunos</h5>
            <a href="/alunos" class="btn btn-primary mt-2">Gerenciar Alunos</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 mb-3">
            <h5>Livros</h5>
            <a href="/livros" class="btn btn-success mt-2">Gerenciar Livros</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 mb-3">
            <h5>Emprestimos</h5>
            <a href="/livros-alugados" class="btn btn-warning mt-2">Ver Emprestimos</a>
        </div>
    </div>
</div>
@endsection
