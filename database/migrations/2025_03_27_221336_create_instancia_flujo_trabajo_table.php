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
        Schema::create('instancia_flujo_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('consecutivo')->unique();
            $table->text('descripcion',400)->nullable();
            $table->unsignedBigInteger('flujo_trabajo_id');            
            $table->softDeletes();
            $table->timestamps();            
            $table->foreign('flujo_trabajo_id')->references('id')->on('flujo_trabajo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instancia_flujo_trabajo');
    }
};
