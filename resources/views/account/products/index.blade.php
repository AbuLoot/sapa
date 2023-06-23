@extends('layout')

@section('meta_title', 'Мои товары')

@section('meta_description', 'Мои товары')

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
                <h5 class="float-left">Мои товары</h5>
                <a href="/user-products/create" class="btn btn-primary float-right me-auto">Добавить</a>
              </div>
              <div class="card-divider"></div>
              <div class="card-table">
                <div class="table-responsive table-products">
                  <table class="table data table-striped table-condensed table-hover">
                    <thead>
                      <tr class="active">
                        <td>Картинка</td>
                        <td>Название</td>
                        <td>Категории</td>
                        <td>Компания</td>
                        <td>Проекты</td>
                        <td>
                          <span>
                            <svg width="18px" height="18px"><use xlink:href="/img/sprite.svg#person-20"></use></svg>
                          </span>
                        </td>
                        <td>Режим</td>
                        <td>Статус</td>
                        <td class="text-right">Функции</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $product)
                        <tr>
                          <td>
                            <a href="/p/{{ $product->id.'-'.$product->slug }}" title="Просмотр товара" target="_blank">
                              <img src="/img/products/{{ $product->path.'/'.$product->image }}" class="img-responsive" style="width:80px;height:auto;">
                            </a>
                          </td>
                          <td><a href="/p/{{ $product->id.'-'.$product->slug }}" title="Просмотр товара" target="_blank">{{ $product->title }}</a></td>
                          <td>{{ $product->category->title }}</td>
                          <td>{{ ($product->company) ? $product->company->title : '' }}</td>
                          <td>
                            @foreach($product->projects as $project)
                              {{ $project->title }}<br>
                            @endforeach
                          </td>
                          <td>{{ $product->views }}</td>
                          <td class="text-nowrap">
                            @foreach ($product->modes as $mode)
                              <?php $mode = unserialize($mode->title); ?>
                              {{ $mode[$lang]['title'] }}<br>
                            @endforeach
                          </td>
                          <td class="text-{{ trans('statuses.product.'.$product->status.'.style') }}">{{ trans('statuses.product.'.$product->status.'.title') }}</td>
                          <td class="text-right text-nowrap">
                            <a class="btn btn-link btn-sm" href="/user-products/{{ $product->id }}/edit" title="Редактировать">Изменить</a>
                            <form method="POST" action="{{ route('user-products.destroy', [$product->id]) }}" accept-charset="UTF-8">
                              <input name="_method" type="hidden" value="DELETE">
                              <input name="_token" type="hidden" value="{{ csrf_token() }}">
                              <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')">Удалить</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-divider"></div>
              <div class="card-footer">
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

@endsection