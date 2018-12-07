
{{--------------------------------------------------------
                   6DV6DzdçBZDIBYZDUH
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                          6V56TB98YZ78D9B8
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
  @config('app.name') - Santé
@endsection




{{--------------------------------------------------------
                      C5ESV567BT8T
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    BSDY9028BD8YD
--------------------------------------------------------}}
@section("content")
  <div class="row">
    <div class="col s6">
      <p class="green-text">Relevés</p>
      <canvas id="chart" width="200" height="100" style="display: block; max-width: 400px; max-height: 150px;"></canvas>
    </div>

    <div class="col s6">
      <p class="green-text">Outil d'auto-médication</p>
      <form action="@route('guest.health.heal')" method="POST">
        {{ csrf_field() }}

        <div class="row">
          <div class="input-field col s12">
            <select multiple name="symptoms[]">
              <option value="" disabled selected>Vos symptômes</option>
              @foreach($symptoms as $symptom)
                <option value="{!! $symptom->id !!}" >{{ $symptom->name }}</option>
              @endforeach
            </select>
            <label>Indiquez vos symptômes</label>
          </div>
        </div>

        <div class="row">
          <button type="submit" class="green-text waves-effect waves-green btn-flat col s8 offset-s2">Rechercher</button>
        </div>
      </form>
    </div>

    <div class="col s6">
      <p class="green-text">Recommandations médicales</p>
      <div class="separator"></div>
      <p class="green-text">Dr. Beckman, il y a 1h: "Toutes vos données de santé semblent, normales. Pensez à bien vous hydrater."</p>
    </div>

    <div class="col s6">
      <p class="green-text">Dernier traitement:</p>
      <div class="separator"></div>
      <p class="green-text">Anti-douleurs (maux de tête) il a 2 jours</p>
    </div>
  </div>
@endsection




{{--------------------------------------------------------
                         Je vais vous faire gagner tu temps, ça ne veut rien dire
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src="@js('chart.min.js')"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('select').formSelect();
    });
    

    var ctx = document.getElementById("chart").getContext("2d");
  var data = data = {
    datasets: [{
      data: [{
            x: 0,
            y: 85
            }, {
            x: 5,
            y: 90
            }, {
            x: 15,
            y: 88
            }, {
            x: 20,
            y: 92
        }],
      borderColor: "#4CAF50",
      label: 'Rythme Cardiaque'
    }]
  };
  var barChart = new Chart(ctx, {
    type: 'line',
    data: data
  });
  </script>
@endsection
