<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_usuario')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->string('nombre')->nullable()->default(null);
            $table->time('hora_entrada')->required();
            $table->time('hora_salida')->required();
            $table->time('limite_entrada')->required();
            $table->time('limite_salida')->required();
            $table->uuid('id_usuario_admin')->references('id')->on('colaboradores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
