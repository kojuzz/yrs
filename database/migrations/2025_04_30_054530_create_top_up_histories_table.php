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
        Schema::create('top_up_histories', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique('trx_id_unique');
            $table->bigInteger('wallet_id');
            $table->bigInteger('user_id');
            $table->bigInteger('amount');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'approve', 'reject']);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up_histories');
    }
};
