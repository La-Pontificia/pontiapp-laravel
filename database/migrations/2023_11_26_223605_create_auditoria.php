<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_colab');
            $table->foreign('id_colab')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('modulo')->default('Unknown');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
