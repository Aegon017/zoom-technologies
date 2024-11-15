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
        Schema::create('footer_offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_section_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('location');
            $table->string('location_url')->nullable();
            $table->string('mobile');
            $table->string('landline')->nullable();
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_offices');
    }
};
