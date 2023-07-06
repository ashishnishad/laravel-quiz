<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\QuizResultOption;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request, $slug)
    {
        $category = Category::where(['slug'=>$slug])->with('quizzes')->firstOrFail();
       
    	return view('quiz', ['category' => $category]);
    }

    public function bucket(Request $request, $quiz_id)
    {
        $randomString = str_random(15);
        session(['bucket_id' => $randomString]);
    	return view('bucket', ['quiz_id' => $quiz_id, 'bucket_id' => $randomString]);
    }

    public function quiz_start(Request $request, $quiz_id, $bucket_id)
    {
        if(!session('bucket_id')) abort(403, 'Unauthorized action.');
    	return view('quiz_start', ['quiz_id' => $quiz_id, 'bucket_id' => $bucket_id]);
    }

    public function quiz_questions(Request $request){
        $user_id = auth()->user()->id;
        $quiz_id = $request->quiz_id;
        $bucket_id = session('bucket_id');

        $question = QuizQuestion::where(['quiz_id' => $quiz_id])
                    ->join('questions', function($join) {
                      $join->on('questions.id', '=', 'quiz_questions.question_id');
                    })
                    ->where('questions.status', 'enabled')
                    ->with(['question_q:id,question','options:id,answer_option,question_id'])->paginate(1);
       //dd($question);
        if($request->action == 'next' || $request->action == 'prev'){
            $quiz_result = QuizResult::firstOrNew(['quiz_id' => $request->quiz_id,'bucket_id' => $bucket_id,'user_id' => $user_id,'question_id' => $request->ques_id]);
            $quiz_result->save();

            if($request->options){
                $options = $request->get('options');
                $options_arr = [];
                parse_str($options,$options_arr);
                foreach($options_arr['q_option'] as $key=>$option){
                    $quiz_result_opt = QuizResultOption::firstOrNew(['quiz_result_id' => $quiz_result->id,'option_id' => $option]);
                    $quiz_result_opt->save();
                }
                QuizResultOption::whereNotIn('option_id', $options_arr['q_option'])->where(['quiz_result_id' => $quiz_result->id])->delete();
            }
          
            $quiz_result = QuizResult::with('options:option_id,quiz_result_id')->where(['quiz_id' => $request->quiz_id,'bucket_id' => $bucket_id,'question_id' => $question[0]->question_q->id,'user_id' => $user_id])->first();

        }else{
           // dd($question[0]->question_q);
            $quiz_result = QuizResult::with('options:option_id,quiz_result_id')->where(['quiz_id' => $request->quiz_id,'bucket_id' => $bucket_id,'question_id' => $question[0]->question_q->id,'user_id' => $user_id])->first();

        }
       
        if($quiz_result && $quiz_result->options){
            $options = array_column($quiz_result->options->toArray(),'option_id');
        }else{
            $options = [];
        }

        $last_page = false;
        $first_page = false;
        if($question->lastPage() == $request->page){
            $last_page = true;
        }
        if($question->onFirstPage()){
            $first_page = true;
        }


        if(!empty($question)){
            return response()->json(['success'=>true,'question'=>$question[0]->question_q,'options'=>$question[0]->options,'selected_options'=>$quiz_result,'s_options'=>$options,'questiond'=>$question,'last_page'=>$last_page,'first_page'=>$first_page,'total_page'=>$question->total(),'current_page'=>$question->currentPage()]);
        }else{
            return response()->json(['success'=>false]);
        }        
    }

    public function quiz_result(Request $request, $quiz_id){

        if(!session('bucket_id')){
            abort(403, 'Session ended.');
        }
        $bucket_id = session('bucket_id');
        $total_ques = QuizResult::Where(['quiz_id'=>$quiz_id,'bucket_id'=>$bucket_id])->count();
        $quess = QuizResult::with(['answers:id,question_id','options:quiz_result_id,option_id'])->Where(['quiz_id'=>$quiz_id,'bucket_id'=>$bucket_id])->get();
        
        $correct = 0;
        if($quess){
            foreach($quess as $key=>$ques){
                $answer = $ques->answers->pluck('id');
                $options = $ques->options->pluck('option_id');
                if(count($answer) == count($options)){
                    $differentItems = $answer->diff($options);
                    
                    if($differentItems->isEmpty()){
                        $correct++;
                    }
                }
            }
        }
        session()->forget('bucket_id');
        return view('quiz_result', ['total_ques'=>$total_ques,'correct'=>$correct]);
    }
}