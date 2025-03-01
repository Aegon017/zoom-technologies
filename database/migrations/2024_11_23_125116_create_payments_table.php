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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_number')->nullable();
            $table->string('payment_id');
            $table->string('method');
            $table->string('mode')->nullable();
            $table->string('description');
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->mediumInteger('amount');
            $table->string('currency')->default('Rs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
