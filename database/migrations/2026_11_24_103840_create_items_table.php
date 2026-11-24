<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);

            $table->string('sku', 50)
                ->unique();

            $table->string('category', 100);

            $table->text('description')
                ->nullable();

            $table->decimal('selling_price', 10, 2);

            $table->unsignedInteger('stock_quantity')
                ->default(0);

            $table->string('status', 20)
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};