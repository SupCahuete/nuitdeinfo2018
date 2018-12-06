
{{--------------------------------------------------------
                   Extends Layout Blade
--------------------------------------------------------}}
@extends('frontuser.layouts.main')




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
  <link rel="stylesheet" href="@css('frontuser/home/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('controller.home')
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
  <h1 class="center text-or">Dashboard</h1>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src=""></script>
@endsection
