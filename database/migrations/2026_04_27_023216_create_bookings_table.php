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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('space_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('email');
        $table->string('whatsapp');
        $table->string('booking_date');
        $table->string('duration');
        $table->text('addon')->nullable();
        $table->text('notes')->nullable();
        $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
        $table->string('payment_status')->default('unpaid');
        $table->string('payment_method')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
