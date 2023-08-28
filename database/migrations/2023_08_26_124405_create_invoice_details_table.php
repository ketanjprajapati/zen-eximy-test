<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id('invoice_detail_id')->autoIncrement();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('rate', 10, 2);
            $table->string('unit');
            $table->integer('qty');
            $table->decimal('disc_percentage', 5, 2);
            $table->decimal('net_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            // Define foreign keys
            $table->foreign('invoice_id')->references('invoice_id')->on('invoice_masters');
            $table->foreign('product_id')->references('product_id')->on('product_masters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
