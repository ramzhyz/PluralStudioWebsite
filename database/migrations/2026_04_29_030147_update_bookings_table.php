<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'contacted', 
                'invoice_sent',
                'confirmed',
                'completed',
                'cancelled'
            ])->default('pending')->change();
            
            $table->string('invoice_path')->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->text('completion_notes')->nullable();
            $table->string('extra_time')->nullable();
            $table->text('damage_notes')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->string('invoice_number')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_path',
                'payment_proof_path', 
                'completion_notes',
                'extra_time',
                'damage_notes',
                'total_price',
                'invoice_number',
            ]);
        });
    }
};
