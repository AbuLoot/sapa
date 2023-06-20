@extends('layout')

@section('meta_title', 'Оформление')

@section('meta_description', 'Оформление')

@section('head')
  <link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
@endsection

@section('content')

  <div class="page-header">
    <div class="page-header__container container">
      <br>
      <div class="page-header__title">
        <h1>Оформление</h1>
      </div>
    </div>
  </div>
  <div class="checkout block">
    <form action="/store-order" method="post">
      @csrf
      <div class="container">
        @include('partials.alerts')

        <div class="row">
          <div class="col-12 col-lg-6 col-xl-7">
            <div class="card mb-lg-0">
              <div class="card-body">
                <h3 class="card-title">Данные покупателя</h3>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Фамилия</label>
                    <input type="text" class="form-control" minlength="2" maxlength="60" name="surname" placeholder="Фамилия*" value="{{ old('surname') }}" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Имя</label>
                    <input type="text" class="form-control" minlength="2" maxlength="40" name="name" placeholder="Имя*" value="{{ old('name') }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Имя компании <span class="text-muted">(Необязательно)</span></label>
                  <input type="text" class="form-control" name="company_name" id="checkout-company-name">
                </div>
                <div class="form-group">
                  <label for="region_id">Регион</label>
                  <select id="region_id" name="region_id" class="form-control form-control-select2">
                    <option value=""></option>
                    <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
                      <?php foreach ($nodes as $node) : ?>
                        <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                        <?php $traverse($node->children, $prefix.'___'); ?>
                      <?php endforeach; ?>
                    <?php }; ?>
                    <?php $traverse($regions); ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Адрес улицы <span>*</span></label>
                  <input type="text" class="form-control" name="address" placeholder="Город, улица, дом..." value="{{ old('address') }}" required>
                </div>
                <div class="form-group">
                  <label>Postcode / ZIP</label>
                  <input type="text" class="form-control" id="checkout-postcode">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Email адрес <span class="text-muted">(Необязательно)</span></label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Введите email почту" value="{{ old('email') }}">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Номер телефона</label>
                    <input type="tel" class="form-control" name="phone" minlength="6" maxlength="40" placeholder="Номер телефона*" value="{{ old('phone') }}" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-5 mt-4 mt-lg-0">
            <div class="card mb-0">
              <div class="card-body">
                <h3 class="card-title">Ваш заказ</h3>
                <table class="checkout__totals">
                  <thead class="checkout__totals-header">
                    <tr>
                      <th>Продукт</th>
                      <th>Итого</th>
                    </tr>
                  </thead>
                  <tbody class="checkout__totals-products">
                    <?php $sum_total = 0;?>
                    <?php $items = session('items'); ?>
                    @foreach ($products as $product)
                      <?php $quantity = $items['products_id'][$product->id]['quantity']; ?>
                      <?php $sum_total += $product->price * $quantity; ?>
                      <tr>
                        <td>
                          <input type="hidden" name="count[{{ $product->id }}]" value="{{ $quantity }}">
                          {{ $product->title }} <strong> × {{ $quantity }}</strong>
                        </td>
                        <td><?php echo $product->price * $quantity; ?>₸</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="checkout__totals-footer">
                    <tr>
                      <th>Общая сумма</th>
                      <td><strong>{{ $sum_total }}₸</strong></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="payment-methods">
                  <ul class="payment-methods__list">
                    @foreach(trans('orders.pay') as $id => $item)
                      <li class="payment-methods__item payment-methods__item--active">
                        <label class="payment-methods__item-header">
                          <span class="payment-methods__item-radio input-radio">
                            <span class="input-radio__body">
                              <input class="input-radio__input" type="radio" name="pay" value="{{ $id }}" @if($id == 2) checked @endif>
                              <span class="input-radio__circle"></span>
                            </span>
                          </span>
                          <span class="payment-methods__item-title">{{ $item['value'] }}</span>
                        </label>
                        <div class="payment-methods__item-container">
                          <div class="payment-methods__item-description text-muted">{{ $item['value'] }}</div>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
                <div class="checkout__agree form-group">
                  <div class="form-check">
                    <span class="form-check-input input-check">
                      <span class="input-check__body">
                        <input class="input-check__input" type="checkbox" id="checkout-terms">
                        <span class="input-check__box"></span>
                        <svg class="input-check__icon" width="9px" height="7px">
                          <use xlink:href="images/sprite.svg#check-9x7"></use>
                        </svg>
                      </span>
                    </span>
                    <label class="form-check-label" for="checkout-terms">
                      Я прочитал и согласен с условиями использования веб-сайта * <a target="_blank" href="terms-and-conditions.html">условия и положения</a>*
                    </label>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-xl btn-block">Оформить заказ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

@endsection

@section('footer')
  <script src="/vendor/select2/js/select2.min.js"></script>
  <script type="text/javascript">
    $(function(){
      /*
      // .block-finder
      */
      $(function () {
        $('.block-finder__select').on('change', function() {
          const item = $(this).closest('.block-finder__form-item');

          if ($(this).val() !== 'none') {
            item.find('~ .block-finder__form-item:eq(0) .block-finder__select').prop('disabled', false).val('none');
            item.find('~ .block-finder__form-item:gt(0) .block-finder__select').prop('disabled', true).val('none');
          } else {
            item.find('~ .block-finder__form-item .block-finder__select').prop('disabled', true).val('none');
          }

          item.find('~ .block-finder__form-item .block-finder__select').trigger('change.select2');
        });
      });

      /*
      // select2
      */
      $(function () {
        $('.form-control-select2, .block-finder__select').select2({width: ''});
      });
    });
  </script>
@endsection