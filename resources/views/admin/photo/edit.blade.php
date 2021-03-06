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
                    <h2>{{ $title }}</h2>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => ['photos.update', [$photo->id, app()->getLocale()]], 'method'=>'put']) !!}

                    {{-- Tumbnail --}}
                    <div class="form-group">
                        {{ trans('admin_CRUD.photo_preview') }}
                        <img width="200" src="{{ asset('storage/photos/' . $photo->image_url) }}" alt="no photo">
                    </div>

                    {{-- Intro --}}
                    <div class="form-group @if($errors->has('intro_cn')) has-error @endif">
                        {!! Form::label('intro_cn', trans('admin_CRUD.intro_cn')) !!}
                        {!! Form::textarea('intro_cn', $photo->getTranslation('intro', 'cn'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_cn'),
                        ]) !!}
                        @if ($errors->has('intro_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('intro_en')) has-error @endif">
                        {!! Form::label('intro_en', trans('admin_CRUD.intro_en')) !!}
                        {!! Form::textarea('intro_en', $photo->getTranslation('intro', 'en'), [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_intro_in_en'),
                        ]) !!}
                        @if ($errors->has('intro_en'))
                            <span class="help-block text-red-500">{!! $errors->first('intro_en') !!}</span>
                        @endif
                    </div>

                    {{-- tag --}}
                    <div class="form-group @if($errors->has('tag_id')) has-error @endif">
                        {!! Form::label('tag_id', trans('admin_CRUD.tags')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
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

                    {!! Form::submit(trans('admin_CRUD.update'), ['class' => 'btn btn-sm btn-warning']) !!}
                    {!! Form::close() !!}
                </br>
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
        var message = document.getElementById('trans-select-tags').textContent;
        $('#tag_id').select2({
            placeholder: message
        }).val({!! json_encode($photo->tags()->allRelatedIds()) !!}).trigger('change');
    });
</script>
@endsection
