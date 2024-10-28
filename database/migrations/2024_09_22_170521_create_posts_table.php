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
        Schema::create('posts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(\App\Models\User::class)->references('id')->on('users')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('location')->nullable();
            $table->boolean('hide_like_view')->default(false);
            $table->boolean('allow_commenting')->default(true);
            $table->enum('type', ['reel', 'post'])->default('post');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
