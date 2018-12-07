
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
  <link rel="stylesheet" href="@css('guest/resources/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('guest.resources')
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
 @foreach($resources->groupBy('resources_type_id') as $resourcesGrouped)
   @foreach($resourcesGrouped as $resource)

     <a href="@route('guest.resources.add', $resource->id)">AJAX! Ajouter +</a>
     <br>
     <a href="@route('guest.resources.remove', $resource->id)">AJAX! Moins -</a>
     <br>
     @foreach($resource->toArray() as $key => $value)
       {{ $key }} => {{ $value ?? 'NULL' }}
       <br>
     @endforeach
     <br>

   @endforeach
 @endforeach
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
