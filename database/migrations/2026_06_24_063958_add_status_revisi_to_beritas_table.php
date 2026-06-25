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
        Schema::table('beritas', function (Blueprint $table) {
            DB::statement("ALTER TABLE beritas MODIFY COLUMN status_berita ENUM('Draft', 'Pending', 'Published', 'Rejected', 'Revisi') DEFAULT 'Draft'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            DB::statement("ALTER TABLE beritas MODIFY COLUMN status_berita ENUM('Draft', 'Pending', 'Published', 'Rejected') DEFAULT 'Draft'");
        });
    }
};
