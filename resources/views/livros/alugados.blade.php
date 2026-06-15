
@extends('layouts.app')

@section('content')
<h2>Emprestimos</h2>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card p-3 mb-4">
            <h5>Emprestar Livro</h5>
            <form action="/emprestar" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Buscar Aluno</label>
                    <input type="text" id="buscaAluno" class="form-control" placeholder="Digite o nome do aluno..." autocomplete="off">
                    <div id="listaAlunos" class="list-group mt-1" style="display:none; max-height:200px; overflow-y:auto;"></div>
                    <input type="hidden" name="aluno_id" id="aluno_id">
                    <small id="alunoSelecionado" class="text-success"></small>
                </div>
                <div class="mb-3">
                    <label>Buscar Livro</label>
                    <input type="text" id="buscaLivro" class="form-control" placeholder="Digite o nome do livro..." autocomplete="off">
                    <div id="listaLivros" class="list-group mt-1" style="display:none; max-height:200px; overflow-y:auto;"></div>
                    <input type="hidden" name="livro_id" id="livro_id">
                    <small id="livroSelecionado" class="text-success"></small>
                </div>
                <div class="mb-3">
                    <label>Prazo de devolucao (dias)</label>
                    <input type="number" name="dias" class="form-control" value="7" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Emprestar</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3 mb-4">
            <h5>Devolver Livro</h5>
            <div class="mb-3">
                <label>Buscar Emprestimo</label>
                <input type="text" id="buscaDevolver" class="form-control" placeholder="Digite o nome do livro ou aluno..." autocomplete="off">
                <div id="listaDevolver" class="list-group mt-1" style="display:none; max-height:200px; overflow-y:auto;"></div>
                <small id="emprestimoSelecionado" class="text-success"></small>
            </div>
            <form action="/devolver" method="POST" id="formDevolver">
                @csrf
                <input type="hidden" name="emprestimo_id" id="emprestimo_id">
                <button type="submit" class="btn btn-warning">Devolver</button>
            </form>
        </div>
    </div>
</div>

@if($atrasados->count() > 0)
<div class="alert alert-danger">
    <h5>Alunos com emprestimos atrasados ({{ $atrasados->count() }})</h5>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Livro</th>
                <th>Devolvido ate</th>
                <th>Dias em atraso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($atrasados as $e)
            <tr>
                <td>{{ $e->aluno->nome }}</td>
                <td>{{ $e->livro->nome }}</td>
                <td>{{ $e->data_prevista_devolucao->format('d/m/Y') }}</td>
                <td>{{ $e->data_prevista_devolucao->diffInDays(now()) }} dias</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mt-3">
    <h4>Lista de Emprestimos Ativos</h4>
    <input type="text" id="buscaEmprestimos" class="form-control w-50" placeholder="Pesquisar por aluno ou livro...">
</div>

<table class="table table-bordered table-striped mt-2">
    <thead class="table-dark">
        <tr>
            <th>Livro</th>
            <th>Aluno</th>
            <th>Data Emprestimo</th>
            <th>Devolver ate</th>
            <th>Dias</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="corpoEmprestimos">
        @foreach($emprestimos as $e)
        <tr class="{{ $e->atrasado ? 'table-danger' : '' }}">
            <td>{{ $e->livro->nome }}</td>
            <td>{{ $e->aluno->nome }}</td>
            <td>{{ $e->data_emprestimo->format('d/m/Y') }}</td>
            <td>{{ $e->data_prevista_devolucao->format('d/m/Y') }}</td>
            <td>{{ $e->dias }} dias</td>
            <td>
                @if($e->atrasado)
                    <span class="badge bg-danger">Atrasado</span>
                @else
                    <span class="badge bg-success">Em dia</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
const alunos = @json($alunos);
const livros = @json($livrosDisponiveis);
const emprestimos = @json($emprestimos);

function criarBusca(inputId, listaId, dados, campoTexto, hiddenId, labelId) {
    const input = document.getElementById(inputId);
    const lista = document.getElementById(listaId);
    const hidden = document.getElementById(hiddenId);
    const label = document.getElementById(labelId);

    input.addEventListener('input', function() {
        const busca = this.value.toLowerCase();
        lista.innerHTML = '';
        if (busca.length < 1) { lista.style.display = 'none'; return; }

        const filtrados = dados.filter(d => d[campoTexto].toLowerCase().includes(busca));
        if (filtrados.length === 0) { lista.style.display = 'none'; return; }

        filtrados.forEach(d => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = d[campoTexto] + (d.cpf ? ' - CPF: ' + d.cpf : '') + (d.n_patrimonio ? ' - Pat: ' + d.n_patrimonio : '');
            item.addEventListener('click', function() {
                hidden.value = d.id;
                input.value = d[campoTexto];
                label.textContent = 'Selecionado: ' + d[campoTexto];
                lista.style.display = 'none';
            });
            lista.appendChild(item);
        });
        lista.style.display = 'block';
    });
}

criarBusca('buscaAluno', 'listaAlunos', alunos, 'nome', 'aluno_id', 'alunoSelecionado');
criarBusca('buscaLivro', 'listaLivros', livros, 'nome', 'livro_id', 'livroSelecionado');

const inputDevolver = document.getElementById('buscaDevolver');
const listaDevolver = document.getElementById('listaDevolver');
const hiddenDevolver = document.getElementById('emprestimo_id');

inputDevolver.addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    listaDevolver.innerHTML = '';
    if (busca.length < 1) { listaDevolver.style.display = 'none'; return; }

    const filtrados = emprestimos.filter(e =>
        e.livro.nome.toLowerCase().includes(busca) ||
        e.aluno.nome.toLowerCase().includes(busca)
    );

    if (filtrados.length === 0) { listaDevolver.style.display = 'none'; return; }

    filtrados.forEach(e => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action';
        item.textContent = e.livro.nome + ' - ' + e.aluno.nome;
        item.addEventListener('click', function() {
            hiddenDevolver.value = e.id;
            inputDevolver.value = e.livro.nome + ' - ' + e.aluno.nome;
            document.getElementById('emprestimoSelecionado').textContent = 'Selecionado: ' + e.livro.nome;
            listaDevolver.style.display = 'none';
        });
        listaDevolver.appendChild(item);
    });
    listaDevolver.style.display = 'block';
});

document.getElementById('buscaEmprestimos').addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    const linhas = document.querySelectorAll('#corpoEmprestimos tr');
    linhas.forEach(linha => {
        linha.style.display = linha.textContent.toLowerCase().includes(busca) ? '' : 'none';
    });
});
</script>
@endsection
