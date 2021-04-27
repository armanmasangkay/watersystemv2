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
            $table->string('customer_account_number');
            $table->foreign('customer_account_number')
                    ->references('account_number')
                    ->on('customers');
            $table->string('description');
            $table->string('landmark');
            $table->date('init_building_inspection_sched');
            $table->date('init_waterworks_inspection_sched');
            $table->string('type'); //the type of service
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
        Schema::dropIfExists('services');
    }
}
