<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'title',

    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
