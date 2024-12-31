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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_category_id')->newconstrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('thumbnail');
            $table->string('thumbnail_alt');
            $table->string('image');
            $table->string('image_alt');
            $table->string('source');
            $table->string('source_url')->nullable();
            $table->string('content', 8000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
