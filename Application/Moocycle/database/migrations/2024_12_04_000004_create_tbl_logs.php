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
        Schema::create('tbl_logs', function (Blueprint $table) {
            $table->increments('num_tblLog'); // Clé primaire
            $table->integer('num_tblVache')->unsigned(); // Référence vers tbl_vaches
            $table->date('date_evenement'); // Date de l'événement (chaleur, insémination, etc.)
            $table->boolean('insemination')->default(false); // Indique si c'est une insémination

            $table->foreign('num_tblVache')->references('num_tblVache')->on('tbl_vaches')->onDelete('cascade');
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
