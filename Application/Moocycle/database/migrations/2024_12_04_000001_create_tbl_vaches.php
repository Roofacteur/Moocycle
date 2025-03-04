<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_vaches', function (Blueprint $table) {
            $table->increments('num_tblVache'); // Clé primaire
            $table->string('nom', 50)->nullable(); // Champ VARCHAR(50) non nul
            $table->integer('numero_collier')->nullable();
            $table->string('numero_oreille', 50);
            $table->date('date_prochaine_chaleur')->nullable(); // Champ DATE, nullable
            $table->date('date_insemination')->nullable(); // Champ DATE, nullable
            $table->date('date_naissance'); // Champ DATE non nul
            $table->integer('nombre_lactation')->nullable(); // Champ INT, nullable
            $table->foreignId('num_tblUser')->constrained('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_vaches');
    }
};
