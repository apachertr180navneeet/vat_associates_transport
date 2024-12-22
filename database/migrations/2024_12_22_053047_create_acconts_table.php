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
        Schema::create('acconts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('firm_id');      // Firm ID
            $table->string('name');
            $table->string('opening_blance');
            $table->enum('nature',['income','expense'])->default('income');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acconts');
    }
};
