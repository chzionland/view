<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
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
        $title = trans('admin_CRUD.subject_list');
        $subjects = Subject::orderBy('id', 'DESC')->get();
        return view('admin.subject.index', compact('title', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('admin_CRUD.create_subject');
        return view('admin.subject.create', compact('title'));
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
                'name_cn' => 'required|max:191|unique:subjects,name->cn',
                'name_en' => 'required|max:191|unique:subjects,name->en',
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

        Subject::create([
            'admin_id' => Auth::id(),
            'name' => ['cn'=>$request->name_cn, 'en'=>$request->name_en],
            'slug' => str_slug($request->name_en),
            'is_published' => $request->is_published,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Session::flash('message', trans('admin_CRUD.created_successfully'));
        return redirect()->route('subjects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $title = trans('admin_CRUD.update_subject');
        return view('admin.subject.edit', compact('title', 'subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $this->validate($request,
            [
                'name_cn' => 'required|max:191|unique:subjects,name->cn,' . $subject->id,
                'name_en' => 'required|max:191|unique:subjects,name->en,' . $subject->id,
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

        $subject->admin_id = Auth::id();
        $subject->name = ['cn' => $request->name_cn, 'en' => $request->name_en];
        $subject->slug = str_slug($request->name_en);
        $subject->is_published = $request->is_published;
        $subject->save();

        Session::flash('warning-message', trans('admin_CRUD.updated_successfully'));
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        Session::flash('danger-message', trans('admin_CRUD.deleted_successfully'));
        return redirect()->route('subjects.index');
    }
}
