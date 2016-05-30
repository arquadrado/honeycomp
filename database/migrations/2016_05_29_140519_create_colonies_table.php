<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colonies', function(Blueprint $table){
            $table->increments('id');
            $table->integer('beehive_id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('population')->unsigned();
            $table->timestamps();

            $table->foreign('beehive_id')->references('id')->on('beehives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('colonies', function(Blueprint $table){
            $table->dropForeign('colonies_beehive_id_foreign');
        });
    }
}
