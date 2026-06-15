<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->string('nome')->unique()->after('id');
            $table->string('descricao')->nullable()->after('nome');
        });

        // Inserir categorias padrão
        DB::table('categorias')->insert([
            ['nome' => 'livro',      'descricao' => 'Livro',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'revista',    'descricao' => 'Revista',     'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'colecao',    'descricao' => 'Coleção',     'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'jornal',     'descricao' => 'Jornal',      'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'gibi',       'descricao' => 'Gibi',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'romance',    'descricao' => 'Romance',     'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'novela',     'descricao' => 'Novela',      'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'conto',      'descricao' => 'Conto',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'poesia',     'descricao' => 'Poesia',      'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'biografia',  'descricao' => 'Biografia',   'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'didatico',   'descricao' => 'Didático',    'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'dicionario', 'descricao' => 'Dicionário',  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'atlas',      'descricao' => 'Atlas',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'quadrinhos', 'descricao' => 'Quadrinhos',  'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'enciclopedia','descricao' => 'Enciclopédia','created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn(['nome', 'descricao']);
        });
    }
};
