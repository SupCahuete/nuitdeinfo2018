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
  <h1 class="red center">TEST</h1>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src=""></script>
@endsection
