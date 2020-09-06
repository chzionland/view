<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Category;
use App\Http\Requests\PhotoRequest;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PhotoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = trans('admin_CRUD.photo_list');
        $photos = Photo::latest()->get();
        return view('admin.photo.index', compact('title', 'photos'));
    }

    public function create()
    {
        $title = trans('admin_CRUD.photo_upload');
        $tags = Tag::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.photo.create', compact('title', 'tags'));
    }

    public function store(PhotoRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated['image_url'] as $image_url) {

            $current_timestamp = Carbon::now()->timestamp;
            $fileNameWithExt = $image_url->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $image_url->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . $current_timestamp . '.' . $fileExt;

            $photo = new Photo();
            $photo->admin_id = Auth::id();
            $photo->image_url = $fileNameToStore;
            $photo->intro = ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']];
            $photo->is_published = $request->is_published;
            $save = $photo->save();

            $photo->tags()->sync($request->tag_id, true);

            if ($save) {
                $image_url->storeAs('public/photos', $fileNameToStore);
            }
        }
        Session::flash('message', trans('admin_CRUD.image_uploaded_successfully'));
        return redirect()->route('photos.index');
    }

    public function show(Photo $photo)
    {

    }

    public function edit(Photo $photo)
    {
        $title = trans('admin_CRUD.update_photo_info');
        $tags = Tag::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.photo.edit', compact('title', 'photo', 'tags'));
    }

    public function update(PhotoRequest $request, Photo $photo)
    {
        $validated = $request->validated();

        $photo->admin_id = Auth::id();
        $photo->intro = ['cn' => $validated['intro_cn'], 'en' => $validated['intro_en']];
        $photo->is_published = $request->is_published;
        $photo->save();
        $photo->tags()->sync($request->tag_id, true);

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('photos.index');
    }

    public function destroy(Photo $photo)
    {
        Storage::delete('public/photos/' . $photo->image_url);
        $photo->delete();

        Session::flash('danger-message', trans('admin_CRUD.images_deleted_successfully'));
        return redirect()->route('photos.index');
    }
}
