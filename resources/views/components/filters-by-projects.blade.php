
                  <div class="widget-filters__item">
                    <div class="filter filter--opened" data-collapse-item>
                      <button type="button" class="filter__title text-uppercase" data-collapse-trigger>
                        Марки & модели
                        <svg class="filter__arrow" width="12px" height="7px">
                          <use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use>
                        </svg>
                      </button>
                      <div class="filter__body" data-collapse-content>
                        <div class="filter__container">
                          <div class="filter-categories-alt">
                            <ul class="filter-categories-alt__list filter-categories-alt__list--level--1" data-collapse-opened-class="filter-categories-alt__item--open">
                              <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
                                <?php foreach ($projects as $project) : ?>
                                  <li class="filter-categories-alt__item filter-categories-alt__item--open- filter-categories-alt__item--current" data-collapse-item>
                                    <button class="filter-categories-alt__expander" data-collapse-trigger></button>

                                    <label class="filter-list__item ">
                                      <span class="filter-list__input input-check">
                                        <span class="input-check__body">
                                          <input class="input-check__input" type="checkbox">
                                          <span class="input-check__box"></span>
                                          <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                        </span>
                                      </span>
                                      <span class="filter-list__title">{{ $project->title }}</span>
                                    </label>
                                    <!-- <a href="/b/{{ $project->slug .'/'. $project->id }}"><input class="input-check__input-" type="checkbox"> {{ $project->title }}</a> -->
                                    <div class="filter-categories-alt__children" data-collapse-content>
                                      <ul class="filter-categories-alt__list filter-categories-alt__list--level--2">
                                        <?php foreach ($project->children as $child) : ?>
                                          <?php if ($child->children->count() > 1) : ?>
                                            <li class="filter-categories-alt__item filter-categories-alt__item--current" data-collapse-item>
                                              <button class="filter-categories-alt__expander" data-collapse-trigger></button>

                                              <label class="filter-list__item ">
                                                <span class="filter-list__input input-check">
                                                  <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox">
                                                    <span class="input-check__box"></span>
                                                    <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                                  </span>
                                                </span>
                                                <span class="filter-list__title">{{ $child->title }}</span>
                                              </label>
                                              <div class="filter-categories-alt__children" data-collapse-content>
                                                <ul class="filter-categories-alt__list filter-categories-alt__list--level--3">
                                                  <?php foreach ($child->children as $subchild) : ?>
                                                    <li class="filter-categories-alt__item filter-categories__item" data-collapse-item>

                                                      <label class="filter-list__item ">
                                                        <span class="filter-list__input input-check">
                                                          <span class="input-check__body">
                                                            <input class="input-check__input" type="checkbox">
                                                            <span class="input-check__box"></span>
                                                            <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                                          </span>
                                                        </span>
                                                        <span class="filter-list__title">{{ $subchild->title }}</span>
                                                      </label>
                                                    </li>
                                                  <?php endforeach; ?>
                                                </ul>
                                              </div>
                                            </li>
                                          <?php else : ?>
                                            <li class="filter-categories__item filter-categories-alt__item">

                                              <label class="filter-list__item ">
                                                <span class="filter-list__input input-check">
                                                  <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox">
                                                    <span class="input-check__box"></span>
                                                    <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                                  </span>
                                                </span>
                                                <span class="filter-list__title">{{ $child->title }}</span>
                                              </label>
                                              <!-- <a href="/c/{{ $child->slug.'/'.$child->id }}"><input class="input-check__input-" type="checkbox"> {{ $child->title }}</a> -->
                                            </li>
                                          <?php endif; ?>
                                        <?php endforeach; ?>
                                      </ul>
                                    </div>
                                  </li>
                                <?php endforeach; ?>
                              <?php }; ?>
                              <?php $traverse($projects); ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="widget-filters__item">
                    <div class="filter filter--opened" data-collapse-item>
                      <button type="button" class="filter__title text-uppercase" data-collapse-trigger>
                        Марки & модели
                        <svg class="filter__arrow" width="12px" height="7px">
                          <use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use>
                        </svg>
                      </button>
                      <div class="filter__body" data-collapse-content>
                        <div class="filter__container">
                          <div class="filter-categories-alt">
                            <ul class="filter-categories-alt__list filter-categories-alt__list--level--1" data-collapse-opened-class="filter-categories-alt__item--open">
                              <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
                                <?php foreach ($projects as $project) : ?>
                                  <li class="filter-categories-alt__item filter-categories-alt__item--open filter-categories-alt__item--current" data-collapse-item>
                                    <button class="filter-categories-alt__expander" data-collapse-trigger></button>

                                    <a href="#/b/{{ $project->slug .'/'. $project->id }}"><input class="input-check__input-" type="checkbox"> {{ $project->title }}</a>
                                    <div class="filter-categories-alt__children" data-collapse-content>
                                      <ul class="filter-categories-alt__list filter-categories-alt__list--level--2">
                                        <?php foreach ($project->children as $child) : ?>
                                          <?php if ($child->children->count() > 1) : ?>
                                            <li class="filter-categories-alt__item filter-categories-alt__item--current" data-collapse-item>
                                              <button class="filter-categories-alt__expander" data-collapse-trigger></button>

                                              <div class="filter-categories-alt__children" data-collapse-content>
                                                <ul class="filter-categories-alt__list filter-categories-alt__list--level--3">
                                                  <?php foreach ($child->children as $subchild) : ?>
                                                    <li class="filter-categories-alt__item filter-categories__item" data-collapse-item>

                                                      <a href="#/b/{{ $subchild->slug.'/'.$subchild->id }}"><input class="input-check__input-" type="checkbox"> {{ $subchild->title }}</a>
                                                    </li>
                                                  <?php endforeach; ?>
                                                </ul>
                                              </div>
                                            </li>
                                          <?php else : ?>
                                            <li class="filter-categories__item filter-categories-alt__item">
                                              <a href="#/b/{{ $child->slug.'/'.$child->id }}"><input class="input-check__input-" type="checkbox"> {{ $child->title }}</a>
                                            </li>
                                          <?php endif; ?>
                                        <?php endforeach; ?>
                                      </ul>
                                    </div>
                                  </li>
                                <?php endforeach; ?>
                              <?php }; ?>
                              <?php $traverse($projects); ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div class="widget-filters__item">
                    <div class="filter filter--opened" data-collapse-item>
                      <!-- <button type="button" class="filter__title text-uppercase" data-collapse-trigger> -->
                        <!-- Марки & модели <svg class="filter__arrow" width="12px" height="7px"><use xlink:href="/img/sprite.svg#arrow-rounded-down-12x7"></use></svg> -->
                      <!-- </button> -->
                      <div class="filter__body" data-collapse-content>
                        <div class="filter__container">
                          <div class="filter-categories-alt">
                            <ul class="filter-categories-alt__list filter-categories-alt__list--level--1" data-collapse-opened-class="filter-categories-alt__item--open">
                              <?php $traverse = function ($projects, $parent_slug = NULL) use (&$traverse) { ?>
                                <?php foreach ($projects as $project) : ?>
                                  <?php if ($project->children->count() > 0) : ?>
                                    <li class="filter-categories-alt__item filter-categories-alt__item--open- filter-categories-alt__item--current" data-collapse-item>
                                      <button class="filter-categories-alt__expander" data-collapse-trigger></button>
                                      <a href="/b/{{ $project->slug .'/'. $project->id }}"><input class="input-check__input-" type="checkbox"> {{ $project->title }}</a>
                                      <div class="filter-categories-alt__children" data-collapse-content>
                                        <ul class="filter-categories-alt__list filter-categories-alt__list--level--2">
                                          <?php foreach ($project->children as $child) : ?>
                                            <li class="filter-categories__item filter-categories-alt__item">

                                              <label class="filter-list__item ">
                                                <span class="filter-list__input input-check">
                                                  <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox">
                                                    <span class="input-check__box"></span>
                                                    <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                                  </span>
                                                </span>
                                                <span class="filter-list__title">{{ $project->title }}</span>
                                              </label>
                                            </li>
                                          <?php endforeach; ?>
                                        </ul>
                                      </div>
                                    </li>
                                  <?php else : ?>
                                    <li class="filter-categories-alt__item" data-collapse-item>
                                      <label class="filter-list__item ">
                                        <span class="filter-list__input input-check">
                                          <span class="input-check__body">
                                            <input class="input-check__input" type="checkbox">
                                            <span class="input-check__box"></span>
                                            <svg class="input-check__icon" width="9px" height="7px"><use xlink:href="images/sprite.svg#check-9x7"></use></svg>
                                          </span>
                                        </span>
                                        <span class="filter-list__title">{{ $project->title }}</span>
                                      </label>
                                    </li>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              <?php }; ?>
                              <?php // $traverse($projects); ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
