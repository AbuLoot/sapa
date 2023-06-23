@extends('layout')

@section('meta_title', $project->meta_title ?? $project->title)

@section('meta_description', $project->meta_title ?? $project->title)

@section('content')

  <br>
  <div class="page-header__container container">
    <div class="page-header__title">
      <h1>{{ $project->title }}</h1>
    </div>
  </div>
  <!-- Products 1 -->
  <div class="container">
    <div class="row row-custom">
      @foreach ($project->children->where('status', '<>', 0) as $child)
        <div class="col-md-3 col-6">
          <div class="card text-center">
            <a href="/b/{{ $project->slug.'/'.$child->slug.'/'.$child->id }}">
              <img class="img-fluid" src="/file-manager/{{ ($child->image == true) ? $child->image : 'no-image-mini.png' }}" alt="{{ $child->title }}"><br>
              {{ $child->title }}
            </a>
          </div><br>
        </div>
      @endforeach
    </div>
  </div>
@endsection
