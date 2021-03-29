<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_type_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('phone_type_id');
            $table->string('number', 20);
            $table->longText('note')->nullable();
            $table->boolean('is_main');
            $table->timestamps();
            $table->foreign('owner_type_id')->references('id')->on('owner_types');
            $table->foreign('phone_type_id')->references('id')->on('phone_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
