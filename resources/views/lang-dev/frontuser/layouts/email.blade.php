<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Style Css -->
  @yield('style')

  <!-- Script head -->
  @yield('script-head')

  <!-- Title -->
  <title>@yield('title')</title>
</head>


<body>
  <!-- Header -->
  <header>

  </header>

  <!-- Page core -->
  <div id="homepage">
    <div id="homepage-content">
      <div id="homepage-alert">
        @yield('alert')
      </div>

      @yield('content')
    </div>
  </div>

  <!-- Footer -->
  <footer>

  </footer>

  <!-- Script Body -->
  <script type="text/javascript" src="{!! asset_url_js("jquery.min.js") !!}"></script>
  @yield('script-body')
</body>
</html>
