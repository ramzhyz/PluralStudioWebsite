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
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('checkin_signature')->nullable();     // base64 signature client
            $table->text('checkout_signature')->nullable();    // base64 signature client checkout
            $table->text('staff_checkin_signature')->nullable(); // base64 signature staff
            $table->text('staff_checkout_signature')->nullable();
            $table->string('staff_name')->nullable();
            $table->string('deposit_amount')->nullable()->default('1000000');
            $table->string('deposit_method')->nullable();
            $table->string('checkin_path')->nullable();        // path PDF checkin
            $table->string('checkout_path')->nullable();       // path PDF checkout
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();

            // Checkout inspection
            $table->string('cyclorama_status')->nullable()->default('Ok');
            $table->string('floor_status')->nullable()->default('Ok');
            $table->string('furniture_status')->nullable()->default('Ok');
            $table->string('lighting_status')->nullable()->default('Ok');
            $table->string('equipment_status')->nullable()->default('Ok');
            $table->string('payment_method_final')->nullable();
            $table->bigInteger('deposit_deducted')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
