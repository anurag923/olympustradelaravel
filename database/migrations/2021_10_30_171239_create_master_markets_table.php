<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_markets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('master_id')->unsigned();
            $table->BigInteger('market_id')->unsigned();
            $table->string("status")->default(0);
            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
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
        Schema::dropIfExists('master_markets');
    }
}
