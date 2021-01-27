<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->enum('type', ['income', 'expense','saving']);
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->double('amount', 10, 2)->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('repeat_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
