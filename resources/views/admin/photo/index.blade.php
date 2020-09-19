@extends('layouts.app')

@section('content')



    <div class="card-header flex justify-between">
        <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
        <a href="{{ route('photos.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
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
                    <th scope="col" width="80">{{ __('admin_CRUD.tags') }}</th>
                    <th scope="col" width="10">{{ __('admin_CRUD.uploaded_by') }}</th>
                    <th scope="col" width="10">{{ __('admin_CRUD.uploaded_at') }}</th>
                    <th scope="col" width="10">{{ __('admin_CRUD.publish_status') }}</th>
                    <th scope="col" width="10">{{ __('admin_CRUD.edit_delete') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($photos as $photo)
                    <tr>
                        <td>{{ $photo->id }}</td>
                        <td><img width="200" src="{{ asset('storage/photos/' . $photo->image_url) }}" alt="preview"></td>
                        <td>{{ asset('storage/photos/' . $photo->image_url) }}</td>
                        <td>
                            @foreach ($photo->tags as $tag)
                                {{ $tag->name }};&nbsp;
                            @endforeach
                        </td>
                        <td>{{ $photo->admin->name }}</td>
                        <td>{{ $photo->created_at }}</td>
                        <td>
                            @if ($photo->is_published == 1)
                                {{ __('admin_CRUD.published') }}
                            @else
                                {{ __('admin_CRUD.draft') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('photos.edit', [$photo->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                            <a href="{{ route('photos.destroy', [$photo->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                                <div style="display: none" id="trans-delete">
                                    {{ trans('admin_CRUD.really_want_to_delete') }}
                                </div>
                                <i onclick="event.preventDefault();
                                    var message = document.getElementById('trans-delete').textContent;
                                    if (confirm(message)) {
                                        document.getElementById('photo-delete-{{$photo->id}}').submit()
                                    }" class="fas fa-times fa-lg"></i>
                                <form style="display: none"
                                    id="{{ 'photo-delete-' . $photo->id }}" method="POST"
                                    action="{{ route('photos.destroy', [$photo->id, app()->getLocale()]) }}">
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
