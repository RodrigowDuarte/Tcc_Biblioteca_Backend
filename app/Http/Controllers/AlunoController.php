<?php
namespace App\Http\Controllers;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::with(['emprestimos' => function ($q) {
            $q->where('status', 'ativo')->with('livro');
        }])->get()->map(function ($aluno) {
            $emprestimosAtivos = $aluno->emprestimos;
            $aluno->tem_emprestimo = $emprestimosAtivos->count() > 0;
            $aluno->inadimplente = $emprestimosAtivos->some(function ($e) {
                return Carbon::today()->gt($e->data_prevista_devolucao);
            });
            $aluno->total_emprestimos_ativos = $emprestimosAtivos->count();
            return $aluno;
        });
        return response()->json($alunos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'     => 'required|string|max:255',
            'cpf'      => 'nullable|string|unique:alunos,cpf',
            'turma'    => 'nullable|string',
            'tipo'     => 'in:aluno,professor',
            'endereco' => 'nullable|string',
            'telefone' => 'nullable|string',
            'email'    => 'nullable|email|unique:alunos,email',
        ]);
        $aluno = Aluno::create($request->all());
        return response()->json($aluno, 201);
    }

    public function show($id)
    {
        $aluno = Aluno::with('emprestimos.livro')->findOrFail($id);
        return response()->json($aluno);
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());
        return response()->json($aluno);
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        if ($aluno->emprestimos()->where('status', 'ativo')->count() > 0) {
            return response()->json(['message' => 'Aluno possui emprestimos ativos!'], 400);
        }
        $aluno->delete();
        return response()->json(['message' => 'Aluno removido com sucesso']);
    }

    public function inadimplentes()
    {
        $alunos = Aluno::with(['emprestimos' => function ($q) {
            $q->where('status', 'ativo')
              ->where('data_prevista_devolucao', '<', now())
              ->with('livro');
        }])->whereHas('emprestimos', function ($q) {
            $q->where('status', 'ativo')
              ->where('data_prevista_devolucao', '<', now());
        })->get();
        return response()->json($alunos);
    }

    public function porTurma($turma)
    {
        $alunos = Aluno::with(['emprestimos' => function ($q) {
            $q->where('status', 'ativo')->with('livro');
        }])->where('turma', $turma)->get();
        return response()->json($alunos);
    }
}
