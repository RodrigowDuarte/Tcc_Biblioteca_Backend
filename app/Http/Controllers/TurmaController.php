<?php
namespace App\Http\Controllers;
use App\Models\Turma;
use App\Models\Aluno;
use Illuminate\Http\Request;
 
class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount([
            'membros as total_membros',
            'membros as total_inadimplentes' => function ($q) {
                $q->whereHas('emprestimos', function ($q2) {
                    $q2->where('status', 'ativo')
                       ->where('data_prevista_devolucao', '<', now());
                });
            },
        ])->orderBy('nome')->get();
        return response()->json($turmas);
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:100|unique:turmas,nome',
            'descricao' => 'nullable|string|max:255',
        ]);
        $turma = Turma::create($request->all());
        return response()->json($turma, 201);
    }
 
    public function show($id)
    {
        $turma = Turma::findOrFail($id);
        return response()->json($turma);
    }
 
    public function update(Request $request, $id)
    {
        $turma = Turma::findOrFail($id);
        $request->validate([
            'nome'      => 'required|string|max:100|unique:turmas,nome,' . $id,
            'descricao' => 'nullable|string|max:255',
        ]);
 
        $nomeAntigo = $turma->nome;
        $turma->update($request->all());
 
        // Atualizar todos os alunos que tinham o nome antigo
        if ($nomeAntigo !== $turma->nome) {
            Aluno::where('turma', $nomeAntigo)->update(['turma' => $turma->nome]);
        }
 
        return response()->json($turma);
    }
 
    public function destroy($id)
    {
        $turma = Turma::findOrFail($id);
        $turma->delete();
        return response()->json(['message' => 'Turma removida com sucesso']);
    }
 
    public function membros($id)
    {
        $turma = Turma::findOrFail($id);
        $membros = Aluno::with(['emprestimos' => function ($q) {
            $q->where('status', 'ativo')->with('livro');
        }])
        ->where('turma', $turma->nome)
        ->orderBy('nome')
        ->get()
        ->map(function ($aluno) {
            $emprestimosAtivos     = $aluno->emprestimos->where('status', 'ativo');
            $aluno->tem_emprestimo = $emprestimosAtivos->count() > 0;
            $aluno->inadimplente   = $emprestimosAtivos->filter(function ($e) {
                return $e->data_prevista_devolucao < now()->toDateString();
            })->count() > 0;
            return $aluno;
        });
        return response()->json([
            'turma'   => $turma,
            'membros' => $membros,
        ]);
    }
}