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
        Schema::create('manual_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_phone');
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('packageSchedule_id')->nullable();
            $table->mediumInteger('course_price');
            $table->mediumInteger('cgst');
            $table->mediumInteger('sgst');
            $table->mediumInteger('amount');
            $table->string('payment_mode');
            $table->string('proof');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_orders');
    }
};
