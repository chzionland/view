<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;

class WebsiteController extends Controller
{
    public function index()
    {   $title = trans('website.home');
        $posts = Post::orderBy('is_top', 'DESC')->latest()->where('post_type', 'post')->where('is_published', '1')->paginate(6)->onEachSide(1);
        return view('website.index', compact('title', 'posts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_published', '1')->first();
        if ($category) {
            $title = $category->title;
            $posts = $category->posts()->latest()->where('is_published', '1')->paginate(6)->onEachSide(1);
            return view('website.category', compact('title', 'category', 'posts'));
        }
    }

    public function column($slug)
    {
        $column = Category::where('slug', $slug)->where('is_column', '1')->where('is_published', '1')->first();
        if ($column) {
            $title = $column->title;
            $categories = $column->categories()->where('is_published', '1')->get();
            return view('website.column', compact('title', 'column', 'categories'));
        }
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->where('is_published', '1')->first();
        if ($post) {
            $title = $post->title;
            return view('website.post', compact('title', 'post'));
        }
    }

    public function page($slug)
    {
        $page = Post::where('slug', $slug)->where('post_type', 'page')->where('is_published', '1')->first();
        if ($page) {
            $title = $page->title;
            return view('website.page', compact('title', 'page'));
        }
    }
}
