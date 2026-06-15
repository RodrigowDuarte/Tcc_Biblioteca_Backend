<?php
namespace App\Http\Controllers;
use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        return response()->json(Livro::with('prateleira.estante.setor', 'estante.setor')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'         => 'required|string|max:255',
            'n_patrimonio' => 'required|string|unique:livros,n_patrimonio',
            'quantidade'   => 'integer|min:1',
            'categoria'    => 'nullable|string|max:100',
        ]);

        $data = $request->all();
        $data['quantidade_disponivel'] = $data['quantidade'] ?? 1;
        $livro = Livro::create($data);
        return response()->json($livro->load('estante.setor'), 201);
    }

    public function show($id)
    {
        return response()->json(Livro::with('prateleira.estante.setor', 'aluno')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $livro = Livro::findOrFail($id);
        $livro->update($request->all());
        return response()->json($livro->load('estante.setor'));
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();
        return response()->json(['message' => 'Livro removido com sucesso']);
    }

    public function disponiveis()
    {
        return response()->json(Livro::where('quantidade_disponivel', '>', 0)->get());
    }
}
