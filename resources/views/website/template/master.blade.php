<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <title>{{ $title }}</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('website/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="{{ asset('website/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100;300&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ asset('website/css/clean-blog.css') }}" rel="stylesheet">

    <style>
    /* Nav bar fixed top */
    .fixed-top {
        position: fixed !important;
        width: 100%;
        top: 0;
        left: 0;
    }

    /* Nav bar hamberg to close */
    .navbar-close-icon {
        font-size: 18px;
        color: gray;
        font-weight: lighter;
    }
    .navbar-toggler-icon {
        width: 30px;
        height: 30px;
        border: 1px;
        border-color: gray;
    }
    .navbar-toggler.collapsed .navbar-close-icon {
        display: none;
    }
    .navbar-toggler:not(.collapsed) .navbar-toggler-icon {
        display: inline;
    }

    /* Pagination */
    .pagenation ul {
        margin: 0 auto;
    }
    .page-link {
        color: #0085a1;
        text-align: center;
    }
    .page-item.active .page-link {
        background-color: #0085a1;
        border-color: #0085a1;
    }
    </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <div>
            <span>
                <img src="{{ asset('website/logo/avatar.png') }}" alt="logo" style="height: 35px">
              </span>
              <a class="navbar-brand" href="#" style="padding-left: 0;">
                  {{ __('app.app_name') }}
              </a>
        </div>

      <button class="navbar-toggler navbar-toggler-right collapsed border-0" type="button"
        data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"
        style="padding: 0;">
        <div class="navbar-close-icon px-1">X</div>
        <div class="navbar-toggler-icon"></div>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto" style="align-items: center;">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index', app()->getLocale()) }}">
                {{ __('website.home') }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('category_list', app()->getLocale()) }}">
                {{ __('website.category_list') }}
            </a>
          </li>
          @php ($columns = getColumns())
          @foreach ($columns as $column)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('column', [$column->slug, app()->getLocale()]) }}">
                    {{ $column->name }}
                </a>
            </li>
          @endforeach
          @php ($pages = getPages())
          @foreach ($pages as $page)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('page', [$page->slug, app()->getLocale()]) }}">
                    {{ $page->title }}
                </a>
            </li>
          @endforeach
          <li class="nav-item">
            <a class="nav-link" href="https://www.qizhong.land#contact" target="_blank">
                {{ __('website.contact_us') }}&nbsp;<i class="fas fa-external-link-alt fa-xs"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- Footer -->
  <hr>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

          <p class="copyright text-muted">
              {{ __('website.copyright') }} &copy; {{ __('website.owner') }}&nbsp;{{ date("Y") }}
              <br>
              <a class="text-decoration-none" href="https://www.qizhong.land" target="_blank" style="color: #0085a1">
                {{ __('website.owner_site') }}&nbsp;<i class="fas fa-external-link-alt fa-xs"></i>
              </a>
          </p>

        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('website/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('website/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Custom scripts for this template -->
  <script src="{{ asset('website/js/clean-blog.min.js') }}"></script>

</body>

</html>
