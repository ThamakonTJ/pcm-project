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
        Schema::create('purchease__orders', function (Blueprint $table) {
            $table->id('Doc_No');
            $table->string('company_name');
            $table->integer('quantity_pcs');
            $table->integer('untiy_price');
            $table->integer('total');
            $table->integer('vat');
            $table->integer('grand_total');
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
        Schema::dropIfExists('purchease__orders');
    }
};
