@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 flex justify-center">

            <div class="card my-5">
                <div class="card-header">
                    <h2>{{ __('admin_CRUD.photo_upload') }}</h2>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => ['photos.store', app()->getLocale()], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group @if($errors->has('image_url')) has-error @endif">

                        {{-- {!! Form::label('Image Url', null, ['style' => 'display: block;']) !!} --}}
                        {!! Form::file('image_url[]', ['multiple' => 'multiple']) !!}
                        @if ($errors->has('image_url'))
                            <span class="help-block">{!! $errors->first('image_url') !!}</span>
                        @endif
                    </div>
                    {!! Form::submit(trans('admin_CRUD.upload'), ['class' => 'btn btn-sm btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection