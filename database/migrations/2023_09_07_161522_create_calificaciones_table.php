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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_objetivo');
            $table->foreign('id_objetivo')->references('id')->on('objetivos')->onDelete('cascade');

            //
            $table->unsignedBigInteger('id_supervisor');
            $table->foreign('id_supervisor')->references('id')->on('colaboradores')->onDelete('cascade');

            //
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->integer('aprobado');

            //
            $table->decimal('pun_01', 3, 1)->default(0.0);
            $table->integer('eva_01')->default(0);
            $table->integer('apr_01')->default(0);
            $table->timestamp('f_apr_01')->nullable();
            $table->timestamp('f_eva_01')->nullable();
            $table->timestamp('c_01')->nullable();

            //
            $table->decimal('pun_02', 3, 1)->default(0.0);
            $table->integer('eva_02')->default(0);
            $table->integer('apr_02')->default(0);
            $table->timestamp('f_apr_02')->nullable();
            $table->timestamp('f_eva_02')->nullable();
            $table->timestamp('c_02')->nullable();

            //
            $table->integer('c_eda')->default(0);
            $table->integer('c_f_eda')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
