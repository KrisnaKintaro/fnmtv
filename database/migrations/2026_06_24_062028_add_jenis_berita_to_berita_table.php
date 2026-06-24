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
            $table->enum('jenis_berita', ['reguler', 'feature'])->default('reguler')->after('id');
            $table->integer('harga_berita')->nullable()->after('jenis_berita');
            $table->string('bukti_pembayaran')->nullable()->after('harga_berita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['jenis_berita', 'harga_berita', 'bukti_pembayaran']);
        });
    }
};
