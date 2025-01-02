<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('builty', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('firm_id');      // Firm ID
            $table->date('date');
            $table->enum('type',['to_pay','free_of_cost','to_be_billed','paid'])->default('to_pay');
            $table->BigInteger('branch');
            $table->string('grno');
            $table->BigInteger('consigner');
            $table->BigInteger('conignee');
            $table->BigInteger('from_city');
            $table->BigInteger('to_city');
            $table->BigInteger('good_location');
            $table->string('no_of_package');
            $table->string('total_price');
            $table->enum('status',['pending','delivered'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builty');
    }
};
