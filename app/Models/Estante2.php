<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estante2 extends Model
{
    protected $table = 'estantes2';
    
    protected $fillable = ['nome', 'setor_id', 'descricao'];

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function prateleiras()
    {
        return $this->hasMany(Prateleira::class, 'estante_id');
    }
}