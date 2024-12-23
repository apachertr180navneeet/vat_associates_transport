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
        Schema::create('departmenttypes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('firm_id'); 
            $table->string('name');
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
        Schema::dropIfExists('departmenttypes');
    }
};
