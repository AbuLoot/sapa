@extends('layout')

@section('meta_title', $post->meta_title ?? $post->title)

@section('meta_description', $post->meta_description ?? $post->title)

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
            <li class="breadcrumb-item">
              <a href="/i/news-category">Новости</a>
              <svg class="breadcrumb-arrow" width="6px" height="9px">
                <use xlink:href="/img/sprite.svg#arrow-rounded-right-6x9"></use>
              </svg>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-8">
        <div class="block post post--layout--classic">
          <div class="post__header post-header post-header--layout--classic">
            <h1 class="post-header__title">{{ $post->title }}</h1>
            <div class="post-header__meta">
              <div class="post-header__meta-item">Admin</div>
              <div class="post-header__meta-item"><a href="">{{ $post->getDateAttribute() }}</a></div>
            </div>
          </div>
          <div class="post__featured">
            <a href="#">
              <img src="/img/posts/{{ $post->image }}" alt="{{ $post->title }}">
            </a>
          </div>
          <div class="post__content typography ">{!! $post->content !!}</div>
          <section class="post__section">
            <h4 class="post__section-title">Другие новости</h4>
            <div class="related-posts">
              <div class="related-posts__list">
                @unless(is_null($prev))
                  <div class="related-posts__item post-card post-card--layout--related">
                    <div class="post-card__image">
                      <a href="/news/{{ $prev->slug }}">
                        <img src="/img/posts/{{ $prev->image }}" alt="{{ $prev->title }}">
                      </a>
                    </div>
                    <div class="post-card__info">
                      <div class="post-card__name">
                        <a href="/news/{{ $prev->slug }}">{{ $prev->title }}</a>
                      </div>
                      <div class="post-card__date">{{ $prev->getDateAttribute() }}</div>
                    </div>
                  </div>
                @endunless
                @unless(is_null($next))
                  <div class="related-posts__item post-card post-card--layout--related">
                    <div class="post-card__image">
                      <a href="/news/{{ $next->slug }}">
                        <img src="/img/posts/{{ $next->image }}" alt="{{ $next->title }}">
                      </a>
                    </div>
                    <div class="post-card__info">
                      <div class="post-card__name">
                        <a href="/news/{{ $next->slug }}">{{ $next->title }}</a>
                      </div>
                      <div class="post-card__date">{{ $next->getDateAttribute() }}</div>
                    </div>
                  </div>
                @endunless
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="block block-sidebar block-sidebar--position--end">
          <div class="block-sidebar__item">
            <div class="widget-search">
              <form class="widget-search__body">
                <input class="widget-search__input" placeholder="Поиск новостей..." type="text" autocomplete="off" spellcheck="false">
                <button class="widget-search__button" type="submit">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#search-20"></use>
                  </svg>
                </button>
              </form>
            </div>
          </div>
          <div class="block-sidebar__item">
            <div class="widget-posts widget">
              <h4 class="widget__title">Последние новости</h4>
              <div class="widget-posts__list">
                @foreach($posts as $latest_post)
                  <div class="widget-posts__item">
                    <div class="widget-posts__image">
                      <a href="/news/{{ $latest_post->slug }}">
                        <img src="/img/posts/{{ $latest_post->image }}" alt="{{ $latest_post->title }}">
                      </a>
                    </div>
                    <div class="widget-posts__info">
                      <div class="widget-posts__name">
                        <a href="/news/{{ $latest_post->slug }}">{{ $latest_post->title }}</a>
                      </div>
                      <div class="widget-posts__date">{{ $latest_post->getDateAttribute() }}</div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
