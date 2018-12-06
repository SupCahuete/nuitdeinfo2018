
{{--------------------------------------------------------
                   Extends Layout Blade
--------------------------------------------------------}}
@extends('frontuser.layouts.main')




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
  <link rel="stylesheet" href="@css('frontuser/login/index.css')">
@endsection

@section('script-head')
@endsection

@section('title')
  @config('app.name') - @lang('controller.login')
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
  <div class="container">
    <div class="row">
      <div id="loginCard" class="col s10 m8 l8 offset-s10 offset-m2 offset-l2 white z-depth-2">
        <div class="container">
          <div class="row">
            <h3 id="title" class="center text-or-dark">Connectez vous</h3>
            <div class="center-align">
              <img id="logo" src="@image('logo.png')" />
            </div>
          </div>
          <div class="row">
            <form class="col s12" role="form" method="POST" action="@route("frontuser.login.store")">
              {{ csrf_field() }}

              <div class="row">
                <div class="input-field col s12">
                  <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                  <label for="email">Adresse Email</label>
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input id="password" type="password" name="password" value="{{ old('password') }}" required>
                  <label for="password">Mot de passe</label>
                  @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>


              <div class="row">
                <p class="checkbox-container">
                  <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}>
                    <span class="text-or-dark"> Se souvenir de moi </span>
                  </label>
                </p>
              </div>

              <div class="row">
                <button type="submit" class="waves-effect waves-light btn col s8 offset-s2 back-or-dark back-hover-or-dark">Connexion</button>
              </div>

              <div class="row">
                <div class="col s12 center-align">
                  <a class="grey-text" href="@route("frontuser.forgotPassword.index")">Mot de passe oublié ?</a>
                </div>
                <div class="col s12 center-align">
                  <a class="grey-text" href="@route("frontuser.register.index")">Pas encore de compte? Rejoignez @config('app.name')</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection




{{--------------------------------------------------------
                          Script
--------------------------------------------------------}}
@section('script-body')
  <script type="text/javascript" src=""></script>
@endsection

