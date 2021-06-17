<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('responsible_user_id');
            $table->string('place', 200);
            $table->string('schedule', 400)->nullable();
            $table->integer('max_subscribers')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('responsible_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('activity_classes');
    }
}
