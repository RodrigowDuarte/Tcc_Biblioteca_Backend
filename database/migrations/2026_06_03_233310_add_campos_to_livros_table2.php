<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('nome');
            $table->enum('categoria', ['livro', 'revista', 'colecao', 'jornal', 'gibi'])->default('livro')->after('isbn');
            $table->integer('quantidade')->default(1)->after('categoria');
            $table->integer('quantidade_disponivel')->default(1)->after('quantidade');
            $table->text('sinopse')->nullable()->after('editora');
            $table->text('observacao')->nullable()->after('sinopse');
            $table->unsignedBigInteger('prateleira_id')->nullable()->after('observacao');
        });
    }

    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'categoria', 'quantidade', 'quantidade_disponivel', 'sinopse', 'observacao', 'prateleira_id']);
        });
    }
};