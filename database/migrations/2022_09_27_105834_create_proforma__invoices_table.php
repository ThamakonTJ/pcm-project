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
        Schema::create('proforma__invoices', function (Blueprint $table) {
            $table->id('Doc_No');
            $table->string('PO_NO');
            $table->string('product_id');
            $table->string('quantity');
            $table->string('unity_price');
            $table->string('amount_usd');
            $table->string('total_pcs');
            $table->string('grand_total');
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
        Schema::dropIfExists('proforma__invoices');
    }
};
