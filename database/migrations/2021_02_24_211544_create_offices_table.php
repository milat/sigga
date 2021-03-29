<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('city', 100)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('party', 20)->nullable();
            $table->longText('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('owner_type_id')->default(config('owner_types.offices.id'));
            $table->timestamps();
            $table->foreign('owner_type_id')->references('id')->on('owner_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
