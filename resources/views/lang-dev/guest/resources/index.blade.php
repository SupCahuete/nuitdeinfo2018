
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
      <ul class="tabs transparent">
          <li class="col s1"></li>
        @foreach($resources->groupBy('resources_type_id') as $resourcesGrouped)
          <li class="tab col s2"><a href="#{{ $resourcesGrouped->first()->type->id }}" class="green-text">{{ $resourcesGrouped->first()->type->name }}</a></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="ressourcesContainer">
    @foreach($resources->groupBy('resources_type_id') as $resourcesGrouped)
      <div id="{{ $resourcesGrouped->first()->type->id }}" class="col s12">
        <table>
          <tr>
            <th class="green grey-text text-darken-4">Ressources</th>
            <th class="green grey-text text-darken-4">Quantité</th>
            <th class="green grey-text text-darken-4">Ajouter</th>
            <th class="green grey-text text-darken-4">Retirer</th>
          </tr>
          @foreach($resourcesGrouped as $resource)
            <tr>
              <td class="green-text">
                <i class="material-icons">check</i> {{ $resource->name }} 
              </td>
              <td class="green-text">
                <span class="quantity">{{ $resource->quantity }}</span> {{ $resource->resource_unit }}
              </td>
              <td>
                <a class="add-item btn-flat waves-effect waves-green" data-path="@route('guest.resources.add', $resource->id)"><i class="material-icons green-text">add</i></a>
              </td>
              <td>
                <a class="remove-item btn-flat waves-effect waves-green" data-path="@route('guest.resources.remove', $resource->id)"><i class="material-icons green-text">remove</i></a>
              </td>
              </p>
            </tr>
          @endforeach
        </table>
      </div>
    @endforeach
  </div>
@endsection




{{--------------------------------------------------------
                          TA TAAAAAAA
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript">
    $(document).ready(function(){
      $('.tabs').tabs();

      addItemEvent();
      removeItemEvent();
    });

    function addItemEvent() {
      $('.add-item').click(function() {
        var element = $(this);
        $.get(element.attr('data-path'))
        .done(function(data) {
          element.closest('tr').find('.quantity').text(data.quantity);
        });
      });
    }

    function removeItemEvent() {
      $('.remove-item').click(function() {
        var element = $(this);
        $.get(element.attr('data-path'))
        .done(function(data) {
          element.closest('tr').find('.quantity').text(data.quantity);
        });
      });
    }

  </script>
@endsection
