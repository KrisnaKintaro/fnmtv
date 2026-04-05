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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained()->cascadeOnDelete();

            $table->string('judul_berita');
            $table->string('slug')->unique(); // URL SEO Friendly
            $table->longText('isi_berita');
            $table->string('foto_thumbnail');
            $table->string('foto_isi_berita')->nullable();
            $table->text('catatan_penolakan')->nullable();

            // Pake index biar pas pengunjung cari berita "Published" loadingnya cepet
            $table->enum('status_berita', ['Draft', 'Pending','Published', 'Rejected'])->default('Draft')->index();
            $table->integer('jumlah_view')->default(0); // Buat nampilin angka total aja
            $table->timestamp('waktu_publikasi')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
