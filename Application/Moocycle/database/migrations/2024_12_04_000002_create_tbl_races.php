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
        Schema::create('tbl_races', function (Blueprint $table) {
            $table->increments('num_tblRace'); // Clé primaire
            $table->string('nom', 50); // Champ VARCHAR(50) non nul
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_races');
    }
};
