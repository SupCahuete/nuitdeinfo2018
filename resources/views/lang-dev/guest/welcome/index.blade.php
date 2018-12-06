{{--------------------------------------------------------
                   Extends Layout Blade
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                           Head
--------------------------------------------------------}}
@section('meta')
  <meta name="description" content="">
@endsection

@section('favicon')
@endsection

@section('facebook')
@endsection

@section('twitter')
@endsection

@section('linkedin')
@endsection

@section('google')
@endsection

@section('style')
  <link rel="stylesheet" href="@css('guest/welcome/index.css')">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Raleway', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 95px;
    }

    .title .title-mini {
      display: block;
      font-size: 20px;
    }

    .title .title-little {
      display: block;
      font-size: 50px;
    }

    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 70px;
    }
  </style>
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name')
@endsection




{{--------------------------------------------------------
                      Alert messages
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    Content page core
--------------------------------------------------------}}
@section("content")
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="title m-b-md">
        Laravel ADA
        <br>
        <span class="title-mini">By</span>
        <span class="title-little">HexaGo'On</span>
      </div>

      <div class="links">
        {{--<a href="">Documentation</a>--}}
        <a href="https://github.com/hexago-on/ada">GitHub</a>
        <a href="https://www.facebook.com/hexagoonCM/">Facebook</a>
        <a href="https://twitter.com/hexago_on">Twitter</a>
      </div>
    </div>
  </div>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src=""></script>
@endsection
