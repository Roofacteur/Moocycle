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
        Schema::create('tbl_raceVache', function (Blueprint $table) {
            $table->integer('num_tblVache')->unsigned(); // Référence vers tbl_vaches
            $table->integer('num_tblRace')->unsigned(); // Référence vers tbl_races

            $table->primary(['num_tblVache', 'num_tblRace']); // Clé primaire composite

            $table->foreign('num_tblVache')->references('num_tblVache')->on('tbl_vaches')->onDelete('cascade');
            $table->foreign('num_tblRace')->references('num_tblRace')->on('tbl_races')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_raceVache');
    }
};
