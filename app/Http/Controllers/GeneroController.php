<?php
namespace App\Http\Controllers;
use App\Models\Genero;
use App\Models\Livro;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index()
    {
        return response()->json(Genero::orderBy('descricao')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:100|unique:generos,nome',
            'descricao' => 'nullable|string|max:255',
        ]);

        $genero = Genero::create([
            'nome'      => strtolower(trim($request->nome)),
            'descricao' => $request->descricao ?? ucfirst($request->nome),
        ]);

        return response()->json($genero, 201);
    }

    public function update(Request $request, $id)
    {
        $genero = Genero::findOrFail($id);
        $request->validate([
            'nome'      => 'sometimes|string|max:100|unique:generos,nome,' . $id,
            'descricao' => 'nullable|string|max:255',
        ]);

        $nomeAntigo = $genero->nome;
        $genero->update($request->all());

        // Atualizar livros em cascata
        if ($nomeAntigo !== $genero->nome) {
            Livro::where('genero', $nomeAntigo)->update(['genero' => $genero->nome]);
        }

        return response()->json($genero);
    }

    public function destroy($id)
    {
        $genero = Genero::findOrFail($id);
        $genero->delete();
        return response()->json(['message' => 'Gênero removido']);
    }
}
