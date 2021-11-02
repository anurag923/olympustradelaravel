<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMastertimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mastertimers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('mastermarket_id')->unsigned();
            $table->BigInteger('master_id')->unsigned();
            $table->string('timer');
            $table->float('payout',10,2);
            $table->foreign('mastermarket_id')->references('id')->on('master_markets')->onDelete('cascade');
            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');
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
        Schema::dropIfExists('mastertimers');
    }
}
