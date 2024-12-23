<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('timezone_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->time('time');
            $table->time('end_time');
            $table->tinyInteger('duration');
            $table->string('duration_type');
            $table->string('day_off');
            $table->string('training_mode');
            $table->string('zoom_meeting_url')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('certificate_status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
