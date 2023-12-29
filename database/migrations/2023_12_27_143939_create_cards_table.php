<?php

use App\Models\Card;
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
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner_id')->index();
            $table->foreignUuid('card_request_id')->index();
            $table->string('card_number');
            $table->date('card_validity');
            $table->decimal('card_limit', 64, 0);
            $table->enum('card_type', Card::TYPE)->default('virtual');
            $table->decimal('card_balance', 64, 0);
            $table->string('currency')->default('USD');
            $table->enum('card_status', Card::STATUS);
            $table->decimal('daily_limit', 64, 0);
            $table->decimal('per_transaction_limit', 64, 0);
            $table->decimal('card_fees', 64, 0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('card_request_id')->references('id')->on('card_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
