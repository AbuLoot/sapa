@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title.' - '.$page->title)

@section('meta_description', $page->meta_description ?? $page->title.' - '.$page->title)

@section('head')

@endsection

@section('content')
  <div class="page-header">
    <div class="page-header__container container">
      <div class="page-header__breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/">Главная</a>
              <svg class="breadcrumb-arrow" width="6px" height="9px">
                <use xlink:href="/img/sprite.svg#arrow-rounded-right-6x9"></use>
              </svg>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="block">
    <div class="container">
      @include('partials.alerts')

      <div class="card mb-0">
        <div class="card-body contact-us">
          <div class="contact-us__container">
            <div class="document__header">
              <h1 class="document__title">{{ 'Свяжитесь с нами' ?? $page->title }}</h1>
            </div>
            <div class="row">
              <div class="col-12 col-lg-6 pb-4 pb-lg-0">
                <h4 class="contact-us__header card-title">Наш адрес</h4>
                <div class="contact-us__address">
                  {!! $page->content !!}
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <h4 class="contact-us__header card-title">Форма для письма</h4>
                <form action="/send-app" name="contact" id="contact-form" method="post">
                  @csrf
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="form-name">Ваше ФИО</label>
                      <input type="text" name="name" class="form-control" id="form-name" minlength="2" maxlength="40" autocomplete="off" placeholder="Ваше ФИО" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="form-email">Email</label>
                      <input type="email" name="email" class="form-control" id="form-email" autocomplete="off" placeholder="Ваше Email" rrequired>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="form-number">Номер телефона</label>
                    <input type="tel" id="form-number" class="form-control" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="Номер телефона" required>
                  </div>
                  <div class="form-group">
                    <label for="form-message">Текст</label>
                    <textarea id="form-message" name="message" class="form-control" rows="4" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
