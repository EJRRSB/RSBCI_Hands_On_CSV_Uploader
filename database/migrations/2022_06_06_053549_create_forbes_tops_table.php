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
    public function up()
    {
        Schema::create('forbes_tops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('year')->nullable();
            $table->string('rank')->nullable();
            $table->string('recipient')->nullable();
            $table->string('country')->nullable();
            $table->string('career')->nullable();
            $table->string('tied')->nullable(); 
            $table->string('title')->nullable(); 
            $table->timestamps();

            
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forbes_tops');
    }
};
