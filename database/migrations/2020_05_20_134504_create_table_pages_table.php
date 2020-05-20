<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 120)->unique()->nullable();
            $table->string('slug')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->nullable();
            $table->string('template', 60)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('images')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('parent_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
