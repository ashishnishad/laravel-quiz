<?php
namespace App\Http\Controllers;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('quizzes')->paginate(15);
    	return view('home', ['categories' => $categories]);
    }
}