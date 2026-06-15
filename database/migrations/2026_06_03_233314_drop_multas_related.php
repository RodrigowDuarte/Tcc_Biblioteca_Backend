<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('multas');
        Schema::dropIfExists('configuracoes');
    }

    public function down(): void
    {
        // irreversível
    }
};