<?php
/**
 * content-product.php — Tarjeta profesional médica Dentix
 * Ubicada en woocommerce/ (raíz) para que wc_get_template_part() la encuentre.
 * Estilo: badge especialidad, marca, referencia, precio limpio, botón compacto.
 */
defined('ABSPATH') || exit;

global $product;
if ( empty($product) || ! $product->is_visible() ) return;

$img       = get_the_post_thumbnail_url( get_the_ID(), 'dentix-product-thumb' );
$sku       = $product->get_sku();
$on_sale   = $product->is_on_sale();
$in_stock  = $product->is_in_stock();
$qty       = $product->get_stock_quantity();
$reg_price = $product->get_regular_price();
$sale_price= $product->get_sale_price();

// Marca
$brand_terms = wp_get_post_terms( get_the_ID(), 'pa_marca' );
$brand = ( ! is_wp_error($brand_terms) && ! empty($brand_terms) ) ? $brand_terms[0]->name : '';

// Especialidad (primera categoría del producto)
$cat_terms = wp_get_post_terms( get_the_ID(), 'product_cat', ['number' => 1] );
$cat_name  = ( ! is_wp_error($cat_terms) && ! empty($cat_terms) ) ? $cat_terms[0]->name : '';
$cat_slug  = ( ! is_wp_error($cat_terms) && ! empty($cat_terms) ) ? $cat_terms[0]->slug : '';

// Descuento
$discount = 0;
if ( $on_sale && $reg_price && $sale_price ) {
    $discount = round( ( ($reg_price - $sale_price) / $reg_price ) * 100 );
}
?>

<a href="<?php the_permalink(); ?>"
   class="pcard<?php echo ! $in_stock ? ' pcard-nostock' : ''; ?>"
   title="<?php echo esc_attr( $product->get_name() ); ?>">

  <!-- ── Imagen ─────────────────────────────────────────────── -->
  <div class="pcard-img">

    <?php if ( $img ) : ?>
      <img src="<?php echo esc_url($img); ?>"
           alt="<?php echo esc_attr($product->get_name()); ?>"
           loading="lazy">
    <?php else : ?>
      <div class="pcard-noimg">
        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2">
          <rect x="8" y="12" width="32" height="24" rx="3"/>
          <line x1="16" y1="20" x2="32" y2="20"/>
          <line x1="16" y1="26" x2="24" y2="26"/>
        </svg>
      </div>
    <?php endif; ?>

    <!-- Badge descuento -->
    <?php if ( $discount > 0 ) : ?>
      <span class="pcard-discount">−<?php echo $discount; ?>%</span>
    <?php endif; ?>

    <!-- Sin stock overlay -->
    <?php if ( ! $in_stock ) : ?>
      <div class="pcard-outofstock">Sin stock</div>
    <?php endif; ?>

  </div>

  <!-- ── Info ───────────────────────────────────────────────── -->
  <div class="pcard-body">

    <!-- Badge especialidad -->
    <?php if ( $cat_name ) : ?>
      <span class="pcard-cat pcard-cat-<?php echo esc_attr($cat_slug); ?>">
        <?php echo esc_html($cat_name); ?>
      </span>
    <?php endif; ?>

    <!-- Nombre -->
    <div class="pcard-name"><?php the_title(); ?></div>

    <!-- Marca y referencia -->
    <div class="pcard-meta">
      <?php if ( $brand ) : ?>
        <span class="pcard-brand"><?php echo esc_html($brand); ?></span>
      <?php endif; ?>
      <?php if ( $sku ) : ?>
        <span class="pcard-sku">REF <?php echo esc_html($sku); ?></span>
      <?php endif; ?>
    </div>

    <!-- Footer: precio + botón -->
    <div class="pcard-footer">
      <div class="pcard-price">
        <?php if ( $on_sale && $sale_price ) : ?>
          <span class="pcard-price-current"><?php echo wc_price($sale_price); ?></span>
          <span class="pcard-price-old"><?php echo wc_price($reg_price); ?></span>
        <?php else : ?>
          <span class="pcard-price-current"><?php echo $product->get_price_html(); ?></span>
        <?php endif; ?>
      </div>

      <?php if ( $in_stock ) : ?>
        <button class="pcard-add"
                onclick="event.preventDefault();dentixAddToCart(<?php echo get_the_ID(); ?>,this)"
                aria-label="Añadir al carrito"
                title="Añadir al carrito">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
        </button>
      <?php else : ?>
        <button class="pcard-add pcard-add-disabled" disabled>−</button>
      <?php endif; ?>
    </div>

  </div><!-- /pcard-body -->

</a>
