<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $posts = Post::orderBy('id', 'DESC')->where('post_type', 'post')->get();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'title_cn' => 'required|max:191|unique:posts,title->cn',
                'title_en' => 'required|max:191|unique:posts,title->en',
            ],
            [
                'title_cn.required' => trans('admin_CRUD.is_must'),
                'title_en.required' => trans('admin_CRUD.is_must'),
                'title_cn.max' => trans('admin_CRUD.max_limit'),
                'title_en.max' => trans('admin_CRUD.max_limit'),
                'title_cn.unique' => trans('admin_CRUD.already_exist'),
                'title_en.unique' => trans('admin_CRUD.already_exist'),
            ]
        );

        $post = Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $request->thumbnail,
            'title' => ['cn'=>$request->title_cn, 'en'=>$request->title_en],
            'slug' => str_slug($request->title_en),
            'sub_title' => ['cn'=>$request->sub_title_cn, 'en'=>$request->sub_title_en],
            'details' => ['cn'=>$request->details_cn, 'en'=>$request->details_en],
            'is_published' => $request->is_published,
            'post_type' => 'post',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $post->categories()->sync($request->category_id, false);

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
        $categories = Category::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('admin.post.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,
            [
                'title_cn' => 'required|max:191|unique:posts,title->cn,' . $post->id,
                'title_en' => 'required|max:191|unique:posts,title->en,' . $post->id,
            ],
            [
                'title_cn.required' => trans('admin_CRUD.is_must'),
                'title_en.required' => trans('admin_CRUD.is_must'),
                'title_cn.max' => trans('admin_CRUD.max_limit'),
                'title_en.max' => trans('admin_CRUD.max_limit'),
                'title_cn.unique' => trans('admin_CRUD.already_exist'),
                'title_en.unique' => trans('admin_CRUD.already_exist'),
            ]
        );
        $post->admin_id = Auth::id();
        $post->thumbnail = $request->thumbnail;
        $post->title = ['cn' => $request->title_cn, 'en' => $request->title_en];
        $post->slug = str_slug($request->title_en);
        $post->sub_title = ['cn' => $request->sub_title_cn, 'en' => $request->sub_title_en];
        $post->details = ['cn' => $request->details_cn, 'en' => $request->details_en];
        $post->is_published = $request->is_published;
        $post->post_type = 'post';
        $post->save();

        $post->categories()->sync($request->category_id, false);

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
