@extends('pos.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <p class="text-right">
    <a href="/{{ $lang }}/pos/units" class="btn btn-primary"><i class="material-icons md-18">arrow_back</i></a>
  </p>
  <div class="row">
    <div class="col-md-7">
      <div class="panel panel-default">
        <div class="panel-body">
          <form action="{{ route('units.update', [$lang, $unit->id]) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="title">Название</label>
              <input type="text" class="form-control" id="title" name="title" maxlength="255" value="{{ (old('title')) ? old('title') : $unit->title }}" required>
            </div>
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="255" value="{{ (old('slug')) ? old('slug') : $unit->slug }}">
            </div>
            <div class="form-group">
              <label for="description">Описание</label>
              <textarea class="form-control" id="description" name="description" rows="5">{{ (old('description')) ? old('description') : $unit->description }}</textarea>
            </div>
            <div class="form-group">
              <label for="lang">Язык</label>
              <select id="lang" name="lang" class="form-control" required>
                @foreach($languages as $language)
                  @if ($unit->lang == $language->slug)
                    <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
                  @else
                    <option value="{{ $language->slug }}">{{ $language->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="status">Статус:</label>
              <label>
                <input type="checkbox" id="status" name="status" @if ($unit->status == 1) checked @endif> Активен
              </label>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection