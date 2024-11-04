<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_type');
            $table->string('city');
            $table->string('address');
            $table->string('landline')->nullable();
            $table->string('mobile');
            $table->string('email');
            $table->string('website');
            $table->string('map_iframe', 800);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_locations');
    }
};
