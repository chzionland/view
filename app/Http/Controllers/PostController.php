<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.post_list');
        $posts = Post::latest()->where('post_type', 'post')->get();
        return view('admin.post.index', compact('title', 'posts'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.create_post');
        $authors = Author::orderBy('name', 'ASC')->pluck('name', 'id');
        $categories = Category::orderBy('name', 'ASC')->where('is_column', '0')->pluck('name', 'id');
        $tags = Tag::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.post.create', compact('title', 'authors', 'categories', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'admin_id' => Auth::id(),
            'thumbnail' => $validated['thumbnail'],
            'title' => ['cn' => $validated['title_cn'], 'en' => $validated['title_en']],
            'slug' => $validated['slug'],
            'sub_title' => ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']],
            'is_top' => $request->is_top,
            'limit' => '0',
            'is_reproduced' => $request->is_reproduced,
            'source' => $validated['source'],
            'source_url' => $validated['source_url'],
            'editor' => $validated['editor'],
            'intro' => ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']],
            'details' => ['cn' => $validated['details_cn'], 'en' => $validated['details_en']],
            'is_published' => $request->is_published,
            'post_type' => 'post',
            'created_at' => $request->created_at,
        ];

        if ($request->category_id){
            $category = Category::find($validated['category_id']);
            $post = $category->posts()->create($data);
        } else {
            $post = Post::create($data);
        }

        $post->authors()->sync($request->author_id, true);
        $post->tags()->sync($request->tag_id, true);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        $title = trans('admin_CRUD.update_post');
        $authors = Author::orderBy('name', 'ASC')->pluck('name', 'id');
        $categories = Category::orderBy('name', 'ASC')->where('is_column', '0')->pluck('name', 'id');
        $tags = Tag::orderBy('name', 'ASC')->pluck('name', 'id');
        $category_belonging_id = null;
        if ($post->category()->first()) {
            $category_belonging_id = $post->category()->first()->id;
        }
        return view('admin.post.edit', compact('title', 'authors', 'categories', 'tags', 'post', 'category_belonging_id'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->admin_id = Auth::id();
        $post->thumbnail = $validated['thumbnail'];
        $post->title = ['cn' => $validated['title_cn'], 'en' => $validated['title_en']];
        $post->slug = $validated['slug'];
        $post->sub_title = ['cn' => $validated['sub_title_cn'], 'en' => $validated['sub_title_en']];
        $post->is_top = $request->is_top;
        $post->limit = '0';
        $post->is_reproduced = $request->is_reproduced;
        $post->source = $validated['source'];
        $post->source_url = $validated['source_url'];
        $post->editor = $validated['editor'];
        $post->intro = ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']];
        $post->details = ['cn' => $validated['details_cn'], 'en' => $validated['details_en']];
        $post->is_published = $request->is_published;
        $post->post_type = 'post';
        $post->created_at = $request->created_at;

        if ($request->category_id) {
            $category = Category::find($validated['category_id']);
            $post->category()->associate($category);
        } else {
            try {
                $post->category()->dissociate();
            }
            catch (Exception $e) {
                return;
            }
        }

        $post->save();

        $post->authors()->sync($request->author_id, true);
        $post->tags()->sync($request->tag_id, true);

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('posts.index');
    }
}
