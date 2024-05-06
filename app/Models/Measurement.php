<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_id',
        'user_id',
        'blood_pressure',
        'sugar_analysis',
        'tempreture', 
        'fluid_balance',
        'respiratory_rate',
        'heart_rate', 
        'note',
        'stats',
    ];

    public function call()
    {
        return $this->belongsTo(Call::class,'call_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
