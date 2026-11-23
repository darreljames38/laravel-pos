<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the archive flag to the Tasks database.
     */
    public function up(): void
    {
        if (
            ! Schema::connection('tasks')
                ->hasColumn('tasks', 'is_archived')
        ) {
            Schema::connection('tasks')
                ->table('tasks', function (Blueprint $table) {
                    $table->boolean('is_archived')
                        ->default(false);
                });
        }
    }

    /**
     * Remove the archive flag.
     */
    public function down(): void
    {
        if (
            Schema::connection('tasks')
                ->hasColumn('tasks', 'is_archived')
        ) {
            Schema::connection('tasks')
                ->table('tasks', function (Blueprint $table) {
                    $table->dropColumn('is_archived');
                });
        }
    }
};