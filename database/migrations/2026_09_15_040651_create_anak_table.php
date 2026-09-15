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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi',30)->unique();
            $table->string('nama_lengkap');
            $table->string('no_kk',16);
            $table->string('nik',16)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status_anak', ['Yatim', 'Piatu', 'Yatim Piatu']);
            $table->string('no_rekening',30)->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('alamat_domisili_id')->constrained('alamat')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->nullOnDelete();
            $table->enum('status_data', ['Draft','Pending','Disetujui','Ditolak'])->default('Draft')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
