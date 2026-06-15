<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('turma')->nullable()->after('nome');
            $table->enum('tipo', ['aluno', 'professor'])->default('aluno')->after('turma');
            $table->boolean('ativo')->default(true)->after('tipo');
        });
    }

    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropColumn(['turma', 'tipo', 'ativo']);
        });
    }
};