
{{--------------------------------------------------------
                   −·−· · −·−· ··  · ··· −  ··− −·  −·−· −−− −− −− · −· − ·− ·· ·−· · 
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                           ···· · ·− −·· 
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
                      ···− −−− ··− ···  ···− −−− ··− ···  ·− −− ··− ··· · −−··  ···− ·−· ·− ·· −− · −· − 
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    ·−  − ·−· ·− −·· ··− ·· ·−· ·  − −−− ··− −  −·−· ·  −−·− ··− ·−−−−· −−− −·  · −·−· ·−· ·· − 
--------------------------------------------------------}}
@section("content")
  <div class="ressourcesContainer">
    <table>
      <tr>
        <th class="green grey-text text-darken-4">Symptôme</th>
        <th class="green grey-text text-darken-4">Traitement suggéré</th>
      </tr>
      @foreach($symptoms as $symptom)
        <tr>
          <td class="green-text">
            <i class="material-icons">check</i> {{ $symptom->name }}
          </td>
          <td class="green-text">
            @foreach($symptom->resources as $resource)
              {{ $resource->name }}
            @endforeach
          </td>
        </tr>
      @endforeach
    </table>
  </div>
@endsection




{{--------------------------------------------------------
                          ··· ·−−· −−− ·· ·−·· · ·−· −−−···  −·· ·− ·−· −·−  ···− ·− −·· −−− ·−·  · ··· −  ·−·· ·  ·−−· · ·−· ·  −·· ·  ·−·· ··− −·− · 
--------------------------------------------------------}}
@section('script-body')
  {{--<script type="text/javascript" src="@js()"></script>--}}
@endsection
