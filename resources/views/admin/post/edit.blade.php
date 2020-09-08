@extends('layouts.app')

@section('stylesheet')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full xl:w-10/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['posts.update', [$post->id, app()->getLocale()]], 'method'=>'put']) !!}

                    {{-- Tumbnail --}}
                    <div class="form-group">
                        {{ trans('admin_CRUD.original_photo_preview') }}
                        <img width="200" src="{{ $post->thumbnail }}" alt="no photo">
                    </div>
                    <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                        {!! Form::label('thumbnail', trans('admin_CRUD.thumbnail')) !!}
                        <span class="text-red-500">&nbsp;&nbsp;</span>
                        <a href="{{ route('photos.index', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.photos') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::text('thumbnail', $post->thumbnail, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.paste_thumbnail_address_here')
                        ]) !!}
                        @if ($errors->has('thumbnail'))
                            <span class="help-block text-red-500">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <div class="form-group @if($errors->has('title_cn')) has-error @endif">
                        {!! Form::label('title_cn', trans('admin_CRUD.title_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('title_cn', $post->getTranslation('title', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_title_in_cn')
                        ]) !!}
                        @if ($errors->has('title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('title_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('title_en')) has-error @endif">
                        {!! Form::label('title_en', trans('admin_CRUD.title_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('title_en', $post->getTranslation('title', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_title_in_en')
                        ]) !!}
                        @if ($errors->has('title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('title_en') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('slug')) has-error @endif">
                        @if ($errors->has('slug'))
                            <span class="help-block text-red-500">{!! $errors->first('slug') !!}</span>
                        @endif
                    </div>

                    {{-- Sub Title --}}
                    <div class="form-group @if($errors->has('sub_title_cn')) has-error @endif">
                        {!! Form::label('sub_title_cn', trans('admin_CRUD.sub_title_cn')) !!}
                        {!! Form::text('sub_title_cn', $post->getTranslation('sub_title', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_sub_title_in_cn'),
                        ]) !!}
                        @if ($errors->has('sub_title_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('sub_title_en')) has-error @endif"
                        style="display:none"
                        >
                        {!! Form::label('sub_title_en', trans('admin_CRUD.sub_title_en')) !!}
                        {!! Form::text('sub_title_en', $post->getTranslation('sub_title', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_sub_title_in_en'),
                        ]) !!}
                        @if ($errors->has('sub_title_en'))
                            <span class="help-block text-red-500">{!! $errors->first('sub_title_en') !!}</span>
                        @endif
                    </div>

                    {{-- Is Top --}}
                    <div class="form-group">
                        {!! Form::label('is_top', trans('admin_CRUD.is_top')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_top', [
                                0 => trans('admin_CRUD.no'),
                                1 => trans('admin_CRUD.top')
                            ], isset($post->is_top) ? $post->is_top : null,
                            ['class' => 'form-control']
                        ) !!}
                    </div>

                    {{-- Reproduced --}}
                    <div class="form-group">
                        {!! Form::label('is_reproduced', trans('admin_CRUD.original_or_reproduced')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_reproduced', [0 => trans('admin_CRUD.original'), 1 => trans('admin_CRUD.reproduced')], isset($post->is_reproduced) ? $post->is_reproduced : null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group @if($errors->has('source')) has-error @endif">
                        {!! Form::label('source', trans('admin_CRUD.source')) !!}
                        {!! Form::text('source', $post->source, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_source')
                        ]) !!}
                        @if ($errors->has('source'))
                            <span class="help-block text-red-500">{!! $errors->first('source') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('source_url')) has-error @endif">
                        {!! Form::label('source_url', trans('admin_CRUD.source_url')) !!}
                        {!! Form::text('source_url', $post->source_url, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_source_url')
                        ]) !!}
                        @if ($errors->has('source_url'))
                            <span class="help-block text-red-500">{!! $errors->first('source_url') !!}</span>
                        @endif
                    </div>

                    {{-- Author --}}
                    <div class="form-group @if($errors->has('author_id')) has-error @endif">
                        {!! Form::label('author_id', trans('admin_CRUD.authors')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        <a href="{{ route('authors.create', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.create_author') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        <div style="display: none" id="trans-select-authors">
                            {{ trans('admin_CRUD.select_authors') }}
                        </div>
                        {!! Form::select('author_id[]', $authors, null, [
                            'class' => 'form-control',
                            'id'=>'author_id',
                            'multiple'=>'multiple'
                        ]) !!}
                        @if ($errors->has('author_id'))
                            <span class="help-block text-red-500">{!! $errors->first('author_id') !!}</span>
                        @endif
                    </div>

                    {{-- Editor --}}
                    <div class="form-group @if($errors->has('editor')) has-error @endif">
                        {!! Form::label('editor', trans('admin_CRUD.editor')) !!}
                        {!! Form::text('editor', $post->editor, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_editor'),
                        ]) !!}
                        @if ($errors->has('editor'))
                            <span class="help-block text-red-500">{!! $errors->first('editor') !!}</span>
                        @endif
                    </div>

                    {{-- Intro --}}
                    <div class="form-group @if($errors->has('intro_cn')) has-error @endif">
                        {!! Form::label('intro_cn', trans('admin_CRUD.intro_cn')) !!}
                        {!! Form::textarea('intro_cn', $post->getTranslation('intro', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_cn'),
                        ]) !!}
                        @if ($errors->has('intro_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('intro_en')) has-error @endif"
                        style="display:none"
                        >
                        {!! Form::label('intro_en', trans('admin_CRUD.intro_en')) !!}
                        {!! Form::textarea('intro_en', $post->getTranslation('intro', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_en'),
                        ]) !!}
                        @if ($errors->has('intro_en'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_en') !!}</span>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="form-group @if($errors->has('details_cn')) has-error @endif">
                        {!! Form::label('details_cn', trans('admin_CRUD.details_cn')) !!}
                        {!! Form::textarea('details_cn', $post->getTranslation('details', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_details_in_cn')
                        ]) !!}
                        @if ($errors->has('details_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('details_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('details_en')) has-error @endif"
                        style="display:none"
                        >
                        {!! Form::label('details_en', trans('admin_CRUD.details_en')) !!}
                        {!! Form::textarea('details_en', $post->getTranslation('details', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_details_in_en'),
                        ]) !!}
                        @if ($errors->has('details_en'))
                            <span class="help-block text-red-500">{!! $errors->first('details_en') !!}</span>
                        @endif
                    </div>

                    {{-- Category --}}
                    <div class="form-group @if($errors->has('category_id')) has-error @endif">
                        {!! Form::label('category_id', trans('admin_CRUD.categories')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        <a href="{{ route('categories.create', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.create_category') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::select('category_id', $categories, null, [
                            'class' => 'form-control',
                            'id'=>'category_id',
                        ]) !!}
                        @if ($errors->has('category_id'))
                            <span class="help-block">{!! $errors->first('category_id') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" id="trans-select-category">
                        {{ trans('admin_CRUD.select_categories') }}
                    </div>
                    <div style="display: none" id="category_belonging_id">
                        {{ $category_belonging_id }}
                    </div>

                    {{-- Tag --}}
                    <div class="form-group @if($errors->has('tag_id')) has-error @endif">
                        {!! Form::label('tag_id', trans('admin_CRUD.tags')) !!}
                        <span class="text-red-500">&nbsp;&nbsp;</span>
                        <a href="{{ route('tags.create', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.create_tag') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        <div style="display: none" id="trans-select-tags">
                            {{ trans('admin_CRUD.select_tags') }}
                        </div>
                        {!! Form::select('tag_id[]', $tags, null, [
                            'class' => 'form-control',
                            'id'=>'tag_id',
                            'multiple'=>'multiple'
                        ]) !!}
                        @if ($errors->has('tag_id'))
                            <span class="help-block text-red-500">{!! $errors->first('tag_id') !!}</span>
                        @endif
                    </div>

                    {{-- Publish Status --}}
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_published', [
                                0 => trans('admin_CRUD.save_as_draft'),
                                1 => trans('admin_CRUD.publish')
                            ], isset($post->is_published) ? $post->is_published : null,
                            ['class' => 'form-control']
                        ) !!}
                    </div>

                    {{-- Created Date --}}
                    <div class="form-group">
                        {!! Form::label('created_at', trans('admin_CRUD.created_at')) !!}
                        {!! Form::date('created_at', $post->created_at, [
                            'class' => 'form-control', 'min'=>'1970-01-01',
                            'placeholder' => trans('admin_CRUD.default_is_today')
                        ]) !!}
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
<script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function () {

        CKEDITOR.replace('details_cn');
        CKEDITOR.replace('details_en');

        let select_authors = document.getElementById('trans-select-authors').textContent;
        $('#author_id').select2({
            placeholder: select_authors
        }).val({!! json_encode($post->authors()->allRelatedIds()) !!}).trigger('change');

        let select_category = document.getElementById('trans-select-category').textContent;
        $('#category_id').select2({
            placeholder: select_category
        }).val(null).trigger('change');

        let category_belonging_id = document.getElementById('category_belonging_id').textContent;
        if ( category_belonging_id != null){
            $('#category_id').val({{ $category_belonging_id }}).trigger('change');
        }

        let select_tags = document.getElementById('trans-select-tags').textContent;
        $('#tag_id').select2({
            placeholder: select_tags
        }).val({!! json_encode($post->tags()->allRelatedIds()) !!}).trigger('change');
    });
</script>
@endsection
