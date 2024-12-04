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
        Schema::create('tbl_vache', function (Blueprint $table) {
            $table->increments('numero')->primary(); // Clé primaire
            $table->string('nom', 50); // Champ VARCHAR(50) non nul
            $table->date('date_prochaine_chaleur')->nullable(); // Champ DATE, nullable
            $table->date('date_insemination')->nullable(); // Champ DATE, nullable
            $table->date('date_naissance'); // Champ DATE non nul
            $table->integer('nombre_lactation')->nullable(); // Champ INT, nullable
            $table->string('race', 50); // Champ VARCHAR(50) non nul
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_vache');
    }
};
