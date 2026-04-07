<?php
namespace App\Services;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Medium;
use Storage;

class SubjectService
{
	protected $StandardModel;
    protected $SubjectModel;
    public function __construct()
    {
    	$this->StandardModel = new Standard();
    	$this->SubjectModel=new Subject();
    }

    public function fetch($id)
    {
        if($id!=0)
    	return $this->SubjectModel->where(['is_active' => 1 ,'medium_id'=>$id])->get();
    	else
    	return $this->SubjectModel->where(['is_active' => 1])->get();
    	
    }

    public function fetchSubjects($record)
    {
        $data = $this->SubjectModel
        ->join('standards','standards.id','subjects.standard_id')
        ->join('media','media.id','subjects.medium_id')
        ->whereIn('subjects.is_active',[1,0])
        ->orderBy('subjects.id','ASC')
        ->select('subjects.*','standards.name AS standard_name','media.name as medium_name');
        if($record!=null)
        {
            $data = $data->where(function($query) use ($record){
                $query->where('subjects.name','like','%'.$record.'%')
                ->orWhere('standards.name','like','%'.$record.'%')
                ->orWhere('subjects.type','like','%'.$record.'%')
                ->orWhere('media.name','like','%'.$record.'%');
            });
        }
        return $data;
    }

    public function create($record)
    {
        $medium = Medium::find($record['standard_id']);
        if($medium)
        {
            $record['standard_id'] = $medium->standard_id ?? 0;
            $record['medium_id'] = $medium->id ?? 0;
        }

        if($record['image']!=null)
        {
            $record['image'] = $record['image']->store('subjects');
        }
        return $this->SubjectModel->create($record);
    }

    public function changeStatus($id)
    {
        $record = $this->SubjectModel->where('id',$id)->first();
        if($record && $record->is_active == 1)
        {
            $record->is_active = 0;
            $record->save();
        }
        else
        {
            $record->is_active = 1;
            $record->save();
        }
        return $record;
        
    }

    public function delete($id)
    {
        $record = $this->SubjectModel->where('id',$id)->first();
        if($record)
        {
            $record->is_active = 2;
            $record->save();
        }
        return $record;
    }

    public function fetchSingle($id)
    {
        return $this->SubjectModel->where(['is_active' => 1 ,'id'=>$id])->first();
    }

    public function update($data)
    {
        $id = $data['id'];
        unset($data['id']);

        $medium = Medium::find($data['standard_id']);
        if($medium)
        {
            $data['standard_id'] = $medium->standard_id ?? 0;
            $data['medium_id'] = $medium->id ?? 0;
        }

        if(isset($data['image']))
        {
            $data['image'] = $data['image']->store('subjects');
        }
        return $this->SubjectModel->where('id',$id)->update($data);

    }
    
    public function get()
    {
        return $this->SubjectModel
        ->join('standards','standards.id','subjects.standard_id')
        ->join('media','media.id','subjects.medium_id')
        ->where(['subjects.is_active' => 1])
        ->orderBy('subjects.name','ASC')
        ->select('subjects.*','standards.name as standard_name','media.name as medium_name')
        ->get();
    }
}
