@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full md:w-10/12 lg:w-8/12 xl:w-6/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['subjects.update', [$subject->id, app()->getLocale()]], 'method'=>'put']) !!}
                    <div class="form-group @if($errors->has('name_cn')) has-error @endif">
                        {!! Form::label('name_cn', trans('admin_CRUD.subject_name_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {{ App::setLocale('cn') }}
                        {!! Form::text('name_cn', $subject->name, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_subject_name_in_cn')]) !!}
                        @if ($errors->has('name_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('name_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('name_en')) has-error @endif">
                        {!! Form::label('name_en', trans('admin_CRUD.subject_name_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {{ App::setLocale('en') }}
                        {!! Form::text('name_en', $subject->name, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_subject_name_in_en')]) !!}
                        @if ($errors->has('name_en'))
                            <span class="help-block text-red-500">{!! $errors->first('name_en') !!}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_published', [0 => trans('admin_CRUD.save_as_draft'), 1 => trans('admin_CRUD.publish')], isset($subject->is_published) ? $subject->is_published : null, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::submit(trans('admin_CRUD.update'), ['class' => 'btn btn-warning']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
