<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
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
        $title = trans('admin_CRUD.page_list');
        $pages = Post::latest()->where('post_type', 'page')->get();
        return view('admin.page.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.create_page');
        return view('admin.page.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $validated = $request->validated();

        if ($request->created_at) {
            $created_at = $request->created_at;
        } else {
            $created_at = Carbon::now();
        }

        Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'title' => ['cn' => $validated['title_cn'], 'en' => $validated['title_en']],
            'slug' => str_slug($validated['title_en']),
            'sub_title' => ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']],
            'is_top' => $request->is_top,
            'details' => ['cn' => $validated['details_cn'], 'en' => $validated['details_en']],
            'is_published' => $request->is_published,
            'post_type' => 'page',
            'created_at' => $created_at,
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('pages.index');
    }

    public function show($id){

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
        $page = Post::where('id', $id)->first();
        if ($page) {
            return view('admin.page.edit', compact('title', 'page'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Post $page)
    {
        $validated = $request->validated();

        if ($request->created_at) {
            $created_at = $request->created_at;
        } else {
            $created_at = Carbon::now();
        }

        $page->admin_id = Auth::id();
        $page->thumbnail = $validated['thumbnail'];
        $page->title = ['cn' => $validated['title_cn'], 'en' => $validated['title_en']];
        $page->slug = str_slug($validated['title_en']);
        $page->sub_title = ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']];
        $page->is_top = $request->is_top;
        $page->details = ['cn' => $validated['details_cn'], 'en' => $validated['details_en']];
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->created_at = $created_at;
        $page->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Post::where('id', $id)->first();
        if ($page) {
            $page->delete();
            Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
            return redirect()->route('pages.index');
        }
    }
}
