<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Aluno;
use App\Models\EmprestimoAtivo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmprestimoController extends Controller
{
    public function index()
    {
        $emprestimos = EmprestimoAtivo::with(['livro', 'aluno'])
            ->where('status', 'ativo')
            ->get()
            ->map(function ($e) {
                $e->atrasado = $e->estaAtrasado();
                $e->dias = $e->diasEmprestado();
                return $e;
            });

        return response()->json($emprestimos);
    }

    public function emprestar(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id',
            'aluno_id' => 'required|exists:alunos,id',
            'dias'     => 'required|integer|min:1',
        ]);

        $livro = Livro::findOrFail($request->livro_id);

        if ($livro->quantidade_disponivel <= 0) {
            return response()->json(['message' => 'Livro sem exemplares disponiveis!'], 400);
        }

        $livro->quantidade_disponivel -= 1;
        if ($livro->quantidade_disponivel == 0) {
            $livro->status = 'alugado';
        }
        $livro->usuario_id = $request->aluno_id;
        $livro->save();

        $emprestimo = EmprestimoAtivo::create([
            'livro_id'                => $request->livro_id,
            'aluno_id'                => $request->aluno_id,
            'data_emprestimo'         => Carbon::today(),
            'data_prevista_devolucao' => Carbon::today()->addDays((int) $request->dias),
            'status'                  => 'ativo',
        ]);

        return response()->json($emprestimo, 201);
    }

    public function devolver(Request $request)
    {
        $request->validate([
            'emprestimo_id' => 'required|exists:emprestimos_ativos,id',
        ]);

        $emprestimo = EmprestimoAtivo::findOrFail($request->emprestimo_id);
        $emprestimo->status = 'devolvido';
        $emprestimo->data_devolucao = Carbon::today();
        $emprestimo->save();

        $livro = Livro::findOrFail($emprestimo->livro_id);
        $livro->quantidade_disponivel += 1;
        $livro->status = 'disponivel';
        $livro->usuario_id = null;
        $livro->save();

        return response()->json(['message' => 'Livro devolvido com sucesso!']);
    }

    public function historico()
    {
        $historico = EmprestimoAtivo::with(['livro', 'aluno'])
            ->where('status', 'devolvido')
            ->orderBy('data_devolucao', 'desc')
            ->get();

        return response()->json($historico);
    }

    public function inadimplentes()
    {
        $atrasados = EmprestimoAtivo::with(['livro', 'aluno'])
            ->where('status', 'ativo')
            ->where('data_prevista_devolucao', '<', Carbon::today())
            ->get();

        return response()->json($atrasados);
    }

    public function deletarHistorico($id)
{
    $emprestimo = EmprestimoAtivo::where('id', $id)->where('status', 'devolvido')->firstOrFail();
    $emprestimo->delete();
    return response()->json(['message' => 'Registro apagado']);
}

public function limparHistorico()
{
    EmprestimoAtivo::where('status', 'devolvido')->delete();
    return response()->json(['message' => 'Histórico limpo']);
}
}