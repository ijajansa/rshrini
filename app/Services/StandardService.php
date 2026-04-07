<?php
namespace App\Services;
use App\Models\Standard;
use App\Models\Medium;
use Storage;

class StandardService
{
	protected $StandardModel;
	protected $MediumModel;
    public function __construct()
    {
    	$this->StandardModel = new Standard();
    	$this->MediumModel = new Medium();
    }

    public function fetch()
    {
    	return $this->StandardModel->where('is_active',1)->get();
    }
    
    public function fetchMedium($id)
    {
        return $this->MediumModel->where('standard_id',$id)->where('is_active',1)->get();
    }

}
