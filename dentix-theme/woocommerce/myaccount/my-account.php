<?php
/**
 * myaccount/my-account.php — Área privada Dentix
 */
defined('ABSPATH') || exit;
get_header();
?>

<?php dentix_breadcrumb(); ?>

<div class="page-content-wrap">
    <header class="account-header">
        <h1>Mi cuenta</h1>
        <p>Gestiona tus pedidos y datos personales</p>
    </header>

    <div class="account-wrap">
        <aside class="account-sidebar">
            <nav class="account-nav">
                <?php 
                $current   = WC()->query->get_current_endpoint();
                $endpoints = wc_get_account_menu_items();
                foreach ( $endpoints as $endpoint => $label ) :
                    $url    = wc_get_account_endpoint_url( $endpoint );
                    $active = ( $current === $endpoint || ( $endpoint === 'dashboard' && ! $current ) );
                ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="account-nav-item<?php echo $active ? ' active' : ''; ?>">
                        <?php echo esc_html( $label ); ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <?php $user = wp_get_current_user(); if ( $user->ID ) : ?>
                <div class="account-user-card" style="margin-top:20px; padding:20px; background:var(--white); border-radius:12px; border:1px solid var(--border);">
                    <div style="font-weight:700; color:var(--dark-main);"><?php echo esc_html( $user->display_name ); ?></div>
                    <div style="font-size:12px; color:var(--gray-mid);"><?php echo esc_html( $user->user_email ); ?></div>
                </div>
            <?php endif; ?>
        </aside>

        <main class="account-content">
            <?php do_action( 'woocommerce_account_content' ); ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>