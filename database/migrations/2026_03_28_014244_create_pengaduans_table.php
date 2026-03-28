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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pengaduan');
            $table->foreignId('id_siswa')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('id_kategori')->constrained('kategoris')->cascadeOnDelete();
            $table->string('lokasi');
            $table->text('keterangan');
            $table->enum('status', ['menunggu', 'proses', 'selesai'])->default('menunggu');
            $table->text('feedback')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
