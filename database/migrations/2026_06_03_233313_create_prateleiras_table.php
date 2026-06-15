<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prateleiras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('estante_id')->constrained('estantes2')->onDelete('cascade');
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prateleiras');
    }
};