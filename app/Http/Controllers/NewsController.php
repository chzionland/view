<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
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
        $title = trans('admin_CRUD.news_list');
        $newses = Post::latest()->where('post_type', 'news')->get();
        return view('admin.news.index', compact('title', 'newses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.create_news');
        return view('admin.news.create', compact('title'));
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

        Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $request->thumbnail,
            'title' => ['cn'=>$request->title_cn, 'en'=>$request->title_en],
            'slug' => str_slug($request->title_en),
            'sub_title' => ['cn'=>$request->sub_title_cn, 'en'=>$request->sub_title_en],
            'details' => ['cn'=>$request->details_cn, 'en'=>$request->details_en],
            'is_published' => $request->is_published,
            'post_type' => 'news',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('newses.index');
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
    public function edit($id)
    {
        $title = trans('admin_CRUD.update_news');
        return view('admin.news.edit', compact('title', 'news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $news)
    {
        $this->validate($request,
            [
                'title_cn' => 'required|max:191|unique:posts,title->cn,' . $news->id,
                'title_en' => 'required|max:191|unique:posts,title->en,' . $news->id,
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
        $news->admin_id = Auth::id();
        $news->thumbnail = $request->thumbnail;
        $news->title = ['cn' => $request->title_cn, 'en' => $request->title_en];
        $news->slug = str_slug($request->title_en);
        $news->sub_title = ['cn' => $request->sub_title_cn, 'en' => $request->sub_title_en];
        $news->details = ['cn' => $request->details_cn, 'en' => $request->details_en];
        $news->is_published = $request->is_published;
        $news->post_type = 'news';
        $news->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('newses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $news)
    {
        $news->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('newses.index');
    }
}
