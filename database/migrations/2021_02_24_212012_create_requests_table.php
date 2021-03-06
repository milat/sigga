<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->morphs('owner');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->string('title', 100);
            $table->longText('description');
            $table->string('place', 150)->nullable();
            $table->date('reminder')->nullable();
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('category_id')->references('id')->on('request_categories');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('status_id')->references('id')->on('request_statuses');
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
        Schema::dropIfExists('requests');
    }
}
