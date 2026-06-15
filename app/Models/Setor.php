<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'setores';
    protected $fillable = ['nome', 'descricao'];

    public function estantes()
    {
        return $this->hasMany(Estante2::class, 'setor_id');
    }
}