<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'nurse_id',
        'analysis_id',
        'patient_name',
        'age',
        'phone',
        'description',
        'status',
        'case_status',
    ];
    public $with = ['doctor', 'nurse', 'measurement'];

    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
    public function analysis()
    {
        return $this->belongsTo(User::class, 'analysis_id');
    }

    public function measurement()
    {
        return $this->hasOne(Measurement::class);
    }
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }
}
