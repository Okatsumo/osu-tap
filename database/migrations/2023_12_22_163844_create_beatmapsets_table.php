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
            $table->string('artist')->nullable(false);
            $table->string('artist_unicode');
            $table->string('cover'); // cover Files
            $table->string('creator')->nullable(false);
            $table->boolean('nsfw')->nullable(false)->default(true);
            $table->string('play_count')->nullable(false)->default(0);
            $table->string('preview_url'); //mp3 file
            $table->string('source');
            $table->boolean('spotlight')->nullable(false);
            $table->enum('status', ['ranked', 'qualified', 'disqualified', 'never_qualified', 'approved'])->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('title_unicode');
            $table->integer('user_id')->nullable(false);
            $table->boolean('video')->default(false)->nullable(false);
            $table->float('bpm')->nullable(false);
            $table->integer('ranked')->nullable(false)->default(0);
            $table->dateTime('ranked_date')->default(null);
            $table->boolean('storyboard')->nullable(false);
            $table->dateTime('submitted_date')->default(null);
            $table->dateTime('last_updated')->default(null);
            $table->text('tags');
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
