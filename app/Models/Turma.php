<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = ['nome', 'descricao'];

    public function membros()
    {
        return $this->hasMany(Aluno::class, 'turma', 'nome');
    }
}