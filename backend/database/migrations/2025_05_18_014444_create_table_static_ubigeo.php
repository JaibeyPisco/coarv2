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
        Schema::create('static_ubigeo', function (Blueprint $table) {

            $table->integer('id_ubigeo')->primary();
            $table->string('departamento');
            $table->string('provincia');
            $table->string('distrito');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_static_ubigeo');
    }
};
