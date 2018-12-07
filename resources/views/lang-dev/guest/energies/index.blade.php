
{{--------------------------------------------------------
                   La on fait un truc
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                           Là aussi
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
  <link rel="stylesheet" href="@css('guest/energies/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('guest.energies')
@endsection




{{--------------------------------------------------------
                      Là c'est le machin là
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    Et là c'est assez evident
--------------------------------------------------------}}
@section("content")
  <div class="row">
    <div class="col s6">
      <p class="green-text">Niveaux:</>
      <canvas id="chart" width="400" height="300" style="display: block; max-width: 400px; max-height: 300px;"></canvas>
    </div>

    <div class="col s6">
      <p class="green-text">Etat des equipements</p>
      <div class="separator"></div>
      <p class="green-text"> Panneaux solaires: RAS</p>
      <p class="green-text"> Eolienne: RAS</p>
      <p class="green-text"> Carburants pétroles: -</p>
      <p class="green-text"> Batteries: [QrX16] Batterie à 80% de sa capacité d'origine</p>
      
    </div>
  </div>
@endsection




{{--------------------------------------------------------
                          Et là on en parle pas
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
        data: [100, 90, 100, 70, 20, 40, 30, 0],
        backgroundColor: [
        "#4CAF50",
        "#4CAF50",
        "#4CAF50",
        "#4CAF50",
        "#4CAF50",
        "#4CAF50",
        "#4CAF50",
        "#4CAF50"
      ],
        label: "Niveaux de batterie en %"
      }],
      labels: ['QrX16', 'CH2019', 'Batterie centrale', 'Cet appareil', 'Batterie 2', 'Batterie 3', 'Batterie 4', 'Batterie HS']
    };
    var barChart = new Chart(ctx, {
      type: 'horizontalBar',
      data: data
    });
  </script>
@endsection
