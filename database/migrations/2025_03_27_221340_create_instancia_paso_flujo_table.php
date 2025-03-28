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
        Schema::create('instancia_paso_flujo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion',400)->nullable();
            $table->integer('orden'); 
            $table->integer('es_final')->default(0);
            $table->unsignedBigInteger('instancia_flujo_trabajo_id');            
            $table->unsignedBigInteger('estado');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('instancia_flujo_trabajo_id')->references('id')->on('instancia_flujo_trabajo');
            $table->foreign('estado')->references('id')->on('lista_elementos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instancia_paso_flujo');
    }
};
