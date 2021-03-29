<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_type_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('postal_code', 15)->nullable();
            $table->string('address', 255);
            $table->unsignedBigInteger('address_type_id');
            $table->string('number', 10);
            $table->string('extra')->nullable();
            $table->string('neighborhood');
            $table->string('city', 100);
            $table->string('state', 30);
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->foreign('owner_type_id')->references('id')->on('owner_types');
            $table->foreign('address_type_id')->references('id')->on('address_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
