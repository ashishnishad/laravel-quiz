<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\Datatables\Datatables;
use DB;

class CategoryController extends Controller
{

	public function datatable(Request $request){
        return \DataTables::of(Category::query())->addColumn('action', function(Category $data) {
                                return '<div class="action-list"><a href="' . route('category.edit',$data->id) . '" class="btn btn-success">Edit</a> <a href="javascript:;" data-href="'.route('category.remove',$data->id).'" data-toggle="modal" data-target="#confirm-delete" class="delete btn btn-danger">Delete</a></div>';
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
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $parents    = Category::all();
        //return ($categories);
        return view('admin.category.create',['category'=>[],'parents'=>$parents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category([
            'name' => $request->get('name'),
            'status'=> $request->get('status'),
        ]);
		
        $category->slug         = $this->createSlug($request->get('name'));
        $category->save();
        return redirect()->route('category.index')->withStatus(__('Category successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name         = $request->name;
        $category->status       = $request->status;
        $category->slug         = $this->createSlug($request->name,$category->id);
		
        $category->save();
        return redirect()->back()->withStatus('Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category,$id)
    {
        $cat = Category::find($id);
        $cat->delete();
        return response()->json('Category deleted successfully.');
    }
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($title, $id = 0)
    {
        // Normalize the title
        $slug = str_slug($title);

        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);

        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
		$i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Category::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}