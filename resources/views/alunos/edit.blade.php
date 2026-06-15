@extends('layouts.app')

@section('content')
<h2>Editar Livro</h2>

<form action="/livros/{{ $livro->id }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" value="{{ $livro->nome }}" required>
    </div>
    <div class="mb-3">
        <label>Numero de Patrimonio</label>
        <input type="text" name="n_patrimonio" class="form-control" value="{{ $livro->n_patrimonio }}" required>
    </div>
    <div class="mb-3">
        <label>Posicao na Estante</label>
        <input type="text" name="posicao_do_livro" class="form-control" value="{{ $livro->posicao_do_livro }}">
    </div>
    <a href="/livros" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-success">Salvar</button>
</form>
@endsection