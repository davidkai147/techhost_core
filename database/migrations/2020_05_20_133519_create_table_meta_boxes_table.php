<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMetaBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_boxes', function (Blueprint $table) {
            $table->bigIncrements('meta_id');
            $table->bigInteger('pp_id');
            $table->string('meta_key')->nullable();
            $table->longText('meta_value')->nullable();
            $table->string('cols_type')->nullable();
            $table->timestamps();

            $table->index('meta_key');
            $table->index('pp_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_boxes');
    }
}
