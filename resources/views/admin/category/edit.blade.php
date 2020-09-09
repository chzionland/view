@extends('layouts.app')

@section('stylesheet')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5 w-full lg:w-10/12 xl:w-8/12">
                <div class="card-header">
                    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => ['categories.update', [$category->id, app()->getLocale()]], 'method'=>'put']) !!}

                    {{-- Tumbnail --}}
                    <div class="form-group">
                        {{ trans('admin_CRUD.original_photo_preview') }}
                        <img width="200" src="{{ $category->thumbnail }}" alt="no photo">
                    </div>
                    <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                        {!! Form::label('thumbnail', trans('admin_CRUD.thumbnail')) !!}
                        <span class="text-red-500">&nbsp;&nbsp;</span>
                        <a href="{{ route('photos.index', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.photos') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::text('thumbnail', $category->thumbnail, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.paste_thumbnail_address_here')
                        ]) !!}
                        @if ($errors->has('thumbnail'))
                            <span class="help-block text-red-500">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    {{-- Name --}}
                    <div class="form-group @if($errors->has('name_cn')) has-error @endif">
                        {!! Form::label('name_cn', trans('admin_CRUD.category_name_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_cn', $category->getTranslation('name', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_category_name_in_cn')
                        ]) !!}
                        @if ($errors->has('name_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('name_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('name_en')) has-error @endif">
                        {!! Form::label('name_en', trans('admin_CRUD.category_name_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_en', $category->getTranslation('name', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_category_name_in_en')
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

                    {{-- Is Column --}}
                    <div class="form-group">
                        {!! Form::label('is_column', trans('admin_CRUD.set_column_or_not')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_column', [
                                0 => trans('admin_CRUD.set_as_sub_category'),
                                1 => trans('admin_CRUD.set_as_column')
                            ], isset($category->is_column) ? $category->is_column : null,
                            ['class' => 'form-control']
                        ) !!}
                        <span class="text-blue-500">注：同子类的文章可在文末汇集成相关文章列表</span>
                    </div>

                    {{-- Column --}}
                    <div class="form-group @if($errors->has('category_id')) has-error @endif">
                        {!! Form::label('category_id',
                            trans('admin_CRUD.column_belonging') . " (" . trans('admin_CRUD.must_for_sub_category') . ") "
                        ) !!}
                        <a href="{{ route('categories.create', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.create_category') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        {!! Form::select('category_id', $columns, null, [
                            'class' => 'form-control',
                            'id'=>'category_id',
                        ]) !!}
                        <input type="button" value="{{ trans('admin_CRUD.clean_selection') }}"
                            onclick="$('#category_id').val(null).trigger('change')"
                            class="text-blue-500 px-1 border rounded my-1"
                        >
                        @if ($errors->has('category_id'))
                            <span class="help-block text-red-500">{!! $errors->first('category_id') !!}</span>
                        @endif
                    </div>
                    <div style="display: none" id="trans-select-column">
                        {{ trans('admin_CRUD.select_column') }}
                    </div>
                    <div style="display: none" id="column_belonging_id" >
                        {{ $column_belonging_id }}
                    </div>
                    <br class="">

                    {{-- Publish Status --}}
                    <div class="form-group">
                        {!! Form::label('is_published', trans('admin_CRUD.is_published')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::select('is_published', [
                                0 => trans('admin_CRUD.save_as_draft'),
                                1 => trans('admin_CRUD.publish')
                            ], isset($category->is_published) ? $category->is_published : null,
                            ['class' => 'form-control']
                        ) !!}
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
<script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function () {

        let select_column = document.getElementById('trans-select-column').textContent;
        $('#category_id').select2({
            placeholder: select_column
        }).val(null).trigger('change');

        let column_belonging_id = document.getElementById('column_belonging_id').textContent;
        if ( column_belonging_id != null){
            $('#category_id').val({{ $column_belonging_id }}).trigger('change');
        }

    });
</script>
@endsection
