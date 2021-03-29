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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('owner_type_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('status_id');
            $table->string('title', 100);
            $table->longText('description');
            $table->string('place', 150)->nullable();
            $table->date('reminder')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('owner_type_id')->references('id')->on('owner_types');
            $table->foreign('category_id')->references('id')->on('request_categories');
            $table->foreign('status_id')->references('id')->on('request_statuses');
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
