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
        Schema::create('child_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('submission_number')->unique();
            $table->string('full_name');
            $table->text('nik_encrypted')->nullable();
            $table->string('nik_hash', 64)->nullable()->unique();
            $table->text('bank_account_encrypted')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->enum('child_status', ['yatim', 'piatu', 'yatim piatu']);
            $table->text('family_card_number_encrypted')->nullable();
            $table->text('address');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('current_status', ['draft', 'diajukan_ke_kecamatan', 'dikembalikan_ke_kelurahan', 'diajukan_ke_kesra', 'disetujui', 'ditolak_kesra'])->default('draft')->index();
            $table->uuid('office_id')->index();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreign('office_id')->references('id')->on('offices')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['office_id', 'current_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_records');
    }
};
