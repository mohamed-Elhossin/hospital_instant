<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordType extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id',
        'type',
    ];

    public function medicalRecord()
    {
        return $this->hasMany(medicalRecord::class);
    }
}
