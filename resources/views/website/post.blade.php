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
                    @foreach ($post->authors as $author)
                        {{ $author->name }},&nbsp;
                    @endforeach
                    {{ date('Y.m.d', strtotime($post->created_at)) }}
                    @if ($post->category()->first()->category()->first())
                        ,&nbsp;{{ __('website.category') }}:&nbsp;{{$post->category()->first()->category()->first()->name}}
                    @endif
                </p>
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

        <br class="">
        <hr class="">
        <br class="">

        {{-- related posts --}}
        <div class="row">
            <div class="">
                <h2 class="column-title">{{ trans('website.related_posts') }}</h2>
            </div>

            <ul class="col-lg-8 col-md-10 mx-auto" style="list-style: none">
                @php($category = $post->category()->first())
                @php($posts = $category->posts()->orderBy('title', 'ASC')->where('is_published', '1')->get())
                @foreach ($posts as $post)
                    <li class="">
                        <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}" class="">
                            {{ $post->title }}
                            @if ($post->sub_title)
                                - {{ $post->sub_title }}
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        </article>
    </div>

@endsection


