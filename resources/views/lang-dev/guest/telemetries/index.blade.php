
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
    <div class="col s12">
      <table>
        <tr>
          <th class="green grey-text text-darken-4">Appareils</th>
          <th class="green grey-text text-darken-4">Type</th>
          <th class="green grey-text text-darken-4">Mode</th>
          <th class="green grey-text text-darken-4">Signal</th>
        </tr>
        @foreach($machines as $machine)
          <tr>
            <td class="green-text">
              <i class="material-icons">check</i> {{ $machine->name }}
            </td>
            <td class="green-text">
              {{ $machine->type }}
            </td>
            <td class="green-text">
              {{ $machine->state }}
            </td>
            <td class="green-text">
              <i class="material-icons">signal_wifi_4_bar</i>
            </td>
          </tr>
        @endforeach
      </table>
      </div>

      <div class="advanced-settings">
        <h5 class="green-text center">Télémétrie avancée</h5>
        <p class="green-text center"><i class="material-icons center medium">keyboard_arrow_down</i></p>
      </div>

    </div>
  </div>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
