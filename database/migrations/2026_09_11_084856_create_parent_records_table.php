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
        Schema::create('parent_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('child_record_id');
            $table->enum('type', ['father', 'mother']);
            $table->string('name');
            $table->text('nik_encrypted')->nullable();
            $table->string('nik_hash', 64)->nullable();
            $table->string('occupation')->nullable();
            $table->enum('life_status', ['hidup', 'meninggal'])->nullable();
            $table->foreign('child_record_id')->references('id')->on('child_records')->cascadeOnDelete();
            $table->unique(['child_record_id', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_records');
    }
};
