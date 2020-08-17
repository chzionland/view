@extends('layouts.app')

@section('content')
<div class="card-header flex justify-between">
    <h2 class="font-bold text-xl ml-10">{{ __('admin_CRUD.categoy_list') }}</h2>
    <a href="{{ route('categories.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>
<div class="card-body">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th scope="col" width="5">{{ __('#') }}</th>
                <th scope="col" width="80">{{ __('admin_CRUD.category_name') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.created_by') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.updated_at') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.publish_status') }}</th>
                <th scope="col" width="15">{{ __('admin_CRUD.edit_delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->admin->name }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        @if ($category->is_published == 1)
                            {{ __('admin_CRUD.published') }}
                        @else
                            {{ __('admin_CRUD.draft') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', [$category->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>
                        <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                        <a href="{{ route('categories.destroy', [$category->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                            <div style="display: none" id="trans-delete">
                                {{ trans('admin_CRUD.really_want_to_delete') }}
                            </div>
                            <i onclick="event.preventDefault();
                                var message = document.getElementById('trans-delete').textContent;
                                if (confirm(message)) {
                                    document.getElementById('category-delete-{{$category->id}}').submit()
                                }" class="fas fa-times fa-lg"></i>
                            <form style="display: none"
                                id="{{ 'category-delete-' . $category->id }}" method="POST"
                                action="{{ route('categories.destroy', [$category->id, app()->getLocale()]) }}">
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
