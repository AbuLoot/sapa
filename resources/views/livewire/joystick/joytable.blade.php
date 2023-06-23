<div>

  <div class="row">
    <div class="col-md-6">
      <h4>Кол-во: {{ $productsCount }}</h4>
    </div>
    <div class="col-md-6 text-right">
      <div class="btn-group">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownModes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Режимы <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownModes">
          @foreach($modes as $mode)
            <?php $titles = unserialize($mode->title); ?>
            <li>
              <a href="#">
                <label><input type="checkbox" wire:model="modesId" value="{{ $mode->id }}"> {{ $titles[$lang]['title'] }}</label>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
      @if($editMode)
        @if($sortMode)
          <div wire:click.prevent="resortProducts()" class="btn btn-success"><i class="material-icons md-18">sort</i></div>
        @else
          <div wire:click.prevent="sortProducts()" class="btn btn-primary"><i class="material-icons md-18">sort</i></div>
        @endif
        <div wire:click.prevent="saveProduct()" class="btn btn-success"><i class="material-icons md-18">save</i></div>
      @else
        <div wire:click.prevent="editProduct()" class="btn btn-primary"><i class="material-icons md-18">mode_edit</i></div>
      @endif
    </div>
  </div>

  <style type="text/css">
    .id-codes {
      min-width: 140px;
      text-align: right;
    }
    .joytable .input-group-addon {
      padding: 6px;
    }
  </style>

  <div class="table-responsive table-products">
    <table class="table data table-striped table-condensed table-hover">
      <thead>
        <tr class="active">
          @if(!$editMode)
            <td><input type="checkbox" onclick="toggleCheckbox(this)" class="checkbox-ids"></td>
          @endif
          <td>Картинка</td>
          <td>Название</td>
          <!-- <td>Закупочная цена</td> -->
          <!-- <td>Оптовая цена</td> -->
          <td>Цена</td>
          <td>Артикулы и кол-во</td>
          <td>Категории</td>
          <td>Режимы</td>
          @if(!$editMode)
            <td>Статус</td>
          @endif
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; ?>
        @foreach($productsItems as $index => $product)
          @if($editMode)
            <tr @if($product->id == $productId) class="info" @endif>
              <td><img src="/img/products/{{ $product->path.'/'.$product->image }}" class="img-responsive" style="width:80px;height:auto;"></td>
              <td class="cell-size">
                <textarea wire:model="products.{{ $index }}.title" class="form-control" rows="3"></textarea>
                @error('products.'.$index.'.title')<div class="text-danger">{{ $message }}</div>@enderror
              </td>
              <!-- <td>
                <input type="text" wire:model="products.{{ $index }}.purchase_price" class="form-control" onfocus="this.select()">
                @error('products.'.$index.'.purchase_price')<div class="text-danger">{{ $message }}</div>@enderror
              </td>
              <td>
                <input type="text" wire:model="products.{{ $index }}.wholesale_price" class="form-control" onfocus="this.select()">
                @error('products.'.$index.'.wholesale_price')<div class="text-danger">{{ $message }}</div>@enderror
              </td> -->
              <td>
                <input type="text" wire:model="products.{{ $index }}.price" class="form-control" onfocus="this.select()">
                @error('products.'.$index.'.price')<div class="text-danger">{{ $message }}</div>@enderror
              </td>
              <td>
                <table class="table-condensed joytable">
                  <tbody>
                    @if(!empty($product->idCodesData))
                      @foreach($product->idCodesData as $idCode => $count)
                        <tr>
                          <td class="id-codes">
                            <div class="input-group">
                              <input type="text" class="form-control" wire:model="idCodes.{{ $index }}.{{ $i }}" placeholder="Артикул">
                              <span wire:click="findByIdCode('{{ $idCode }}', '{{ $product->id }}')" class="input-group-addon" style="cursor: pointer;"><i class="material-icons md-18">search</i></span>
                            </div>
                          </td>
                          <td class="@error('idCodesCount.'.$index.'.'.$i) has-error @enderror">
                            <input type="text" class="form-control" wire:model="idCodesCount.{{ $index }}.{{ $i }}" placeholder="Кол-во" onfocus="this.select()">
                          </td>
                        </tr>
                        <?php $i++; ?>
                      @endforeach
                    @else
                      <tr>
                        <td>
                          <div class="input-group">
                            <input type="text" class="form-control" wire:model="idCodes.{{ $index }}.{{ $i }}" placeholder="Артикул">
                          </div>
                        </td>
                        <td class="@error('idCodesCount.'.$index.'.'.$i) has-error @enderror">
                          <input type="text" class="form-control" wire:model="idCodesCount.{{ $index }}.{{ $i }}" placeholder="Кол-во" onfocus="this.select()">
                        </td>
                      </tr>
                      <?php $i++; ?>
                    @endif
                  </tbody>
                </table>
              </td>
              <td class="text-nowrap">
                <select wire:model="products.{{ $index }}.category_id" class="form-control">
                  <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $product) { ?>
                    <?php foreach ($nodes as $node) : ?>
                      <option value="{{ $node['id'] }}" <?php if ($product->category_id == $node['id']) echo "selected"; ?>>{{ PHP_EOL.$prefix.' '.$node['title'] }}</option>
                      <?php $traverse($node['children'], $prefix.'___'); ?>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                </select>
                @error('products.'.$index.'.categories')<div class="text-danger">{{ $message }}</div>@enderror
              </td>
              <td class="text-right">
                <div class="dropdown">
                  <?php
                    $modeTitle = 'No mode';

                    if($product->modes->count()) {
                      $modeTitle = unserialize($product->modes->first()->title);
                      $modeTitle = $modeTitle[$lang]['title'];
                    }
                  ?>
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownModes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?php echo $modeTitle; ?> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownModes">
                    @foreach($modes as $mode)
                      <?php $titles = unserialize($mode->title); ?>
                      <li>
                        <a href="#">
                          <label><input type="checkbox" wire:model="products.{{ $index }}.modes_id" value="{{ $mode->id }}"> {{ $titles[$lang]['title'] }}</label>
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
                @error('products.'.$index.'.modes_id')<div class="text-danger">{{ $message }}</div>@enderror
              </td>
            </tr>

            @if(count($sameProducts) >= 1 && $product->id == $productId)

              <tr class="info text-center">
                <td colspan="6">
                  <button wire:click="addField('{{ $index }}')" type="button" class="btn btn-link btn-xs"><i class="material-icons md-18">add</i> Добавить артикул</button>
                </td>
              </tr>

              @foreach($sameProducts as $sameIndex => $sameProduct)
                <tr class="success">
                  <td><img src="/img/products/{{ $sameProduct->path.'/'.$sameProduct->image }}" class="img-responsive" style="width:80px;height:auto;"></td>
                  <td class="cell-size">
                    <textarea name="title" class="form-control" rows="3">{{ $sameProduct->title }}</textarea>
                    <div>Meta title:</div>
                    <textarea name="title" class="form-control" rows="3">{{ $sameProduct->meta_title }}</textarea>
                  </td>
                  <!-- <td>
                    <input type="text" name="purchase_price" class="form-control" value="{{ $sameProduct->purchase_price }}">
                  </td>
                  <td>
                    <input type="text" name="wholesale_price" class="form-control" value="{{ $sameProduct->wholesale_price }}">
                  </td> -->
                  <td>
                    <input type="text" name="price" class="form-control" value="{{ $sameProduct->price }}">
                  </td>
                  <td>
                    <table class="table-condensed joytable">
                      <tbody>
                        <tr>
                          <td class="id-codes">
                            <div class="input-group">
                              <input type="text" name="" value="{{ $sameProduct->id_codes }}" class="form-control" placeholder="Артикул">
                              <a wire:click="deleteProduct('{{ $sameIndex }}')" class="input-group-addon" style="cursor: pointer;"><i class="material-icons md-18">delete</i></a>
                            </div>
                          </td>
                          <td>
                            <input type="text" name="" value="{{ $sameProduct->count }}" class="form-control" placeholder="Кол-во">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td class="text-nowrap">
                    <select class="form-control">
                      <?php $categoryId = $sameProduct->category_id;  ?>
                      <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $categoryId) { ?>
                        <?php foreach ($nodes as $node) : ?>
                          <option value="{{ $node['id'] }}" <?php if ($categoryId == $node['id']) echo "selected"; ?>>{{ PHP_EOL.$prefix.' '.$node['title'] }}</option>
                          <?php $traverse($node['children'], $prefix.'___'); ?>
                        <?php endforeach; ?>
                      <?php }; ?>
                      <?php $traverse($categories); ?>
                    </select>
                  </td>
                  <td class="text-nowrap">
                    <select class="form-control">
                      <?php foreach ($modes as $mode) : ?>
                        <?php $titles = unserialize($mode->title); ?>
                        <option value="{{ $mode['id'] }}" <?php if ($product->modes->contains($mode->id)) echo "selected"; ?>>{{ $titles[$lang]['title'] }}</option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                </tr>
              @endforeach
            @elseif($dataAlert && $product->id == $productId)
              <tr class="warning text-center">
                <td colspan="6">No data</td>
              </tr>
            @endif
          @else
            <tr>
              <td><input type="checkbox" name="products_id[]" value="{{ $product->id }}" class="checkbox-ids"></td>
              <td><img src="/img/products/{{ $product->path.'/'.$product->image }}" class="img-responsive" style="width:80px;height:auto;"></td>
              <td class="cell-size">{{ $product->title }}</td>
              <!-- <td>{{ $product->purchase_price }}</td>
              <td>{{ $product->wholesale_price }}</td> -->
              <td>{{ $product->price }}</td>
              <td>
                <?php $idCodesData = json_decode($product->id_codes, true) ?? ['' => 0]; ?>
                @foreach($idCodesData as $idCode => $count)
                  {{ $idCode.' - '.$count }}шт<br>
                @endforeach
              </td>
              <td class="text-nowrap">{{ $product->category->title }}</td>
              <td class="text-nowrap">
                @foreach($product->modes as $mode)
                  <?php $titles = unserialize($mode->title); ?>
                  {{ $titles[$lang]['title'] }}<br>
                @endforeach
              </td>
              <td class="text-{{ trans('statuses.product.'.$product->status.'.style') }}">{{ trans('statuses.product.'.$product->status.'.title') }}</td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $productsItems->links() }}

</div>
