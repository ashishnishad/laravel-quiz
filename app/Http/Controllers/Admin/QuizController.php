<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Http\Requests\QuizRequest;
use Yajra\Datatables\Datatables;

class QuizController extends Controller
{

	public function datatable(Request $request){
        return \DataTables::of(Quiz::with('category')->get())->addColumn('action', function(Quiz $data) {
                                return '<div class="action-list"><a href="javascript:;" data-href="'.route('quiz.remove',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger">Delete</a></div>';
                            })
                            ->rawColumns(['action'])->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.quiz.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$categories = Category::all();
        return view('admin.quiz.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$priorty = $request->get('priorty');
    	$priorty_arr = [];
    	parse_str($priorty,$priorty_arr);
    	
        $quiz = new Quiz([
            'name' => 'Quiz',
            'category_id'=> $request->get('category_id')
        ]);
		
        $quiz->save();
        $quiz->name = $quiz->name.'#'.$quiz->id;
        $quiz->save();

        $priorty_arr = $priorty_arr['priorty'];
        
        foreach($priorty_arr as $question=>$priorty){
        	$quiz_question = new QuizQuestion;
        	$quiz_question->quiz_id = $quiz->id;
        	$quiz_question->question_id = $question;
        	$quiz_question->priorty = (int)$priorty;
        	$quiz_question->save();
        }

        return response()->json(array('success' => true, 'msg'=>'Quiz created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\Question  $Question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin\Question  $Question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
    	
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\Question  $Question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\Quiz $Quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,$id)
    {
    	$quiz_question = QuizQuestion::where(['quiz_id'=>$id])->delete();
        $quiz = Quiz::find($id);
        $quiz->delete();

        return response()->json('Quiz deleted successfully.');
    }
}