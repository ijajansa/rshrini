<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    
    protected $fillable =['name','link','subject_id','type'];
    
    public function questions()
    {
        return $this->hasMany('App\Models\Question','chapter_id','id');
    }
}
