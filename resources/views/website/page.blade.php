@extends('website.template.master')

@section('content')

<!-- Page Header -->
<header class="masthead" style="background-image: url({{ $page->thumbnail }})">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h2>{{ __('website.site_name') . " · " . $page->title }}</h2>
            <h3 class="subheading mt-4">{{ $page->subtitle }}</h3>
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
                {!! $page->details !!}
            </div>
        </div>
    </div>
</article>

@endsection


