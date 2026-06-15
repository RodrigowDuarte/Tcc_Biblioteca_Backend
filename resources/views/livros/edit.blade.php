@extends('layouts.app')

@section('content')
<h2>Editar Livro</h2>

<form action="/livros/{{ $livro->id }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ $livro->nome }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Autor</label>
            <input type="text" name="autor" class="form-control" value="{{ $livro->autor }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Genero</label>
            <input type="text" name="genero" class="form-control" value="{{ $livro->genero }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Numero de Paginas</label>
            <input type="number" name="num_paginas" class="form-control" value="{{ $livro->num_paginas }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Ano de Publicacao</label>
            <input type="number" name="ano_publicacao" class="form-control" value="{{ $livro->ano_publicacao }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Editora</label>
            <input type="text" name="editora" class="form-control" value="{{ $livro->editora }}">
        </div>
        <div class="col-md-6 mb-3">
            <label>Numero de Patrimonio</label>
            <input type="text" name="n_patrimonio" class="form-control" value="{{ $livro->n_patrimonio }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label>Posicao na Estante</label>
            <input type="text" name="posicao_do_livro" class="form-control" value="{{ $livro->posicao_do_livro }}">
        </div>
    </div>
    <a href="/livros" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-success">Salvar</button>
</form>
@endsection
