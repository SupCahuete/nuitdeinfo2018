
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
  <link rel="stylesheet" href="@css('guest/health/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('guest.health')
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
  <form action="@route('guest.health.heal')" method="GET">
    <div class="row">
      <div class="input-field col s12 m12 l12">
        <select multiple>
          <option value="" disabled selected>Vos symptômes</option>
          @foreach($symptoms as $symptom)
            <option value="{!! $symptom->id !!}" >{{ $symptom->name }}</option>
          @endforeach
        </select>
        <label>Indiquez vos symptômes</label>
      </div>
    </div>

    <div class="row">
      <button type="submit" class="waves-effect waves-light btn col s8 offset-s2">Demander des médicaments</button>
    </div>
  </form>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript">
    $(document).ready(function() {
      $('select').formSelect();
    });
  </script>
@endsection
