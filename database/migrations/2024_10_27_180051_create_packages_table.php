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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position');
            $table->string('courses');
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
            $table->mediumInteger('sale_price')->nullable();
            $table->mediumInteger('actual_price');
            $table->string('message', 500)->nullable();
            $table->decimal('rating', 2, 1);
            $table->unsignedInteger('number_of_ratings');
            $table->unsignedInteger('number_of_students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
