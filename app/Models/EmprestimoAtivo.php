<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmprestimoAtivo extends Model
{
    protected $table = 'emprestimos_ativos';

    protected $fillable = [
        'livro_id', 'aluno_id', 'data_emprestimo', 'data_prevista_devolucao', 'data_devolucao', 'status'
    ];

    protected $casts = [
        'data_emprestimo' => 'date',
        'data_prevista_devolucao' => 'date',
        'data_devolucao' => 'date',
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function diasEmprestado()
    {
        $fim = $this->data_devolucao ?? Carbon::today();
        return $this->data_emprestimo->diffInDays($fim);
    }

    public function estaAtrasado()
    {
        return $this->status === 'ativo' && Carbon::today()->gt($this->data_prevista_devolucao);
    }

    public function multa()
{
    return $this->hasOne(Multa::class, 'emprestimo_id');
}
}