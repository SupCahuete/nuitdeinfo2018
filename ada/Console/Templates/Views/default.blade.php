
{{--------------------------------------------------------
                   Extends Layout Blade
--------------------------------------------------------}}
@extends('TAG_EXTENDS')




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
  <link rel="stylesheet" href="@css('TAG_CSS_PATH')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('TAG_GUARD_NAME_LCFIRST.TAG_VIEW_NAME_LCFIRST')
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
  <h1 class="center text-or">TAG_VIEW_NAME_UCFIRST</h1>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
