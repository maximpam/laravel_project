<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->char('name', 12)->unique();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('owner_id');
        });

        Schema::table('editions', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('owner_id')->references('id')->on('owners');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editions');
    }
}
