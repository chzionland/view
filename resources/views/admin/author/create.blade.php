@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full lg:w-10/12 xl:w-8/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['authors.store', app()->getLocale()]]) !!}

                    {{-- Thumbnail --}}
                    <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                        {!! Form::label('thumbnail', trans('admin_CRUD.thumbnail')) !!}
                        <span class="text-red-500">&nbsp;&nbsp;</span>
                        <a href="{{ route('photos.index', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.photos') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::text('thumbnail', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.paste_thumbnail_address_here')
                        ]) !!}
                        @if ($errors->has('thumbnail'))
                            <span class="help-block text-red-500">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    {{-- Name --}}
                    <div class="form-group @if($errors->has('name_cn')) has-error @endif">
                        {!! Form::label('name_cn', trans('admin_CRUD.author_name_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_cn', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_author_name_in_cn')
                        ]) !!}
                        @if ($errors->has('name_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('name_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('name_en')) has-error @endif">
                        {!! Form::label('name_en', trans('admin_CRUD.author_name_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_en', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_author_name_in_en')
                        ]) !!}
                        @if ($errors->has('name_en'))
                            <span class="help-block text-red-500">{!! $errors->first('name_en') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('slug')) has-error @endif">
                        @if ($errors->has('slug'))
                            <span class="help-block text-red-500">{!! $errors->first('slug') !!}</span>
                        @endif
                    </div>

                    {{-- Intro --}}
                    <div class="form-group @if($errors->has('intro_cn')) has-error @endif">
                        {!! Form::label('intro_cn', trans('admin_CRUD.intro_cn')) !!}
                        {!! Form::textarea('intro_cn', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_cn')
                        ]) !!}
                        @if ($errors->has('intro_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('intro_en')) has-error @endif">
                        {!! Form::label('intro_en', trans('admin_CRUD.intro_en')) !!}
                        {!! Form::textarea('intro_en', 'Introduction in English', [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_en')
                        ]) !!}
                        @if ($errors->has('intro_en'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_en') !!}</span>
                        @endif
                    </div>

                    {{-- Publish Status --}}
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_published', [
                            0 => trans('admin_CRUD.save_as_draft'),
                            1 => trans('admin_CRUD.publish')
                        ], null, ['class' => 'form-control']) !!}
                    </div>

                    {!! Form::submit(trans('admin_CRUD.create'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
