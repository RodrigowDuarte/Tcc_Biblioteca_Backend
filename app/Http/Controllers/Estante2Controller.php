<?php

namespace App\Http\Controllers;

use App\Models\Estante2;
use Illuminate\Http\Request;

class Estante2Controller extends Controller
{
    public function index()
    {
        return response()->json(Estante2::with('setor', 'prateleiras')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'     => 'required|string|max:255',
            'setor_id' => 'required|exists:setores,id',
            'descricao' => 'nullable|string',
        ]);
        $estante = Estante2::create($request->all());
        return response()->json($estante, 201);
    }

    public function show($id)
    {
        return response()->json(Estante2::with('setor', 'prateleiras')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $estante = Estante2::findOrFail($id);
        $estante->update($request->all());
        return response()->json($estante);
    }

    public function destroy($id)
    {
        Estante2::findOrFail($id)->delete();
        return response()->json(['message' => 'Estante removida com sucesso']);
    }
}