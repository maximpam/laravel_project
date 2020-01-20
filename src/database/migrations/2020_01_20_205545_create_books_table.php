<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->char('name', 12);
            $table->date('year');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('edition_id');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('edition_id')->references('id')->on('editions');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
