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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->uuid('child_record_id')->unique();
            $table->string('name')->nullable();
            $table->string('relationship')->nullable();
            $table->text('nik_encrypted')->nullable();
            $table->string('nik_hash', 64)->nullable();
            $table->string('occupation')->nullable();
            $table->foreign('child_record_id')->references('id')->on('child_records')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
