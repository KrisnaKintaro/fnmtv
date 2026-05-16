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
        Schema::create('iklans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('gambar');
            $table->string('posisi'); // horizontal_728x90 atau sidebar_300x250
            $table->string('link_tujuan')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Ubah bagian ini:
            $table->unsignedBigInteger('dibuat_oleh');
            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iklans');
    }
};