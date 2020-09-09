
@extends('website.template.master')

@section('content')
{{-- Page Header --}}
  <header class="masthead" style="background-image: url({{ asset('website/img/banners/bg1.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            {{-- <h1></h1> --}}
            <span class="subheading mt-4" style="line-height: 1.5">{{ __('website.title') }}</span>
            <span class="subheading mt-4" style="line-height: 1.5 text-align: left">{{ __('website.sub_title') }}</span>

        </div>
        </div>
      </div>
    </div>
  </header>

{{-- Main Content --}}
  <div class="container">

    {{-- News
    @if (count($newses) > 0)
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <h2 class="post-title">{{ trans("admin_CRUD.newses") }}</h2>
            @foreach ($newses as $news)
            <li class="m-2">
                <a href="{{ route('news', [$news->slug, app()->getLocale()]) }}">
                    {{ $news->title }}
                    <span class="text-muted">
                        - {{ date('Y.m.d', strtotime($news->created_at)) }}
                    </span>
                </a>
            </li>
            @endforeach

          <!-- Pager -->
          <br>
            <div class="clearfix mt-4">
              {{ $posts->links() }}
            </div>
          <br>

        </div>
    </div>
    <hr>
    @endif --}}

    {{-- Posts --}}
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        {{-- <h2 class="post-title">{{ trans("admin_CRUD.latest_posts") }}</h2> --}}
        @foreach ($posts as $post)
          <div class="post-preview">
            <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
              <h3 class="post-title text-center">{{ $post->title }}</h3>
              <h4 class="post-subtitle text-center">{{ $post->sub_title }}</h4>
            </a>
            <div class="post-meta">
                <p class="text-center">
                    {{ __('website.created_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->created_at)) }}
                    @if (date('Y.m.d', strtotime($post->created_at)) != date('Y.m.d', strtotime($post->updated_at)))
                        ,&nbsp;{{ __('website.updated_on') }}&nbsp;{{ date('Y.m.d', strtotime($post->updated_at)) }}
                    @endif
                    @if ($post->category()->first())
                        ,&nbsp;{{ __('website.category') }}:&nbsp;{{$post->category()->first()->name}}
                    @endif
                </p>

                <p class="content-preview">
                    {{ $post->intro }}
                </p>
            </div>
          </div>
          <hr>
        @endforeach


        {{-- Pager --}}
        <br>
          <div class="clearfix mt-4">
            {{ $posts->links() }}
          </div>
        <br>

      </div>
    </div>
  </div>
@endsection

