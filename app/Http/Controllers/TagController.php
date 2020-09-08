<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.tag_list');
        $tags = Tag::orderBy('name', 'ASC')->get();
        return view('admin.tag.index', compact('title', 'tags'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.create_tag');
        return view('admin.tag.create', compact('title'));
    }

    public function store(TagRequest $request)
    {
        $validated = $request->validated();

        Tag::create([
            'admin_id' => Auth::id(),
            'name' => ['cn'=>$validated['name_cn'], 'en'=>$validated['name_en']],
            'slug' => $validated['slug'],
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('tags.index');
    }

    public function show(Tag $tag)
    {
        //
    }

    public function edit(Tag $tag)
    {
        $title = trans('admin_CRUD.update_tag');
        return view('admin.tag.edit', compact('title', 'tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $validated = $request->validated();

        $tag->admin_id = Auth::id();
        $tag->name = ['cn' => $validated['name_cn'], 'en' => $validated['name_en']];
        $tag->slug = $validated['slug'];
        $tag->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('tags.index');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('tags.index');
    }
}
