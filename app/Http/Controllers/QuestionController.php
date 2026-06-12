<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Question;
use App\Models\Chapter;
use App\Services\QuestionService;
use Hash;
use Illuminate\Validation\Rule;


class QuestionController extends Controller
{
    protected  $QuestionService;
    public function __construct()
    {
        abort(404);
        $this->QuestionService = new QuestionService();
    }
    
    public function getAllQuestions(Request $request)
    {
    	if($request->ajax())
    	{
    	    $search = $request->questions ?? null;
    		$data = $this->QuestionService->getMCQList($search);
    		return DataTables::of($data)->make(true);
    	}
    	return view('questions.all');
    }

    public function getAddQuestion()
    {
    	$chapters = Chapter::where('chapters.is_active',1)
    	->join('subjects','subjects.id','chapters.subject_id')
        ->join('standards','standards.id','subjects.standard_id')
        ->select('chapters.*','subjects.name AS subject_name','standards.name AS standard_name')
        ->get();
    	return view('questions.add',compact('chapters'));
    }
    public function addQuestion(Request $request)
    {
    	$request->validate([
    		'chapter_id' => 'required',
    		'question_type' => 'required',
    		'question_text' => 'required_if:question_type,==,0',
    		'question_image' => 'required_if:question_type,==,1|mimes:jpg,png,jpeg,svg',
    		'solution' => 'required',
    		'solution_type' => 'required',
    		'solution_text' => 'required_if:solution_type,==,0',
    		'solution_image' => 'mimes:jpg,png,jpeg,svg|required_if:solution_type,==,1',
    		'option1' => 'required_if:option1_type,==,0',
    		'option1_image' => 'mimes:jpg,png,jpeg,svg|required_if:option1_type,==,1',
    		'option1_type' => 'required',
    		'option2' => 'required_if:option2_type,==,0',
    		'option2_image' => 'mimes:jpg,png,jpeg,svg|required_if:option2_type,==,1',
    		'option2_type' => 'required',
    		'option3' => 'required_if:option3_type,==,0',
    		'option3_image' => 'mimes:jpg,png,jpeg,svg|required_if:option3_type,==,1',
    		'option3_type' => 'required',
    		'option4' => 'required_if:option4_type,==,0',
    		'option4_image' => 'mimes:jpg,png,jpeg,svg|required_if:option4_type,==,1',
    		'option4_type' => 'required'
    	]);

    	$record = $request->all();
        unset($record['_token']);
        
        $response = $this->QuestionService->createQuestion($record);
        if($response)
        {
        	return redirect('mcq-questions/all')->with('success','Question added successfully');
        }
    	return redirect('mcq-questions/all')->with('error','Unable to add question');
    }

    public function deleteQuestion($id)
    {
    	$response = Question::find($id);
    	if($response)
    	{
    	    if($response->question_image!=null && file_exists(storage_path('app')."/".$response->question_image))
            {
                unlink(storage_path('app')."/".$response->question_image);
            }
    	    if($response->option1_image!=null && file_exists(storage_path('app')."/".$response->option1_image))
            {
                unlink(storage_path('app')."/".$response->option1_image);
            }
    	    if($response->option2_image!=null && file_exists(storage_path('app')."/".$response->option2_image))
            {
                unlink(storage_path('app')."/".$response->option2_image);
            }
    	    if($response->option3_image!=null && file_exists(storage_path('app')."/".$response->option3_image))
            {
                unlink(storage_path('app')."/".$response->option3_image);
            }
    	    if($response->option4_image!=null && file_exists(storage_path('app')."/".$response->option4_image))
            {
                unlink(storage_path('app')."/".$response->option4_image);
            }
            if($response->solution_image!=null && file_exists(storage_path('app')."/".$response->solution_image))
            {
                unlink(storage_path('app')."/".$response->solution_image);
            }
    		$response->delete();
    		return redirect()->back()->with('success','Question deleted successfully');		
    	}
    	else
    	{
    		return redirect()->back()->with('error','Unable to delete');		
    	}
    }
    
    public function editQuestionPage($id)
    {
        $response = $this->QuestionService->fetch($id);
        $chapters = Chapter::where('chapters.is_active',1)
    	->join('subjects','subjects.id','chapters.subject_id')
        ->join('standards','standards.id','subjects.standard_id')
        ->select('chapters.*','subjects.name AS subject_name','standards.name AS standard_name')
        ->get();
        if($response)
        {
            return view('questions.edit',compact('response','chapters'));
        }
        else
        {
            return redirect()->back()->with('error','Unable to get question record');
        }
    }
    
    public function viewQuestionPage($id)
    {
        $response = $this->QuestionService->fetch($id);
        $chapters = Chapter::where('chapters.is_active',1)
    	->join('subjects','subjects.id','chapters.subject_id')
        ->join('standards','standards.id','subjects.standard_id')
        ->select('chapters.*','subjects.name AS subject_name','standards.name AS standard_name')
        ->get();
        if($response)
        {
            return view('questions.view',compact('response','chapters'));
        }
        else
        {
            return redirect()->back()->with('error','Unable to get question record');
        }
    }
    
    public function postUpdateQuestion(Request $request)
    {
        $request->validate([
    		'chapter_id' => 'required',
    		'question_type' => 'required',
    		'question_text' => 'required_if:question_type,==,0',
    		'question_image' => 'nullable|required_if:question_type,==,1|mimes:jpg,png,jpeg,svg',
    		'solution' => 'required',
    		'solution_type' => 'required',
    		'solution_text' => 'required_if:solution_type,==,0',
    		'solution_image' => 'nullable|required_if:solution_type,==,1',
    		'option1' => 'required_if:option1_type,==,0',
    		'option1_image' => 'nullable|required_if:option1_type,==,1',
    		'option1_type' => 'required',
    		'option2' => 'required_if:option2_type,==,0',
    		'option2_image' => 'nullable|required_if:option2_type,==,1',
    		'option2_type' => 'required',
    		'option3' => 'required_if:option3_type,==,0',
    		'option3_image' => 'nullable|required_if:option3_type,==,1',
    		'option3_type' => 'required',
    		'option4' => 'required_if:option4_type,==,0',
    		'option4_image' => 'nullable|required_if:option4_type,==,1',
    		'option4_type' => 'required'
    	]);
        
        $data = $request->all();
        $data['id'] = $request->id ?? 0;
        unset($data['_token']);
        $response = $this->QuestionService->updateQuestion($data);
        if($response)
        {
            return redirect('mcq-questions/all')->with('success','Question updated successfully');
        }
        else
        {
            return redirect('mcq-questions/all')->with('error','Unable to update record');
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
        $response = $this->QuestionService->changeStatus($id);
        if($response)
        {
            return redirect()->back()->with('success','Status changed successfully');
        }
        else
        {
            return redirect()->back()->with('error','Unable to change status');
        }  
    }
    
    
}
