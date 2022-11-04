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
            $table->bigInteger('product_id');
            $table->bigInteger('member_id')->nullable();
            $table->integer('count');
            $table->integer('price');
            $table->integer('new_price')->nullable();
            $table->integer('discount')->default(0)->nullable();
            $table->integer('total_price');
            $table->integer('total_discount_price')->nullable();
            $table->string('install')->nullable();
            $table->string('install_toman')->nullable();
            $table->integer('Total_discount')->nullable();
            $table->bigInteger('Total')->nullable();
            $table->integer('ordering')->nullable();
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
