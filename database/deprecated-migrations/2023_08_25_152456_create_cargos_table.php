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
        Schema::create('cargos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('codigo', 255)->require();
            $table->string('nombre', 255)->require();
            $table->uuid('id_puesto')->references('id')->on('puestos')->onDelete('cascade');
            $table->uuid('id_departamento')->references('id')->on('departamentos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
