@extends('website.template.master')

@section('content')
<!-- Page Header -->
  <header class="masthead" style="background-image: url({{ $column->thumbnail }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>{{ $column->name }}</h2>
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
            <div class="">
                <h2 class="column-title">{{ $category->name }}</h2>
            </div>

            @php ($posts = $category->posts()->orderBy('is_top', 'DESC')->latest()->where('is_published', '1')->paginate(3))
            @foreach ($posts as $post)
                <div class="post-preview">
                    <a href="{{ route('post', [$post->slug, app()->getLocale()]) }}">
                        <h3 class="post-title">{{ $post->title }}</h3>
                        <h4 class="post-subtitle">{{ $post->sub_title }}</h4>
                    </a>
                    <div class="post-meta">
                        <p>
                            @foreach ($post->authors as $author)
                                {{ $author->name }},&nbsp;
                            @endforeach
                            {{ date('Y.m.d', strtotime($post->created_at)) }}
                        </p>

                        <p class="content-preview">
                            {{ $post->intro }}
                        </p>
                    </div>
                </div>
                <hr>
            @endforeach

            <!-- Pager -->
            <br>
            <div class="clearfix mt-4" style="text-align: center; ali">
                {{ $posts->links() }}
            </div>
            <br>
        @endforeach

      </div>
    </div>
  </div>
@endsection
