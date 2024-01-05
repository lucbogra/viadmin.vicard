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
        Schema::create('card_top_up_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('card_id');
            $table->foreignUuid('user_id');
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'validated', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_top_up_requests');
    }
};
