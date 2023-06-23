
  <div class="account-nav flex-grow-1">
    <h4 class="account-nav__title">Навигация</h4>
    <ul>
      <li class="account-nav__item ">
        <a href="/profile">Моя страница</a>
      </li>
      @can('viewAny', App\Models\Product::class)
      <li class="account-nav__item ">
        <a href="/user-products">Мои товары</a>
      </li>
      @endcan
      <li class="account-nav__item ">
        <a href="/statistics">Статистика</a>
      </li>
      <li class="account-nav__item ">
        <a href="/profile/edit">Редактировать профиль</a>
      </li>
      <li class="account-nav__item ">
        <a href="/orders">История заказов</a>
      </li>
      <li class="account-nav__item ">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </div>