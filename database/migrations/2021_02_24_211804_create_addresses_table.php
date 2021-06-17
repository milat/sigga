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
            $table->morphs('owner');
            $table->string('code', 15)->nullable();
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('address_type_id');
            $table->string('number', 10)->nullable();
            $table->string('extra')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('country', 30)->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
