<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('factor_id');
            $table->string('name');
            $table->integer('product_id');
            $table->integer('count');
            $table->integer('price');
            $table->integer('new_price');
            $table->integer('discount');
            $table->integer('total_price');
            $table->integer('total_discount_price');
            $table->integer('install')->nullable();
            $table->integer('Total_discount');
            $table->bigInteger('Total')->nullable();
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
        Schema::dropIfExists('factors');
    }
}
