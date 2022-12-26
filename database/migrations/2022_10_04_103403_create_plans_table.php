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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('ext')->nullable();
            $table->string('bath')->nullable();
            $table->string('bedroom')->nullable();
            $table->string('kitchen')->nullable();
            $table->string('toilets')->nullable();
            $table->string('living_room')->nullable();
            $table->string('verandah')->nullable();
            $table->string('store')->nullable();
            $table->string('story')->nullable();
            $table->string('sqm')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
