
{{--------------------------------------------------------
                   Devniez la musique
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                           Ca fait
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
                      TA TA TA
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    TA
--------------------------------------------------------}}
@section("content")
  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        @foreach($resources->groupBy('resources_type_id') as $resourcesGrouped)
          <li class="tab col s3"><a href="#{{ $resourcesGrouped->first()->type->id }}">{{ $resourcesGrouped->first()->type->name }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  @foreach($resources->groupBy('resources_type_id') as $resourcesGrouped)

    Type : {{ $resourcesGrouped->first()->type->name }}
    @foreach($resourcesGrouped as $resource)
      <div id="{{ $resourcesGrouped->first()->type->id }}" class="col s12">
        <a href="@route('guest.resources.add', $resource->id)">AJAX! Ajouter +</a>
        <a href="@route('guest.resources.remove', $resource->id)">AJAX! Moins -</a>
      </div>

   @endforeach
 @endforeach
@endsection




{{--------------------------------------------------------
                          TA TAAAAAAA
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript">
    $(document).ready(function(){
      $('.tabs').tabs();
    });
  </script>
@endsection
