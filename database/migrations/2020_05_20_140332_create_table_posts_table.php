<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->unique()->nullable();
            $table->string('slug')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->nullable();
            $table->string('format_type', 60)->nullable();
            $table->string('images')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->tinyInteger('ordering')->nullable();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
