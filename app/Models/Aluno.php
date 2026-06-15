<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'nome', 'turma', 'tipo', 'ativo', 'cpf', 'endereco', 'telefone', 'email'
    ];

    public function livros()
    {
        return $this->hasMany(Livro::class, 'usuario_id');
    }

    public function emprestimos()
    {
        return $this->hasMany(EmprestimoAtivo::class);
    }
}