
{{--------------------------------------------------------
                   <(^^)> \(^^)\ /(^^)/ 
--------------------------------------------------------}}
@extends('guest.layouts.main')




{{--------------------------------------------------------
                          <(^^)> \(^^)\ /(^^)/ 
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
  <link rel="stylesheet" href="@css('guest/chat/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
@endsection




{{--------------------------------------------------------
                      <(^^)> \(^^)\ /(^^)/ 
--------------------------------------------------------}}
@section("alert")
@endsection




{{--------------------------------------------------------
                    <(^^)> \(^^)\ /(^^)/ 
--------------------------------------------------------}}
@section("content")
  <div class="answerContainer">
  </div>
  <form id="chat" action="@route('guest.chat.go')" method="POST">
    {{ csrf_field() }}

    <div class="row">
      <div class="input-field col s12 m12 l12">
        <input id="textChat" class="green-text" name="text" type="text" size="50">
        <label for="textChat">Chattez avec votre asistance intelligente et autonome</label>
      </div>
    </div>

    <div class="row">
      <button type="submit" class="green-text waves-effect waves-green btn-flat col s8 offset-s2">Envoyer</button>
    </div>
  </form>
@endsection




{{--------------------------------------------------------
                  <(^^)> \(^^)\ /(^^)/ 
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript">
    $(document).ready(function() {
      initChat();
    }):

    function initChat() {
      $("#chat").submit(function(e) {
        e.preventDefault();
        var form = $(this);

        $.post(form.attr('href'), {text: $("#textChat", form).val()})
        .done(function(data) {
          $("#answerContainer").html(data);
        });
      });
    }
  </script>
@endsection
