<?php
/**
 * page.php — Plantilla genérica para páginas de WordPress
 * Para páginas WooCommerce (Mi cuenta, Cesta, Checkout) NO muestra
 * el header ni breadcrumb propios — WooCommerce los gestiona.
 */
get_header();

// Detectar si es una página WooCommerce funcional
$is_wc_page = function_exists('is_woocommerce')
    && ( is_account_page() || is_cart() || is_checkout() );
?>

<?php if ( ! $is_wc_page ) : ?>
  <?php dentix_breadcrumb(); ?>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php if ( $is_wc_page ) : ?>
    <?php the_content(); ?>
  <?php else : ?>
    <div class="page-content-wrap">
      <article>
        <header class="page-article-header">
          <h1 class="page-article-title"><?php the_title(); ?></h1>
          <?php if ( get_the_modified_date() ) : ?>
            <p class="page-article-date">
              Ultima actualizacion: <?php echo get_the_modified_date( 'd/m/Y' ); ?>
            </p>
          <?php endif; ?>
        </header>
        <div class="entry-content"><?php the_content(); ?></div>
      </article>
    </div>
  <?php endif; ?>
<?php endwhile; ?>

<?php get_footer(); ?>
