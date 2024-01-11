<?php

use App\Models\Transaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('card_id')->index();
            $table->enum('type', Transaction::TYPE);
            $table->enum('method', Transaction::METHOD)->nullable();
            $table->date('date');
            $table->string('merchant')->nullable();
            $table->decimal('amount', 64, 0);
            $table->string('currency')->default('USD');
            $table->json('receips')->nullable();
            $table->boolean('confirmed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('card_id')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
