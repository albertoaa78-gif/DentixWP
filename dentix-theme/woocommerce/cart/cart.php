<?php
/**
 * cart/cart.php — Página de cesta Dentix
 */
defined('ABSPATH') || exit;
get_header();
?>

<?php dentix_breadcrumb(); ?>

<div class="page-content-wrap">
    <header class="account-header">
        <h1>Mi cesta</h1>
    </header>

    <?php wc_print_notices(); ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <div class="cart-grid">
            
            <div class="cart-main">
                <table class="shop_table cart woocommerce-cart-form__contents">
                    <thead>
                        <tr>
                            <th class="product-name">Producto</th>
                            <th class="product-price">Precio</th>
                            <th class="product-quantity">Cantidad</th>
                            <th class="product-subtotal">Subtotal</th>
                            <th class="product-remove">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) : ?>
                                <tr class="woocommerce-cart-form__cart-item">
                                    <td class="product-name">
                                        <div style="display:flex; align-items:center; gap:15px;">
                                            <?php echo $_product->get_image(); ?>
                                            <span style="font-weight:700;"><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ); ?></span>
                                        </div>
                                    </td>
                                    <td class="product-price"><?php echo WC()->cart->get_product_price( $_product ); ?></td>
                                    <td class="product-quantity"><?php woocommerce_quantity_input( array( 'input_name' => "cart[{$cart_item_key}][qty]", 'input_value' => $cart_item['quantity'] ) ); ?></td>
                                    <td class="product-subtotal"><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></td>
                                    <td class="product-remove">
                                        <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" style="color:var(--red); text-decoration:none; font-weight:bold;">✕</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ) ), $cart_item_key ); ?>
                                    </td>
                                </tr>
                            <?php endif; endforeach; ?>
                    </tbody>
                </table>
                
                <div style="margin-top:20px; display:flex; justify-content:space-between; gap:15px; flex-wrap:wrap;">
                    <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon" style="display:flex; gap:10px;">
                            <input type="text" name="coupon_code" placeholder="Cupón" style="padding:10px; border:1px solid var(--border); border-radius:8px;"> 
                            <button type="submit" name="apply_coupon" class="account-nav-item" style="padding:10px 20px; cursor:pointer; background:var(--panel);">Aplicar</button>
                        </div>
                    <?php } ?>
                    <button type="submit" name="update_cart" class="account-nav-item" style="padding:10px 20px; cursor:pointer; background:var(--panel);">Actualizar cesta</button>
                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>
            </div>

            <aside class="cart-sidebar">
                <h2 style="font-family:'Playfair Display',serif; font-size:20px; margin-bottom:20px;">Resumen</h2>
                <?php woocommerce_cart_totals(); ?>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button" style="display:block; width:100%; background:var(--dark-main); color:#fff; text-align:center; padding:15px; border-radius:10px; text-decoration:none; font-weight:700; margin-top:20px;">
                    Finalizar compra
                </a>
            </aside>

        </div>
    </form>
</div>

<?php get_footer(); ?>