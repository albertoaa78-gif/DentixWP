<?php
/**
 * front-page.php — Homepage Dentix v5.5
 * Carrusel original din8 + especialidades dinámicas de WooCommerce
 */
get_header();
?>

<!-- ═══ HERO con carrusel ════════════════════════════════════ -->
<section class="hero">

  <!-- Carrusel de fondo — 5 escenas CSS del sector dental -->
  <div class="hero-carousel">
    <div class="hero-slide hs1 active"></div>
    <div class="hero-slide hs2"></div>
    <div class="hero-slide hs3"></div>
    <div class="hero-slide hs4"></div>
    <div class="hero-slide hs5"></div>
    <div class="hero-carousel-overlay"></div>
  </div>

  <!-- Círculos decorativos del diseño validado index1 -->
  <div class="hero-circle-red"></div>
  <div class="hero-circle-white"></div>

  <!-- Dots de navegación -->
  <div class="carousel-dots" id="carouselDots">
    <div class="cdot active" data-slide="0"></div>
    <div class="cdot" data-slide="1"></div>
    <div class="cdot" data-slide="2"></div>
    <div class="cdot" data-slide="3"></div>
    <div class="cdot" data-slide="4"></div>
  </div>

  <!-- Izquierda — titular dinámico por slide -->
  <div class="hero-left">
    <div class="hero-eyebrow">
      <div class="hero-eline"></div>
      <span class="hero-etag" id="slideTag">Distribuidor oficial · España</span>
    </div>

    <h1 class="hero-h1" id="slideTitle">El instrumental<br>que tu clínica<br><em>merece.</em></h1>
    <p class="hero-h1-line2" id="slideSubtitle">Precisión. Calidad. Garantía Profesional.</p>

    <p class="hero-desc" id="slideDesc">
      Más de <strong>10.000 referencias</strong> de instrumental odontológico profesional.
      Marcas líderes mundiales, precios B2B exclusivos y entrega garantizada
      en <strong>24–48h</strong> para toda España.
    </p>

    <div class="hero-ctas">
      <?php
      $shop_url      = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/tienda/');
      $novedades_term = get_term_by('slug', 'novedades', 'product_cat');
      $novedades_url  = $novedades_term ? get_term_link($novedades_term) : $shop_url;
      ?>
      <a href="<?php echo esc_url($shop_url); ?>" class="btn-red" id="slideCta1">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
        <span id="slideCta1Text">Explorar catálogo</span>
      </a>
      <a href="<?php echo esc_url($novedades_url); ?>" class="btn-outline-d">Ver novedades</a>
    </div>

    <div class="hero-stats">
      <div class="stat">
        <div class="stat-n">10<sup>K+</sup></div>
        <div class="stat-l">Referencias en catálogo</div>
      </div>
      <div class="stat">
        <div class="stat-n">48<sup>h</sup></div>
        <div class="stat-l">Entrega máx. España</div>
      </div>
      <div class="stat">
        <div class="stat-n">20<sup>+</sup></div>
        <div class="stat-l">Años distribuyendo</div>
      </div>
    </div>
  </div>

  <!-- Derecha — productos showcase (dinámico) -->
  <div class="hero-right">
    <div class="hero-showcase">
      <?php
      // Obtener primeros 3 productos destacados o recientes para mostrar
      $showcase_items = function_exists('wc_get_products') ? wc_get_products([
        'limit'  => 3,
        'status' => 'publish',
        'orderby'=> 'popularity',
        'order'  => 'DESC',
      ]) : [];
      $shop_url_sc = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/tienda/');

      if (!empty($showcase_items)) :
        $labels = ['★ Más vendido', 'Novedad', 'En oferta'];
        $classes= ['badge-best', 'badge-new', 'badge-sale'];
        $colors = ['rgba(192,57,43,0.25)', 'rgba(52,152,219,0.18)', 'rgba(76,175,80,0.18)'];
        foreach ($showcase_items as $i => $sp) :
          $sp_img   = get_the_post_thumbnail_url($sp->get_id(), 'thumbnail');
          $sp_price = $sp->get_price_html();
          $sp_sku   = $sp->get_sku();
          $sp_url   = get_permalink($sp->get_id());
          $is_first = ($i === 0);
      ?>
        <a href="<?php echo esc_url($sp_url); ?>"
           class="hsc<?php echo $is_first ? ' hsc-featured' : ''; ?>">
          <div class="hsc-img" style="background:<?php echo $colors[$i] ?? 'rgba(100,100,100,0.2)'; ?>">
            <?php if ($sp_img) : ?>
              <img src="<?php echo esc_url($sp_img); ?>"
                   alt="<?php echo esc_attr($sp->get_name()); ?>"
                   style="width:48px;height:48px;object-fit:contain;border-radius:6px">
            <?php else : ?>
              <svg width="38" height="38" viewBox="0 0 38 38" fill="none">
                <rect x="8" y="10" width="22" height="18" rx="3" fill="white" opacity=".6"/>
                <line x1="14" y1="16" x2="24" y2="16" stroke="white" stroke-width="2" opacity=".8"/>
                <line x1="14" y1="21" x2="20" y2="21" stroke="white" stroke-width="2" opacity=".6"/>
              </svg>
            <?php endif; ?>
          </div>
          <?php if ($is_first) : ?><div class="hsc-info"><?php endif; ?>
          <span class="hsc-badge <?php echo $classes[$i] ?? ''; ?>">
            <?php echo esc_html($labels[$i] ?? ''); ?>
          </span>
          <div class="hsc-name"><?php echo esc_html($sp->get_name()); ?></div>
          <?php if ($sp_sku) : ?>
            <div class="hsc-ref">REF. <?php echo esc_html($sp_sku); ?></div>
          <?php endif; ?>
          <div class="hsc-price"><?php echo $sp_price; ?></div>
          <?php if ($is_first) : ?></div><?php endif; ?>
          <?php if (!$is_first) : ?><div class="hsc-cta">Ver →</div><?php endif; ?>
        </a>
      <?php endforeach;
      else : // Si no hay productos, mostrar enlace a la tienda ?>
        <a href="<?php echo esc_url($shop_url_sc); ?>" class="hsc hsc-featured">
          <div class="hsc-info">
            <span class="hsc-badge badge-best">Catálogo</span>
            <div class="hsc-name">Ver todos los productos</div>
            <div class="hsc-cta">Explorar →</div>
          </div>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ═══ TRUST BAR ═════════════════════════════════════════════ -->
<div class="trust">
  <div class="trust-item">
    <span class="t-icon">🔒</span>
    <div class="t-txt">
      <strong>Solo profesionales</strong>
      <span>Acceso acreditado B2B</span>
    </div>
  </div>
  <div class="trust-item">
    <span class="t-icon">🚚</span>
    <div class="t-txt">
      <strong>Envío gratis +150€</strong>
      <span>Toda España</span>
    </div>
  </div>
  <div class="trust-item">
    <span class="t-icon">⏱</span>
    <div class="t-txt">
      <strong>Entrega 24–48h</strong>
      <span>95% mismo día</span>
    </div>
  </div>
  <div class="trust-item">
    <span class="t-icon">🔄</span>
    <div class="t-txt">
      <strong>Stock en tiempo real</strong>
      <span>Sincronizado con ERP</span>
    </div>
  </div>
  <div class="trust-item">
    <span class="t-icon">↩️</span>
    <div class="t-txt">
      <strong>Devolución 30 días</strong>
      <span>Sin preguntas</span>
    </div>
  </div>
</div>

<?php if (dentix_opt('show_cats', 1)) :
  $wc_cats = dentix_get_wc_categories();
  if (!empty($wc_cats)) : ?>

<!-- ═══ ESPECIALIDADES ══════════════════════════════════════════ -->
<section class="sec-cats">
  <div class="sec-header">
    <div class="sec-pre">Catálogo organizado por especialidad</div>
    <h2 class="sec-title">Elige tu especialidad</h2>
    <p class="sec-desc">
      <?php echo esc_html(get_option('woocommerce_catalog_count', '2.500')); ?> referencias
      distribuidas en <?php echo count($wc_cats); ?> especialidades odontológicas.
    </p>
  </div>
  <div class="cats-grid">
    <?php foreach ($wc_cats as $cat) : ?>
      <a href="<?php echo esc_url($cat['url']); ?>" class="cat-card">
        <div class="cat-icon-wrap" style="background:<?php echo esc_attr($cat['color']); ?>">
          <?php if (!empty($cat['image'])) : ?>
            <img src="<?php echo esc_url($cat['image']); ?>"
                 alt="<?php echo esc_attr($cat['label']); ?>"
                 class="cat-img">
          <?php else : ?>
            <span class="cat-icon"><?php echo $cat['icon']; ?></span>
          <?php endif; ?>
        </div>
        <div class="cat-info">
          <div class="cat-name"><?php echo esc_html($cat['label']); ?></div>
          <div class="cat-desc"><?php echo esc_html($cat['desc']); ?></div>
          <?php if ($cat['count'] > 0) : ?>
            <div class="cat-count"><?php echo $cat['count']; ?> referencias</div>
          <?php endif; ?>
        </div>
        <div class="cat-arrow">→</div>
      </a>
    <?php endforeach; ?>
  </div>
  <div style="text-align:center;margin-top:40px">
    <?php
    $shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/tienda/');
    ?>
    <a href="<?php echo esc_url($shop_url); ?>" class="btn-catalog">
      Ver catálogo completo — todas las referencias
    </a>
  </div>
</section>

<?php endif; endif; ?>

<?php if (dentix_opt('show_featured', 1)) :

// ── Consultas dinámicas de WooCommerce ───────────────────────
$productos_nuevos    = function_exists('wc_get_products') ? wc_get_products(['limit'=>8,'status'=>'publish','orderby'=>'date','order'=>'DESC']) : [];
$productos_vendidos  = function_exists('wc_get_products') ? wc_get_products(['limit'=>8,'status'=>'publish','orderby'=>'popularity','order'=>'DESC']) : [];
$productos_oferta    = function_exists('wc_get_products') ? wc_get_products(['limit'=>8,'status'=>'publish','on_sale'=>true]) : [];

// Fallback: si no hay productos de oferta o vendidos, usar los nuevos
if (empty($productos_vendidos)) $productos_vendidos = $productos_nuevos;
if (empty($productos_oferta))   $productos_oferta   = $productos_nuevos;

$shop_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/tienda/');

if (!empty($productos_nuevos)) : ?>

<!-- ═══ PRODUCTOS — 3 SECCIONES DINÁMICAS ══════════════════════ -->
<section class="sec-featured">
  <div class="sec-header">
    <div class="sec-pre">Selección Dentix</div>
    <h2 class="sec-title">Productos</h2>
  </div>

  <!-- Pestañas -->
  <div class="prod-tabs">
    <button class="prod-tab on" data-tab="nuevos">Últimas incorporaciones</button>
    <button class="prod-tab" data-tab="vendidos">Más vendidos</button>
    <button class="prod-tab" data-tab="oferta">En oferta</button>
  </div>
  <!-- Helper para renderizar tarjetas -->
  <?php
  function dentix_render_product_cards(array $products): void {
    foreach ($products as $product) :
      $img         = get_the_post_thumbnail_url($product->get_id(), 'dentix-product-thumb');
      $sku         = $product->get_sku();
      $on_sale     = $product->is_on_sale();
      $reg_price   = $product->get_regular_price();
      $sale_price  = $product->get_sale_price();
      $brand_terms = wp_get_post_terms($product->get_id(), 'pa_marca');
      $brand       = (!is_wp_error($brand_terms) && !empty($brand_terms)) ? $brand_terms[0]->name : '';
      $cat_terms   = wp_get_post_terms($product->get_id(), 'product_cat', ['number'=>1]);
      $cat_name    = (!is_wp_error($cat_terms) && !empty($cat_terms)) ? $cat_terms[0]->name : '';
      $cat_slug    = (!is_wp_error($cat_terms) && !empty($cat_terms)) ? $cat_terms[0]->slug : '';
      $discount    = ($on_sale && $reg_price && $sale_price) ? round((($reg_price - $sale_price) / $reg_price) * 100) : 0;
  ?>
    <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"
       class="pcard" title="<?php echo esc_attr($product->get_name()); ?>">
      <div class="pcard-img">
        <?php if ($img) : ?>
          <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="lazy">
        <?php else : ?>
          <div class="pcard-noimg"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="8" y="12" width="32" height="24" rx="3"/><line x1="16" y1="20" x2="32" y2="20"/></svg></div>
        <?php endif; ?>
        <?php if ($discount > 0) : ?><span class="pcard-discount">−<?php echo $discount; ?>%</span><?php endif; ?>
      </div>
      <div class="pcard-body">
        <?php if ($cat_name) : ?><span class="pcard-cat pcard-cat-<?php echo esc_attr($cat_slug); ?>"><?php echo esc_html($cat_name); ?></span><?php endif; ?>
        <div class="pcard-name"><?php echo esc_html($product->get_name()); ?></div>
        <div class="pcard-meta">
          <?php if ($brand) : ?><span class="pcard-brand"><?php echo esc_html($brand); ?></span><?php endif; ?>
          <?php if ($sku) : ?><span class="pcard-sku">REF <?php echo esc_html($sku); ?></span><?php endif; ?>
        </div>
        <div class="pcard-footer">
          <div class="pcard-price">
            <?php if ($on_sale && $sale_price) : ?>
              <span class="pcard-price-current"><?php echo wc_price($sale_price); ?></span>
              <span class="pcard-price-old"><?php echo wc_price($reg_price); ?></span>
            <?php else : ?>
              <span class="pcard-price-current"><?php echo $product->get_price_html(); ?></span>
            <?php endif; ?>
          </div>
          <?php if ($product->is_in_stock()) : ?>
            <button class="pcard-add"
              onclick="event.preventDefault();dentixAddToCart(<?php echo $product->get_id(); ?>,this)"
              aria-label="Añadir al carrito">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </a>
  <?php endforeach; }
  ?>

  <!-- Panel Nuevos -->
  <div class="prod-panel on" id="panel-nuevos">
    <div class="prod-grid-4"><?php dentix_render_product_cards($productos_nuevos); ?></div>
  </div>
  <!-- Panel Más vendidos -->
  <div class="prod-panel" id="panel-vendidos">
    <div class="prod-grid-4"><?php dentix_render_product_cards($productos_vendidos); ?></div>
  </div>
  <!-- Panel Oferta -->
  <div class="prod-panel" id="panel-oferta">
    <?php if (!empty($productos_oferta) && $productos_oferta !== $productos_nuevos) : ?>
      <div class="prod-grid-4"><?php dentix_render_product_cards($productos_oferta); ?></div>
    <?php else : ?>
      <div style="text-align:center;padding:40px;color:var(--gray-mid);font-size:14px">
        Próximamente artículos en oferta. <a href="<?php echo esc_url($shop_url); ?>" style="color:var(--red)">Ver catálogo →</a>
      </div>
    <?php endif; ?>
  </div>

  <div style="text-align:center;margin-top:32px">
    <a href="<?php echo esc_url($shop_url); ?>" class="btn-catalog">Ver todo el catálogo →</a>
  </div>
</section>

<script>
document.querySelectorAll('.prod-tab').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.prod-tab').forEach(b => b.classList.remove('on'));
    document.querySelectorAll('.prod-panel').forEach(p => p.classList.remove('on'));
    btn.classList.add('on');
    const panel = document.getElementById('panel-' + btn.dataset.tab);
    if (panel) panel.classList.add('on');
  });
});
</script>

<?php endif; endif; ?>

<?php get_footer(); ?>
