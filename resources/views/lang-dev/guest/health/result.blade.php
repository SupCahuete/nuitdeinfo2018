
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
  <link rel="stylesheet" href="@css('guest/health/result.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - Santé - Résultat
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
  @foreach($symptoms as $symptom)
    <h5>{{ $symptom->name }} :</h5>
    <ul>
      @foreach($symptom->resources as $resource)
        <li>{{ $resource->name }}</li>
      @endforeach
    </ul>
    <br>
  @endforeach
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
