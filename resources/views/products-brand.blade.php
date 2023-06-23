@extends('layout')

@section('meta_title', 'Запчасти '.$company->title)

@section('meta_description', 'Запчасти '.$company->title)

@section('btn-filter')
  <div class="view-options__filters-button">
    <button type="button" class="filters-button">
      <svg class="filters-button__icon" width="16px" height="16px"><use xlink:href="/img/sprite.svg#filters-16"></use></svg>
      <span class="filters-button__title">Фильтры</span>
    </button>
  </div>
@endsection

@section('content')

  <?php $items = session('items'); ?>
  <?php $favorite = session('favorite'); ?>

  <div class="site__body">
    <div class="page-header">
      <div class="page-header__container container">
        <div class="page-header__breadcrumb">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/">Главная</a>
                <svg class="breadcrumb-arrow" width="6px" height="9px"><use xlink:href="/img/sprite.svg#arrow-rounded-right-6x9"></use></svg>
              </li>
              <li class="breadcrumb-item active" aria-current="page">{{ $company->title }}</li>
            </ol>
          </nav>
        </div>
        <br>
        <div class="page-header__title">
          <h1>Товары {{ $company->title }}</h1>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="shop-layout shop-layout--sidebar--start">

        <!-- Sidebar -->
        <div class="shop-layout__sidebar">
          <div class="block block-sidebar block-sidebar--offcanvas--mobile">
            <div class="block-sidebar__backdrop"></div>
            <div class="block-sidebar__body">
              <div class="block-sidebar__header">
                <div class="block-sidebar__title">Фильтры</div>
                <button class="block-sidebar__close" type="button">
                  <svg width="20px" height="20px"><use xlink:href="/img/sprite.svg#cross-20"></use></svg>
                </button>
              </div>

              <div class="block-sidebar__item">
                <div class="widget-filters widget widget-filters--offcanvas--mobile" data-collapse data-collapse-opened-class="filter--opened">
                  <h4 class="widget-filters__title widget__title">Фильтр</h4>
                  <div class="widget-filters__list">

                    <form action="/" method="get" id="filter">
                      {{ csrf_field() }}

                      <div class="widget-filters__item">
                        <div class="filter filter--opened" data-collapse-item>
                          <button type="button" class="filter__title" data-collapse-trigger>
                            Категории {{ $company->title }} <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg>
                          </button>

                          <div class="filter__body" data-collapse-content>
                            <div class="filter__container">
                              <div class="filter-categories">
                                <ul class="widget-categories__list" data-collapse data-collapse-opened-class="widget-categories__item--open">
                                  @foreach ($category_list as $category_item)
                                  <li class="widget-categories__item" data-collapse-item>
                                    <div class="widget-categories__row">
                                      <a href="/brand/{{ $company->slug.'/'.$category_item->slug.'/'.$category_item->id }}">
                                        <svg class="widget-categories__arrow" width="6px" height="9px"><use xlink:href="/img/sprite.svg#arrow-rounded-right-6x9"></use></svg> 
                                        {{ $category_item->title }}
                                      </a><div class="filter-categories__counter"></div>
                                    </div>
                                  </li>
                                  @endforeach
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="shop-layout__content">
          <div class="block">
            <div class="products-view">
              <div class="products-view__options">
                <div class="view-options view-options--offcanvas--mobile">
                  <div class="view-options__filters-button">
                    <button type="button" class="filters-button">
                      <svg class="filters-button__icon" width="16px" height="16px">
                        <use xlink:href="/img/sprite.svg#filters-16"></use>
                      </svg>
                      <span class="filters-button__title">Фильтры</span>
                      <!-- <span class="filters-button__counter">3</span> -->
                    </button>
                  </div>
                  <div class="view-options__legend" id="products-count">Показано с {{ $products->firstItem().' по '.$products->lastItem().' из '.$products->total() }} товаров</div>
                  <div class="view-options__divider"></div>
                </div>
              </div>
              <div id="products">
                <div class="row row-custom">
                  @foreach ($products as $product)
                    <div class="col-md-4 col-6">
                      <div class="product-card">
                        <div class="product-card__badges-list">
                          @foreach($product->modes as $mode)
                            <?php $titles = unserialize($mode->title); ?>
                            <div class="product-card__badge product-card__badge--<?= (in_array($mode->slug, ['new', 'sale', 'hot'])) ? $mode->slug : 'default'; ?>">{{ $titles[$lang]['title'] }}</div>
                          @endforeach
                        </div>
                        <a href="/p/{{ $product->id.'-'.$product->slug }}" class="product-image__body">
                          <img class="product-image__img" src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                        </a>
                        <div class="product-card__info">
                          <div class="product-card__name">
                            <a href="/p/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a>
                          </div>
                          <div class="product-card__prices">{{ $product->price }}〒</div>
                          <div class="product-card__buttons">
                            @if ($product->count_web == 0)
                              <a href="/i/contacts" class="btn btn-primary">Предзаказ</a>
                            @elseif (is_array($items) AND isset($items['products_id'][$product->id]))
                              <a href="/cart" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оформить</a>
                            @else
                              <button class="btn btn-dark text-nowrap" type="button" data-product-id="{{ $product->id }}" onclick="addToCart(this);" title="Добавить в корзину">В корзину</button>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div><br>

                {{ $products->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
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
          $('*[data-product-id="'+productId+'"]').replaceWith('<a href="/cart" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>');
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
          $('#count-favorite').text(data.countFavorite);
        }
      });
    }
  </script>
@endsection
