        <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
          <?php foreach ($projects as $project) : ?>
            <div class="product-tabs__pane product-tabs__pane--active" id="tab-{{ $project->company_id }}">
              <div class="row">
                <?php foreach ($project->children->chunk(4) as $chunk) : ?>
                  <div class="col-3">
                    <?php foreach($chunk as $child) : ?>
                    <ul class="megamenu__links megamenu__links--level--0">
                      <li class="megamenu__item  megamenu__item--with-submenu ">
                        <a href="/b/{{ $child->slug .'/'. $child->id }}">{{ $child->title }}</a>
                        <?php if($child->descendants->count() > 0) : ?>
                          <ul class="megamenu__links megamenu__links--level--1">
                            <?php foreach ($child->children as $sub_child) : ?>
                              <li class="megamenu__item"><a href="/b/{{ $sub_child->slug .'/'. $sub_child->id }}">{{ $sub_child->title }}</a></li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    </ul><br>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($projects); ?>

        <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
          <?php foreach ($projects as $project) : ?>
            <div class="product-tabs__pane product-tabs__pane--active" id="tab-{{ $project->company_id }}">
              <div class="row">
                <?php foreach ($project->children as $child) : ?>
                  <div class="col-3 float-right float-left">
                    <ul class="megamenu__links megamenu__links--level--0">
                      <li class="megamenu__item  megamenu__item--with-submenu ">
                        <a href="/b/{{ $child->slug .'/'. $child->id }}">{{ $child->title }}</a>
                        <?php if($child->descendants->count() > 0) : ?>
                          <ul class="megamenu__links megamenu__links--level--1">
                            <?php foreach ($child->children as $sub_child) : ?>
                              <li class="megamenu__item"><a href="/b/{{ $sub_child->slug .'/'. $sub_child->id }}">{{ $sub_child->title }}</a></li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    </ul><br>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($projects); ?>

        <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
          <?php foreach ($projects as $project) : ?>
            <div class="product-tabs__pane- -product-tabs__pane--active" id="tab-{{ $project->company_id }}">
              <div class="row-">
                <?php foreach ($project->children as $child) : ?>
                  <div class="card-columns">
                    <?php if($child->descendants->count() > 0) : ?>
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">{{ $child->title }}</h5>
                          <ul class="col-md-10 col-12 mb-3">
                            <?php foreach ($child->children as $sub_child) : ?>
                              <li href="/b/{{ $sub_child->slug .'/'. $sub_child->id }}">{{ $sub_child->title }}</li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </div>
                    <?php else : ?>
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title"><a href="/b/{{ $sub_child->slug .'/'. $sub_child->id }}"><b>{{ $child->title }}</b></a></h5>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php }; ?>
        <?php //$traverse($projects); ?>