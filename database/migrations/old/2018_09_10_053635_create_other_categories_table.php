<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_category_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('pic')->nullable();
            $table->text('description')->nullable()->default(NULL);
            $table->integer('order')->unsigned();
            $table->enum('status', ['Active', 'Banned'])->default('Active');
            $table->timestamps();

            $table->foreign('sub_category_id')
                ->references('id')->on('sub_categories')
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
        Schema::dropIfExists('other_categories');
    }
}
