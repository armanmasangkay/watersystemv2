<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string("account_number");
            $table->string("email");
            $table->string("mobile_number");
            $table->string("password");
            $table->string("valid_id");
            $table->string("latest_bill");
            $table->string("other_party")->nullable();
            $table->string("status");
            $table->foreign("account_number")->references("account_number")->on('customers')->onDelete("cascade");
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
        Schema::dropIfExists('accounts');
    }
}
