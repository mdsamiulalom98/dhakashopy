<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('purchase_price');
            $table->integer('old_price')->nullable();
            $table->integer('new_price');
            $table->integer('stock');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('product_variables');
    }
};
