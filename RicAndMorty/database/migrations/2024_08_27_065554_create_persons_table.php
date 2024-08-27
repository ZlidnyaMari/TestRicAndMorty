<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->string('species')->nullable();
            $table->string('gender')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('episode');
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('person_episode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id');
            $table->foreignId('episode_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('person_episode');
    }
};
