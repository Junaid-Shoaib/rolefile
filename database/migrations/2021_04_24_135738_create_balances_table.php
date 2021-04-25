<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->decimal('op_debit',14,2)->default('0');
            $table->decimal('op_credit',14,2)->default('0');
            $table->decimal('t_debit',14,2)->default('0');
            $table->decimal('t_credit',14,2)->default('0');
            $table->decimal('cl_debit',14,2)->default('0');
            $table->decimal('cl_credit',14,2)->default('0');
            $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('balances');
    }
}
