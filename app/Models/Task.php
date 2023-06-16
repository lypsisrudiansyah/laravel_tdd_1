<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STARTED = 'started';
    public const PENDING = 'pending';
    public const NOT_STARTED = 'not_started';
    public const DONE = 'done';

    protected $fillable = [
        'todo_list_id',
        'title',
        'description',
        'status',
    ];

    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
