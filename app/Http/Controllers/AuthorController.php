<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Requests\AuthorRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.author_list');
        $authors = Author::latest()->get();
        return view('admin.author.index', compact('title', 'authors'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.create_author');
        return view('admin.author.create', compact('title'));
    }

    public function store(AuthorRequest $request)
    {
        $validated = $request->validated();

        Author::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'name' => ['cn'=>$validated['name_cn'], 'en'=>$validated['name_en']],
            'slug' => $validated['slug'],
            'intro' => ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']],
            'is_published' => $request->is_published,
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('authors.index');
    }

    public function show(Author $author)
    {
        //
    }

    public function edit(Author $author)
    {
        $title = trans('admin_CRUD.update_author');
        return view('admin.author.edit', compact('title', 'author'));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $validated = $request->validated();

        $author->admin_id = Auth::id();
        $author->thumbnail = $validated['thumbnail'];
        $author->name = ['cn'=>$validated['name_cn'], 'en'=>$validated['name_en']];
        $author->slug = $validated['slug'];
        $author->intro = ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']];
        $author->is_published = $request->is_published;
        $author->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('authors.index');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('authors.index');
    }
}
