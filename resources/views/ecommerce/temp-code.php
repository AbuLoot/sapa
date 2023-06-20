  <!-- Button of favourite -->
  <button class="btn btn-secondary btn-sm btn-svg-icon <?php if (is_array($favorite) AND in_array($product->id, $favorite['products_id'])) echo 'btn-liked'; ?>" type="button" data-favourite-id="{{ $product->id }}" onclick="toggleFavourite(this);">
    <svg width="18px" height="18px"><use xlink:href="/img/sprite.svg#wishlist-16"></use></svg>
  </button>