<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;

class WebsiteController extends Controller
{
    public function index()
    {   $title = trans('website.home');
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        $posts = Post::latest()->where('post_type', 'post')->where('is_published', '1')->paginate(5)->onEachSide(1);
        return view('website.index', compact('title', 'posts', 'categories'));
    }

    public function categoryList()
    {
        $title = trans('website.category_list');
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        return view('website.category-list', compact('title', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_published', '1')->first();
        if ($category) {
            $title = $category->title;
            $posts = $category->posts()->orderBy('post_id', 'DESC')->where('is_published', '1')->paginate(5);
            return view('website.category', compact('title', 'category', 'posts'));
        }
    }

    public function column($slug)
    {
        $column = Category::where('slug', $slug)->where('is_published', '1')->first();
        if ($column) {
            $title = $column->title;
            $posts = $column->posts()->orderBy('post_id', 'DESC')->where('is_published', '1')->paginate(5);
            return view('website.column', compact('title', 'column', 'posts'));
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
