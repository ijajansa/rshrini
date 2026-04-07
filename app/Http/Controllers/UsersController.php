<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Validation\Rule;
use Hash;

class UsersController extends Controller
{
    public function getAllUsers(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = User::where('role_id','=','2');
    		return DataTables::of($data)->make(true);
    	}
    	return view('users.all');
    }

    public function getAddUser()
    {
    	return view('users.add');
    }
    public function addUser(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'email' => 'required|unique:users|email',
    		'contact_number' => 'required|unique:users|digits:10|numeric',
    		'password' => 'required|min:8',
    	]);

    	$record = $request->all();
    	$record['role_id'] = 2;
    	$record['password'] = Hash::make($record['password']);
    	$data = User::create($record);
    	return redirect('users/all')->with('success','User added successfully');
    }

    public function deleteUser($id)
    {
    	$data = User::find($id);
    	if($data)
    	{
    		$data->delete();
    		return redirect()->back()->with('success','User deleted successfully');		
    	}
    	else
    	{
    		return redirect()->back()->with('error','Unable to delete user');		
    	}
    }
    
    public function changeStatus($id)
    {
        $response = User::find($id);
        if($response)
        {
            if($response->is_active == 1)
            $response->is_active =0;
            else
            $response->is_active =1;
            $response->save();
            
            return redirect()->back()->with('success','Student status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change student record');
        }  
    }
    
    public function getEditUser($id)
    {
        $data = User::find($id);
        return view('users.edit',compact('data'));
    }
    
    public function updateUser(Request $request)
    {
    	$request->validate([
    		'name' => 'required|regex:/^[\pL\s\-]+$/u',
    		'email' => 'required|unique:users,email,'.$request->id.'',
    		'contact_number' => 'required|unique:users,contact_number,'.$request->id.'|digits:10|numeric',
    		'password' => 'nullable|min:8',
    	]);
    	$data = User::where('id',$request->id)->first();
    	$data->name = $request->name ?? null;
    	if($request->password!=null)
    	{
        	$data->password = Hash::make($request->password);
    	}
    	$data->email = $request->email ?? null;
    	$data->contact_number = $request->contact_number ?? null;
    	$data->save();
    	return redirect('users/all')->with('success','User details updated successfully');
    }
    
}
