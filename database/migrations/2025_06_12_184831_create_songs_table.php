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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul lagu
            $table->string('artist'); // Artis lagu 
            $table->date('release_date'); // Tanggal rilis
            $table->string('genre'); // Genre lagu
            $table->text('lyrics')->nullable(); // Lirik lagu, nullable jika tidak ada
            $table->string('duration'); // Durasi lagu dalam format HH:MM:SS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
