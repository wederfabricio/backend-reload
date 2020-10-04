<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique()->nullable(false);
            $table->integer('quantity')->nullable(false);
            $table->string('resume')->nullable(false);
            $table->double('price_ht')->nullable(false);
            $table->double('price_ttc')->nullable(false);
            $table->string('desc')->nullable(false);
            $table->boolean('active')->nullable(false);
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
        Schema::dropIfExists('products');
    }
}
