<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeehivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beehives', function(Blueprint $table){
            $table->increments('id');
            $table->integer('apiary_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('type');
            $table->timestamps();

            $table->foreign('apiary_id')->references('id')->on('apiaries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('beehives', function(Blueprint $table){
            $table->dropForeign('beehives_apiary_id_foreign');
        });
    }
}
