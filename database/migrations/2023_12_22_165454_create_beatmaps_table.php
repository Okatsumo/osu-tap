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
        Schema::create('beatmaps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('difficulty_rating');
            $table->enum('mode', ['fruits', 'mania', 'osu', 'taiko'])->nullable(false);
            $table->enum('status', ['ranked', 'qualified', 'disqualified', 'never_qualified'])->nullable(false);
            $table->integer('total_length')->nullable(false);
            $table->integer('user_id')->nullable(false);
            $table->string('version')->nullable(false);
            $table->integer('accuracy')->nullable(false);
            $table->integer('ar')->nullable(false);
            $table->integer('bpm')->nullable(false);
            $table->boolean('convert')->nullable(false);
            $table->integer('count_circles')->nullable(false);
            $table->integer('count_sliders')->nullable(false);
            $table->integer('count_spinners')->nullable(false);
            $table->integer('cs')->nullable(false);
            $table->dateTime('deleted_at')->nullable(true)->default(null);
            $table->integer('drain')->nullable(false);
            $table->integer('hit_length')->nullable(false);
            $table->boolean('is_scoreable')->nullable(false);
            $table->integer('mode_int')->nullable(false);
            $table->integer('passcount')->nullable(false);
            $table->integer('playcount')->nullable(false);
            $table->integer('ranked')->nullable(false);
            $table->string('url')->nullable(false);
            $table->string('checksum')->nullable(false);
            $table->integer('max_combo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beatmaps');
    }
};
