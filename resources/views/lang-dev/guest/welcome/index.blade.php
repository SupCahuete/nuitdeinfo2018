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
                      ? + ? = 10
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    ! + ? = 7
--------------------------------------------------------}}
@section("content")
  <div>
    <h2 class="green-text center"></h2>
  </div>
@endsection




{{--------------------------------------------------------
                      Combien vaut !    
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src=""></script>
@endsection
