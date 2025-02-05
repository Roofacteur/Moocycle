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
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->increments('num_tblLog'); // Clé primaire
            $table->date('date'); // Champ DATE
            $table->boolean('insemination'); // Champ BOOL pour l'insemination
            $table->unsignedInteger('num_tblVache'); // Clé étrangère
            $table->foreign('num_tblVache')->references('num_tblVache')->on('tbl_vaches')->onDelete('cascade'); // Définir la clé étrangère et la contrainte de suppression
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_logs');
    }
};
