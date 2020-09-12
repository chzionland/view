<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
            if (count($categories) > 0) {
                $first_category = $categories->first();
                $posts = $first_category->posts()->orderBy('is_top', 'DESC')->latest()->where('is_published', '1')->get();
                foreach ($categories as $category) {
                    $new_posts = $category->posts()->orderBy('is_top', 'DESC')->latest()->where('is_published', '1')->get();
                    $merged_posts = $new_posts->merge($posts);
                    $posts = $merged_posts;
                }
                $posts->sortByDesc('is_top')->sortByDesc('created_at');
                $posts = $this->paginate($posts);
                // dd($posts);
            } else {
                $posts = null;
            }
            return view('website.column', compact('title', 'column', 'posts', 'categories'));
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

    public function paginate($items, $perPage = 6, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
