<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 60)->nullable();
            $table->integer('author_id')->nullable();
            $table->string('author_type', 255)->nullable();
            $table->tinyInteger('ordering')->nullable();
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
        Schema::dropIfExists('tags');
    }
}
