<?php

namespace App\Http\Controllers;

use App\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller
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
        $title = trans('admin_CRUD.author_list');
        $authors = Author::latest()->get();
        return view('admin.author.index', compact('title', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.create_author');
        return view('admin.author.create', compact('title'));
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
                'name_cn' => 'required|max:191|unique:authors,name->cn',
                'name_en' => 'required|max:191|unique:authors,name->en',
            ],
            [
                'name_cn.required' => trans('admin_CRUD.is_must'),
                'name_en.required' => trans('admin_CRUD.is_must'),
                'name_cn.max' => trans('admin_CRUD.max_limit'),
                'name_en.max' => trans('admin_CRUD.max_limit'),
                'name_cn.unique' => trans('admin_CRUD.already_exist'),
                'name_en.unique' => trans('admin_CRUD.already_exist'),
            ]
        );

        Author::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $request->thumbnail,
            'name' => ['cn'=>$request->name_cn, 'en'=>$request->name_en],
            'slug' => str_slug($request->name_en),
            'intro' => ['cn' => $request->intro_cn, 'en' => $request->intro_en],
            'is_published' => $request->is_published,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('authors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        $title = trans('admin_CRUD.update_author');
        return view('admin.author.edit', compact('title', 'author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $this->validate($request,
            [
                'name_cn' => 'required|max:191|unique:authors,name->cn,' . $author->id,
                'name_en' => 'required|max:191|unique:authors,name->en,' . $author->id,
            ],
            [
                'name_cn.required' => trans('admin_CRUD.is_must'),
                'name_en.required' => trans('admin_CRUD.is_must'),
                'name_cn.max' => trans('admin_CRUD.max_limit'),
                'name_en.max' => trans('admin_CRUD.max_limit'),
                'name_cn.unique' => trans('admin_CRUD.already_exist'),
                'name_en.unique' => trans('admin_CRUD.already_exist'),
            ]
        );

        $author->thumbnail = $request->thumbnail;
        $author->admin_id = Auth::id();
        $author->name = ['cn' => $request->name_cn, 'en' => $request->name_en];
        $author->slug = str_slug($request->name_en);
        $author->intro = ['cn' => $request->intro_cn, 'en' => $request->intro_en];
        $author->is_published = $request->is_published;
        $author->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('authors.index');
    }
}
