<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->string('name', 100);
            $table->string('identity_document', 20);
            $table->string('email', 100)->nullable();
            $table->date('birth')->nullable();
            $table->longText('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
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
        Schema::dropIfExists('citizens');
    }
}
