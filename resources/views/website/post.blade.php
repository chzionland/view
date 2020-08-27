@extends('website.template.master')

@section('content')

<!-- Page Header -->
<header class="masthead" style="background-image: url({{ $post->thumbnail }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">
            <h1>{{ $post->title }}</h1>
            <h2 class="subheading">{{ $post->subtitle }}</h2>

            <div class="post-meta" style="opacity: 0.8">
                <p>
                    {{-- {{ $post->admin->name}},&nbsp; --}}
                    {{ __('website.created_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->created_at)) }}
                    @if (date('Y.m.d', strtotime($post->created_at)) != date('Y.m.d', strtotime($post->updated_at)))
                        ,&nbsp;{{ __('website.updated_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->updated_at)) }}
                    @endif
                </p>
                @if (count($post->categories) > 0)
                    <p class="post-category">
                        {{ __('website.category') }}:&nbsp;
                        @foreach ($post->categories as $category)
                            <a class="text-white" href="{{ route('category', [$category->slug, app()->getLocale()]) }}">{{ $category->name }};</a>
                        @endforeach
                    </p>
                @endif
            </div>

          </div>
        </div>
      </div>
    </div>
  </header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! $post->details !!}
            </div>
        </div>
    </div>
</article>

@endsection


