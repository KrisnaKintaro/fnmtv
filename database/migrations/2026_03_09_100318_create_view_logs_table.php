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
        Schema::create('view_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address')->nullable(); // Mencegah spam view dari IP yang sama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_logs');
    }
};
