@extends('layout')

@section('meta_title', 'Добавление товара')

@section('meta_description', 'Добавление товара')

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

            <div class="card">
              <div class="card-header">
                <h5>Добавление товара</h5>
              </div>
              <div class="card-divider"></div>
              <div class="card-body">
                <form action="/user-products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="_method" value="PUT">
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="col-md-8">
                      <div class="panel panel-default">
                        <div class="panel-heading">Основная информация</div>
                        <div class="panel-body">
                          <div class="form-group">
                            <label for="title">Название</label>
                            <input type="text" class="form-control" id="title" name="title" minlength="5" value="{{ (old('title')) ? old('title') : $product->title }}" required>
                          </div>
                          <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" minlength="2" value="{{ (old('slug')) ? old('slug') : $product->slug }}" readonly>
                          </div>
                          <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control" id="summernote" name="description" rows="6" maxlength="2000">{{ (old('description')) ? old('description') : $product->description }}</textarea>
                          </div>
                          <div class="form-group">
                            <label for="characteristic">Характеристика</label>
                            <input type="text" class="form-control" id="characteristic" name="characteristic" minlength="2" value="{{ (old('characteristic')) ? old('characteristic') : $product->characteristic }}">
                          </div>
                          <div class="form-group">
                            <label for="parameters">Параметры</label>
                            <input type="text" class="form-control" id="parameters" name="parameters" minlength="5" value="{{ (old('parameters')) ? old('parameters') : $product->parameters }}">
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="barcode">Артикул</label>
                                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ (old('barcode')) ? old('barcode') : $product->barcode }}">
                              </div>
                              <div class="form-group">
                                <label for="count">Количество</label>
                                <input type="number" class="form-control" id="count" name="count" minlength="5" maxlength="80" value="{{ (old('count')) ? old('count') : $product->count_web }}">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="price">Цена</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ (old('price')) ? old('price') : $product->price }}" required>
                                  <div class="input-group-addon">{{ $currency->symbol }}</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="type">Тип</label><br>
                            <label class="radio-inline">
                              <input type="radio" name="type" value="1" @if ($product->type == '1') checked @endif> Новый
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="type" value="2" @if ($product->type == '2') checked @endif> Б/у
                            </label>
                          </div>
                          <div class="row">
                              
                            <h4>Галерея</h4><br>
                            <div class="w-100"></div>
                            <?php $images = ($product->images == true) ? unserialize($product->images) : []; ?>
                            <?php $key_last = array_key_last($images); ?>
                            @for ($i = 0; $i <= (($key_last >= 4) ? $key_last : 3); $i++)
                              @if(array_key_exists($i, $images))
                                <div class="col-6">
                                  <img class="img-fluid" src="/img/products/{{ $product->path.'/'.$images[$i]['present_image'] }}">
                                </div>
                                <div class="col-6" id="gallery">
                                  <input type="file" name="images[]" accept="image/*" multiple>
                                  <br>
                                </div>
                              @else
                                <div class="col-6 form-group" id="gallery">
                                  <br>
                                  <input type="file" name="images[]" accept="image/*" multiple>
                                </div>
                              @endif
                            @endfor
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="status">Статус:</label>
                                <select id="status" name="status" class="form-control" required>
                                  @foreach(trans('statuses.product') as $num => $status)
                                    @if ($num == 1)
                                      <option value="{{ $num}}" selected>{{ $status['title'] }}</option>
                                    @else
                                      <option value="{{ $num}}">{{ $status['title'] }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="panel panel-default">
                        <div class="panel-heading">Параметры</div>
                        <div class="panel-body">

                          <div class="form-group">
                            <label for="company_id">Компания</label>
                            <select id="company_id" name="company_id" class="form-control js-basic-select">
                              @foreach($companies as $company)
                                @if ($company->id == $product->company_id)
                                  <option value="{{ $company->id }}" selected>{{ $company->title }}</option>
                                @else
                                  <option value="{{ $company->id }}">{{ $company->title }}</option>
                                @endif
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group">
                            <p><b>Проекты</b></p>
                            <select class="form-control js-basic-select" name="projects_id[]" size="15" multiple="multiple">
                              <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $product) { ?>
                                <?php foreach ($nodes as $node) : ?>
                                  <option value="{{ $node->id }}" <?php if ($product->project_id == $node->id) echo "selected"; ?>>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                                  <?php $traverse($node->children, $prefix.'___'); ?>
                                <?php endforeach; ?>
                              <?php }; ?>
                              <?php $traverse($projects); ?>
                            </select>
                          </div>

                          <p><b>Категории</b></p>
                          <div class="panel panel-default">
                            <div class="panel-body" style="max-height: 250px; overflow-y: auto;">
                              <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $product) { ?>
                                <?php foreach ($nodes as $node) : ?>
                                  <div class="radio">
                                    <label>
                                      <input type="radio" name="category_id" value="{{ $node->id }}" <?php if ($product->category_id == $node->id) echo "checked"; ?>> {{ PHP_EOL.$prefix.' '.$node->title }}
                                    </label>
                                  </div>
                                <?php $traverse($node->children, $prefix.'___'); ?>
                                <?php endforeach; ?>
                              <?php }; ?>
                              <?php $traverse($categories); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

@endsections