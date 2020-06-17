<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36)->primary()->comment('ID');
            $table->string('email', 128)->unique()->default('')->comment('Login email');
            $table->string('password', 256)->default('')->comment('Login password');
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

        });

        DB::statement("ALTER TABLE users
                                ADD COLUMN name VARBINARY(256) DEFAULT NULL AFTER `password`,
                                ADD COLUMN user_number VARBINARY(64) NOT NULL UNIQUE AFTER `name`,
                                ADD COLUMN birthday VARBINARY(64) DEFAULT NULL AFTER `user_number`,
                                ADD COLUMN gender VARBINARY(16) DEFAULT NULL AFTER `birthday`,
                                ADD COLUMN post_code VARBINARY(64) DEFAULT NULL AFTER `gender`,
                                ADD COLUMN city_name VARBINARY(256) DEFAULT NULL AFTER `post_code`,
                                ADD COLUMN address VARBINARY(512) DEFAULT NULL AFTER `city_name`,
                                ADD COLUMN tel VARBINARY(32) DEFAULT NULL AFTER `address`
         ");

        Schema::table('users', function (Blueprint $table) {
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
        Schema::drop('users');
    }

}
