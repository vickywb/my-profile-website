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
        Schema::create('experience_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('lang', ['en', 'id'])->default('en');
            $table->longText('job_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_translations');
    }
};
