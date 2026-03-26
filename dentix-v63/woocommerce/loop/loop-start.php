<?php
/**
 * loop/loop-start.php — Dentix override
 *
 * Usa <div> en lugar de <ul> porque nuestro content-product.php
 * genera directamente <a class="prod-card">, no un <li>.
 * Poner <a> dentro de <ul> es HTML inválido y el navegador
 * inserta un <li> vacío implícito antes del primer producto.
 */
defined('ABSPATH') || exit;
?>
<div class="products shop-products">
