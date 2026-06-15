<?php
namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Livro;
use Illuminate\Http\Request;
 
class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::orderBy('descricao')->get());
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:100|unique:categorias,nome',
            'descricao' => 'nullable|string|max:255',
        ]);
 
        $categoria = Categoria::create([
            'nome'      => strtolower(trim($request->nome)),
            'descricao' => $request->descricao ?? ucfirst($request->nome),
        ]);
 
        return response()->json($categoria, 201);
    }
 
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $request->validate([
            'nome'      => 'sometimes|string|max:100|unique:categorias,nome,' . $id,
            'descricao' => 'nullable|string|max:255',
        ]);
 
        $nomeAntigo = $categoria->nome;
        $categoria->update($request->all());
 
        // Atualizar todos os livros que tinham o nome antigo
        if ($nomeAntigo !== $categoria->nome) {
            Livro::where('categoria', $nomeAntigo)->update(['categoria' => $categoria->nome]);
        }
 
        return response()->json($categoria);
    }
 
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(['message' => 'Categoria removida']);
    }
}
 