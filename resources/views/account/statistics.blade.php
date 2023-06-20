@extends('layout')

@section('meta_title', 'Статистика')

@section('meta_description', 'Статистика')

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
            @include('partials.alerts')

            <div class="row">
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5>Количество товаров</h5>
                  </div>
                  <div class="card-divider"></div>
                  <div class="card-body">
                    <div class="display-4 text-center">{{ $count_products }}</div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5>Количество моих заказов</h5>
                  </div>
                  <div class="card-divider"></div>
                  <div class="card-body">
                    <div class="display-4 text-center">{{ $count_orders }}</div>
                  </div>
                </div>
              </div>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5>Количество заказов клиентов</h5>
                  </div>
                  <div class="card-divider"></div>
                  <div class="card-body">
                    <div class="display-4 text-center">{{ $count_users_orders }}</div>
                  </div>
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