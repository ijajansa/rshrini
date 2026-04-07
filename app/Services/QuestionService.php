<?php
namespace App\Services;
use App\Models\Question;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\StudentAnswer;
use App\Models\StudentAnswerHistory;
use App\Models\Bookmark;
use Storage;

class QuestionService
{
    protected $SubjectModel;
    protected $ChapterModel;
    protected $QuestionModel;
    protected $BookmarkModel;
    protected $StudentAnswerModel;
    protected $StudentAnswerHistoryModel;

    public function __construct()
    {
        $this->ChapterModel = new Chapter();
        $this->SubjectModel = new Subject();
        $this->QuestionModel = new Question();
        $this->BookmarkModel = new Bookmark();
        $this->StudentAnswerModel = new StudentAnswer();
        $this->StudentAnswerHistoryModel = new StudentAnswerHistory();
    }

    public function getQuestions($data = [])
    {
        $limit=$data['numbers'] ? $data['numbers'] : 0;
        
        if($limit == 0)
        {
            $get_chapter_record = $this->QuestionModel->where('chapter_id',$data['chapter_id'])->count();
            //9;
            $check_record_count1 = $this->StudentAnswerHistoryModel->where('is_active',1)->where('chapter_id',$data['chapter_id'])->where('user_id',$data['id'])->count();
        }
        else
        {
            $get_chapter_record = $this->QuestionModel->where('chapter_id',$data['chapter_id'])->count();
        
            $check_record_count1 = $this->StudentAnswerHistoryModel->where('is_active',1)->where('chapter_id',$data['chapter_id'])->where('user_id',$data['id'])->count();
        }
        
        
        
        // 9;
        if($check_record_count1 >= $get_chapter_record)
        {
            $rec['attempted'] = 0;
            $check_record_count = $this->StudentAnswerHistoryModel->where('is_active',1)->where('chapter_id',$data['chapter_id'])->where('user_id',$data['id'])->where('attempted',1)->count();
            $this->StudentAnswerHistoryModel->where('is_active',1)->where('chapter_id',$data['chapter_id'])->where('user_id',$data['id'])->update($rec);
        }
        else
        {
            $check_record_count = $this->StudentAnswerHistoryModel->where('is_active',1)->where('chapter_id',$data['chapter_id'])->where('user_id',$data['id'])->where('attempted',1)->count();
        }
        
        $record = $this->QuestionModel->join('chapters','chapters.id','questions.chapter_id')->where('questions.is_active',1)->where('questions.chapter_id',$data['chapter_id']);
        if($limit !=0)
        {
            $record = $record->skip($check_record_count)->take($limit);
        }
        else
        {
            $record = $record->skip($check_record_count)->take($get_chapter_record);
        }
        $record = $record->select('questions.*','chapters.name as chapter_name')->get();
        foreach($record as $ans)
        {
            $ans->is_bookmarked = 0;
            $rec = $this->BookmarkModel->where('question_id',$ans->id)->where('user_id',$data['id'])->first();
            if($rec)
            {
                $ans->is_bookmarked = 1;    
            }
            
        }
        
        return $record;
    }
    
    public function submitAnswer($data =[])
    {
        foreach ($data['answer_list'] as $key => $value) {
            $question = $this->QuestionModel->where('id',$value['question_id'])->first();
            if($question)
            {
                $record = $question->toArray();
                // $add = $this->StudentAnswerModel->where('user_id',$data['user_id'])->where('question_id',$value['question_id'])->first();
                // if(!$add)
                // {
                    $add = $this->StudentAnswerModel;
                // } 
                $add->user_id = $data['user_id'] ?? 0;
                $add->quiz_id = $data['quiz_id'] ?? null;
                

                $record['user_id'] = $data['user_id'] ?? 0;
                $record['quiz_id'] = $data['quiz_id'] ?? null;
                
                $record['question_id'] = $value['question_id'];
                $add->question_id = $value['question_id'] ?? 0;
                if($value['selected_answer']!=null)
                {
                    $record['answer'] = $value['selected_answer'] ?? null;
                    $add->answer = $value['selected_answer'] ?? null;

                    if($value['selected_answer'] == $question->solution)
                    {
                        // answer is correct
                        $add->is_correct = 2;
                        $record['is_correct'] = 2;
                    }
                    else
                    {
                        // answer is wrong
                        $add->is_correct = 1;
                        $record['is_correct'] = 1;
                    }
                }
                else
                {
                    // answer not attempted
                    $add->is_correct = 0;
                    $record['is_correct'] = 0;

                }
                $add->save();
                unset($record['id']);
                unset($record['created_at']);
                unset($record['updated_at']);
                unset($record['is_active']);

                    // $record_exists = $this->StudentAnswerHistoryModel->where('user_id',$record['user_id'])->where('question_id',$record['question_id'])->where('chapter_id',$record['chapter_id'])->first();
                    // if($record_exists)
                    // {
                    //     $this->StudentAnswerHistoryModel->where('user_id',$record['user_id'])->where('question_id',$record['question_id'])->where('chapter_id',$record['chapter_id'])->update($record);
                    // }
                    // else
                    // {
                        $this->StudentAnswerHistoryModel->create($record);
                    // }
            }
        }

        return 1;
    }
    
    
    public function getSummary($data =[])
    {
        $response = $this->StudentAnswerHistoryModel->join('chapters','chapters.id','student_answer_histories.chapter_id')->where('quiz_id',$data['quiz_id'])->select('student_answer_histories.*','chapters.name as chapter_name')->get();
        if($response)
        {
            return response()->json([
				'status' => true,
				'message' => 'Summary details loaded successfully',
				'questions' => $response,
                'total_questions' => $this->StudentAnswerHistoryModel->where('quiz_id',$data['quiz_id'])->count(),
                'correct_questions' => $this->StudentAnswerHistoryModel->where('quiz_id',$data['quiz_id'])->where('is_correct',2)->count(),
                'incorrect_questions' => $this->StudentAnswerHistoryModel->where('quiz_id',$data['quiz_id'])->where('is_correct',1)->count(),
                'skipped_questions' => $this->StudentAnswerHistoryModel->where('quiz_id',$data['quiz_id'])->where('is_correct',0)->count()
			]);    
        }
        else
        {
            return response()->json([
				'status' => false,
				'message' => 'Something went wrong'
				]);
        }
        
    }
    
    public function getQuestionHistory($data =[])
    {
        return $this->StudentAnswerHistoryModel->join('chapters','chapters.id','student_answer_histories.chapter_id')->where('chapters.subject_id',$data['subject_id'])->where('student_answer_histories.user_id',$data['user_id'])->where('student_answer_histories.quiz_id','!=',null)->select('student_answer_histories.quiz_id','chapters.name as chapter_name')->distinct()->get();
    }
    
    public function getSubjectRecord($data =[])
    {
        $record_array =[];
        $records = $this->SubjectModel->where('is_active',1)->select('id','name')->get(); 
        foreach($records as $subject)
        {
            $chapters = $this->ChapterModel->where('subject_id',$subject->id)->get();
            if($chapters)
            {
                foreach($chapters as $chapter)
                {
                    $chapter['question_count'] = $this->QuestionModel->where('chapter_id',$chapter->id)->count();
                    $chapter['attempted_question_count'] = $this->StudentAnswerHistoryModel->where('chapter_id',$chapter->id)->where('user_id',$data['user_id'])->count();
                }
                $subject['question_count'] = $chapter->question_count ?? 0;
                $subject['attempted_question_count'] = $chapter->attempted_question_count ?? 0;
                if($subject->attempted_question_count > 0)
                {
                    array_push($record_array,$subject);
                }    
            }
            
        }
        
        
        
        return $record_array;
    }
    
    public function getMCQList($data)
    {
        $record = $this->QuestionModel
        ->join('chapters','chapters.id','questions.chapter_id')
        ->join('subjects','subjects.id','chapters.subject_id')
        ->join('standards','standards.id','subjects.standard_id');
        if($data!=null)
        {
            $record = $record->where(function($query) use($data){
                $query->where('chapters.name','like','%'.$data.'%')->orWhere('subjects.name','like','%'.$data.'%')->orWhere('standards.name','like','%'.$data.'%'); 
            });
        }
        $record = $record->select('questions.*','chapters.name AS chapter_name','subjects.name AS subject_name','standards.name AS standard_name')
        ->get();
        
        return $record;
    }

    public function createQuestion($data = [])
    {
        if(isset($data['question_image']) && $data['question_image']!=null)
        {
            $data['question_image'] = $data['question_image']->store('question_images');
        }
        if(isset($data['option1_image']) && $data['option1_image']!=null)
        {
            $data['option1_image'] = $data['option1_image']->store('option1_images');
        }
        if(isset($data['option2_image']) && $data['option2_image']!=null)
        {
            $data['option2_image'] = $data['option2_image']->store('option2_images');
        }
        if(isset($data['option3_image']) && $data['option3_image']!=null)
        {
            $data['option3_image'] = $data['option3_image']->store('option3_images');
        }
        if(isset($data['option4_image']) && $data['option4_image']!=null)
        {
            $data['option4_image'] = $data['option4_image']->store('option4_images');
        }
        if(isset($data['solution_image']) && $data['solution_image']!=null)
        {
            $data['solution_image'] = $data['solution_image']->store('solution_images');
        }
        return $this->QuestionModel->create($data);
    }

    public function changeStatus($id)
    {
        $record = $this->QuestionModel->where('id',$id)->first();
        if($record && $record->is_active == 1)
        {
            $record->is_active = 0;
            $record->save();
        }
        else
        {
            $record->is_active = 1;
            $record->save();
        }
        return $record;
        
    }
    
    public function fetch($id)
    {
        return $this->QuestionModel->find($id);
    }
    
    public function updateQuestion($data =[])
    {
        $existing = $this->QuestionModel->where('id',$data['id'])->first();
        {
        
        if(isset($data['question_image']) && $data['question_image']!=null)
        {
            $data['question_image'] = $data['question_image']->store('question_images');
            if($existing->question_image!=null && file_exists(storage_path('app')."/".$existing->question_image))
            {
                unlink(storage_path('app')."/".$existing->question_image);
            }
        }
        if(isset($data['option1_image']) && $data['option1_image']!=null)
        {
            $data['option1_image'] = $data['option1_image']->store('option1_images');
            if($existing->option1_image!=null && file_exists(storage_path('app')."/".$existing->option1_image))
            {
                unlink(storage_path('app')."/".$existing->option1_image);
            }
        }
        if(isset($data['option2_image']) && $data['option2_image']!=null)
        {
            $data['option2_image'] = $data['option2_image']->store('option2_images');
            if($existing->option2_image!=null && file_exists(storage_path('app')."/".$existing->option2_image))
            {
                unlink(storage_path('app')."/".$existing->option2_image);
            }
        }
        if(isset($data['option3_image']) && $data['option3_image']!=null)
        {
            $data['option3_image'] = $data['option3_image']->store('option3_images');
            if($existing->option3_image!=null && file_exists(storage_path('app')."/".$existing->option3_image))
            {
                unlink(storage_path('app')."/".$existing->option3_image);
            }
        }
        if(isset($data['option4_image']) && $data['option4_image']!=null)
        {
            $data['option4_image'] = $data['option4_image']->store('option4_images');
            if($existing->option4_image!=null && file_exists(storage_path('app')."/".$existing->option4_image))
            {
                unlink(storage_path('app')."/".$existing->option4_image);
            }
        }
        if(isset($data['solution_image']) && $data['solution_image']!=null)
        {
            $data['solution_image'] = $data['solution_image']->store('solution_images');
            if($existing->solution_image!=null && file_exists(storage_path('app')."/".$existing->solution_image))
            {
                unlink(storage_path('app')."/".$existing->solution_image);
            }
        }
        
        }
        return $this->QuestionModel->where('id',$data['id'])->update($data);
    }

}
