<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prateleira extends Model
{
    protected $fillable = ['nome', 'estante_id', 'descricao'];

    public function estante()
    {
        return $this->belongsTo(Estante2::class, 'estante_id');
    }

    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}