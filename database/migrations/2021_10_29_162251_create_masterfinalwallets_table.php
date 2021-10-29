<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterfinalwalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masterfinalwallets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('master_id')->unsigned();
            $table->float('amount',10,2);
            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');
            $table->string('status')->default(1);
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
        Schema::dropIfExists('masterfinalwallets');
    }
}
