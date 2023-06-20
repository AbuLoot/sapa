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
            @include('partials.alerts')

            <div class="card">
              <div class="card-header">
                <h5>Рекдактирование профиля</h5>
              </div>
              <div class="card-divider"></div>
              <div class="card-body">
                <form action="/profile" method="post">
                  <input type="hidden" name="_method" value="PUT">
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Имя</label>
                            <input type="text" class="form-control" minlength="2" maxlength="40" name="name" placeholder="Имя*" value="{{ (old('name')) ? old('name') : $user->name }}" required>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Отчество</label>
                            <input type="text" class="form-control" minlength="2" maxlength="60" name="lastname" placeholder="Фамилия*" value="{{ (old('lastname')) ? old('lastname') : $user->lastname }}" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Регион</label>
                        <select id="region_id" name="region_id" class="form-control">
                          <option value=""></option>
                          <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $user) { ?>
                            <?php foreach ($nodes as $node) : ?>
                              <option value="{{ $node->id }}" <?= ($node->id == $user->profile->region_id) ? 'selected' : ''; ?>>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                              <?php $traverse($node->children, $prefix.'___'); ?>s
                            <?php endforeach; ?>
                          <?php }; ?>
                          <?php $traverse($regions); ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Номер телефона</label>
                        <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" name="phone" placeholder="Номер телефона*" value="{{ (old('phone')) ? old('phone') : $user->profile->phone }}" required>
                      </div>
                      <div class="form-group">
                        <label>Дата рождения</label>
                        <input type="date" class="form-control" name="birthday" minlength="3" maxlength="30" placeholder="Дата рождения" value="{{ (old('birthday')) ? old('birthday') : $user->profile->birthday }}" >
                      </div>
                      <div class="form-group">
                        <div><label>Пол</label></div>
                        @foreach(trans('data.gender') as $key => $value)
                          <label class="container_radio" style="display: inline-block; margin-right: 15px;">{{ $value }}
                            <input type="radio" name="gender" @if($key == $user->profile->gender) checked="checked" @endif value="{{ $key }}">
                            <span class="checkmark"></span>
                          </label>
                        @endforeach
                      </div>
                      <div class="form-group">
                        <label for="about">О себе</label>
                        <textarea class="form-control" id="about" name="about" rows="5">{{ (old('about')) ? old('about') : $user->profile->about }}</textarea>
                      </div>
                    </div>
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

@endsection

@section('scripts')

@endsection