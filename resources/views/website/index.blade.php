
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

        @foreach ($posts as $post)
          <div class="post-preview">
            <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
                <h3 class="post-title">{{ $post->title }}</h3>
                @if ($post->sub_title)
                <h4 class="post-subtitle"> - {{ $post->sub_title }}</h4>
                @endif
            </a>
            <div class="post-meta">
                <p>
                    @foreach ($post->authors as $author)
                        {{ $author->name }},&nbsp;
                    @endforeach
                    {{ date('Y.m.d', strtotime($post->created_at)) }}
                    @if ($post->category()->first()->category()->first())
                        ,&nbsp;{{ __('website.category') }}:&nbsp;{{$post->category()->first()->category()->first()->name}}
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

