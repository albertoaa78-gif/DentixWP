<?php
/**
 * search.php — Resultados de búsqueda (busca en productos WooCommerce por nombre y SKU)
 */
get_header();
?>

<div class="breadcrumb">
  <a href="<?php echo home_url(); ?>">Inicio</a>
  <span>›</span>
  <strong>Resultados para: <?php echo esc_html(get_search_query()); ?></strong>
</div>

<div style="padding:48px 60px 80px;max-width:1440px;margin:0 auto">
  <div style="margin-bottom:32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div>
      <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:var(--dark-main)">
        Resultados para: <em><?php echo esc_html(get_search_query()); ?></em>
      </h1>
      <?php if (have_posts()) : ?>
        <p style="font-size:13px;color:var(--gray-mid);margin-top:6px">
          <?php echo sprintf(_n('%s resultado encontrado', '%s resultados encontrados', $wp_query->found_posts, 'dentix'), number_format_i18n($wp_query->found_posts)); ?>
        </p>
      <?php endif; ?>
    </div>
    <!-- Nueva búsqueda -->
    <form role="search" method="get" action="<?php echo home_url('/'); ?>" style="display:flex;gap:8px">
      <div class="search-outer" style="max-width:320px">
        <input type="search" name="s" placeholder="Nueva búsqueda…" value="<?php echo esc_attr(get_search_query()); ?>">
        <input type="hidden" name="post_type" value="product">
        <button type="submit" class="search-btn">Buscar</button>
      </div>
    </form>
  </div>

  <?php if (have_posts()) : ?>
    <div class="pcard-grid">
      <?php while (have_posts()) : the_post();
        $product = wc_get_product(get_the_ID());
        if (!$product) continue;
        $img = get_the_post_thumbnail_url(get_the_ID(), 'dentix-product-thumb');
        $sku = $product->get_sku();
        $brand_terms = wp_get_post_terms(get_the_ID(), 'pa_marca');
        $brand = !empty($brand_terms) && !is_wp_error($brand_terms) ? $brand_terms[0]->name : '';
      ?>
        <?php
        $cat_terms_s = wp_get_post_terms(get_the_ID(), 'product_cat', ['number'=>1]);
        $cat_name_s  = (!is_wp_error($cat_terms_s) && !empty($cat_terms_s)) ? $cat_terms_s[0]->name : '';
        $cat_slug_s  = (!is_wp_error($cat_terms_s) && !empty($cat_terms_s)) ? $cat_terms_s[0]->slug : '';
        ?>
        <a href="<?php the_permalink(); ?>" class="pcard">
          <div class="pcard-img">
            <?php if ($img) : ?>
              <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
            <?php else : ?>
              <div class="pcard-noimg"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="8" y="12" width="32" height="24" rx="3"/></svg></div>
            <?php endif; ?>
          </div>
          <div class="pcard-body">
            <?php if ($cat_name_s) : ?><span class="pcard-cat pcard-cat-<?php echo esc_attr($cat_slug_s); ?>"><?php echo esc_html($cat_name_s); ?></span><?php endif; ?>
            <div class="pcard-name"><?php the_title(); ?></div>
            <div class="pcard-meta">
              <?php if ($brand) echo '<span class="pcard-brand">' . esc_html($brand) . '</span>'; ?>
              <?php if ($sku) echo '<span class="pcard-sku">REF ' . esc_html($sku) . '</span>'; ?>
            </div>
            <div class="pcard-footer">
              <div class="pcard-price"><span class="pcard-price-current"><?php echo $product->get_price_html(); ?></span></div>
              <button class="pcard-add" onclick="event.preventDefault();dentixAddToCart(<?php echo get_the_ID(); ?>,this)">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              </button>
            </div>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
    <!-- Paginación -->
    <div style="margin-top:48px;display:flex;justify-content:center">
      <?php echo paginate_links(['type' => 'list', 'prev_text' => '‹', 'next_text' => '›']); ?>
    </div>
  <?php else : ?>
    <div style="text-align:center;padding:80px 0">
      <div style="font-size:48px;margin-bottom:16px">🔍</div>
      <h2 style="font-family:'Playfair Display',serif;font-size:24px;color:var(--dark-main);margin-bottom:12px">
        No encontramos resultados para "<?php echo esc_html(get_search_query()); ?>"
      </h2>
      <p style="color:var(--gray-mid);font-size:14px;margin-bottom:32px">
        Intenta buscar por referencia de producto, SKU o nombre de marca.<br>
        También puedes buscar con menos palabras o revisar la ortografía.
      </p>
      <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn-red" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;background:var(--red);color:white;border-radius:8px;font-weight:600">
        Ver catálogo completo
      </a>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
