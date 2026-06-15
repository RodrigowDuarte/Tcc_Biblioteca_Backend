@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Alunos</h2>
    <a href="/alunos/create" class="btn btn-primary">Novo Aluno</a>
</div>

<div class="mb-3">
    <input type="text" id="buscaAluno" class="form-control" placeholder="Pesquisar por nome, CPF, email ou telefone...">
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Acoes</th>
        </tr>
    </thead>
    <tbody id="corpoAlunos">
        @foreach($alunos as $aluno)
        <tr>
            <td>{{ $aluno->id }}</td>
            <td>{{ $aluno->nome }}</td>
            <td>{{ $aluno->cpf }}</td>
            <td>{{ $aluno->telefone }}</td>
            <td>{{ $aluno->email }}</td>
            <td>
                <a href="/alunos/{{ $aluno->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                <form action="/alunos/{{ $aluno->id }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Remover aluno?')">Remover</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
document.getElementById('buscaAluno').addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    const linhas = document.querySelectorAll('#corpoAlunos tr');
    linhas.forEach(linha => {
        linha.style.display = linha.textContent.toLowerCase().includes(busca) ? '' : 'none';
    });
});
</script>
@endsection
