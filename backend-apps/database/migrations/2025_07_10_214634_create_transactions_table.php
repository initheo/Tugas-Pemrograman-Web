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
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_store_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->unsignedBigInteger('user_id'); // user yang membuat 
            $table->unsignedBigInteger('service_id')->nullable(); // service yang terkait, jika ada
            $table->date('transaction_date'); 
            $table->decimal('weight', 8, 2)->nullable(); // berat laundry
            $table->decimal('total_amount', 10, 2);
            $table->decimal('base_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->string('status_payment')->default('pending');
            $table->string('status_laundry')->default('pending');
            $table->string('urlPaymentGateway')->nullable();
            $table->string('payment_session_id')->nullable();
            $table->string('payment_reference_id')->nullable();
            $table->string('payment_method');
            $table->text('notes')->nullable();  
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('branch_store_id')->references('id')->on('branch_stores')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
