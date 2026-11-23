<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Use the separate Tasks database connection.
     */
    protected $connection = 'tasks';

    /**
     * Database table used by this model.
     */
    protected $table = 'tasks';

    /**
     * Fields allowed for mass assignment.
     */
    protected $fillable = [
        'title',
        'status',
        'task_date',
        'is_archived',
    ];

    /**
     * Convert database values to appropriate PHP types.
     */
    protected function casts(): array
    {
        return [
            'task_date' => 'date',
            'is_archived' => 'boolean',
        ];
    }
}