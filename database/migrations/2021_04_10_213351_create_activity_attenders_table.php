<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityAttendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_attenders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->boolean('has_came')->default(true);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('lesson_id')->references('id')->on('activity_lessons');
            $table->foreign('subscriber_id')->references('id')->on('activity_subscribers');
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->foreign('updated_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_attenders');
    }
}
