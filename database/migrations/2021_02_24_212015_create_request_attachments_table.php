<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('file_id');
            $table->string('title', 100);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('request_id')->references('id')->on('requests');
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('created_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_attachments');
    }
}
