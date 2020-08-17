@extends('website.template.master')

@section('content')
<!-- Page Header -->
  <header class="masthead" style="background-image: url({{ asset('website/img/banners/bg1.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>{{ __('website.title') }}</h1>
            <span class="subheading mt-4" style="line-height: 1.5">{{ __('website.sub_title') }}</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

        @foreach ($posts as $post)
          <div class="post-preview">
            <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
              <h2 class="post-title">{{ $post->title }}</h2>
              <h3 class="post-subtitle">{{ $post->sub_title }}</h3>
            </a>
            <div class="post-meta">
                <p>
                    {{ __('website.created_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->created_at)) }}
                    @if (date('Y.m.d', strtotime($post->created_at)) != date('Y.m.d', strtotime($post->updated_at)))
                        ,&nbsp;{{ __('website.updated_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->updated_at)) }}
                    @endif
                </p>
                @if (count($post->categories) > 0)
                    <p class="post-category">
                        {{ __('website.category') }}:&nbsp;
                        @foreach ($post->categories as $category)
                            <a class="text-decoration-none" href="{{ route('category', [$category->slug, app()->getLocale()]) }}">{{ $category->name }};</a>
                        @endforeach
                    </p>
                @endif
                <p class="content-preview">
                    {{ substr($post->details, 100) }}...
                </p>
            </div>
          </div>
          <hr>
        @endforeach


        <!-- Pager -->
        <br>
          <div class="clearfix mt-4">
            {{ $posts->links() }}
          </div>
        <br>

      </div>
    </div>
  </div>
@endsection
