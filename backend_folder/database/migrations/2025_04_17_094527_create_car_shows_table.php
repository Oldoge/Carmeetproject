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
        Schema::create('car_shows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('picture')->nullable();
            $table->string('organizer')->nullable();
            $table->date('event_date')->nullable();
            $table->dateTime('event_date_START')->nullable();
            $table->dateTime('event_date_END')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_shows');
    }
};
