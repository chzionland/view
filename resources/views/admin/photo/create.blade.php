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
                    {!! Form::open(['route' => ['photos.store', app()->getLocale()], 'enctype' => 'multipart/form-data']) !!}

                    {{-- Subject --}}
                    <div class="form-group @if($errors->has('subject_id')) has-error @endif">
                        {!! Form::label('subject_id', trans('admin_CRUD.subjects')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>&nbsp;&nbsp;
                        <a href="{{ route('subjects.create', app()->getLocale()) }}" target="_blank" class="text-primary">
                            {{ __('admin_CRUD.create_subject') }}
                            <i class="fas fa-external-link-alt fa-sm"></i>
                        </a>
                        <div style="display: none" id="trans-select-subjects">
                            {{ trans('admin_CRUD.select_subjects') }}
                        </div>

                        {!! Form::select('subject_id[]', $subjects, null, ['class' => 'form-control', 'id'=>'subject_id', 'multiple'=>'multiple']) !!}
                        @if ($errors->has('subject_id'))
                            <span class="help-block text-red-500">{!! $errors->first('subject_id') !!}</span>
                        @endif
                    </div>

                    <div class="form-group @if($errors->has('image_url')) has-error @endif">
                        {!! Form::file('image_url[]', ['multiple' => 'multiple']) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        @if ($errors->has('image_url'))
                            <span class="help-block text-red-500">{!! $errors->first('image_url') !!}</span>
                        @endif
                    </div>

                    <div>{{ __('admin_CRUD.support_multi_photo') }}</div>
                    <div>{{ __('admin_CRUD.support_png_jpg_jpeg') }}</div>
                    <br>

                    {!! Form::submit(trans('admin_CRUD.upload'), ['class' => 'btn btn-sm btn-primary']) !!}
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
        var message = document.getElementById('trans-select-subjects').textContent;
        $('#subject_id').select2({
            placeholder: message
        });
    });
</script>
@endsection
