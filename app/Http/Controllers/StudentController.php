<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Medium;
use App\Models\Standard;
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
    		$data = User::leftJoin('standards', 'users.standard', '=', 'standards.id')
                ->leftJoin('media', 'users.medium', '=', 'media.id')
                ->where('users.role_id','=','3')
                ->select('users.*', 'standards.name as standard_name', 'media.name as medium_name')
                ->orderBy('users.created_at','DESC');
    		if($request->student!=null)
    		{
    			$rec = $request->student ?? null;
    			$data = $data->where(function($query) use($rec){
    				return $query->where('users.name','like','%'.$rec.'%')
                        ->orWhere('users.contact_number','like','%'.$rec.'%')
                        ->orWhere('users.parent_contact_number','like','%'.$rec.'%')
                        ->orWhere('users.email','like','%'.$rec.'%')
                        ->orWhere('standards.name','like','%'.$rec.'%')
                        ->orWhere('media.name','like','%'.$rec.'%');
    			});
    		}
            if(isset($request->standard) && $request->standard!=null)
            {
                $data = $data->where('users.standard',$request->standard);
            }
            if(isset($request->medium) && $request->medium!=null)
            {
                $data = $data->where('users.medium',$request->medium);
            }
            if(isset($request->payment_type) && $request->payment_type!=null)
            {
                $data = $data->where('users.payment_type',$request->payment_type);
            }
            if(isset($request->status) && $request->status!=null)
            {
                $data = $data->where('users.is_active',$request->status);
            }
            if(isset($request->day) && $request->day!=null)
            {
                $data = $data->whereDay('users.created_at',$request->day);
            }
            if(isset($request->month) && $request->month!=null)
            {
                $data = $data->whereMonth('users.created_at',$request->month);
            }
            if(isset($request->year) && $request->year!=null)
            {
                $data = $data->whereYear('users.created_at',$request->year);
            }
    		return DataTables::of($data)->
            addColumn('register_date',function($rec){
                return date('d-m-Y',strtotime($rec->created_at));
            })
            ->rawColumns(['register_date'])
            ->make(true);
    	}
        $standards = Standard::where('is_active', 1)->orderBy('name')->get();

    	return view('students.all', compact('standards'));
    }

    public function getAddStudent()
    {
        $standards = Standard::where('is_active', 1)->orderBy('name')->get();

    	return view('students.add', compact('standards'));
    }

    public function getMediumsByStandard($standard)
    {
        $mediums = Medium::where('standard_id', $standard)
            ->where('is_active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($mediums);
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
            'standard' => 'required|integer|exists:standards,id',
            'medium' => [
                'required',
                'integer',
                Rule::exists('media', 'id')->where(function ($query) use ($request) {
                    return $query->where('standard_id', $request->standard);
                }),
            ],
    		'profile_photo' => 'nullable|max:2048|mimes:jpg,png,jpeg'
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
            $standards = Standard::where('is_active', 1)->orderBy('name')->get();
            return view('students.edit',compact('response', 'standards'));
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
            'standard' => 'required|integer|exists:standards,id',
            'medium' => [
                'required',
                'integer',
                Rule::exists('media', 'id')->where(function ($query) use ($request) {
                    return $query->where('standard_id', $request->standard);
                }),
            ],
        ]);
    	
        
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        unset($data['_token']);
        $response = $this->StudentService->updateUser($data);
        if($response)
        {
            $user = User::find($response->id);
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
