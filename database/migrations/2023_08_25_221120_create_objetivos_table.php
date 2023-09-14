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
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_colaborador');
            $table->foreign('id_colaborador')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->unsignedBigInteger('id_supervisor');
            $table->foreign('id_supervisor')->references('id')->on('colaboradores')->onDelete('cascade');
            //
            $table->string('objetivo', 255);
            $table->string('descripcion', 1255);
            $table->string('indicadores', 1255);
            $table->decimal('porcentaje', 5, 2);

            $table->integer('estado')->default(0); // 0= DESAPROBADO, 1=PENDIENTE, 2=APROBADO
            $table->timestamp('estado_fecha')->nullable();

            $table->string('feedback', 455)->nullable();
            $table->timestamp('feedback_fecha')->nullable();

            $table->integer('nota_colab');
            $table->integer('nota_super')->default(0);
            $table->timestamp('nota_super_fecha')->nullable();

            $table->integer('eva')->default(1); // 1= EVA1, 2=EVA2
            $table->string('año', 4)->nullable();

            $table->integer('notify_super')->default(1);
            $table->integer('notify_colab')->nullable(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos');
    }
};
