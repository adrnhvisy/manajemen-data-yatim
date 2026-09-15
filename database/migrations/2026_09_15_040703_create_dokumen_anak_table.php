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
        Schema::create('dokumen_anak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->cascadeOnDelete();
            $table->foreignId('kategori_dok_id')->constrained('kategori_dokumen')->restrictOnDelete();
            $table->unique(['anak_id', 'kategori_dok_id']);
            $table->string('file_path');
            $table->enum('status_verifikasi', ['Pending', 'Valid', 'Tidak Valid'])->default('Pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index('status_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_anak');
    }
};
