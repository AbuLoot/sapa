@extends('layout')

@section('meta_title', 'Заказы')

@section('meta_description', 'Заказы')

@section('content')

  <div class="site__body">
    <br>
    <div class="block">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-3 d-flex">

            @include('account.nav')

          </div>
          <div class="col-12 col-lg-9 mt-4 mt-lg-0">
            <div class="card">
              <div class="card-header">
                <h5>История заказов</h5>
              </div>
              <div class="card-divider"></div>
              <div class="card-table">
                <div class="table-responsive-sm">
                  <table>
                    <thead>
                      <tr>
                        <th>Заказ</th>
                        <th>Дата</th>
                        <th>Город</th>
                        <th>Продукт</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($orders as $order)
                        <tr>
                          <td>{{ $order->id }}</td>
                          <td>{{ $order->created_at }}</td>
                          <td>{{ (isset($order->region->title)) ? $order->region->title : '' }} {{ $order->address }}</td>
                          <td>
                            <?php $countAllProducts = unserialize($order->count) ?? []; $i = 0; ?>
                            @foreach ($countAllProducts as $id => $countProduct)
                              @if (isset($order->products[$i]) AND $order->products[$i]->id == $id)
                                {{ $countProduct . ' шт.' }} <a href="/p/{{ $order->products[$i]->id.'-'.$order->products[$i]->slug }}">{{ $order->products[$i]->title }}</a><br>
                              @endif
                              <?php $i++; ?>
                            @endforeach
                          </td>
                          <td class="text-nowrap">{{ $order->amount }}〒</td>
                          <td>{{ trans('orders.statuses.'.$order->status) }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-divider"></div>
              <div class="card-footer">
                {{ $orders->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

@endsection