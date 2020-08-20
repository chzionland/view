<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
        $photos = Photo::orderBy('id', 'DESC')->get();
        return view('admin.photo.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.photo.create');
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
                "image_url" => "required",
            ],
            [
                "image_url.required" => 'admin_CRUD.select_image',
            ]
        );
        foreach ($request->image_url as $image_url) {

            $fileNameWithExt = $image_url->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $image_url->getClientOriginalExtension();
            $fileNameToStore = $fileName . '.' . $fileExt;

            $photo = new Photo();
            $photo->admin_id = Auth::id();
            $photo->image_url = $fileNameToStore;
            $save = $photo->save();

            if ($save) {
                $image_url->storeAs('public/photos', $fileNameToStore);
            }
        }
        Session::flash('message', trans('admin_CRUD.image_uploaded_successfully'));
        return redirect()->route('photos.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        Storage::delete('public/galleries' . $photo->image_url);
        $photo->delete();

        Session::flash('danger-message', trans('admin_CRUD.images_deleted_successfully'));
        return redirect()->route('galleries.index');
    }
}
