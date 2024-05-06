<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'call_id',
        'image',
        'note',
        'stats',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id');
    } 
    public function medicalRecordType()
    {
        return $this->hasMany(MedicalRecordType::class);
    
    }
}
