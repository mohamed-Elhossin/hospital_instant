<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'manger_id',
    'report_name',
    'description',
    'answer',
    'image',
    'status',
  ];
  
  public function user()
  {
      return $this->belongsTo(User::class,'user_id');
  } 
   public function manger()
  {
      return $this->belongsTo(User::class,'manger_id');
  }
}
