@extends('layout')

@section('meta_title', $user->name)

@section('meta_description', $user->name)

@section('head')

@endsection

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
            <div class="dashboard">
              <div class="dashboard__profile card profile-card">
                <div class="card-body profile-card__body">
                  <!-- <div class="profile-card__avatar">
                    <img src="/img/">
                  </div> -->
                  <div class="profile-card__name">{{ $user->name }}</div>
                  <div class="profile-card__email">{{ $user->email }}</div>
                  <div class="profile-card__edit">
                    <a href="/profile/edit" class="btn btn-secondary btn-sm">Редактировать профиль</a>
                  </div>
                </div>
              </div>
              <div class="dashboard__address card address-card address-card--featured">
                <div class="address-card__badge">Профиль</div>
                <div class="address-card__body">
                  <div class="address-card__name">О себе</div>
                  <div class="address-card__row">{{ $user->profile->about }}</div>
                  <div class="address-card__row">
                    <div class="address-card__row-title">Номер телефона</div>
                    <div class="address-card__row-content">{{ $user->profile->phone }}</div>
                  </div>
                  <div class="address-card__row">
                    <div class="address-card__row-title">Email адрес</div>
                    <div class="address-card__row-content">{{ $user->email }}</div>
                  </div>
                </div>
              </div>
              <div class="dashboard__orders card">
                <div class="card-header">
                  <h5>Заказы</h5>
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
                            <td>{{ (isset($order->city->title)) ? $order->city->title : '' }} {{ $order->address }}</td>
                            <td>
                              <?php $countAllProducts = unserialize($order->count); $i = 0; ?>
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

                  {{ $orders->links() }}
                </div>
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