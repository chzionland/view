<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = trans('app.dashboard');

        $categories = Category::orderBy('updated_at', 'DESC')->limit('5')->get();
        $posts = Post::orderBy('updated_at', 'DESC')->where('post_type', 'post')->limit('5')->get();
        $pages = Post::orderBy('updated_at', 'DESC')->where('post_type', 'page')->limit('5')->get();

        return view('admin.dashboard', compact('title', 'categories', 'posts', 'pages'));
    }
}
