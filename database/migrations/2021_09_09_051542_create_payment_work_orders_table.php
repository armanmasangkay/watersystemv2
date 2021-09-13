<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('customer_id');
            $table->string('or_no')->unique();
            $table->double('payment_amount');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('payment_workorders');
    }
}
