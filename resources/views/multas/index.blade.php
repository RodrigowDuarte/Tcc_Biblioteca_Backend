@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Multas</h2>
    <div class="card p-3">
        <form action="/multas/valor" method="POST" class="d-flex align-items-center gap-2">
            @csrf
            <label class="mb-0">Valor por dia: R$</label>
            <input type="number" name="valor_multa_dia" class="form-control" style="width:100px" value="{{ $valorDia }}" step="0.01" min="0">
            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
        </form>
    </div>
</div>
<div class="mb-3">
    <input type="text" id="buscaMulta" class="form-control" placeholder="Pesquisar por aluno ou livro...">
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Aluno</th><th>Livro</th><th>Dias Atraso</th><th>Valor/Dia</th><th>Total</th><th>Status</th><th>Pagamento</th><th>Acoes</th>
        </tr>
    </thead>
    <tbody id="corpoMultas">
        @foreach($multas as $multa)
        <tr class="{{ $multa->status === 'pendente' ? 'table-danger' : 'table-success' }}">
            <td>{{ $multa->aluno->nome }}</td>
            <td>{{ $multa->emprestimo->livro->nome }}</td>
            <td>{{ $multa->dias_atraso }} dias</td>
            <td>R$ {{ number_format($multa->valor_dia, 2, ',', '.') }}</td>
            <td>R$ {{ number_format($multa->valor_total, 2, ',', '.') }}</td>
            <td>@if($multa->status === 'pendente')<span class="badge bg-danger">Pendente</span>@else<span class="badge bg-success">Paga</span>@endif</td>
            <td>{{ $multa->data_pagamento ? $multa->data_pagamento->format('d/m/Y') : '-' }}</td>
            <td>@if($multa->status === 'pendente')<form action="/multas/{{ $multa->id }}/pagar" method="POST">@csrf<button class="btn btn-sm btn-success" onclick="return confirm('Confirmar pagamento?')">Pagar</button></form>@endif</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
document.getElementById('buscaMulta').addEventListener('input', function() {
    const busca = this.value.toLowerCase();
    document.querySelectorAll('#corpoMultas tr').forEach(linha => {
        linha.style.display = linha.textContent.toLowerCase().includes(busca) ? '' : 'none';
    });
});
</script>
@endsection
