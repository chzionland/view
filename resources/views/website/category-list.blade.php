@extends('website.template.master')

@section('content')
<!-- Page Header -->
  <header class="masthead" style="background-image: url({{ asset('website/img/banners/bg3.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>{{ __('website.site_name') }} · {{ __('website.category_list') }}</h2>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

        @foreach ($categories as $category)
            @if (count($category->posts) > 0)
            <div class="post-preview">
                <a href="{{ route('category', [$category->slug, app()->getLocale()]) }}">
                    <h3 class="post-name text-center mb-4">{{ $category->name }}</h3>
                </a>
                <div class="post-meta">

                    <ul class="text-center p-0" style="list-style: none">
                        @foreach ($category->posts()->orderBy('id', 'DESC')->where('post_type', 'post')->where('is_published', '1')->limit(3)->get() as $post)
                        <li class="m-2">
                            <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
                                {{ $post->title }}
                                <span class="text-muted">
                                    - {{ date('Y.m.d', strtotime($post->created_at)) }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                        <li class="m-2"><a href="{{ route('category', [$category->slug, app()->getLocale()]) }}">
                            {{ __('website.read_more') }}
                        </a></li>
                    </ul>

                </div>
            </div>
            <hr>
            @endif
        @endforeach

        @if (count($uncategorized_posts) > 0)
        <div class="post-preview">
            <h3 class="post-name text-center mb-4">{{ __('website.uncategorized_posts') }}</h3>

            <div class="post-meta">
                <ul class="text-center p-0" style="list-style: none">
                @foreach ($uncategorized_posts as $post)
                    <li class="m-2">
                        <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
                            {{ $post->title }}
                            <span class="text-muted">
                                - {{ date('Y.m.d', strtotime($post->created_at)) }}
                            </span>
                        </a>
                    </li>
                @endforeach
                </ul>

            </div>
        </div>
        @endif

      </div>
    </div>
  </div>
@endsection
