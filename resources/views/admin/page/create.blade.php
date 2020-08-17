@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full lg:w-10/12 xl:w-8/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ __('admin_CRUD.create_page') }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['pages.store', app()->getLocale()]]) !!}

                    {{-- Tumbnail --}}
                    <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                        {!! Form::label('thumbnail', trans('admin_CRUD.thumbnail')) !!}
                        &nbsp;&nbsp;
                        <a href="#" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.gallery') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::text('thumbnail', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.paste_thumbnail_address_here')]) !!}
                        @if ($errors->has('thumbnail'))
                            <span class="help-block text-red-500">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="form-group @if($errors->has('title_cn')) has-error @endif">
                        {!! Form::label('title_cn', trans('admin_CRUD.title_cn')) !!}
                        <span class="text-red-500">*&nbsp;</span>
                        {!! Form::text('title_cn', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_title_in_cn')]) !!}
                        @if ($errors->has('title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('title_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('title_en')) has-error @endif">
                        {!! Form::label('title_en', trans('admin_CRUD.title_en')) !!}
                        <span class="text-red-500">*&nbsp;</span>
                        {!! Form::text('title_en', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_title_in_en')]) !!}
                        @if ($errors->has('title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('title_en') !!}</span>
                        @endif
                    </div>

                    {{-- Sub Title --}}
                    <div class="form-group @if($errors->has('sub_title_cn')) has-error @endif">
                        {!! Form::label('sub_title_cn', trans('admin_CRUD.sub_title_cn')) !!}
                        {!! Form::text('sub_title_cn', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_sub_title_in_cn')]) !!}
                        @if ($errors->has('sub_title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_cn') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" class="form-group @if($errors->has('sub_title_en')) has-error @endif">
                        {!! Form::label('sub_title_en', trans('admin_CRUD.sub_title_en')) !!}
                        {!! Form::text('sub_title_en', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_sub_title_in_en')]) !!}
                        @if ($errors->has('sub_title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_en') !!}</span>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="form-group @if($errors->has('details_cn')) has-error @endif">
                        {!! Form::label('details_cn', trans('admin_CRUD.details_cn')) !!}
                        {!! Form::textarea('details_cn', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_details_in_cn')]) !!}
                        @if ($errors->has('details_cn'))
                            <span class="help-block">{!! $errors->first('details_cn') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" class="form-group @if($errors->has('details_en')) has-error @endif">
                        {!! Form::label('details_en', trans('admin_CRUD.details_en')) !!}
                        {!! Form::textarea('details_en', null, ['class' => 'form-control', 'placeholder' => trans('admin_CRUD.input_details_in_en')]) !!}
                        @if ($errors->has('details_en'))
                            <span class="help-block">{!! $errors->first('details_en') !!}</span>
                        @endif
                    </div>

                    {{-- Publish Status --}}
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">*&nbsp;</span>
                        {!! Form::select('is_published', [0 => trans('admin_CRUD.save_as_draft'), 1 => trans('admin_CRUD.publish')], null, ['class' => 'form-control']) !!}
                    </div>

                    {!! Form::submit(trans('admin_CRUD.create'), ['class' => 'btn btn-primary']) !!}
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
