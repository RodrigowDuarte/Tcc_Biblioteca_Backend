<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    protected $fillable = [
        'numero', 'genero', 'quantidade', 'livros_id'
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livros_id');
    }
}