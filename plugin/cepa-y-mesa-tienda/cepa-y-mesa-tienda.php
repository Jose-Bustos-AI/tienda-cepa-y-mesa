<?php
/**
 * Plugin Name: Cepa y Mesa Tienda
 * Description: Catálogo, ajustes y funciones a medida de la tienda de ejemplo Cepa y Mesa: recomendador de maridaje, ficha de cata, formatos en botella o caja, aviso de mayoría de edad, envíos y pago de prueba.
 * Version: 1.0.2
 * Author: Dania360
 * Requires Plugins: woocommerce
 * Text Domain: cepa-y-mesa-tienda
 */

defined( 'ABSPATH' ) || exit;

define( 'CYM_VER', '1.0.2' );
define( 'CYM_DIR', plugin_dir_path( __FILE__ ) );
define( 'CYM_URL', plugin_dir_url( __FILE__ ) );

require_once CYM_DIR . 'inc/datos.php';
require_once CYM_DIR . 'inc/montaje.php';
require_once CYM_DIR . 'inc/tienda.php';
