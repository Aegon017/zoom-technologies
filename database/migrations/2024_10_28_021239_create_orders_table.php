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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number');
            $table->string('transaction_id');
            $table->string('payu_id');
            $table->string('payment_mode')->nullable();
            $table->string('payment_time');
            $table->string('payment_desc');
            $table->mediumInteger('amount');
            $table->string('status');
            $table->string('invoice')->nullable();
            $table->string('course_name');
            $table->string('course_thumbnail');
            $table->string('course_thumbnail_alt');
            $table->tinyInteger('course_duration');
            $table->string('course_duration_type');
            $table->string('course_schedule');
            $table->mediumInteger('course_price');
            $table->smallInteger('sgst');
            $table->smallInteger('cgst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
