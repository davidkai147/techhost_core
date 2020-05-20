<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->unique()->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 60)->nullable();
            $table->integer('author_id')->nullable();
            $table->string('author_type', 255)->nullable();
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->tinyInteger('ordering')->nullable();
            $table->tinyInteger('is_default')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('parent_id');
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
