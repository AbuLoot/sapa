@extends('layout')

@section('meta_title', 'Профиль')

@section('meta_description', 'Профиль')

@section('content')

  <div class="site__body">
    <br>
    <div class="block">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-3 d-flex">

            @include('account.nav')

          </div>
          <div class="col-12 col-lg-9 mt-4 mt-lg-0">
            <div class="card">
              <div class="card-header">
                <h5><i class="fa fa-lock"></i> Изменение пароля</h5>
              </div>
              <div class="card-divider"></div>
              <div class="card-body">
                <div class="row no-gutters">
                  <div class="col-12 col-lg-7 col-xl-6">
                    <form action="/{{ $lang }}/my-profile/{{ $user->id }}" method="post">
                      <input type="hidden" name="_method" value="PUT">
                      {!! csrf_field() !!}
                      <div class="form-group">
                        <label>Старый пароль</label>
                        <input class="form-control" name="old_password" type="password">
                      </div>
                      <div class="form-group">
                        <label>Новый пароль</label>
                        <input class="form-control" name="new_password" type="password">
                      </div>
                      <div class="form-group">
                        <label>Подтвердите новый пароль</label>
                        <input class="form-control" name="confirm_new_password" type="password">
                      </div>
                      <div class="form-group mt-5 mb-0">
                        <button class="btn btn-primary">Изменить</button>
                      </div>
                      <p><button type="submit" class="btn btn-primary">Сохранить</button></p>
                    </form>
                  </div>
                </div>
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
