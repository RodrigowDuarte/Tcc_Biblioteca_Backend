@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Livros</h2>
    <a href="/livros/create" class="btn btn-success">Novo Livro</a>
</div>

<div class="mb-3">
    <input type="text" id="buscaLivro" class="form-control" placeholder="Pesquisar por nome, autor, genero ou patrimonio...">
</div>

<table class="table table-bordered table-striped" id="tabelaLivros">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Autor</th>
            <th>Genero</th>
            <th>Paginas</th>
            <th>Ano</th>
            <th>Editora</th>
            <th>Patrimonio</th>
            <th>Posicao</th>
            <th>Status</th>
            <th>Aluno</th>
            <th>Acoes</th>
        </tr>
    </thead>
    <tbody id="corpoLivros">
        @foreach($livros as $livro)
        <tr>
            <td>{{ $livro->id }}</td>
            <td>{{ $livro->nome }}</td>
            <td>{{ $livro->autor }}</td>
            <td>{{ $livro->genero }}</td>
            <td>{{ $livro->num_paginas }}</td>
            <td>{{ $livro->ano_publicacao }}</td>
            <td>{{ $livro->editora }}</td>
            <td>{{ $livro->n_patrimonio }}</td>
            <td>{{ $livro->posicao_do_livro }}</td>
            <td>
                @if($livro->status === 'disponivel')
                    <span class="badge bg-success">Disponivel</span>
                @else
                    <span class="badge bg-danger">Alugado</span>
                @endif
            </td>
            <td>{{ $livro->aluno ? $livro->aluno->nome : '-' }}</td>
            <td>
                <a href="/livros/{{ $livro->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                <form action="/livros/{{ $livro->id }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Remover livro?')">Remover</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
document.getElementById('buscaLivro').addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    const linhas = document.querySelectorAll('#corpoLivros tr');
    linhas.forEach(linha => {
        linha.style.display = linha.textContent.toLowerCase().includes(busca) ? '' : 'none';
    });
});
</script>
@endsection
