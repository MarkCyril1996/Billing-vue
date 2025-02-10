<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Foreign key to client table
            $table->decimal('meter_cubic_usage', 8, 2); // Meter cubic usage
            $table->decimal('amount', 10, 2); // Amount billed
            $table->enum('payment_status', ['Pending', 'Paid']); // Payment status
            $table->enum('billing_cycle', ['Monthly', 'Quarterly']); // Billing cycle
            $table->date('billing_date'); // Billing date
            $table->date('due_date'); // Due date for payment
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billings');
    }
}
