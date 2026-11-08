<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'tasks';

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'status',
        'task_date',
    ];

    protected function casts(): array
    {
        return [
            'task_date' => 'date',
        ];
    }
}