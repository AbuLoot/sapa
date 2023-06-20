@extends('layout')

@section('meta_title', 'Вход')

@section('meta_description', 'Вход')

@section('head')

@endsection

@section('content')

  <div class="site__body">
    <div class="page-header">
      <div class="page-header__container container">
        <br>
        <!-- <div class="page-header__title">
          <h1>Аутентификация</h1>
        </div> -->
      </div>
    </div>
    <div class="block">
      <div class="container">

        @include('partials.alerts')

        <div class="row">
          <div class="col-md-6 d-flex flex-column">
            <div class="card flex-grow-1 mb-md-0">
              <div class="card-body">
                <h3 class="card-title">Вход</h3>
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus placeholder="Введите Email" required>
                  </div>
                  <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль" required>
                    <small class="form-text text-muted">
                      <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    </small>
                  </div>

                  <!-- Remember Me -->
                  <div class="form-group">
                    <div class="form-check">
                      <span class="form-check-input input-check">
                        <span class="input-check__body">
                          <input class="input-check__input" type="checkbox" id="login-remember" name="remember">
                          <span class="input-check__box"></span>
                          <svg class="input-check__icon" width="9px" height="7px">
                            <use xlink:href="images/sprite.svg#check-9x7"></use>
                          </svg>
                        </span>
                      </span>
                      <label class="form-check-label" for="login-remember">Запомнить меня</label>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary mt-4">Войти</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex flex-column mt-4 mt-md-0">
            <div class="card flex-grow-1 mb-0">
              <div class="card-body">
                <h3 class="card-title">Регистрация</h3>
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <input type="hidden" name="form_type" value="site">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Имя</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ваше имя" required autofocus>
                      </div>
                      <div class="col-md-6">
                        <label>Отчество</label>
                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="Ваше Отчество" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Введите email" required autofocus>
                  </div>
                  <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль" required autocomplete="new-password">
                  </div>
                  <div class="form-group">
                    <label>Повторите ввод пароля</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Повторите ввод пароля" required>
                  </div>
                  <button type="submit" class="btn btn-primary mt-4">Регистрация</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

@endsection