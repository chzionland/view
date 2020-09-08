@extends('layouts.app')

@section('content')
<div class="card-header flex justify-between">
    <h2 class="font-bold text-xl ml-10">{{ $title }}</h2>
    <a href="{{ route('tags.create', app()->getLocale()) }}" class="btn btn-md btn-primary mr-10">
        <i class="fas fa-plus fa-lg"></i>
    </a>
</div>
<div class="card-body">
    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th scope="col" width="5">{{ __('#') }}</th>
                <th scope="col" width="80">{{ __('admin_CRUD.tag_name') }}</th>
                <th scope="col" width="30">{{ __('admin_CRUD.created_by') }}</th>
                <th scope="col" width="60">{{ __('admin_CRUD.updated_at') }}</th>
                <th scope="col" width="15">{{ __('admin_CRUD.edit_delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>
                        <p>{{ $tag->getTranslation('name', 'cn') }}</p>
                        <p>{{ $tag->getTranslation('name', 'en') }}</p>
                    </td>
                    <td>{{ $tag->admin->name }}</td>
                    <td>{{ $tag->updated_at }}</td>
                    <td>
                        {{-- Edit Button --}}
                        <a href="{{ route('tags.edit', [$tag->id, app()->getLocale()]) }}" class="btn btn-sm btn-warning px-2">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>

                        <span class="text-gray-500">&nbsp;&nbsp;|&nbsp;&nbsp;</span>

                        {{-- Delete Button --}}
                        <a href="{{ route('tags.destroy', [$tag->id, app()->getLocale()]) }}" class="btn btn-sm btn-danger px-2">
                            {{-- Translation of delete confirmation --}}
                            <div style="display: none" id="trans-delete">
                                {{ trans('admin_CRUD.really_want_to_delete') }}
                            </div>
                            {{-- Click and Confirm --}}
                            <i onclick="event.preventDefault();
                                let confirm_delete_message = document.getElementById('trans-delete').textContent;
                                if (confirm(confirm_delete_message)) {
                                    document.getElementById('tag-delete-{{$tag->id}}').submit()
                                }" class="fas fa-times fa-lg">
                            </i>
                            {{-- Delete Form --}}
                            <form style="display: none"
                                id="{{ 'tag-delete-' . $tag->id }}" method="POST"
                                action="{{ route('tags.destroy', [$tag->id, app()->getLocale()]) }}">
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
