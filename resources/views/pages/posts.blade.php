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
            <li class="breadcrumb-item active" aria-current="page">Новости</li>
          </ol>
        </nav>
      </div>
      <div class="page-header__title">
        <h1>Последние новости</h1>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="block">
          <div class="posts-view">
            <div class="posts-view__list posts-list posts-list--layout--classic">
              <div class="posts-list__body">
                @foreach($posts as $post)
                  <div class="posts-list__item">
                    <div class="post-card post-card--layout--grid post-card--size--lg">
                      <div class="post-card__image">
                        <a href="/news/{{ $post->slug }}">
                          <img src="/img/posts/{{ $post->image }}" alt="{{ $post->title }}">
                        </a>
                      </div>
                      <div class="post-card__info">
                        <div class="post-card__name">
                          <a href="/news/{{ $post->slug }}">{{ $post->title }}</a>
                        </div>
                        <div class="post-card__date">{{ $post->getDateAttribute() }}</div>
                        <div class="post-card__content">{!! strip_tags(Str::limit($post->content, 260)) !!}</div>
                        <div class="post-card__read-more">
                          <a href="/news/{{ $post->slug }}" class="btn btn-secondary btn-sm">Читать далее</a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <br>

            {{ $posts->links() }}
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-4">

      </div>
    </div>
  </div>
@endsection