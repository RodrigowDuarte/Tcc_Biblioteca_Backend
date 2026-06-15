<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->string('autor')->nullable()->after('nome');
            $table->string('genero')->nullable()->after('autor');
            $table->integer('num_paginas')->nullable()->after('genero');
            $table->year('ano_publicacao')->nullable()->after('num_paginas');
            $table->string('editora')->nullable()->after('ano_publicacao');
        });
    }

    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->dropColumn(['autor', 'genero', 'num_paginas', 'ano_publicacao', 'editora']);
        });
    }
};