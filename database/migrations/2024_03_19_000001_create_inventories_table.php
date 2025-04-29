<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->integer('minimum_stock');
            $table->string('location');
            $table->string('status');
            $table->timestamp('last_restock_date')->nullable();
            $table->integer('last_restock_quantity')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->morphs('inventoryable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
