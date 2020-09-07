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
            <colgroup>
                <col style="width: 5%">
                <col style="width: 25%">
                <col style="width: 4%">
                <col style="width: 6%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 8%">
                <col style="width: 10%">
                <col style="width: 8%">
                <col style="width: 14%">
              </colgroup>
            <tr>
                <th scope="col">{{ __('#') }}</th>
                <th scope="col">{{ __('admin_CRUD.post_title') }}</th>
                <th scope="col">{{ __('admin_CRUD.is_top') }}</th>
                <th scope="col">{{ __('admin_CRUD.original_or_reproduced') }}</th>
                <th scope="col">{{ __('admin_CRUD.author') }}</th>
                <th scope="col">{{ __('admin_CRUD.created_at') }}</th>
                <th scope="col">{{ __('admin_CRUD.category_belonging') }}</th>
                <th scope="col">{{ __('admin_CRUD.tags') }}</th>
                <th scope="col">{{ __('admin_CRUD.publish_status') }}</th>
                <th scope="col">{{ __('admin_CRUD.edit_delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        <p>{{ $post->getTranslation('title', 'cn') }}</p>
                        <p style="text-transform: capitalize;">{{ $post->getTranslation('title', 'en') }}</p>
                    </td>
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
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>
                        @foreach ($post->tags as $tag)
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
