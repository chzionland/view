<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\VisitorContact;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class WebsiteController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->where('post_type', 'post')->where('is_published', '1')->paginate(5)->onEachSide(1);

        return view('website.index', compact('posts'));
    }

    public function categoryList()
    {
        $categories = Category::orderBy('name', 'ASC')->where('is_published', '1')->get();
        $posts = Post::orderBy('id', 'DESC')->where('is_published', '1')->where('post_type', 'post')->get();
        $uncategorized_posts = [];
        foreach ($posts as $post) {
            if (count($post->categories) == 0) {
                $uncategorized_posts[] = $post;
            }
        }
        return view('website.category-list', compact('categories', 'uncategorized_posts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_published', '1')->first();
        if ($category) {
            $posts = $category->posts()->orderBy('post_id', 'DESC')->where('is_published', '1')->paginate(5);
            return view('website.category', compact('category', 'posts'));
        }
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->where('is_published', '1')->first();
        if ($post) {
            return view('website.post', compact('post'));
        }
    }

    public function page($slug)
    {
        $page = Post::where('slug', $slug)->where('post_type', 'page')->where('is_published', '1')->first();
        if ($page) {
            return view('website.page', compact('page'));
        }
    }

    public function showMessageForm() {
        return view('website.message');
    }

    public function submitMessageForm(Request $request) {
        $this->validate($request,
            [
                'name' => 'required',
                'email' => 'required',
                'tel' => 'required',
                'message' => 'required',
            ],
            [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'tel.required' => 'Tel is required',
                'message.required' => 'Message is required'
            ],
        );
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'message' => $request->message,
        ];

        Mail::to('media@qizhong.land')->send(new VisitorContact($data));

        Session::flash('message', trans('website.message_sent_successfully'));
        return redirect()->route('message.show', app()->getLocale());
    }
}
