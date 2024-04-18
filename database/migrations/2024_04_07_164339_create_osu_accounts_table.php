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
        Schema::create('osu_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->enum('proxy_type', ['http', 'https'])->nullable(false);
            $table->string('proxy_host')->nullable(false);
            $table->string('proxy_login')->nullable(false);
            $table->string('proxy_password')->nullable(false);
            $table->integer('proxy_port')->nullable(false);

            $table->text('refresh_token')->nullable(false);
            $table->text('access_token')->nullable(false);
            $table->integer('expires_in')->nullable(false);

            $table->string('user_agent')->nullable(false);
            $table->string('client_secret')->nullable(false);
            $table->string('client_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osu_accounts');
    }
};
