<?php
namespace App\Services;
use App\Models\Format;
use App\Models\Chapter;
use Storage;
use File;


class ChapterService
{
	protected $ChapterModel;
	protected $ChapterFormatModel;
    public function __construct()
    {
    	$this->ChapterModel = new Chapter();
    	$this->ChapterFormatModel = new Format();
    }

    public function fetchChapterType()
    {
    	return $this->ChapterFormatModel->where('is_active',1)->select('id','name')->get();
    }
    public function fetchChapters(array $data=[])
    {
        // if($data['format_id']!=null || $data['format_id']!=0)
        // {
        // 	return $this->ChapterModel->where(['is_active' => 1,'format_id' => $data['format_id'],'subject_id' => $data['subject_id']])->get();
        // }
        // else
        // {
    	    return $this->ChapterModel->where(['is_active' => 1,'subject_id' => $data['subject_id']])->get();
        // }
    }

    public function fetch($data =[])
    {
    	$record = $this->ChapterModel->whereIn('chapters.is_active',[0,1])
    	->join('subjects','subjects.id','chapters.subject_id');
    	if($data['chapter']!=null)
    	{
    	    $chapter = $data['chapter'] ?? null;
    	    $record = $record->where(function($query) use($chapter){
    	        $query->where('chapters.name','like','%'.$chapter.'%')
    	        ->orWhere('subjects.name','like','%'.$chapter.'%');  
    	    });  
    	}
    	$record = $record->select('chapters.*','subjects.name as subject_name')
    	->get();
    	
    	return $record;
    }
    
    public function formats()
    {
        return $this->ChapterFormatModel->where('is_active',1)->get();
    }
    
    public function create($record)
    {
        if(isset($record['image']) && $record['image']!=null)
        {
            $record['link'] = $record['image']->store('chapter_links');
        }
        
        return $this->ChapterModel->create($record);
    }
    public function changeStatus($id)
    {
        $record = $this->ChapterModel->where('id',$id)->first();
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
        $record = $this->ChapterModel->where('id',$id)->first();
        if($record)
        {
            $record->is_active = 2;
            $record->save();
        }
        return $record;
    }
    
    public function fetchSingle($id)
    {
        return $this->ChapterModel->where(['id'=>$id])->first();
    }
    
    public function update($data)
    {
        $id = $data['id'];
        $record = $this->ChapterModel->where('id',$id)->first();
        unset($data['id']);
        if(isset($data['image']))
        {
            $data['link'] = $data['image']->store('chapter_links');

            if (File::exists(storage_path("/app/".$record->link))) {
                File::delete(storage_path("/app/".$record->link));
           }
        }
        unset($data['image']);
        return $this->ChapterModel->where('id',$id)->update($data);
    }


    public function fetchFormat($data =[])
    {
        if($data['format'] == 'video')
            $data['type'] = 1;
        else if($data['format'] == 'audio')
            $data['type'] = 0;
        else
            $data['type'] = 2;
        $record = $this->ChapterFormatModel
        ->join('chapters','chapters.id','formats.chapter_id')->where('formats.type',$data['type']);
        if($data['chapter']!=null)
        {
            $record = $record->where('chapters.name','like','%'.$data['chapter'].'%');
        }
        $record = $record->select('chapters.name','formats.*')
        ->get();
        
        return $record;
    }

    public function chapters()
    {
        return $this->ChapterModel->where('chapters.is_active',1)
        ->join('subjects','chapters.subject_id','subjects.id')
        ->join('media','media.id','subjects.medium_id')
        ->join('standards','standards.id','subjects.standard_id')
        ->select('chapters.*','subjects.name as subject_name','media.name as medium_name','standards.name as standard_name')->get();
    }
    
    public function fetchChapterFormats(array $data=[])
    {
        return $this->ChapterFormatModel->where('chapter_id',$data['chapter_id'])->where('type',$data['type'])->where('is_active',1)->get();
    }
}
