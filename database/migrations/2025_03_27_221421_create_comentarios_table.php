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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion',400);
            $table->unsignedBigInteger('instancia_tareas_flujo_id');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('instancia_tareas_flujo_id')->references('id')->on('instancia_tareas_flujo');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
