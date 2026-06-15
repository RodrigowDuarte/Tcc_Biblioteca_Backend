<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->string('descricao')->nullable();
            $table->timestamps();
        });

        // Gêneros padrão
        DB::table('generos')->insert([
            ['nome' => 'terror',       'descricao' => 'Terror',          'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'romance',      'descricao' => 'Romance',         'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'ficcao',       'descricao' => 'Ficção',          'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'aventura',     'descricao' => 'Aventura',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'fantasia',     'descricao' => 'Fantasia',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'misterio',     'descricao' => 'Mistério',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'biografia',    'descricao' => 'Biografia',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'historia',     'descricao' => 'História',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'ciencia',      'descricao' => 'Ciência',         'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'autoajuda',    'descricao' => 'Autoajuda',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'policial',     'descricao' => 'Policial',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'infantil',     'descricao' => 'Infantil',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'didatico',     'descricao' => 'Didático',        'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'filosofia',    'descricao' => 'Filosofia',       'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'religiao',     'descricao' => 'Religião',        'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('generos');
    }
};
