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
        Schema::create('branches', function (Blueprint $table) {
            $table->id(); // Primary Key (Auto Increment)
            $table->string('name');          // Branch Name
            $table->string('code');          // Branch Code
            $table->string('gstn');          // GSTN Number
            $table->BigInteger('firmid');      // Firm ID
            $table->BigInteger('locationid');  // Location ID
            $table->timestamps();            // Created_at and Updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
