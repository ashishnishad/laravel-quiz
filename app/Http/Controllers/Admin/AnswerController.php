<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use Yajra\Datatables\Datatables;

class AnswerController extends Controller
{

	public function datatable(Request $request){
        return \DataTables::of(Answer::with('question')->get())->addColumn('action', function(Answer $data) {
                                return '<div class="action-list"><a href="' . route('answer.edit',$data->id) . '" class="btn btn-success">Edit</a> <a href="javascript:;" data-href="'.route('answer.remove',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger">Delete</a></div>';
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
        return view('admin.answer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $questions    = Question::all();
        return view('admin.answer.create',['questions'=>$questions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnswerRequest $request)
    {
        $answer = new Answer([
            'answer_option' => $request->get('answer_option'),
            'question_id'=> $request->get('question_id'),
            'is_correct'=> $request->get('is_correct')
        ]);
		
        $answer->save();
        return redirect()->route('answer.index')->withStatus(__('Answer successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        $questions    = Question::all();
        return view('admin.answer.edit',['questions'=>$questions, 'answer'=>$answer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        $answer->question_id      = $request->question_id;
        $answer->answer_option    = $request->answer_option;
        $answer->is_correct       = $request->is_correct;
		
        $answer->save();
        return redirect()->back()->withStatus('Answer Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer,$id)
    {
        $ans = Answer::find($id);
        $ans->delete();
        return response()->json('Answer deleted successfully.');
    }
}