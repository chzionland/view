@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full xl:w-10/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['pages.update', [$page->id, app()->getLocale()]], 'method'=>'put']) !!}

                    {{-- Tumbnail --}}
                    <div class="form-group">
                        {{ trans('admin_CRUD.original_photo_preview') }}
                        <img width="200" src="{{ $page->thumbnail }}" alt="no photo">
                    </div>
                    <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                        {!! Form::label('thumbnail', trans('admin_CRUD.thumbnail')) !!}
                        &nbsp;&nbsp;
                        <a href="#" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.photo') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::text('thumbnail', $page->thumbnail, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.paste_thumbnail_address_here')]) !!}
                        @if ($errors->has('thumbnail'))
                            <span class="help-block text-red-500">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="form-group @if($errors->has('title_cn')) has-error @endif">
                        {!! Form::label('title_cn', trans('admin_CRUD.title_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {{ App::setLocale('cn') }}
                        {!! Form::text('title_cn', $page->title, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_title_in_cn')]) !!}
                        @if ($errors->has('title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('title_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('title_en')) has-error @endif">
                        {!! Form::label('title_en', trans('admin_CRUD.title_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {{ App::setLocale('en') }}
                        {!! Form::text('title_en', $page->title, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_title_in_en')]) !!}
                        @if ($errors->has('title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('title_en') !!}</span>
                        @endif
                    </div>

                    {{-- Sub Title --}}
                    <div class="form-group @if($errors->has('sub_title_cn')) has-error @endif">
                        {!! Form::label('sub_title_cn', trans('admin_CRUD.sub_title_cn')) !!}
                        {{ App::setLocale('cn') }}
                        {!! Form::text('sub_title_cn', $page->sub_title, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_sub_title_in_cn')]) !!}
                        @if ($errors->has('sub_title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_cn') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" class="form-group @if($errors->has('sub_title_en')) has-error @endif">
                        {!! Form::label('sub_title_en', trans('admin_CRUD.sub_title_en')) !!}
                        {{ App::setLocale('en') }}
                        {!! Form::text('sub_title_en', $page->sub_title, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_sub_title_in_en')]) !!}
                        @if ($errors->has('sub_title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_en') !!}</span>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="form-group @if($errors->has('details_cn')) has-error @endif">
                        {!! Form::label('details_cn', trans('admin_CRUD.details_cn')) !!}
                        {{ App::setLocale('cn') }}
                        {!! Form::textarea('details_cn', $page->details, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_details_in_cn')]) !!}
                        @if ($errors->has('details_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('details_cn') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" class="form-group @if($errors->has('details_en')) has-error @endif">
                        {!! Form::label('details_en', trans('admin_CRUD.details_en')) !!}
                        {{ App::setLocale('en') }}
                        {!! Form::textarea('details_en', $page->details, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_details_in_en')]) !!}
                        @if ($errors->has('details_en'))
                            <span class="help-block text-red-500">{!! $errors->first('details_en') !!}</span>
                        @endif
                    </div>

                    {{-- Publish Status --}}
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_published', [0 => trans('admin_CRUD.save_as_draft'), 1 => trans('admin_CRUD.publish')], isset($page->is_published) ? $page->is_published : null, ['class' => 'form-control']) !!}
                    </div>

                    {!! Form::submit(trans('admin_CRUD.update'), ['class' => 'btn btn-warning']) !!}
                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js""></script>

<script type="text/javascript">

    $(document).ready(function () {

        CKEDITOR.replace('details_cn');
        CKEDITOR.replace('details_en');

    });
</script>
@endsection
