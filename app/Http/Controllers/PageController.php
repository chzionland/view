<?php

namespace App\Http\Controllers;

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
        $pages = Post::orderBy('id', 'DESC')->where('post_type', 'page')->get();
        return view('admin.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
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
            'post_type' => 'page',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('pages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $page)
    {
        return view('admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $page)
    {
        $this->validate($request,
            [
                'title_cn' => 'required|max:191|unique:posts,title->cn,' . $page->id,
                'title_en' => 'required|max:191|unique:posts,title->en,' . $page->id,
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
        $page->admin_id = Auth::id();
        $page->thumbnail = $request->thumbnail;
        $page->title = ['cn' => $request->title_cn, 'en' => $request->title_en];
        $page->slug = str_slug($request->title_en);
        $page->sub_title = ['cn' => $request->sub_title_cn, 'en' => $request->sub_title_en];
        $page->details = ['cn' => $request->details_cn, 'en' => $request->details_en];
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $page)
    {
        $page->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('pages.index');
    }
}
