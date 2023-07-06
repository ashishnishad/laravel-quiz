<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Category;
use App\Http\Requests\QuestionRequest;
use Yajra\Datatables\Datatables;
use DB;

class QuestionController extends Controller
{

	public function datatable(Request $request){
        return \DataTables::of(Question::query())->addColumn('action', function(Question $data) {
                                return '<div class="action-list"><a href="' . route('question.edit',$data->id) . '" class="btn btn-success">Edit</a> <a href="javascript:;" data-href="'.route('question.remove',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger">Delete</a></div>';
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
        return view('admin.question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories    = Category::all();
        return view('admin.question.create',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $question = new Question([
            'question' => $request->get('question'),
            'category_id'=> $request->get('category_id'),
            'status'=> $request->get('status'),
            'complexity'=> $request->get('complexity')
        ]);
		
        $question->save();
        return redirect()->route('question.index')->withStatus(__('Question successfully created.'));
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
    	$categories    = Category::all();
        return view('admin.question.edit',['categories'=>$categories, 'question'=>$question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\Question  $Question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $question->question      = $request->question;
        $question->category_id   = $request->category_id;
        $question->complexity    = $request->complexity;
        $question->status        = $request->status;
		
        $question->save();
        return redirect()->back()->withStatus('Question Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\Question  $Question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question,$id)
    {
        $question = Question::find($id);
        $question->delete();
        return response()->json('Question deleted successfully.');
    }

    public function question_ajax(Request $request)
    {
        $questions = Question::where(['category_id' => $request->category_id,'complexity' => $request->complexity])->get();
        $returnHTML = view('admin.question.list',['questions'=>$questions])->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function question_by_ids(Request $request)
    {
        $ques_ids = array_map('intval', explode(',', $request->ques_ids) );
       // dd($ques_ids);
        $questions = Question::whereIn('id' , $ques_ids)->get();
        $returnHTML = view('admin.question.question_list',['questions'=>$questions])->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
}