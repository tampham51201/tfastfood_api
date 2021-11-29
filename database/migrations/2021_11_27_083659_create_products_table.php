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
            $table->string('name');
            $table->string('category_id');
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->integer('qty');

            $table->string('img01');
            $table->string('img02')->nullable();

            $table->decimal('orginal_price');
            $table->decimal('selling_price')->nullable();;
           
            $table->tinyInteger('popular')->default('0');
            $table->tinyInteger('featured')->default('0');
            $table->tinyInteger('status')->default('0');

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