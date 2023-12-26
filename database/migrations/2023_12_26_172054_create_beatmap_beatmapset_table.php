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
        Schema::create('beatmap_beatmapset', function (Blueprint $table) {
            $table->unsignedBigInteger('beatmapset_id')->nullable(false);
            $table->unsignedBigInteger('beatmap_id')->nullable(false);

            $table->foreign('beatmapset_id')->on('beatmapsets')->references('id')->onDelete('cascade');
            $table->foreign('beatmap_id')->on('beatmaps')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beatmap_beatmapset');
    }
};
