<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_clients_table.php
// database/migrations/xxxx_xx_xx_create_clients_table.php

public function up()
{
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('meter_code');
        $table->string('email')->unique();
        $table->string('phone_number');
        $table->enum('status', ['Active', 'Inactive'])->default('Active');
        $table->timestamps();
    });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
