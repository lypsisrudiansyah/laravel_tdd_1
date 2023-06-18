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


    /* protected static function boot()
    {
        parent::boot();

        static::deleting(function ($todoList) {
            // & onDelete todoList cascade delete tasks
            $todoList->tasks()->delete();
        });
    } */

    // function hasMany Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
