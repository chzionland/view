@extends('layouts.app')

@section('content')
<div class="card-header flex justify-between">
    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
    <a href="{{ route('authors.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>
<div class="card-body">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th scope="col" width="5">{{ __('#') }}</th>
                <th scope="col" width="80">{{ __('admin_CRUD.author_name') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.created_by') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.updated_at') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.publish_status') }}</th>
                <th scope="col" width="15">{{ __('admin_CRUD.edit_delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>
                        <p>{{ $author->getTranslation('name', 'cn') }}</p>
                        <p>{{ $author->getTranslation('name', 'en') }}</p>
                    </td>
                    <td>{{ $author->admin->name }}</td>
                    <td>{{ $author->updated_at }}</td>
                    <td>
                        @if ($author->is_published == 1)
                            {{ __('admin_CRUD.published') }}
                        @else
                            {{ __('admin_CRUD.draft') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('authors.edit', [$author->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>
                        <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                        <a href="{{ route('authors.destroy', [$author->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                            <div style="display: none" id="trans-delete">
                                {{ trans('admin_CRUD.really_want_to_delete') }}
                            </div>
                            <i onclick="event.preventDefault();
                                var message = document.getElementById('trans-delete').textContent;
                                if (confirm(message)) {
                                    document.getElementById('author-delete-{{$author->id}}').submit()
                                }" class="fas fa-times fa-lg"></i>
                            <form style="display: none"
                                id="{{ 'author-delete-' . $author->id }}" method="POST"
                                action="{{ route('authors.destroy', [$author->id, app()->getLocale()]) }}">
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
