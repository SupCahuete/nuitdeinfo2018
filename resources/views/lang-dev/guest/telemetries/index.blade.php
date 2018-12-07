
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
  <link rel="stylesheet" href="@css('guest/telemetries/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('guest.telemetries')
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
  <div class="row">
    <div class="col s6">
      <P class="green-text">Niveaux</P>
      <canvas id="chart" width="200" height="100" style="display: block; max-width: 400px; max-height: 150px;"></canvas>
    </div>

    <div class="col s6">
      <p class="green-text">Etat des equipements</p>
      <div class="separator"></div>
      <p class="green-text">RAS</p>
      
    </div>
  </div>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
