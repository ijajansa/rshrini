<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Services\ChapterService;
use Hash;
use Illuminate\Validation\Rule;
use App\Models\Format;
use App\Models\Chapter;
use File;


class ChapterController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    protected  $ChapterService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
        $this->ChapterService = new ChapterService();
    }
    
    public function getAllChapters(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->all();
    		$data = $this->ChapterService->fetch($record);
    		return DataTables::of($data)->make(true);
    	}
    	return view('chapters.all');
    }

    public function getAddChapter(Request $request)
    {
    	$data = $this->SubjectService->get();
    	$formats = $this->ChapterService->formats();
    	return view('chapters.add',compact('data','formats'));
    }

    public function addChapter(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'subject_id' => 'required'
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->ChapterService->create($record);
        if($response)
        {
        	return redirect('chapters/all')->with('success','Chapter added successfully');
        }
        	return redirect('chapters/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->ChapterService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Chapter status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change chapter record');
        }  
    }

    public function deleteChapter($id)
    {
    	$response = $this->ChapterService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Chapter deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete chapter');
        }  
    }

    public function editChapterPage($id,Request $request)
    {
    	$data = $this->SubjectService->get();
    	$formats = $this->ChapterService->formats();
    	
    	$record = $this->ChapterService->fetchSingle($id);
    	if($record)
    	{
    		return view('chapters.edit',compact('data','record','formats'));
    	}
    	return redirect()->back('error','Chapter details not found');
    }

    public function postUpdateChapter(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'subject_id' => 'required',
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->ChapterService->update($record);
        if($response)
        {
        	return redirect('chapters/all')->with('success','Chapter details updated successfully');
        }
        	return redirect('chapters/all')->with('error','Something went wrong');

    }

    public function getAllChapterFormats(Request $request)
    {
        if($request->ajax())
        {
            $record = $request->all();
            $data = $this->ChapterService->fetchFormat($record);
            return DataTables::of($data)->
            addColumn('image',function($row){
                if($row->link!=null)
                {
                    if($row->type == 0)
                    {
                        return "<a href='".url('storage/app')."/".$row->link."'><img src='".asset('assets/images/audio.webp')."' width='45px' height:45px>";
                    }
                    else if($row->type == 1)
                    {
                        return "<a href='".url('storage/app')."/".$row->link."'><img src='".asset('assets/images/video.png')."' width='45px' height:45px>";
                    }
                    else
                    {
                        return "<a href='".url('storage/app')."/".$row->link."'><img src='".asset('assets/images/pdf.png')."' width='45px' height:45px>";
                    }
                }
                else
                {
                    return "<img src='".asset('assets/images/default.svg')."' width='45px' height:45px>";
                }
            })
            ->rawColumns(['image'])->make(true);
        }
        return view('formats.all');
    }

    public function deleteChapterFormat($id)
    {
        $record = Format::find($id);
        if($record)
        {
            if (File::exists(storage_path("/app/".$record->link))) 
            {
                File::delete(storage_path("/app/".$record->link));
            }
            $record->delete();
            return redirect()->back()->with('success','Chapter format deleted successfully');
        }
            return redirect()->back()->with('error','Something went wrong');

    }

    public function getAddChapterFormat(Request $request)
    {
        $chapters = $this->ChapterService->chapters();
        return view('formats.add',compact('chapters'));
    }

    public function addChapterFormat(Request $request)
    {
        if($request->type == 'video')
        {
            $request->validate([
                'file' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
            ]);
        }
        else if($request->type == 'audio')
        {
            $request->validate([
                'file' => 'required|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
            ]);
        }
        else
        {
            $request->validate([
                'file' => 'required|mimes:pdf'
            ]);
        }   

        if($request->type == 'video')
            $type = 1;
        else if($request->type == 'audio')
            $type = 0;
        else
            $type =2;

        $new = new Format();
        $new->chapter_id = $request->chapter_id ?? 0;
        $path = $request->file('file')->store('chapter_links');
        $new->chapter_id = $request->chapter_id ?? 0;
        $new->link = $path;
        $new->type = $type;
        $new->save();

        return redirect('chapters/format/all?format='.$request->type)->with('success','Chapter format added successfully');
    }

    public function editChapterFormatPage($id)
    {
        $record = Format::find($id);
        if($record)
        {
            $chapters = $this->ChapterService->chapters();
            return view('formats.edit',compact('record','chapters'));
        }
            return redirect()->back()->with('error','Something went wrong');

    }

    public function postUpdateChapterFormat(Request $request)
    {
        if($request->type == 1)
        {
            $request->validate([
                'file' => 'nullable|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
            ]);
        }
        else if($request->type == 0)
        {
            $request->validate([
                'file' => 'nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav'
            ]);
        }
        else
        {
            $request->validate([
                'file' => 'nullable|mimes:pdf'
            ]);
        }  

        $record = Format::find($request->id);
        if($record)
        {
            $record->chapter_id = $request->chapter_id ?? 0;
            $record->chapter_id = $request->chapter_id ?? 0;
            if($request->file!=null)
            {
                $path = $request->file('file')->store('chapter_links');

                if (File::exists(storage_path("/app/".$record->link))) 
                {
                    File::delete(storage_path("/app/".$record->link));
                }

                $record->link = $path;
            }
            $record->save();

            if($request->type ==0)
                $type = 'audio';
            else if($request->type == 1)
                $type = 'video';
            else
                $type = 'pdf';

            return redirect('chapters/format/all?format='.$type)->with('success','Chapter format details updated successfully');
        } 

            return redirect()->back()->with('error','Something went wrong');


    }

}
