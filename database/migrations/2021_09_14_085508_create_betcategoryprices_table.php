<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetcategorypricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betcategoryprices', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('betcategory_id')->unsigned();
            $table->float('amount',10,2);
            $table->string('status')->default(1);
            $table->foreign('betcategory_id')->references('id')->on('betcategories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('betcategoryprices');
    }
}
