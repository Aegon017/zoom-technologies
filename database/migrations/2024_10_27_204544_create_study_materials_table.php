<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('image');
            $table->string('image_alt');
            $table->string('material_url')->nullable();
            $table->string('material_pdf')->nullable();
            $table->string('subscription');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
