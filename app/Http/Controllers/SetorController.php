<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{
    public function index()
    {
        return response()->json(Setor::with('estantes.prateleiras')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);
        $setor = Setor::create($request->all());
        return response()->json($setor, 201);
    }

    public function show($id)
    {
        return response()->json(Setor::with('estantes.prateleiras')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $setor = Setor::findOrFail($id);
        $setor->update($request->all());
        return response()->json($setor);
    }

    public function destroy($id)
    {
        Setor::findOrFail($id)->delete();
        return response()->json(['message' => 'Setor removido com sucesso']);
    }
}