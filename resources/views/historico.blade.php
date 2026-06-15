@extends('layouts.app')

@section('content')
<h2>Historico de Emprestimos</h2>

<div class="mb-3">
    <input type="text" id="buscaHistorico" class="form-control" placeholder="Pesquisar por aluno, livro ou data...">
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Livro</th>
            <th>Aluno</th>
            <th>Data Emprestimo</th>
            <th>Devolvido ate</th>
            <th>Data Devolucao</th>
            <th>Status</th>
            <th>Multa</th>
        </tr>
    </thead>
    <tbody id="corpoHistorico">
        @foreach($historico as $e)
        <tr class="{{ $e->status === 'atrasado' ? 'table-warning' : '' }}">
            <td>{{ $e->livro->nome }}</td>
            <td>{{ $e->aluno->nome }}</td>
            <td>{{ $e->data_emprestimo->format('d/m/Y') }}</td>
            <td>{{ $e->data_prevista_devolucao->format('d/m/Y') }}</td>
            <td>{{ $e->data_devolucao ? $e->data_devolucao->format('d/m/Y') : '-' }}</td>
            <td>
                @if($e->data_devolucao && $e->data_devolucao->gt($e->data_prevista_devolucao))
                    <span class="badge bg-danger">Devolvido com atraso</span>
                @else
                    <span class="badge bg-success">Devolvido no prazo</span>
                @endif
            </td>
            <td>
                @if($e->multa)
                    <span class="badge bg-danger">R$ {{ number_format($e->multa->valor_total, 2, ',', '.') }}</span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
document.getElementById('buscaHistorico').addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    document.querySelectorAll('#corpoHistorico tr').forEach(linha => {
        linha.style.display = linha.textContent.toLowerCase().includes(busca) ? '' : 'none';
    });
});
</script>
@endsection
