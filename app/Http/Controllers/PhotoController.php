<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PhotoController extends Controller
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
        $title = trans('admin_CRUD.photo_list');
        $photos = Photo::orderBy('id', 'DESC')->get();
        return view('admin.photo.index', compact('title', 'photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.photo_upload');
        $subjects = Subject::orderBy('id', 'DESC')->pluck('name', 'id');
        return view('admin.photo.create', compact('title', 'subjects'));
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
                "subject_id" => "required",
                "image_url" => "required",
            ],
            [
                "subject_id.required" => trans("admin_CRUD.is_must"),
                "image_url.required" => trans("admin_CRUD.select_image"),
            ]
        );
        foreach ($request->image_url as $image_url) {

            $current_timestamp = Carbon::now()->timestamp;
            $fileNameWithExt = $image_url->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $image_url->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . $current_timestamp . '.' . $fileExt;

            $photo = new Photo();
            $photo->admin_id = Auth::id();
            $photo->image_url = $fileNameToStore;
            $save = $photo->save();
            $photo->subjects()->sync($request->subject_id, false);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        Storage::delete('public/photos/' . $photo->image_url);
        $photo->delete();

        Session::flash('danger-message', trans('admin_CRUD.images_deleted_successfully'));
        return redirect()->route('photos.index');
    }
}
