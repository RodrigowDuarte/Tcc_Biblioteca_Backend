<?php

namespace App\Http\Controllers;

use App\Models\Prateleira;
use Illuminate\Http\Request;

class PrateleiraController extends Controller
{
    public function index()
    {
        return response()->json(Prateleira::with('estante.setor')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'       => 'required|string|max:255',
            'estante_id' => 'required|exists:estantes2,id',
            'descricao'  => 'nullable|string',
        ]);
        $prateleira = Prateleira::create($request->all());
        return response()->json($prateleira, 201);
    }

    public function show($id)
    {
        return response()->json(Prateleira::with('estante.setor')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $prateleira = Prateleira::findOrFail($id);
        $prateleira->update($request->all());
        return response()->json($prateleira);
    }

    public function destroy($id)
    {
        Prateleira::findOrFail($id)->delete();
        return response()->json(['message' => 'Prateleira removida com sucesso']);
    }
}