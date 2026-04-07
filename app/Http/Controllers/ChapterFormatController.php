<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Services\ChapterService;
use App\Services\ChapterFormatService;
use Hash;
use Illuminate\Validation\Rule;


class ChapterFormatController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    protected  $ChapterService;
    protected  $ChapterFormatService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
        $this->ChapterService = new ChapterService();
        $this->ChapterFormatService = new ChapterFormatService();
    }
    
    public function getAllChapters(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->subject ?? null;
    		$data = $this->ChapterFormatService->fetch($record);
    		return DataTables::of($data)->make(true);
    	}
    	return view('formats.all');
    }

    public function getAddChapter()
    {
    	return view('formats.add');
    }

    public function addChapter(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->ChapterFormatService->create($record);
        if($response)
        {
        	return redirect('subject-types/all')->with('success','Subject type added successfully');
        }
        	return redirect('subject-types/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->ChapterFormatService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Subject type status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change status');
        }  
    }

    public function deleteChapter($id)
    {
    	$response = $this->ChapterFormatService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Subject deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete subject');
        }  
    }

    public function editChapterPage($id)
    {
    	$data = $this->ChapterFormatService->fetchSingle($id);
    	if($data)
    	{
    		return view('formats.edit',compact('data'));
    	}
    	return redirect()->back('error','Subject type details not found');
    }

    public function postUpdateChapter(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u'
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->ChapterFormatService->update($record);
        if($response)
        {
        	return redirect('subject-types/all')->with('success','Subject details updated successfully');
        }
        	return redirect('subject-types/all')->with('error','Something went wrong');

    }

}
