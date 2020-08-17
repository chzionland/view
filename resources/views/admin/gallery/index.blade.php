@extends('layouts.app')

@section('content')
<div class="card-header flex justify-between">
    <h2 class="font-bold text-xl ml-10">{{ __('admin_CRUD.gallery_list') }}</h2>
    <a href="{{ route('galleries.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>
<div class="card-body">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th scope="col" width="5">{{ __('#') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.preview') }}</th>
                <th scope="col" width="80">{{ __('admin_CRUD.img_url') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.uploaded_by') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.uploaded_at') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($galleries as $gallery)
                <tr>
                    <td>{{ $gallery->id }}</td>
                    <td><img width="200" src="{{ asset('storage/galleries/' . $gallery->image_url) }}" alt="preview"></td>
                    <td>{{ asset('storage/galleries/' . $gallery->image_url) }}</td>
                    <td>{{ $gallery->admin->name }}</td>
                    <td>{{ $gallery->created_at }}</td>
                    <td>
                        {{-- <a href="{{ route('galleries.edit', [$gallery->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>
                        <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span> --}}
                        <a href="{{ route('galleries.destroy', [$gallery->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                            <div style="display: none" id="trans-delete">
                                {{ trans('admin_CRUD.really_want_to_delete') }}
                            </div>
                            <i onclick="event.preventDefault();
                                var message = document.getElementById('trans-delete').textContent;
                                if (confirm(message)) {
                                    document.getElementById('gallery-delete-{{$gallery->id}}').submit()
                                }" class="fas fa-times fa-lg"></i>
                            <form style="display: none"
                                id="{{ 'gallery-delete-' . $gallery->id }}" method="POST"
                                action="{{ route('galleries.destroy', [$gallery->id, app()->getLocale()]) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
