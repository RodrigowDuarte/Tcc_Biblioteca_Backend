<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    protected $fillable = [
        'emprestimo_id', 'aluno_id', 'dias_atraso', 'valor_dia', 'valor_total', 'status', 'data_pagamento'
    ];

    protected $casts = [
        'data_pagamento' => 'date',
    ];

    public function emprestimo()
    {
        return $this->belongsTo(EmprestimoAtivo::class, 'emprestimo_id');
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}