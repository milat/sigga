<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->date('date');
            $table->longText('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('activity_classes');
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
        Schema::dropIfExists('activity_lessons');
    }
}
