<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('news_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('page_name')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('news_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title', 1000);
            $table->string('keywords', 1000);
            $table->string('description', 1000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_details');
    }
};
