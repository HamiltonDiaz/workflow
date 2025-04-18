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
        Schema::create('instancia_tareas_flujo', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 45);
            $table->text('descripcion',400)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->integer('orden'); 
            $table->integer('es_final')->default(0);
            $table->integer('es_editable')->default(0);
            $table->text('ruta_archivo',800)->nullable();
            $table->unsignedBigInteger('instancia_paso_flujo_id');
            $table->unsignedBigInteger('estado');
            $table->unsignedBigInteger('asignado_a')->nullable();
            $table->unsignedBigInteger('asignado_por')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('instancia_paso_flujo_id')->references('id')->on('instancia_paso_flujo');
            $table->foreign('estado')->references('id')->on('lista_elementos');
            $table->foreign('asignado_a')->references('id')->on('users');
            $table->foreign('asignado_por')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instancia_tareas_flujo');
    }
};
