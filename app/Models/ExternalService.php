<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'token',
    ];

    // create castings for token as json/array
    protected $casts = [
        'token' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
