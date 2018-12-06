<!DOCTYPE html>
<html lang="{!! app()->getLocale() !!}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Meta -->
  <meta name="author" content="@config('app.author')">
  <meta name="identifier-url" content="@config('app.url')">
  <meta name="copyright" content="@config('app.copyright')">
  <meta name="keywords" content="">
  @yield('meta')

  <!-- Favicon -->
  <link rel="apple-touch-icon" type="image/png" href="/favicon.png">
  <link rel="shortcut icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
  <meta name="apple-mobile-web-app-title" content="@config('app.name')">
  <meta name="application-name" content="@config('app.name')">
  <meta name="theme-color" content="#ffffff">
  @yield('favicon')

  <!-- Facebook -->
  <meta property="og:image" content="">
  @yield('facebook')

  <!-- Twitter -->
  <meta name="twitter:image" content="">
  @yield('twitter')

  <!-- Linkedin -->
  @yield('linkedin')

  <!-- Google -->
  <meta name="google-site-verification" content="" />
  @yield('google')

  <!-- Cookies Consent -->
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
  <script>
    window.addEventListener("load", function(){
      window.cookieconsent.initialise({
        "palette": {
          "popup": {
            "background": "#F55F5A",
            "text": "#FFFFFF"
          },
          "button": {
            "background": "#61C7E4",
            "text": "#FFFFFF"
          }
        },
        "theme": "edgeless",
        "content": {
          "message": "@trans('cookies-consent.message')",
          "dismiss": "@trans('cookies-consent.dismiss')",
          "href": "http://cookies.insites.com/"
        }
      })});
  </script>

  <!-- Style Css -->
  <link rel="stylesheet" type="text/css" href="@css('materialize.min.css')" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  @yield('style')

  <!-- Script head -->
  @yield('script-head')

  <!-- Title -->
  <title>@yield('title')</title>
</head>


<body>
  <!-- Main navigation bar -->
  @auth('TAG_GUARD_NAME')
    @include('TAG_GUARD_NAME.layouts.menu')
  @endauth

  <!-- Page core -->
  <div id="mainContainer">
    <div id="mainAlert">
      @if ($errors = $errors->all())
        <div class="alert-errors">

          @foreach($errors as $error)
            <p class="alert-error">{{ $error }}</p>
          @endforeach

        </div>
      @endif

      @if ($error = Session::get('error'))
        <div class="alert-errors">
          <p class="alert-error">{{ $error }}</p>
        </div>
      @endif

      @if($success = Session::get('success'))
        <div class="alert-success">

          @foreach($success as $s)
            <p class="info-success">{{ $s }}</p>
          @endforeach

        </div>
      @endif

      @yield('alert')
    </div>

    @yield('content')
  </div>

  <!-- Footer -->
  <footer >
  </footer>

  <!-- Script Body -->
  <script type="text/javascript" src="@js('jquery.js')"></script>
  <script type="text/javascript" src="@js('materialize.min.js')"></script>
  <script type="text/javascript" src="@js('main.js')"></script>
  @yield('script-body')
</body>
</html>
