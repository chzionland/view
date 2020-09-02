<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Post;
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
    public function store(NewsRequest $request)
    {
        $validated = $request->validated();

        Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'title' => ['cn' => $validated['title_cn'], 'en' => $validated['title_en']],
            'slug' => str_slug($validated['title_en']),
            'sub_title' => ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']],
            'is_top' => $request->is_top,
            'details' => ['cn' => $validated['details_cn'], 'en' => $validated['details_en']],
            'is_published' => $request->is_published,
            'post_type' => 'news',
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('news.index');
    }

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
        $news = Post::where('id', $id)->first();
        if ($news) {
            return view('admin.news.edit', compact('title', 'news'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post $news
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, Post $news)
    {
        $validated = $request->validated();

        $news->admin_id = Auth::id();
        $news->thumbnail = $validated['thumbnail'];
        $news->title = ['cn' => $validated['title_cn'], 'en' => $validated['title_en']];
        $news->slug = str_slug($validated['title_en']);
        $news->sub_title = ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']];
        $news->is_top = $request->is_top;
        $news->details = ['cn' => $validated['details_cn'], 'en' => $validated['details_en']];
        $news->is_published = $request->is_published;
        $news->post_type = 'news';
        $news->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = Post::where('id', $id)->first();
        if ($news) {
            $news->delete();
            Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
            return redirect()->route('news.index');
        }
    }
}
