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
        Schema::create('user_profile_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_profile_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('lang', ['en', 'id'])->default('en');
            $table->text('bio')->nullable();
            $table->longText('full_bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile_translations');
    }
};
