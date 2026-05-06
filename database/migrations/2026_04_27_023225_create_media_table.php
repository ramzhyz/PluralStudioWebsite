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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('space_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // showcase, gallery_top, gallery_bottom, team, hero
            $table->string('file_path');
            $table->string('file_type'); // image, video
            $table->string('orientation')->nullable(); // landscape, portrait, square
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
