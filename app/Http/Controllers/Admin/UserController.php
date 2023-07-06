<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use DB;

class UserController extends Controller
{

    public function datatable(Request $request){
        return \DataTables::of(User::query()->where('role','!=','admin'))->addColumn('action', function(User $data) {
                                return '<div class="action-list"><a href="' . route('user.edit',$data->id) . '" class="btn btn-success">Edit</a> <a href="javascript:;" data-href="'.route('user.remove',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger">Delete</a></div>';
                            })
                            ->rawColumns(['action'])->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $user)
    {
        $user->first_name   = $request->get('first_name');
        $user->last_name    = $request->get('last_name');
        $user->name         = $request->get('first_name').' '.$request->get('last_name');
        $user->contact_no   = $request->get('contact_no');
        $user->company_name = $request->get('company_name');
        $user->email        = $request->get('email');
        $user->role         = 'customer';
        $user->password     = Hash::make($request->get('password'));
        $user->save();
        
        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //$city = DB::table('US_CITIES')->where('ID_STATE',$user->state)->get();
        //$user->cities = $city;
        //return $user;
        return view('admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UserRequest $request, User  $user)
    {   
        $user->name         = $request->input('first_name').' '.$request->last_name;
        $user->first_name   = $request->input('first_name');
        $user->last_name    = $request->input('last_name');
        $user->contact_no   = $request->get('contact_no');
        $user->company_name = $request->get('company_name');
        $user->email        = $request->input('email');
        $user->role         = 'customer';
        if($request->filled('password')){
            $user->password     = bcrypt($request->input('password'));
        }
        $user->save();
        

        return redirect()->route('user.edit',$user->id)->withStatus('success','User Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User deleted successfully.');
    }
}
