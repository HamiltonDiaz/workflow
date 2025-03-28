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
        Schema::create('lista_elementos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->unsignedBigInteger('tipo_lista_elemento_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('tipo_lista_elemento_id')->references('id')->on('tipo_lista_elementos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_elementos');
    }
};
