<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.category_list');
        $columns = Category::orderBy('name', 'ASC')->where('is_column', '1')->get();
        return view('admin.category.index', compact('title', 'columns'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.create_category');
        $columns = Category::latest()->where('is_column', '1')->pluck('name', 'id');
        return view('admin.category.create', compact('title', 'columns'));
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'name' => ['cn'=>$validated['name_cn'], 'en'=>$validated['name_en']],
            'slug' => $validated['slug'],
            'is_column' => $request->is_column,
            'is_published' => $request->is_published,
        ];

        if ($request->category_id){
            $column = Category::find($validated['category_id']);
            $column->categories()->create($data);
        } else {
            Category::create($data);
        }

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category)
    {
        $title = trans('admin_CRUD.update_category');
        $columns = Category::latest()->where('is_column', '1')->pluck('name', 'id');
        $column_belonging_id = null;
        if ($category->category()->first()) {
            $column_belonging_id = $category->category()->first()->id;
        }

        return view('admin.category.edit', compact('title', 'category', 'columns', 'column_belonging_id'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->admin_id = Auth::id();
        $category->thumbnail = $validated['thumbnail'];
        $category->name = ['cn'=>$validated['name_cn'], 'en'=>$validated['name_en']];
        $category->slug = $validated['slug'];
        $category->is_column = $request->is_column;
        $category->is_published = $request->is_published;

        if ($request->category_id) {
            $column = Category::find($validated['category_id']);
            $category->category()->associate($column);
        } else {
            try {
                $category->category()->dissociate();
            }
            catch (Exception $e) {
                return;
            }
        }

        $category->save();
        $category->refresh();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('categories.index');
    }
}
