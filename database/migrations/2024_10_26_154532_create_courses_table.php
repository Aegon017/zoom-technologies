<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail');
            $table->string('thumbnail_alt');
            $table->string('image');
            $table->string('image_alt');
            $table->string('outline_pdf')->nullable();
            $table->string('video_link');
            $table->string('short_description', 500);
            $table->tinyInteger('duration');
            $table->string('duration_type');
            $table->string('training_mode');
            $table->boolean('placement');
            $table->boolean('certificate');
            $table->mediumInteger('original_price')->nullable();
            $table->mediumInteger('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};