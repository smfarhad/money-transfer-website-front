<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeRateTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('exchange_rate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('rate', 15, 8);
        });
        Schema::create('history_exchange_rate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exchange_rate_id');
            $table->double('present_rate', 15, 8);
            $table->double('updated_rate', 15, 8);
            $table->integer('updated_by');
            $table->dateTimeTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('exchange_rate');
        Schema::dropIfExists('history_exchange_rate');
    }

}
