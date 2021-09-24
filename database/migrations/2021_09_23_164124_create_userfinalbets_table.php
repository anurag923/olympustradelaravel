<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserfinalbetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userfinalbets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->string('market');
            $table->float('betamount',10,2);
            $table->string('start_date');
            $table->string('start_time');
            $table->string('end_date')->nullable();
            $table->string('end_time')->nullable();
            $table->BigInteger('timer_id')->unsigned();
            $table->float('exposure',8,2)->default(0.00);
            $table->integer('profitloss')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('timer_id')->references('id')->on('timers')->onDelete('cascade');
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
        Schema::dropIfExists('userfinalbets');
    }
}
