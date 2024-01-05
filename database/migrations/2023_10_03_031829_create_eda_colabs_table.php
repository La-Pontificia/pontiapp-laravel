<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('eda_colabs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_eda')->references('id')->on('edas')->onDelete('cascade');
            $table->uuid('id_colaborador')->references('id')->on('colaboradores')->onDelete('cascade');

            $table->uuid('id_evaluacion')->references('id')->on('evaluaciones')->onDelete('cascade');
            $table->uuid('id_evaluacion_2')->references('id')->on('evaluaciones')->onDelete('cascade');

            $table->uuid('id_cuestionario_colab')->nullable()->default(null);
            $table->uuid('id_cuestionario_super')->nullable()->default(null);

            $table->uuid('id_feedback_1')->nullable()->default(null);
            $table->uuid('id_feedback_2')->nullable()->default(null);

            $table->boolean('enviado')->default(false);
            $table->boolean('aprobado')->default(false);
            $table->boolean('cerrado')->default(false);

            $table->timestamp('fecha_envio')->nullable()->default(null);
            $table->timestamp('fecha_aprobado')->nullable()->default(null);
            $table->timestamp('fecha_cerrado')->nullable()->default(null);

            $table->integer('promedio')->default(0);
            $table->timestamps();
        });

        Schema::table('eda_colabs', function (Blueprint $table) {
            $table->foreign('id_cuestionario_colab')->references('id')->on('cuestionarios');
            $table->index('id_cuestionario_colab');

            $table->foreign('id_cuestionario_super')->references('id')->on('cuestionarios');
            $table->index('id_cuestionario_super');

            // feddbacks
            $table->foreign('id_feedback_1')->references('id')->on('feedbacks');
            $table->index('id_feedback_1');

            $table->foreign('id_feedback_2')->references('id')->on('feedbacks');
            $table->index('id_feedback_2');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('eda_colabs');
    }
};
