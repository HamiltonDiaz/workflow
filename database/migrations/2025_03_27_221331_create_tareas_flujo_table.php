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
        Schema::create('tareas_flujo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasos_flujo_id');            
            $table->string('titulo', 45);
            $table->text('descripcion',400)->nullable();
            $table->integer('orden'); 
            $table->integer('es_final')->default(0);
            $table->integer('es_editable')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('pasos_flujo_id')->references('id')->on('pasos_flujo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_flujo');
    }
};
