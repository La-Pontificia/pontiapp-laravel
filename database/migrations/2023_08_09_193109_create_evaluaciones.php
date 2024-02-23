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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('promedio')->default(0);
            $table->integer('autocalificacion')->default(0);

            $table->boolean('autocalificar')->default(false);
            $table->boolean('calificar')->default(false);
            $table->boolean('cerrado')->default(false);

            $table->timestamp('fecha_promedio')->nullable()->default(null);
            $table->timestamp('fecha_autocalificacion')->nullable()->default(null);
            $table->timestamp('fecha_cerrado')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
