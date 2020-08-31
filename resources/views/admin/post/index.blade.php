@extends('layouts.app')

@section('content')
<div class="card-header flex justify-between">
    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
    <a href="{{ route('posts.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>
<div class="card-body">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th scope="col" width="10">{{ __('#') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.post_title') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.is_top') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.original_or_reproduced') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.author') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.updated_at') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.categories') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.publish_status') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.edit_delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if ($post->is_top == 1)
                            {{ __('admin_CRUD.top') }}
                        @else
                            {{ __('admin_CRUD.no') }}
                        @endif
                    </td>
                    <td>
                        @if ($post->is_reproduced == 1)
                            {{ __('admin_CRUD.reproduced') }}
                        @else
                            {{ __('admin_CRUD.original') }}
                        @endif
                    </td>
                    <td>
                        @foreach ($post->authors as $author)
                            {{ $author->name }};&nbsp;
                        @endforeach
                    </td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        @foreach ($post->categories as $category)
                            {{ $category->name }};&nbsp;
                        @endforeach
                    </td>
                    <td>
                        @if ($post->is_published == 1)
                            {{ __('admin_CRUD.published') }}
                        @else
                            {{ __('admin_CRUD.draft') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('posts.edit', [$post->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>
                        <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                        <a href="{{ route('posts.destroy', [$post->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                            <div style="display: none" id="trans-delete">
                                {{ trans('admin_CRUD.really_want_to_delete') }}
                            </div>
                            <i onclick="event.preventDefault();
                                var message = document.getElementById('trans-delete').textContent;
                                if (confirm(message)) {
                                    document.getElementById('post-delete-{{$post->id}}').submit()
                                }" class="fas fa-times fa-lg"></i>
                            <form style="display: none"
                                id="{{ 'post-delete-' . $post->id }}" method="POST"
                                action="{{ route('posts.destroy', [$post->id, app()->getLocale()]) }}">
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
