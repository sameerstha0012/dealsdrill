<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();
            $table->integer('other_category_id')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->string('ads_id', 30);
            $table->string('name');
            $table->string('slug');
            $table->text('features')->nullable()->default(NULL);
            $table->float('price', 8, 2);
            $table->enum('price_negotiable', ['Fixed', 'Negotiable'])->default('Fixed');
            $table->enum('condition', ['Brand New', 'Like New', 'Used'])->default('Brand New');
            $table->string('user_for')->nullable()->default(NULL);
            $table->enum('delivery', ['No', 'Yes'])->default('No');
            $table->string('delivery_area')->nullable()->default(NULL);
            $table->string('pic')->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->enum('status', ['Available', 'Sold'])->default('Available');
            $table->date('expiry_date');
            $table->timestamps();
            
            $table->softDeletes();

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');

            $table->foreign('sub_category_id')
                ->references('id')->on('sub_categories')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

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
