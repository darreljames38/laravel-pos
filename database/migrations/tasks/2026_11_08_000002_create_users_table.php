<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('tasks')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('full_name', 100);
            $table->string('email', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('tasks')->dropIfExists('users');
    }
};