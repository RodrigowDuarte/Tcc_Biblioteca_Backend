<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class MultaController extends Controller
{
    public function index()
    {
        $multas = Multa::with(['aluno', 'emprestimo.livro'])
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->get();

        $valorDia = Configuracao::where('chave', 'valor_multa_dia')->first()->valor ?? 1.00;

        return view('multas.index', compact('multas', 'valorDia'));
    }

    public function pagar($id)
    {
        $multa = Multa::findOrFail($id);
        $multa->status = 'paga';
        $multa->data_pagamento = now();
        $multa->save();

        return redirect('/multas')->with('success', 'Multa marcada como paga!');
    }

    public function atualizarValor(Request $request)
    {
        $request->validate([
            'valor_multa_dia' => 'required|numeric|min:0',
        ]);

        Configuracao::where('chave', 'valor_multa_dia')
            ->update(['valor' => $request->valor_multa_dia]);

        return redirect('/multas')->with('success', 'Valor da multa atualizado!');
    }
}