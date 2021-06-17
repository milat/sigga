<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('document_type_id');
            $table->unsignedBigInteger('file_id');
            $table->date('date');
            $table->string('code', 20)->nullable();
            $table->longText('title');
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::dropIfExists('documents');
    }
}
