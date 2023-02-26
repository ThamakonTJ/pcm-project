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
        Schema::create('pr__details', function (Blueprint $table) {
            $table->id('Doc_No');
            $table->string('product_id');
            $table->string('user_id');
            $table->string('name');
            $table->string('department');
            $table->string('quantity');
            $table->string('PR_unitiy_price');
            $table->string('reason_to_buy');
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
        Schema::dropIfExists('pr__details');
    }
};
