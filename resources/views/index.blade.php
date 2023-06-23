@extends('layout')

@section('meta_title', (!empty($page->meta_title)) ? $page->meta_title : $page->title)
@section('meta_description', (!empty($page->meta_description)) ? $page->meta_description : $page->title)

@section('head')
  <link rel="stylesheet" href="/vendor/owl-carousel/assets/owl.carousel.min.css">
@endsection

@section('class-departments') departments--open departments--fixed @endsection
@section('data-departments') .block-slideshow @endsection

@section('content')

  <?php $items = session('items'); ?>
  <?php $favorite = session('favorite'); ?>

  <!-- Slideshow -->
  @if($banners->isNotEmpty())
    <div class="block-slideshow block-slideshow--layout--with-departments block">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 d-none d-lg-block"></div>
          <div class="col-12 col-lg-9">
            <div class="block-slideshow__body">
              <div class="owl-carousel">
                @foreach($banners as $key => $banner)
                  <a class="block-slideshow__slide" href="/{{ $banner->link }}">
                    <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop" style="background-image: url('/img/banners/{{ $banner->image }}'); background-size: cover; background-position: center;"></div>
                    <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile" style="background-image: url('/img/banners/{{ $banner->image }}'); background-size: cover; background-position: center;"></div>
                    <div class="block-slideshow__slide-content">
                      <div class="block-slideshow__slide-title" style="background-color: rgb(32 32 32 / 25%); padding: 10px; text-shadow: 1px 0px 1px #000000; color: {{ $banner->color }};">
                        {{ $banner->title }}
                        <div style="font-size: 16px; color: {{ $banner->color }};">{{ $banner->marketing }}</div>
                      </div>
                      @if($banner->link != NULL)
                        <div class="block-slideshow__slide-button">
                          <span class="btn btn-primary btn-lg">Подробнее</span>
                        </div>
                      @endif
                    </div>
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Features -->
  @if(!empty($features))
    {!! $features->content !!}
  @endif

  <!-- Products -->
  <div class="container mt-5">
    <?php
      $mode_new = $modes->firstWhere('slug', 'new');
      $mode_new_title = unserialize($mode_new->title);
    ?>
    <h3>{{ 'Часто ищут' ?? $mode_new_title[$lang]['title'] }}</h3>
    <div class="row row-custom">
      @foreach($mode_new->products->where('status', 1)->take(8) as $new_product)
        <div class="col-md-3 col-6">
          <div class="product-card">
            <div class="product-card__badges-list">
              @foreach($new_product->modes as $mode)
                <?php $titles = unserialize($mode->title); ?>
                <div class="product-card__badge product-card__badge--<?= (in_array($mode->slug, ['new', 'sale', 'hot'])) ? $mode->slug : 'default'; ?>">{{ $titles[$lang]['title'] }}</div>
              @endforeach
            </div>
            <div>
              <a href="/p/{{ $new_product->id.'-'.$new_product->slug }}" class="product-image__body">
                <img class="product-image__img" src="/img/products/{{ $new_product->path.'/'.$new_product->image }}" alt="{{ $new_product->title }}">
              </a>
            </div>
            <div class="product-card__info">
              <div class="product-card__name">
                <a href="/p/{{ $new_product->id.'-'.$new_product->slug }}">{{ $new_product->title }}</a>
              </div>
              <div class="product-card__prices">{{ $new_product->price }}〒</div>
              <div class="product-card__buttons">
                @if ($new_product->count_web == 0)
                  <!-- <button class="btn btn-primary" type="button" data-product-id="{{ $new_product->id }}" onclick="preOrder(this);">Предзаказ</button> -->
                  <a href="/i/contacts" class="btn btn-primary">Предзаказ</a>
                @elseif (is_array($items) AND isset($items['products_id'][$new_product->id]))
                  <a href="/cart" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оформить</a>
                @else
                  <button class="btn btn-dark text-nowrap" type="button" data-product-id="{{ $new_product->id }}" onclick="addToCart(this);" title="Добавить в корзину">В корзину</button>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- .block-banner -->
  <!-- <div class="block block-banner mt-5">
    <div class="container">
      <a href="" class="block-banner__body">
        <div class="block-banner__image block-banner__image--desktop" style="background-image: url('/img/banners/banner-1.jpg')"></div>
        <div class="block-banner__image block-banner__image--mobile" style="background-image: url('/img/banners/banner-1-mobile.jpg')"></div>
        <div class="block-banner__title">Hundreds <br class="block-banner__mobile-br"> Hand Tools</div>
        <div class="block-banner__text">Hammers, Chisels, Universal Pliers, Nippers, Jigsaws, Saws</div>
        <div class="block-banner__button">
          <span class="btn btn-primary">Shop Now</span>
        </div>
      </a>
    </div>
  </div> -->

  <!-- Categories -->
  <div class="block block--highlighted block-categories block-categories--layout--classic mt-5">
    <div class="container">
      <div class="block-header">
        <h3 class="block-header__title">Популярные категории</h3>
        <div class="block-header__divider"></div>
      </div>
      <div class="block-categories__list">
        @foreach($relevant_categories as $relevant_category)
          <div class="block-categories__item category-card category-card--layout--classic">
            <div class="category-card__body">
              <div class="category-card__image">
                <a href="/c/{{ $relevant_category->slug .'/'. $relevant_category->id }}"><img src="/file-manager/{{ $relevant_category->image }}" alt="{{ $relevant_category->title }}"></a>
              </div>
              <div class="category-card__content">
                <div class="category-card__name">
                  <a href="/c/{{ $relevant_category->slug .'/'. $relevant_category->id }}">{{ $relevant_category->title }}</a>
                </div>
                <ul class="category-card__links">
                  <?php $hide_descendants = []; ?>
                  @foreach($relevant_category->children as $num => $descendant)
                    @if($num >= 5)
                      <?php $hide_descendants[] = $descendant; continue; ?>
                    @endif
                    <li><a href="/c/{{ $descendant->parent->slug .'/'. $descendant->slug .'/'. $descendant->id }}">{{ $descendant->title }}</a></li>
                  @endforeach
                </ul>
                @if(!empty($hide_descendants))
                  <div class="category-card__all">
                    <a href="#" data-toggle="collapse" data-target="#collapse{{ $relevant_category->id }}" aria-expanded="false" aria-controls="collapse{{ $relevant_category->id }}">Все <span class="fa fa-chevron-down"></span></a>
                    <div class="collapse" id="collapse{{ $relevant_category->id }}">
                      <ul class="category-card__links">
                        @foreach($hide_descendants as $hide_descendant)
                          <li><a href="/c/{{ $hide_descendant->parent->slug .'/'. $hide_descendant->slug .'/'. $hide_descendant->id }}">{{ $hide_descendant->title }}</a></li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Products -->
  <div class="container mt-5">
    <?php
      $mode_top = $modes->firstWhere('slug', 'top');
      $mode_top_title = unserialize($mode_top->title);
    ?>
    <h3>{{ 'Выгодные цены' ?? $mode_top_title[$lang]['title'] }}</h3>
    <div class="row row-custom">
      @foreach($mode_top->products->where('status', 1)->take(8) as $hot_product)
        <div class="col-md-3 col-6">
          <div class="product-card">
            <div class="product-card__badges-list">
              @foreach($hot_product->modes as $mode)
                <?php $titles = unserialize($mode->title); ?>
                <div class="product-card__badge product-card__badge--<?= (in_array($mode->slug, ['new', 'sale', 'hot'])) ? $mode->slug : 'default'; ?>">{{ $titles[$lang]['title'] }}</div>
              @endforeach
            </div>
            <div>
              <a href="/p/{{ $hot_product->id.'-'.$hot_product->slug }}" class="product-image__body">
                <img class="product-image__img" src="/img/products/{{ $hot_product->path.'/'.$hot_product->image }}" alt="{{ $hot_product->title }}">
              </a>
            </div>
            <div class="product-card__info">
              <div class="product-card__name">
                <a href="/p/{{ $hot_product->id.'-'.$hot_product->slug }}">{{ $hot_product->title }}</a>
              </div>
              <div class="product-card__prices">{{ $hot_product->price }}〒</div>
              <div class="product-card__buttons">
                @if ($hot_product->count_web == 0)
                  <!-- <button class="btn btn-primary" type="button" data-product-id="{{ $hot_product->id }}" onclick="preOrder(this);">Предзаказ</button> -->
                  <a href="/i/contacts" class="btn btn-primary">Предзаказ</a>
                @elseif (is_array($items) AND isset($items['products_id'][$hot_product->id]))
                  <a href="/cart" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оформить</a>
                @else
                  <button class="btn btn-dark text-nowrap" type="button" data-product-id="{{ $hot_product->id }}" onclick="addToCart(this);" title="Добавить в корзину">В корзину</button>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

@endsection


@section('scripts')
  <script src="/vendor/owl-carousel/owl.carousel.min.js"></script>
  <script src="/vendor/owl-carousel/owl.carousel-custom.js"></script>
  <script>
    // Add to cart
    function addToCart(i) {
      var productId = $(i).data("product-id");

      $.ajax({
        type: "get",
        url: '/add-to-cart/'+productId,
        dataType: "json",
        data: {},
        success: function(data) {
          $('*[data-product-id="'+productId+'"]').replaceWith('<a href="/cart" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оформить</a>');
          $('#count-items-m').text(data.countItems);
          $('#count-items').text(data.countItems);
          alert('Товар добавлен в корзину');
        }
      });
    }

    // Toggle favourite
    function toggleFavourite (f) {
      var productId = $(f).data("favourite-id");

      $.ajax({
        type: "get",
        url: '/toggle-favourite/'+productId,
        dataType: "json",
        data: {},
        success: function(data) {
          if (data.status == true) {
            $('*[data-favourite-id="'+productId+'"]').addClass('btn-liked');
          } else {
            $('*[data-favourite-id="'+productId+'"]').removeClass('btn-liked');
          }
          $('#count-favorite-m').text(data.countFavorite);
          $('#count-favorite').text(data.countFavorite);
        }
      });
    }
  </script>
@endsection