@extends('layouts.app')

@section('content')
<h2>Novo Livro</h2>

<form action="/livros" method="POST" class="mt-3">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Genero</label>
            <input type="text" name="genero" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Numero de Paginas</label>
            <input type="number" name="num_paginas" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Ano de Publicacao</label>
            <input type="number" name="ano_publicacao" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Editora</label>
            <input type="text" name="editora" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Numero de Patrimonio</label>
            <input type="text" name="n_patrimonio" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Posicao na Estante</label>
            <input type="text" name="posicao_do_livro" class="form-control">
        </div>
    </div>
    <a href="/livros" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-success">Salvar</button>
</form>
@endsection
