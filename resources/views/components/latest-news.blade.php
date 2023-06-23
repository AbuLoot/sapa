
  <!-- Posts -->
  @if($posts->isNotEmpty())
    <div class="block block-posts mt-5" data-layout="list" data-mobile-columns="1">
      <div class="container">
        <div class="block-header">
          <h3 class="block-header__title">Последние новости</h3>
          <div class="block-header__divider"></div>
          <div class="block-header__arrows-list">
            <button class="block-header__arrow block-header__arrow--left" type="button">
              <svg width="7px" height="11px"><use xlink:href="/img/sprite.svg#arrow-rounded-left-7x11"></use></svg>
            </button>
            <button class="block-header__arrow block-header__arrow--right" type="button">
              <svg width="7px" height="11px"><use xlink:href="/img/sprite.svg#arrow-rounded-right-7x11"></use></svg>
            </button>
          </div>
        </div>
        <div class="block-posts__slider">
          <div class="owl-carousel">
            @foreach($posts as $post)
              <div class="post-card">
                <div class="post-card__image">
                  <a href="/news/{{ $post->slug }}">
                    <img src="/img/posts/{{ $post->image }}" alt="{{ $post->title }}" width="730" height="490">
                  </a>
                </div>
                <div class="post-card__info">
                  <div class="post-card__name">
                    <a href="/news/{{ $post->slug }}">{{ $post->title }}</a>
                  </div>
                  <div class="post-card__date">{{ $post->title }}</div>
                  <div class="post-card__content">{!! Str::limit($post->content, 130) !!}</div>
                  <div class="post-card__read-more">
                    <a href="/news/{{ $post->slug }}" class="btn btn-secondary btn-sm">Читать далее</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif