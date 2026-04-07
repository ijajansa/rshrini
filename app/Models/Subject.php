<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
    	'name','image','standard_id','medium_id','type','is_active'
    ];
    
    public function chapters()
    {
        return $this->hasMany('App\Models\Chapter','subject_id','id')->withCount('questions');
    }
}
