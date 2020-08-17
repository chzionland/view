<?php

namespace App\Http\Controllers;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
                'name_cn' => 'required|max:191|unique:categories,name->cn',
                'name_en' => 'required|max:191|unique:categories,name->en',
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

        Category::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $request->thumbnail,
            'name' => ['cn'=>$request->name_cn, 'en'=>$request->name_en],
            'slug' => str_slug($request->name_en),
            'is_published' => $request->is_published,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,
            [
                'name_cn' => 'required|max:191|unique:categories,name->cn,' . $category->id,
                'name_en' => 'required|max:191|unique:categories,name->en,' . $category->id,
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

        $category->thumbnail = $request->thumbnail;
        $category->admin_id = Auth::id();
        $category->name = ['cn' => $request->name_cn, 'en' => $request->name_en];
        $category->slug = str_slug($request->name_en);
        $category->is_published = $request->is_published;
        $category->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('categories.index');
    }
}
