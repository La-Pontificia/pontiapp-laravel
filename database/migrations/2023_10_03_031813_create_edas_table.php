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
        Schema::create('edas', function (Blueprint $table) {
            $table->id();
            $table->integer('year'); // 2023, 2024, 2025 ...
            $table->integer('n_evaluacion'); // 1 , 2
            $table->string('descripcion')->nullable();
            $table->boolean('wearing')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edas');
    }
};
