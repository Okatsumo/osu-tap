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
        Schema::create('beatmapsets', function (Blueprint $table) {
            $table->id();
            $table->string('artist');
            $table->string('artist_unicode');
            $table->boolean('is_cover')->default(true);
            $table->string('creator')->nullable(false);
            $table->boolean('nsfw')->default(true);
            $table->string('play_count')->default(0);
            $table->string('is_preview')->default(true);
            $table->string('source');
            $table->boolean('spotlight');
            $table->enum('status', ['ranked', 'qualified', 'disqualified', 'never_qualified', 'approved', 'loved', 'graveyard', 'pending', 'wip']);
            $table->string('title');
            $table->string('title_unicode');
            $table->integer('user_id');
            $table->boolean('video')->default(false);
            $table->float('bpm', 10);
            $table->integer('ranked')->nullable(false)->default(0);
            $table->dateTime('ranked_date')->default(null)->nullable();
            $table->boolean('storyboard')->nullable(false);
            $table->dateTime('submitted_date')->default(null)->nullable();
            $table->dateTime('last_updated')->default(null)->nullable();
            $table->text('tags')->default(null)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beatmapsets');
    }
};
