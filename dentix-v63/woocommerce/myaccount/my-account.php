<?php
/**
 * myaccount/my-account.php — Dashboard profesional Dentix
 */
defined('ABSPATH') || exit;
get_header();
dentix_breadcrumb();

$current   = WC()->query->get_current_endpoint();
$endpoints = wc_get_account_menu_items();
$user      = wp_get_current_user();

// Iconos SVG por endpoint
$icons = [
    'dashboard'       => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M2 4a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm9 0a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2V4zM2 11a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2H4a2 2 0 01-2-2v-3zm9 0a2 2 0 012-2h3a2 2 0 012 2v3a2 2 0 01-2 2h-3a2 2 0 01-2-2v-3z"/></svg>',
    'orders'          => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM2 9v7a2 2 0 002 2h12a2 2 0 002-2V9H2zm3 2h2a1 1 0 010 2H5a1 1 0 010-2zm0 3h4a1 1 0 010 2H5a1 1 0 010-2z"/></svg>',
    'downloads'       => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M4 16v1a1 1 0 001 1h10a1 1 0 001-1v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>',
    'edit-address'    => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>',
    'edit-account'    => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>',
    'customer-logout' => '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"/></svg>',
];

$labels_es = [
    'dashboard'       => 'Escritorio',
    'orders'          => 'Mis pedidos',
    'downloads'       => 'Descargas',
    'edit-address'    => 'Direcciones',
    'edit-account'    => 'Mi perfil',
    'customer-logout' => 'Cerrar sesión',
];

// Contar pedidos del usuario para el badge
$order_count = wc_get_customer_order_count($user->ID);
?>

<div class="da-layout">

  <!-- ── Sidebar ──────────────────────────────────────────────── -->
  <aside class="da-sidebar">

    <!-- Perfil -->
    <div class="da-profile">
      <div class="da-avatar">
        <?php echo strtoupper( substr( $user->display_name ?: $user->user_email, 0, 1 ) ); ?>
      </div>
      <div class="da-profile-info">
        <div class="da-profile-name"><?php echo esc_html($user->display_name ?: explode('@', $user->user_email)[0]); ?></div>
        <div class="da-profile-email"><?php echo esc_html($user->user_email); ?></div>
        <div class="da-profile-badge">Profesional B2B</div>
      </div>
    </div>

    <!-- Navegación -->
    <nav class="da-nav">
      <?php foreach ($endpoints as $endpoint => $label) :
        $url    = wc_get_account_endpoint_url($endpoint);
        $active = ($current === $endpoint || ($endpoint === 'dashboard' && !$current));
        $icon   = $icons[$endpoint] ?? $icons['dashboard'];
        $label_es = $labels_es[$endpoint] ?? $label;
        $is_logout = ($endpoint === 'customer-logout');
      ?>
        <a href="<?php echo esc_url($url); ?>"
           class="da-nav-item<?php echo $active ? ' active' : ''; ?><?php echo $is_logout ? ' logout' : ''; ?>">
          <span class="da-nav-icon"><?php echo $icon; ?></span>
          <span class="da-nav-label"><?php echo esc_html($label_es); ?></span>
          <?php if ($endpoint === 'orders' && $order_count > 0) : ?>
            <span class="da-nav-badge"><?php echo $order_count; ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <!-- Stats rápidas -->
    <div class="da-stats">
      <div class="da-stat">
        <div class="da-stat-n"><?php echo $order_count; ?></div>
        <div class="da-stat-l">Pedidos</div>
      </div>
      <div class="da-stat">
        <div class="da-stat-n"><?php echo function_exists('wc_get_customer_download_count') ? wc_get_customer_download_count($user->ID) : 0; ?></div>
        <div class="da-stat-l">Descargas</div>
      </div>
    </div>

  </aside>

  <!-- ── Contenido principal ─────────────────────────────────── -->
  <main class="da-content">
    <?php wc_print_notices(); ?>
    <?php do_action('woocommerce_account_content'); ?>
  </main>

</div><!-- /da-layout -->

<?php get_footer(); ?>
