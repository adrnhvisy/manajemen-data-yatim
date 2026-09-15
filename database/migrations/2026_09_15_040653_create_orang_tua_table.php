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
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->cascadeOnDelete();
            $table->enum('jenis_orang_tua', ['Ayah', 'Ibu']);
            $table->unique(['anak_id', 'jenis_orang_tua']);
            $table->string('nama');
            $table->char('nik',16)->nullable();
            $table->enum('status_hidup', ['Hidup', 'Meninggal']);
            $table->string('pekerjaan')->nullable();
            $table->foreignId('alamat_id')->nullable()->constrained('alamat')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};
