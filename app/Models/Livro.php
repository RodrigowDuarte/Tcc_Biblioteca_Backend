<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $fillable = [
        'nome', 'isbn', 'categoria', 'autor', 'genero', 'num_paginas',
        'ano_publicacao', 'editora', 'quantidade', 'quantidade_disponivel',
        'sinopse', 'observacao', 'n_patrimonio', 'posicao_do_livro',
        'status', 'usuario_id', 'prateleira_id', 'estante_id'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'usuario_id');
    }

    public function prateleira()
    {
        return $this->belongsTo(Prateleira::class);
    }

    public function estante()
{
    return $this->belongsTo(Estante2::class, 'estante_id');
}
}