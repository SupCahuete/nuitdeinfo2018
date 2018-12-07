
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
  <link rel="stylesheet" href="@css('guest/chat/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
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
  <form action="@route('guest.chat.go')" method="POST">
    {{ csrf_field() }}

    <div class="row">
      <div class="input-field col s12 m12 l12">
        <input id="text-chat" name="text" type="text" size="50">
        <label for="text-chat">#Chat !</label>
      </div>
    </div>

    <div class="row">
      <button type="submit" class="waves-effect waves-light btn col s8 offset-s2">#Chattez</button>
    </div>
  </form>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript"></script>
@endsection
