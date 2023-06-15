<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    // function hasMany Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
