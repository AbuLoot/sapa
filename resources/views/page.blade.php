@extends('layout')

@section('meta_title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description ?? $page->title)

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
      <div class="document">
        <div class="document__header">
          <h1 class="document__title">{{ $page->title }}</h1>
        </div>
        <div class="document__content">
          {!! $page->content !!}
        </div>
      </div>
    </div>
  </div>
@endsection
