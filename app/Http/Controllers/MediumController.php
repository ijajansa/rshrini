<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Standard;
use App\Models\Medium;
use Illuminate\Validation\Rule;
use Auth;
use DataTables;

class MediumController extends Controller
{
	public function getAllMediums(Request $request)
	{
		if($request->ajax())
		{
			$data = Medium::join('standards','standards.id','media.standard_id')->whereIn('media.is_active',[0,1])->select('media.*','standards.name as standard_name')->get();
			return DataTables::of($data)->make(true);
		}
		return view('mediums.all');
	}

	public function getAddMedium()
	{
		$standards = Standard::where('is_active',1)->get();
		return view('mediums.add',compact('standards'));
	}

	public function addMedium(Request $request)
	{
		$request->merge([
			'name' => trim((string) $request->input('name', '')),
		]);

		$request->validate([
			'name'=>[
				'required',
				Rule::unique('media', 'name')->where(function ($query) use ($request) {
					return $query->where('standard_id', $request->standard_id)
						->whereIn('is_active', [0, 1]);
				}),
			],
			'standard_id'=>'required|integer|exists:standards,id'
		]);

		$new = new Medium();
		$new->name = $request->name;
		$new->standard_id = $request->standard_id;
		$new->save();

		return redirect('mediums/all')->with('success','Medium added successfully');

	}

	public function deleteMedium($id)
	{
		$data = Medium::find($id);
		if($data)
		{
			$data->is_active = 2;
			$data->save();
		}
		return redirect()->back()->with('success','Medium deleted successfully');
	}

	public function editMediumPage($id)
	{
		$data = Medium::find($id);
		$standards = Standard::where('is_active',1)->get();

		if($data)
		{
			return view('mediums.edit',compact('data','standards'));
		}
		return redirect()->back()->with('error','something went wrong');
	}

	public function postUpdateMedium(Request $request,$id)
	{
		$request->merge([
			'name' => trim((string) $request->input('name', '')),
		]);

		$request->validate([
			'name'=>[
				'required',
				Rule::unique('media', 'name')->ignore($id)->where(function ($query) use ($request) {
					return $query->where('standard_id', $request->standard_id)
						->whereIn('is_active', [0, 1]);
				}),
			],
			'standard_id'=>'required|integer|exists:standards,id'
		]);
		$data = Medium::find($id);
		if($data)
		{
			$data->name = $request->name;
			$data->standard_id = $request->standard_id;
			$data->save();
			return redirect('mediums/all')->with('success','Medium details updated successfully');
		}
		return redirect('mediums/all')->with('error','Unable to update details');

	}

	public function changeStatus($id)
	{
		$data = Medium::find($id);
		if($data && $data->is_active == 1)
		{
			$data->is_active = 0;
		}
		else
		{
			$data->is_active = 1;
		}
		$data->save();
		return redirect('mediums/all')->with('success','Status changed successfully');

	}
}
