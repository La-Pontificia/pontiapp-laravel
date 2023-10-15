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
        Schema::create('accesos', function (Blueprint $table) {
            $table->id();
            $table->string('modulo', 50)->require(); // m_colaboradores | m_accesos |  m_edas | m_areas | m_departamentos | m_cargos | m_puestos | m_sedes
            $table->integer('crear')->default(0);
            $table->integer('leer')->default(0);
            $table->integer('actualizar')->default(0);
            $table->integer('eliminar')->default(0);
            $table->unsignedBigInteger('id_colaborador');
            $table->foreign('id_colaborador')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesos');
    }
};
