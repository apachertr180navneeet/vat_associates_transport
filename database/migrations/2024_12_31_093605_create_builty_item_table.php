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
        Schema::create('builty_item', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('builty_item_id');
            $table->BigInteger('item');
            $table->decimal('freight_charge', total: 8, places: 2);
            $table->decimal('surcharge', total: 8, places: 2);
            $table->decimal('cover', total: 8, places: 2);
            $table->decimal('h', total: 8, places: 2);
            $table->decimal('insurance', total: 8, places: 2);
            $table->decimal('heading', total: 8, places: 2);
            $table->decimal('cps', total: 8, places: 2);
            $table->decimal('total', total: 8, places: 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builty_item');
    }
};
