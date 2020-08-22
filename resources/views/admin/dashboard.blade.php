@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-light">
                    {{ __('admin_dashboard.admin_dashboard') }}
                </div>
                <div class="card-body">
                    {{ __('admin_dashboard.you_are_logged_in') }}
                </div>
            </div>
            <br>

            <div class="card">
                <div class="card-header bg-primary text-light">
                    {{ __('admin_CRUD.latest_posts') }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="20">{{ __('#') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.post_title') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.created_by') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.updated_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->admin->name }}</td>
                                    <td>{{ $post->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-primary text-light">
                    {{ __('admin_CRUD.latest_pages') }}
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="20">{{ __('#') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.page_title') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.created_by') }}</th>
                                <th scope="col" width="60">{{ __('admin_CRUD.updated_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->admin->name }}</td>
                                    <td>{{ $page->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>

        </div>
    </div>
</div>
@endsection
