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
        Schema::create('merchants', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('merchant');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignUuid('merchant_id')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('merchant')->nullable();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('merchant_id');
        });
    }
};
