<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'tasks';

    protected $table = 'users';

    protected $fillable = [
        'username',
        'full_name',
        'email',
    ];
}