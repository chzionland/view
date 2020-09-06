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

                    {!! Form::open(['route' => ['tags.store', app()->getLocale()]]) !!}

                    {{-- Name --}}
                    <div class="form-group @if($errors->has('name_cn')) has-error @endif">
                        {!! Form::label('name_cn', trans('admin_CRUD.tag_name_cn')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_cn', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_tag_name_in_cn')
                        ]) !!}
                        @if ($errors->has('name_cn'))
                            <span class="help-block text-red-500">{!! $errors->first('name_cn') !!}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('name_en')) has-error @endif">
                        {!! Form::label('name_en', trans('admin_CRUD.tag_name_en')) !!}
                        <span class="text-red-500">&nbsp;*&nbsp;</span>
                        {!! Form::text('name_en', null, [
                            'class' => 'form-control',
                            'placeholder' => trans('admin_CRUD.input_tag_name_in_en')
                        ]) !!}
                        @if ($errors->has('name_en'))
                            <span class="help-block text-red-500">{!! $errors->first('name_en') !!}</span>
                        @endif
                    </div>

                    {!! Form::submit(trans('admin_CRUD.create'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
