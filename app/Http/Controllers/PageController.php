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
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.page_list');
        $pages = Post::latest()->where('post_type', 'page')->get();
        return view('admin.page.index', compact('title', 'pages'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.create_page');
        return view('admin.page.create', compact('title'));
    }

    public function store(PageRequest $request)
    {
        $validated = $request->validated();

        if (!$request->created_at) {
            $request->created_at = Carbon::now();
        }

        Post::create([
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'title' => ['cn' => $validated['title_cn'], 'en' => $validated['title_en']],
            'slug' => $validated['slug'],
            'sub_title' => ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']],
            'is_top' => $request->is_top,
            'details' => ['cn' => $validated['details_cn'], 'en' => $validated['details_en']],
            'is_published' => $request->is_published,
            'post_type' => 'page',
            'created_at' => $request->created_at,
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('pages.index');
    }

    public function show(Post $page){

    }

    public function edit(Post $page)
    {
        $title = trans('admin_CRUD.update_news');
        return view('admin.page.edit', compact('title', 'page'));
    }

    public function update(PageRequest $request, Post $page)
    {
        $validated = $request->validated();

        if (!$request->created_at) {
            $request->created_at = Carbon::now();
        }

        $page->admin_id = Auth::id();
        $page->thumbnail = $validated['thumbnail'];
        $page->title = ['cn' => $validated['title_cn'], 'en' => $validated['title_en']];
        $page->slug = $validated['slug'];
        $page->sub_title = ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']];
        $page->is_top = $request->is_top;
        $page->details = ['cn' => $validated['details_cn'], 'en' => $validated['details_en']];
        $page->is_published = $request->is_published;
        $page->post_type = 'page';
        $page->created_at = $request->created_at;
        $page->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('pages.index');
    }

    public function destroy(Post $page)
    {
        $page->delete();
        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('pages.index');
    }
}
