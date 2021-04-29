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
            $table->string('type_of_service');
            $table->string('remarks')->nullable();
            $table->string('landmarks');
            $table->string('contact_number');
            $table->date('initial_building_inspection_schedule');
            $table->date('initial_water_works_schedule');
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
