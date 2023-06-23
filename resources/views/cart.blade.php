@extends('layout')

@section('meta_title', 'Корзина')

@section('meta_description', 'Корзина')

@section('head')

@endsection

@section('content')

  <?php $items = session('items'); ?>

  <div class="page-header">
    <div class="page-header__container container">
      <br>
      <div class="page-header__title">
        <h1>Корзина</h1>
      </div>
    </div>
  </div>
  <div class="cart block">
    <div class="container">
      @include('partials.alerts')

      @if ($products->count() > 0)
        <table class="cart__table cart-table">
          <thead class="cart-table__head">
            <tr class="cart-table__row">
              <th class="cart-table__column cart-table__column--image">Картинка</th>
              <th class="cart-table__column cart-table__column--product">Продукт</th>
              <th class="cart-table__column cart-table__column--price">Цена</th>
              <th class="cart-table__column cart-table__column--quantity">В&nbsp;наличии</th>
              <th class="cart-table__column cart-table__column--quantity">Количество</th>
              <th class="cart-table__column cart-table__column--total">Сумма</th>
              <th class="cart-table__column cart-table__column--remove"></th>
            </tr>
          </thead>
          <tbody class="cart-table__body">
            <?php $total_sum = 0; ?>
            @foreach ($products as $product)
              <?php $quantity = session('items')['products_id'][$product->id]['quantity']; ?>
              <?php $total_sum += $product->price * $quantity; ?>
              <tr class="cart-table__row">
                <td class="cart-table__column cart-table__column--image">
                  <a href="/p/{{ $product->id.'-'.$product->slug }}">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" style="max-width: 200px;">
                  </a>
                </td>
                <td class="cart-table__column cart-table__column--product">
                  <a href="/p/{{ $product->id.'-'.$product->slug }}" class="cart-table__product-name">{{ $product->title }}</a>
                  <ul class="cart-table__options">
                    <li>Код товара: {{ $product->barcode }}</li>
                    @if($product->company)<li>Производитель: {{ $product->company->title }}</li>@endif
                  </ul>
                </td>
                <td class="cart-table__column cart-table__column--price" data-title="Цена"><span>{{ $product->price }}</span>〒</td>
                <td class="cart-table__column cart-table__column--quantity" data-title="В наличии">{{ $product->count_web }}</td>
                <td class="cart-table__column cart-table__column--quantity" data-title="Количество">
                  <div class="input-number">
                    <input class="form-control input-number__input sum-{{ $product->id }}" oninput="input_quantity('{{ $product->id }}')" type="number" name="count[{{ $product->id }}]" id="input-quantity-{{ $product->id }}" data-price="{{ $product->price }}" size="4" min="1" value="{{ $quantity }}">
                    <div class="input-number__add" onclick="increment_quantity('{{ $product->id }}')"></div>
                    <div class="input-number__sub" onclick="decrement_quantity('{{ $product->id }}')"></div>
                  </div>
                </td>
                <td class="cart-table__column cart-table__column--total" data-title="Сумма"><span class="sum-item-{{ $product->id }}">{{ ($product->price * $quantity) }}</span>〒</td>
                <td class="cart-table__column cart-table__column--remove">
                  <a href="/destroy-from-cart/{{ $product->id }}" class="btn btn-light btn-sm btn-svg-icon">
                    <svg width="12px" height="12px"><use xlink:href="/img/sprite.svg#cross-12"></use></svg>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="row justify-content-end pt-5">
          <div class="col-12 col-md-7 col-lg-6 col-xl-5">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">Итого</h3>
                <table class="cart__totals">
                  <tfoot class="cart__totals-footer">
                    <tr>
                      <th>Общая сумма</th>
                      <td><span class="sum_total">{{ $total_sum }}</span>₸</td>
                    </tr>
                  </tfoot>
                </table>
                <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="/checkout">Продолжить</a>
              </div>
            </div>
          </div>
        </div>
      @else
        <h2>Корзина пуста</h2>
        <p><a href="/" class="btn btn-primary btn-lg">Перейти к покупкам</a></p>
      @endif
    </div>
  </div>

@endsection

@section('scripts')
<script>
  function increment_quantity(product_id) {

    var inputQuantityElement = $("#input-quantity-"+product_id);
    console.log(inputQuantityElement);
    var newQuantity = parseInt($(inputQuantityElement).val());

    addToCart(product_id, newQuantity);
  }

  function decrement_quantity(product_id) {

    var inputQuantityElement = $("#input-quantity-"+product_id);
    if ($(inputQuantityElement).val() >= 1) {
      var newQuantity = parseInt($(inputQuantityElement).val());

      addToCart(product_id, newQuantity);
    }
  }

  function input_quantity(product_id) {

    var inputQuantityElement = $("#input-quantity-"+product_id);
    var newQuantity = parseInt($(inputQuantityElement).val());

    addToCart(product_id, newQuantity);
  }

  function addToCart(product_id, new_quantity) {

    $.ajax({
      type: "get",
      url: '/add-to-cart/'+product_id,
      dataType: "json",
      data: {
        "quantity": new_quantity
      },
      success: function(data) {
        if (data.status) {
          alert('Неверное количество');
        }

        var sum = parseInt(data.price) * data.quantity;

        $('.sum-'+product_id).val(data.quantity);
        $('.sum-item-'+product_id).text(sum);
        $('.sum_total').text(data.sumPriceItems);
      }
    });
  }

</script>
@endsection