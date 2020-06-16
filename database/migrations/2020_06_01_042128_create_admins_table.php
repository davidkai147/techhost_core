<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->string('id', 36)->primary()->comment('ID');
            $table->string('name', 128)->default('')->comment('Admin name');
            $table->string('email', 128)->unique()->default('')->comment('Login email');
            $table->string('password', 256)->default('')->comment('Login password');
            $table->string('birthday', 64)->nullable()->comment('birthday');
            $table->integer('gender')->default(3)->comment('gender\n1=Male, 2=female, 3=other');
            $table->string('post_code', 64)->nullable()->comment('Post code');
            $table->string('city_name', 256)->nullable()->comment('City name');
            $table->string('address', 512)->nullable()->comment('Address');
            $table->string('tel', 32)->nullable()->comment('Telephone');
            $table->boolean('is_active')->unsigned()->default(1)->comment('Active flag 0=No, 1=Yes');
            $table->boolean('is_deleted')->unsigned()->default(0)->comment('Delete flag 0=No, 1=Yes');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('created_at')->unsigned()->default(0)->comment('Create datetime（UnixTimestamp）');
            $table->string('created_by', 128)->default('')->comment('Create user');
            $table->integer('updated_at')->unsigned()->default(0)->comment('Update datetime（UnixTimestamp）');
            $table->string('updated_by', 128)->default('')->comment('Update user');
            $table->integer('deleted_at')->unsigned()->default(0)->comment('Delete datetime（UnixTimestamp）');
            $table->string('deleted_by', 128)->default('')->comment('Delete user');

            $table->index(['id', 'email']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }

}
