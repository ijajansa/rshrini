<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Services\UserServices;
use Hash;
use Illuminate\Validation\Rule;


class StudentController extends Controller
{
    protected  $StudentService;
    public function __construct()
    {
        $this->StudentService = new UserServices();
    }
    
    public function getAllStudents(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = User::where('role_id','=','3')->orderBy('created_at','DESC');
    		if($request->student!=null)
    		{
    			$rec = $request->student ?? null;
    			$data = $data->where(function($query) use($rec){
    				return $query->where('name','like','%'.$rec.'%')->orWhere('contact_number','like','%'.$rec.'%')->orWhere('parent_contact_number','like','%'.$rec.'%')->orWhere('email','like','%'.$rec.'%');
    			});
    		}
            if(isset($request->payment_type) && $request->payment_type!=null)
            {
                $data = $data->where('payment_type',$request->payment_type);
            }
            if(isset($request->status) && $request->status!=null)
            {
                $data = $data->where('is_active',$request->status);
            }
            if(isset($request->day) && $request->day!=null)
            {
                $data = $data->whereDay('created_at',$request->day);
            }
            if(isset($request->month) && $request->month!=null)
            {
                $data = $data->whereMonth('created_at',$request->month);
            }
            if(isset($request->year) && $request->year!=null)
            {
                $data = $data->whereYear('created_at',$request->year);
            }
    		return DataTables::of($data)->
            addColumn('register_date',function($rec){
                return date('d-m-Y',strtotime($rec->created_at));
            })
            ->rawColumns(['register_date'])
            ->make(true);
    	}
    	return view('students.all');
    }

    public function getAddStudent()
    {
    	return view('students.add');
    }
    public function addStudent(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'email' => 'required|unique:users|email',
    		'contact_number' => 'required|unique:users|digits:10|numeric',
    		'parent_contact_number' => 'required|numeric|digits:10',
    		'address' => 'required',
    		'college_name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'payment_type' => 'required',
    		'gender' => 'required',
    		'profile_photo' => 'nullable|max:1024|mimes:jpg,png,jpeg'
    	]);

    	$record = $request->all();
    	$record['role_id'] = 3;
        unset($record['_token']);
        
        $response = $this->StudentService->createUser($record);
        if($response)
        {
        	return redirect('students/edit/'.$response->id)->with('success','Student record added successfully');
        }
    	return redirect('students/all')->with('error','Unable to create student profile');
    }

    public function deleteStudent($id)
    {
    	$response = $this->StudentService->delete($id);
    	if($response)
    	{
    		return redirect()->back()->with('success','Student record deleted successfully');		
    	}
    	else
    	{
    		return redirect()->back()->with('error','Unable to delete student');		
    	}
    }
    
    public function editStudentPage($id)
    {
        $response = $this->StudentService->fetch($id);
        if($response)
        {
            return view('students.edit',compact('response'));
        }
        else
        {
            return redirect()->back()->with('error','Unable to get student record');
        }
    }
    
    public function postUpdateStudent(Request $request)
    {
    	
    	$request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email,'.$request->id.',id',
            'contact_number' => 'required|digits:10|numeric|unique:users,contact_number,'.$request->id.',id',
            'parent_contact_number' => 'required|numeric|digits:10',
    		'address' => 'required',
    		'college_name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'payment_type' => 'required',
    		'gender' => 'required',
        ]);
    	
        
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        unset($data['_token']);
        $response = $this->StudentService->updateUser($data);
        if($response)
        {
            $user = User::find($response->id)->first();
            if($user)
            {
                $user->payment_type = $request->payment_type ?? null;
                $user->save();
            }
            return redirect()->back()->with('success','Student record updated successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to update record');
        }

    }
    
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8'
            ]);
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        $response = $this->StudentService->updatePassword($data);
        if($response)
        {
            return redirect()->back()->with('success','Password updated successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to update student record');
        }  
        
    }
    
    public function changeStatus($id)
    {
        $response = $this->StudentService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Student status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change student record');
        }  
    }
}
