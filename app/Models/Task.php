<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_name',
        'description',
        'note',
        'image',
        'status',

    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function todo()
    {
        return $this->hasMany(ToDo::class,'task_id');
    }
}
