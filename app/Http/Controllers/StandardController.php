<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Standard;
use Auth;
use DataTables;

class StandardController extends Controller
{
	public function getAllStandards(Request $request)
	{
		if($request->ajax())
		{
			$data = Standard::whereIn('is_active',[0,1]);
			return DataTables::of($data)->make(true);
		}
		return view('standards.all');
	}

	public function getAddStandard()
	{
		return view('standards.add');
	}

	public function addStandard(Request $request)
	{
		$request->validate([
			'name'=>'required',
			'other_name'=>'nullable'
		]);

		$new = new Standard();
		$new->name = $request->name;
		$new->other_name = $request->other_name;
		$new->save();

		return redirect('standards/all')->with('success','Standard added successfully');

	}

	public function deleteStandard($id)
	{
		$data = Standard::find($id);
		if($data)
		{
			$data->is_active = 2;
			$data->save();
		}
		return redirect()->back()->with('success','Standard deleted successfully');
	}

	public function editStandardPage($id)
	{
		$data = Standard::find($id);
		if($data)
		{
			return view('standards.edit',compact('data'));
		}
		return redirect()->back()->with('error','something went wrong');
	}

	public function postUpdateStandard(Request $request,$id)
	{
		$request->validate([
			'name'=>'required',
			'other_name'=>'nullable'
		]);
		$data = Standard::find($id);
		if($data)
		{
			$data->name = $request->name;
			$data->other_name = $request->other_name;
			$data->save();
			return redirect('standards/all')->with('success','Standard details updated successfully');
		}
		return redirect('standards/all')->with('error','Unable to update details');

	}

	public function changeStatus($id)
	{
		$data = Standard::find($id);
		if($data && $data->is_active == 1)
		{
			$data->is_active = 0;
		}
		else
		{
			$data->is_active = 1;
		}
		$data->save();
		return redirect('standards/all')->with('success','Status changed successfully');

	}
}
