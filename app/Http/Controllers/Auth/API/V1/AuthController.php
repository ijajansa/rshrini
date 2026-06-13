<?php

namespace App\Http\Controllers\Auth\API\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserServices;
use App\Services\StandardService;
use App\Services\QuestionService;
use App\Services\SubjectService;
use App\Services\ChapterService;
use App\Services\BookmarkService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\ChapterRequest;
use App\Http\Requests\ChapterFormatRequest;
use App\Http\Requests\MediumRequest;
use App\Http\Requests\SubjectRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;

class AuthController extends Controller
{
	protected $UserService;
	protected $QuestionService;
	protected $StandardService;
	protected $SubjectService;
	protected $ChapterService;
	protected $BookmarkService;
	public function __construct()
	{
		$this->UserService = new UserServices();
		$this->StandardService = new StandardService();
		$this->SubjectService = new SubjectService();
		$this->ChapterService = new ChapterService();
		$this->QuestionService = new QuestionService();
		$this->BookmarkService = new BookmarkService();
	}

	public function register(RegisterRequest $request)
	{
		$data = $request->all();
		$response = $this->UserService->createUser($data);
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Student registered successfully',
				'student_details' => $response
			]);
		}
	}

	public function login(Request $request)
	{
		if(!$request->contact_number || !$request->password)
		{
			return response()->json([
				'status' => false,
				'message' => 'Contact number and password are required.',
			]);
		}

		$user_data = $request->all();
		$check_user = $this->UserService->checkIsUserExists($user_data);
		if(!$check_user)
		{
			return response()->json([
				'status' => false,
				'message' => 'Student record not found',
			]);
		}
		if($check_user && !$check_user->is_active)
		{
			return response()->json([
				'status' => false,
				'message' => 'Student account access restricted',
			]);	
		}

		$credentials = $request->only('contact_number', 'password');
		//Create token
		try {
			if(!$token=JWTAuth::attempt($credentials)){
				return response()->json([
					'status' => false,
					'message' => 'Login credentials are invalid.',
				]);
			}
		}
		catch(JWTException $e) {
			return response()->json([
				'status' => false,
				'message' => 'Could not create token.',
			]);
		}

		return response()->json([
			'status' => true,
			'message' => 'Login successfully',
			'token' => $token,
			'student_details' => Auth::user()->leftjoin('standards', 'users.standard', '=', 'standards.id')
										->leftjoin('media', 'users.medium', '=', 'media.id')
										->select('users.*', 'standards.name as standard_name', 'media.name as medium_name')
										->where('users.id', Auth::user()->id)
										->first()
		]);
	}
	public function getStandardData(Request $request)
	{
		$user_id=$request->user()->id ?? 0;
		$response = $this->StandardService->fetch();
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Standards loaded successfully', 
				'standards' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'User Not Found'
			]); 
		}
	}
	
	public function getSubjectData(SubjectRequest $request)
	{

	    $medium_id = $request->medium_id ?? 0;
	    $response = $this->SubjectService->fetch($medium_id);
		if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Subjects loaded successfully', 
				'subjects' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Subjects Not Found'
			]); 
		}
	    
	}
	
	
	public function getMediumData(MediumRequest $request)
	{
	    
	    $standard_id = $request->standard_id ?? 0;
	    $response = $this->StandardService->fetchMedium($standard_id);
		if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Mediums loaded successfully', 
				'mediums' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Medium Not Found'
			]); 
		}
	    
	}
	
	public function getChapterTypeData(Request $request)
	{
		$response = $this->ChapterService->fetchChapterType();
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'PDF formats loaded successfully', 
				'formats' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Not Found'
			]); 
		}
	}
	
	public function getChapterData(ChapterRequest $request)
	{
		$data = $request->all();
		$response = $this->ChapterService->fetchChapters($data);
		if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Chapters loaded successfully', 
				'chapters' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Not Found'
			]); 
		}
	}
	
	public function updateProfile(UpdateProfileRequest $request)
	{
	    $data = $request->all();
	    if($request->hasFile('profile_photo'))
	    {
	    	$data['profile_photo'] = $request->file('profile_photo');
	    }
	    else
	    {
	    	unset($data['profile_photo']);
	    }
	    $data['id']=$request->user()->id ?? 0;
	    $response = $this->UserService->updateUser($data);
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Student details updated successfully',
				'student_details' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}
	}
	
	public function getProfile(Request $request)
	{
	    $id=$request->user()->id ?? 0;
	    $response = $this->UserService->fetch($id);
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Student details loaded successfully',
				'student_details' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}
	}
	
	public function updateProfilePassword(UpdatePasswordRequest $request)
	{
	    $data = $request->all();
	    $data['id']=$request->user()->id ?? 0;
	    $response = $this->UserService->updatePassword($data);
		if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'New password updated successfully',
				'student_details' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}
	}
	
	public function getQuestions(Request $request)
	{
		$data = $request->all();
	    $data['id']=$request->user()->id ?? 0;
	    $data['numbers']=$request->numbers ?? 0;
	    $response = $this->QuestionService->getQuestions($data);
		if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Questions loaded successfully',
				'quiz_id' => 'quiz_'.uniqid(),
				'questions' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}	
	}
	
	public function bookmarkOperation(Request $request)
	{
		$data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    return $response = $this->BookmarkService->bookmark($data);		
	}
	
	public function bookmarkList(Request $request)
	{
		$data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    $response = $this->BookmarkService->list($data);	
	    if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Bookmarks loaded successfully',
				'questions' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}	
	}
	
	public function addAnswer(Request $request)
	{
		$data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    $response = $this->QuestionService->submitAnswer($data);
	    if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Questions submitted successfully'
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Something went wrong'
			]); 
		}	
	}
	
	public function getSummary(Request $request)
	{
		$data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    return $this->QuestionService->getSummary($data);
	}
	
	public function getQuizHistory(Request $request)
	{
	    $data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    $data['subject_id']=$request->subject_id ?? 0;
	    $response = $this->QuestionService->getQuestionHistory($data);
	    if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'History list loaded successfully',
				'quiz_list' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Something went wrong'
			]); 
		}	
	}
	
	public function getSubjectRecord(Request $request)
	{
	    $data = $request->all();
	    $data['user_id']=$request->user()->id ?? 0;
	    $response = $this->QuestionService->getSubjectRecord($data);
	    if($response)
		{
			return response()->json([
				'status' => true,
				'message' => 'Data loaded successfully',
				'records' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Record not found'
			]); 
		}	
	}
	
	public function getChapterFormatData(ChapterFormatRequest $request)
	{
		$data = $request->all();
		$response = $this->ChapterService->fetchChapterFormats($data);
		if(count($response))
		{
			return response()->json([
				'status' => true,
				'message' => 'Chapters loaded successfully', 
				'chapter_formats' => $response
			]);
		}
		else 
		{
			return response()->json([
				'status'=>false,
				'message'=>'Not Found'
			]); 
		}
	}
}
