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
            Schema::create('playlist_content', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('playlist_id');
                $table->unsignedBigInteger('content_id');
                $table->integer('order')->nullable();
                $table->integer('duration')->nullable();
                $table->timestamps();

                $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade');
                $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_content');
    }
};
