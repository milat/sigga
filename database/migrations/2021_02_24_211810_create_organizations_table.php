<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('user_id');
            $table->string('trade', 30);
            $table->string('name', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->string('identity_document', 30)->unique()->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact', 100);
            $table->longText('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('owner_type_id')->default(config('owner_types.organizations.id'));
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('organizations');
    }
}
