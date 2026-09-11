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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('child_record_id');
            $table->foreignId('reviewer_id')->constrained('users')->restrictOnDelete();
            $table->enum('stage', ['kecamatan', 'kesra']);
            $table->enum('decision', ['forward', 'return', 'approve', 'reject']);
            $table->text('notes')->nullable();
            $table->foreign('child_record_id')->references('id')->on('child_records')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
