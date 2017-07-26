<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cus_id');
            $table->foreign('cus_id')->references('id')->on('customers');

            $table->unsignedInteger('pro_id');
            $table->foreign('pro_id')->references('id')->on('products');
            
            $table->integer('qty');
            $table->float('price');
            $table->decimal('dis');
            $table->float('amount');
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
        Schema::dropIfExists('sales');
    }
}
