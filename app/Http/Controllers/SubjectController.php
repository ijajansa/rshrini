<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Services\UserServices;
use App\Services\SubjectService;
use App\Services\StandardService;
use App\Models\Medium;
use Hash;
use Illuminate\Validation\Rule;


class SubjectController extends Controller
{
    protected  $SubjectService;
    protected  $StandardService;
    public function __construct()
    {
        $this->SubjectService = new SubjectService();
        $this->StandardService = new StandardService();
    }
    
    public function getAllSubjects(Request $request)
    {
    	if($request->ajax())
    	{
    		$record = $request->subject ?? null;
    		$data = $this->SubjectService->fetchSubjects($record);
    		return DataTables::of($data)->
    		addColumn('image',function($row){
    			if($row->image!=null)
    			{
    				return "<img src='".url("storage/app")."/".$row->image."' width='45px' height:45px>";
    			}
    			else
    			{
    				return "<img src='".asset('assets/images/default.svg')."' width='45px' height:45px>";
    			}
    		})
    		->rawColumns(['image'])->make(true);
    	}
    	return view('subjects.all');
    }

    public function getAddSubject()
    {
    	$data = Medium::join('standards','standards.id','media.standard_id')->select('media.*','standards.name as standard_name')->where('media.is_active',1)->where('standards.is_active',1)->get();
    	return view('subjects.add',compact('data'));
    }

    public function addSubject(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'image' => 'required|mimes:jpg,png,svg,jpeg',
    		'standard_id' => 'required',
    	]);

    	$record = $request->all();
        unset($record['_token']);
        $response = $this->SubjectService->create($record);
        if($response)
        {
        	return redirect('subjects/all')->with('success','Subject added successfully');
        }
        	return redirect('subjects/all')->with('error','Something went wrong');
    }

    public function changeStatus($id)
    {
        $response = $this->SubjectService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Subject status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change subject record');
        }  
    }

    public function deleteSubject($id)
    {
    	$response = $this->SubjectService->delete($id);
        if($response)
        {
            return redirect()->back()->with('success','Subject deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to delete subject');
        }  
    }

    public function editSubjectPage($id)
    {
        $data = Medium::join('standards','standards.id','media.standard_id')->select('media.*','standards.name as standard_name')->where('media.is_active',1)->where('standards.is_active',1)->get();
    	$record = $this->SubjectService->fetchSingle($id);
    	if($record)
    	{
    		return view('subjects.edit',compact('data','record'));
    	}
    	return redirect()->back('error','Subject details not found');
    }

    public function postUpdateSubject(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'image' => 'nullable|mimes:jpg,png,svg,jpeg',
    		'standard_id' => 'required',
    	]);

    	$record = $request->all();
    	$record['id'] = $request->id ?? 0;
        unset($record['_token']);
        $response = $this->SubjectService->update($record);
        if($response)
        {
        	return redirect('subjects/all')->with('success','Subject details updated successfully');
        }
        	return redirect('subjects/all')->with('error','Something went wrong');

    }

}
