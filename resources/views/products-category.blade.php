@extends('layout')

@section('meta_title', (!empty($category->meta_title)) ? $category->meta_title : $category->title)

@section('meta_description', (!empty($category->meta_description)) ? $category->meta_description : $category->title)

@section('head')

@endsection

@section('content')

  <?php $items = session('items'); ?>
  <?php $favorite = session('favorite'); ?>

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
            @foreach ($category->ancestors as $ancestor)
              @unless($ancestor->parent_id != NULL && $ancestor->children->count() > 0)
                <li class="breadcrumb-item">
                  <a href="/c/{{ $ancestor->slug.'/'.$ancestor->id }}">{{ $ancestor->title }}</a>
                  <svg class="breadcrumb-arrow" width="6px" height="9px"><use xlink:href="/img/sprite.svg#arrow-rounded-right-6x9"></use></svg>
                </li>
              @endunless
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
          </ol>
        </nav>
      </div>
      <div class="page-header__title">
        <h1>{{ $category->title }}</h1>
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
                <svg width="20px" height="20px">
                  <use xlink:href="/img/sprite.svg#cross-20"></use>
                </svg>
              </button>
            </div>
            <div class="block-sidebar__item">
              <div class="widget-filters widget widget-filters--offcanvas--mobile" data-collapse data-collapse-opened-class="filter--opened">
                <h4 class="widget-filters__title widget__title">Фильтры</h4>
                <div class="widget-filters__list">

                  <form action="/с/{{ $category->slug.'/'.$category->id }}" method="get" id="filter">
                    {{ csrf_field() }}

                    <div class="widget-filters__item">
                      <div class="filter filter--opened" data-collapse-item>
                        <button type="button" class="filter__title text-uppercase" data-collapse-trigger>
                          Марки & модели <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg>
                        </button>
                        <div class="filter__body" data-collapse-content>
                          <div class="filter__container">
                            <div class="filter-list">
                              <div class="filter-list__list">
                                <?php foreach ($projects_category as $project) : ?>
                                <label class="filter-list__item">
                                  <span class="filter-list__input input-check">
                                    <span class="input-check__body">
                                      <input class="input-check__input" type="checkbox" id="p{{ $project->id }}" name="project_id[]" value="{{ $project->id }}" <?php if(isset($_REQUEST['project_id']) AND in_array($project->id, $_REQUEST['project_id'])) echo 'checked'; ?>>
                                      <span class="input-check__box"></span>
                                      <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="/img/sprite.svg#check-9x7"></use></svg>
                                    </span>
                                  </span>
                                  <span class="filter-list__title">{{ $project->title }}</span>
                                  <!-- <span class="filter-list__counter">7</span> -->
                                </label>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    @if($category->children->count() > 0)
                      <div class="widget-filters__item">
                        <div class="filter filter--opened" data-collapse-item>
                          <button type="button" class="filter__title text-uppercase" data-collapse-trigger>
                            Категории <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg>
                          </button>
                          <div class="filter__body" data-collapse-content>
                            <div class="filter__container">
                              <div class="filter-list">
                                <div class="filter-list__list">
                                  <?php foreach ($category->descendants->where('status', '<>', 0) as $child) : ?>
                                    <label class="filter-list__item">
                                      <span class="filter-list__input input-check">
                                        <span class="input-check__body">
                                          <input class="input-check__input" type="checkbox" id="c{{ $child->id }}" name="category_id[]" value="{{ $child->id }}" <?php if(isset($_REQUEST['category_id']) AND in_array($child->id, $_REQUEST['category_id'])) echo 'checked'; ?>>
                                          <span class="input-check__box"></span>
                                          <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="/img/sprite.svg#check-9x7"></use></svg>
                                        </span>
                                      </span>
                                      <span class="filter-list__title">{{ $child->title }}</span>
                                      <!-- <span class="filter-list__counter">7</span> -->
                                    </label>
                                  <?php endforeach; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                    <div class="widget-filters__item">
                      <div class="filter filter--opened" data-collapse-item>
                        <button type="button" class="filter__title text-uppercase" data-collapse-trigger>
                          Тип <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg>
                        </button>
                        <div class="filter__body" data-collapse-content>
                          <div class="filter__container">
                            <div class="filter-list">
                              <div class="filter-list__list">
                                <?php foreach (trans('statuses.types') as $key => $type) : ?>
                                  <label class="filter-list__item">
                                    <span class="filter-list__input input-check">
                                      <span class="input-check__body">
                                        <input class="input-check__input" type="checkbox" name="type_id[]" value="{{ $key }}" <?php if(isset($_REQUEST['type_id']) AND in_array($key, $_REQUEST['type_id'])) echo 'checked'; ?>>
                                        <span class="input-check__box"></span>
                                        <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="/img/sprite.svg#check-9x7"></use></svg>
                                      </span>
                                    </span>
                                    <span class="filter-list__title">{{ $type }}</span>
                                  </label>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    @foreach ($grouped as $data => $group)
                      <div class="widget-filters__item">
                        <div class="filter filter--opened" data-collapse-item>
                          <button type="button" class="filter__title" data-collapse-trigger>
                            <?php $data = json_decode($data, true); ?>
                            {{ $data[app()->getLocale()]['data'] }} <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg>
                          </button>
                          <div class="filter__body" data-collapse-content>
                            <div class="filter__container">
                              <div class="filter-list">
                                <div class="filter-list__list">
                                  @foreach ($group as $option)
                                    <?php $titles = json_decode($option->title, true); ?>
                                    <label class="filter-list__item ">
                                      <span class="filter-list__input input-check">
                                        <span class="input-check__body">
                                          <input class="input-check__input" type="checkbox" id="o{{ $option->id }}" name="option_id[]" value="{{ $option->id }}" <?php if(isset($_REQUEST['option_id']) AND in_array($option->id, $_REQUEST['option_id'])) echo 'checked'; ?>>
                                          <span class="input-check__box"></span>
                                          <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="/img/sprite.svg#check-9x7"></use></svg>
                                        </span>
                                      </span>
                                      <span class="filter-list__title">{{ $titles[app()->getLocale()]['title'] }}</span>
                                      <!-- <span class="filter-list__counter">0</span> -->
                                    </label>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
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

    // Sort actions
    $('#actions').change(function() {

      var action = $(this).val();
      var page = $(location).attr('href').split('c/')[1];
      var slug = page.split('?')[0];

      $.ajax({
        type: "get",
        url: '/c/'.page,
        dataType: "json",
        data: {
          "action": action
        },
        success: function(data) {
          $('#products').html(data);
          // location.reload();
        }
      });
    });

    // Filter products
    $('#filter').on('click', 'input', function(e) {

      var projectIds = new Array();
      var categoriesIds = new Array();
      var optionIds = new Array();
      var typeIds = new Array();

      $('input[name="project_id[]"]:checked').each(function() {
        projectIds.push($(this).val());
      });

      $('input[name="category_id[]"]:checked').each(function() {
        categoriesIds.push($(this).val());
      });

      $('input[name="option_id[]"]:checked').each(function() {
        optionIds.push($(this).val());
      });

      $('input[name="type_id[]"]:checked').each(function() {
        typeIds.push($(this).val());
      });

      // Value of catalog in href attribute
      var page = $(location).attr('href').split('c/')[1];
      var slug = page.split('?')[0];

      console.log(page);

      $.ajax({
        type: 'get',
        url: '/c/' + slug,
        dataType: 'json',
        data: {
          'project_id': projectIds,
          'category_id': categoriesIds,
          'option_id': optionIds,
          'type_id': typeIds,
        },
        success: function(data) {
          // console.log(data);
          $('#products').html(data.products);
          $('#products-count').html(data.count);
        }
      });
    });
  </script>
@endsection