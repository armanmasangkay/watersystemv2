<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('type_of_service');
            $table->string('remarks')->nullable();
            $table->string('landmarks')->nullable();
            $table->string('contact_number');
            $table->date('work_schedule')->nullable();
            $table->date('date_completed')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('services');
    }
}
