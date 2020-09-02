<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StorePostRequest;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Translatable\TranslatableServiceProvider;

class PostController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('admin_CRUD.post_list');
        $posts = Post::latest()->where('post_type', 'post')->get();
        return view('admin.post.index', compact('title', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.create_post');
        $authors = Author::orderBy('name', 'ASC')->pluck('name', 'id');
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('admin.post.create', compact('title', 'authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if ($request->created_at) {
            $created_at = $request->created_at;
        } else {
            $created_at = Carbon::now();
        }

        $post = Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $request->thumbnail,
            'title' => ['cn'=>$request->title_cn, 'en'=>$request->title_en],
            'slug' => str_slug($request->title_en),
            'sub_title' => ['cn'=>$request->sub_title_cn, 'en'=>$request->sub_title_en],
            'is_top' => $request->is_top,
            'limit' => '0',
            'is_reproduced' => $request->is_reproduced,
            'source' => $request->source,
            'source_url' => $request->source_url,
            'editor' => $request->editor,
            'intro' => ['cn'=>$request->intro_cn, 'en'=>$request->intro_en],
            'details' => ['cn'=>$request->details_cn, 'en'=>$request->details_en],
            'is_published' => $request->is_published,
            'post_type' => 'post',
            'created_at' => $created_at,
            'updated_at' => Carbon::now(),
        ]);

        $post->authors()->sync($request->author_id, true);
        $post->categories()->sync($request->category_id, true);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = trans('admin_CRUD.update_post');
        $authors = Author::orderBy('id', 'DESC')->pluck('name', 'id');
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('admin.post.edit', compact('title', 'authors', 'categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if ($request->created_at) {
            $created_at = $request->created_at;
        } else {
            $created_at = Carbon::now();
        }

        $post->admin_id = Auth::id();
        $post->thumbnail = $request->thumbnail;
        $post->title = ['cn' => $request->title_cn, 'en' => $request->title_en];
        $post->slug = str_slug($request->title_en);
        $post->sub_title = ['cn' => $request->sub_title_cn, 'en' => $request->sub_title_en];
        $post->is_top = $request->is_top;
        $post->limit = '0';
        $post->is_reproduced = $request->is_reproduced;
        $post->source = $request->source;
        $post->source_url = $request->source_url;
        $post->editor = $request->editor;
        $post->intro = ['cn' => $request->intro_cn, 'en' => $request->intro_en];
        $post->details = ['cn' => $request->details_cn, 'en' => $request->details_en];
        $post->is_published = $request->is_published;
        $post->post_type = 'post';
        $post->created_at = $created_at;
        $post->save();

        $post->authors()->sync($request->author_id, true);
        $post->categories()->sync($request->category_id, true);

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('posts.index');
    }
}
