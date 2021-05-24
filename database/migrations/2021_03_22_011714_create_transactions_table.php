<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('period_covered');
            $table->date('reading_date');
            $table->double('reading_meter');
            $table->double('reading_consumption');
            $table->double('billing_amount')->nullable();
            $table->double('billing_surcharge')->nullable();
            $table->double('billing_meter_ips')->nullable()->default('0.00');
            $table->double('billing_total')->nullable();
            $table->string('payment_or_no')->nullable();
            $table->date('payment_date')->nullable();
            $table->double('payment_amount')->nullable();
            $table->double('balance');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('customer_id')->references('account_number')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
