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

            // * the research which way better when we manually create cascading delete on related data : https://gist.github.com/lypsisrudiansyah/bd9f4ba8d7d70c04d14cddf25b4df7ad
        });
    } */

    // function hasMany Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
