
  <!-- Brands and Models -->
  <div class="container">
    <div class="product-tabs product-tabs--sticky-">

      <div class="product-tabs__list">
        <div class="product-tabs__list-body">
          <div class="product-tabs__list-container container">
            @foreach($companies as $key => $company)
              <a href="#tab-{{ $company->id }}" class="product-tabs__item @if($key == 0) product-tabs__item--active @endif">
                <img src="/img/companies/{{ $company->image }}" class="img-responsive" width="auto" height="60">
              </a>
            @endforeach
          </div>
        </div>
      </div>
      <div class="product-tabs__content product-tabs-custom">
        <?php foreach($projects as $project) : ?>
          <div class="product-tabs__pane product-tabs__pane--active" id="tab-{{ $project->company_id }}">
            <div class="card-columns card-columns-custom">
              <?php foreach($project->children as $child) : ?>
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title"><a href="/b/{{ $companies->firstWhere('id', $project->company_id)->slug.'/'.$child->slug.'/'.$child->id }}">{{ $child->title }}</a></h5>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
