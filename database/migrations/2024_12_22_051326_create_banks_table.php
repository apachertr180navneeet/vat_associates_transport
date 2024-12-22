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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('accountno');
            $table->string('accountholdername');
            $table->string('ifsc_code');
            $table->string('address');
            $table->BigInteger('firm_id');      // Firm ID
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();            // Created_at and Updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
