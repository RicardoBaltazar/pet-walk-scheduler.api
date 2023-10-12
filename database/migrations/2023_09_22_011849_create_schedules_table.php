<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('walker_id');
            $table->date('date');
            $table->unsignedBigInteger('pet_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status', 20);

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('walker_id')->references('id')->on('users');
            $table->foreign('pet_id')->references('id')->on('pets');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
