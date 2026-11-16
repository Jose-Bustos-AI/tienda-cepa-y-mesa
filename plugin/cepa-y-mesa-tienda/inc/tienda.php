<?php
/**
 * Funciones visibles de la tienda Cepa y Mesa.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'cym-tienda', CYM_URL . 'assets/cym-tienda.css', array(), CYM_VER );
	wp_enqueue_script( 'cym-tienda', CYM_URL . 'assets/cym-tienda.js', array(), CYM_VER, array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

/** Iconos del recomendador (trazo de 32x32). */
function cym_iconos() {
	return array(
		'carnes'  => '<path d="M9 21c-3-3-3-9 2-12s12-2 13 3-2 9-6 10-6 2-9-1z"/><path d="M14 15a3 3 0 1 0 6 0 3 3 0 0 0-6 0M6 24l-3 3M4 23l-1 1M7 26l-1 1"/>',
		'arroces' => '<path d="M4 16h24a12 6 0 0 1-24 0z"/><path d="M28 16h3M1 16h3M10 14l2-2M16 13l1-2M21 14l1-2M13 18h0M19 19h0"/>',
		'pescado' => '<path d="M3 16c5-7 14-8 20 0-6 8-15 7-20 0z"/><path d="M23 16l6-5v10zM9 15h0"/>',
		'quesos'  => '<path d="M4 22l20-12 4 4v10H4z"/><path d="M4 22h24M11 25a1.5 1.5 0 1 0 0 .1M20 19a2 2 0 1 0 0 .1M16 25h0"/>',
		'pasta'   => '<path d="M5 18h22a11 9 0 0 1-22 0z"/><path d="M10 18c0-4 3-6 3-10M15 18c0-5 3-7 2-11M20 18c1-4-1-6 1-10M23 4l-4 14"/>',
		'postres' => '<path d="M6 27h20V17H6zM6 21c3 2 5-2 7 0s4 2 6 0 5-2 7 0"/><path d="M16 17V9M16 9c-2-2-1-5 0-6 1 1 2 4 0 6"/>',
	);
}

/** Recomendador de maridaje: [cym_maridaje] */
add_shortcode( 'cym_maridaje', function () {
	$platos = cym_platos();
	$iconos = cym_iconos();
	ob_start();
	?>
	<section class="cym-mar" id="maridaje" aria-labelledby="cym-mar-titulo">
		<div class="cym-mar__in">
			<div class="cym-mar__cab">
				<p class="cym-ceja"><span></span>Recomendador de maridaje</p>
				<h2 class="cym-titulo" id="cym-mar-titulo">¿Qué vas a <em>cocinar hoy?</em></h2>
				<p>Elige el plato y te decimos qué vino abrir, a qué temperatura servirlo y qué poner en la mesa mientras tanto.</p>
			</div>
			<div class="cym-mar__botones" role="tablist" aria-label="Plato">
				<?php $i = 0; foreach ( $platos as $clave => $pl ) : ?>
					<button type="button" role="tab" id="cym-tab-<?php echo esc_attr( $clave ); ?>" aria-controls="cym-panel-<?php echo esc_attr( $clave ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>">
						<svg viewBox="0 0 32 32" aria-hidden="true"><?php echo $iconos[ $clave ]; // phpcs:ignore ?></svg>
						<span><?php echo esc_html( $pl['nombre'] ); ?></span>
					</button>
				<?php $i++; endforeach; ?>
			</div>
			<?php $i = 0; foreach ( $platos as $clave => $pl ) : ?>
				<div class="cym-mar__panel" role="tabpanel" id="cym-panel-<?php echo esc_attr( $clave ); ?>" aria-labelledby="cym-tab-<?php echo esc_attr( $clave ); ?>" <?php echo 0 === $i ? '' : 'hidden'; ?>>
					<div class="cym-mar__consejo">
						<p class="cym-mar__pide">Abre un</p>
						<p class="cym-mar__estilo"><?php echo esc_html( $pl['estilo'] ); ?></p>
						<p class="cym-mar__porque"><?php echo esc_html( $pl['porque'] ); ?></p>
						<dl class="cym-mar__datos">
							<?php foreach ( $pl['servir'] as $k => $v ) : ?>
								<div><dt><?php echo esc_html( $k ); ?></dt><dd><?php echo esc_html( $v ); ?></dd></div>
							<?php endforeach; ?>
						</dl>
					</div>
					<div class="cym-mar__vinos">
						<p class="cym-mar__pide">Nuestros vinos para este plato</p>
						<?php foreach ( $pl['vinos'] as $slug ) :
							$p = wc_get_product( cym_id_por_slug( $slug ) );
							if ( ! $p ) {
								continue;
							}
							?>
							<a class="cym-mar__vino" href="<?php echo esc_url( $p->get_permalink() ); ?>">
								<?php echo $p->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?>
								<span>
									<b><?php echo esc_html( $p->get_name() ); ?></b>
									<small><?php echo esc_html( get_post_meta( $p->get_id(), '_cym_notas', true ) ); ?></small>
									<em><?php echo wp_kses_post( $p->get_price_html() ); ?></em>
									<strong>Ver el vino →</strong>
								</span>
							</a>
						<?php endforeach; ?>
						<?php $picar = wc_get_product( cym_id_por_slug( $pl['picar'] ) ); if ( $picar ) : ?>
							<a class="cym-mar__picar" href="<?php echo esc_url( $picar->get_permalink() ); ?>">
								<?php echo $picar->get_image( 'woocommerce_gallery_thumbnail', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?>
								<span><small>Y para picar mientras</small><b><?php echo esc_html( $picar->get_name() ); ?></b></span>
								<em><?php echo wp_kses_post( $picar->get_price_html() ); ?></em>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php $i++; endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
} );

/** Ficha de cata: notas, perfil (cuerpo, fruta y frescura), temperatura y con qué marida. */
function cym_cata_html( $id ) {
	$perfil = get_post_meta( $id, '_cym_perfil', true );
	$notas  = get_post_meta( $id, '_cym_notas', true );
	if ( ! $perfil || ! $notas ) {
		return '';
	}
	$html = '<div class="cym-cata"><p class="cym-cata__titulo">En la copa</p><ul class="cym-cata__notas">';
	foreach ( explode( '·', $notas ) as $nota ) {
		$nota  = trim( $nota );
		$html .= '<li>' . esc_html( mb_strtoupper( mb_substr( $nota, 0, 1 ) ) . mb_substr( $nota, 1 ) ) . '</li>';
	}
	$html .= '</ul><dl class="cym-cata__barras">';
	foreach ( array( 'Cuerpo', 'Fruta', 'Frescura' ) as $n => $nombre ) {
		$valor = (int) $perfil[ $n ];
		$html .= '<div><dt>' . $nombre . '</dt><dd aria-label="' . $valor . ' de 5"><span style="--v:' . $valor . '"></span></dd></div>';
	}
	$html .= '</dl>';
	$servir = get_post_meta( $id, '_cym_servir', true );
	$marida = (array) get_post_meta( $id, '_cym_marida', true );
	$html  .= '<div class="cym-cata__pie">';
	if ( $servir ) {
		$html .= '<p><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 14V4a2 2 0 1 1 4 0v10a4 4 0 1 1-4 0z"/><path d="M12 10v7"/></svg>Servir a <b>' . esc_html( $servir ) . '</b></p>';
	}
	if ( array_filter( $marida ) ) {
		$html .= '<p><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3v7a2 2 0 0 0 4 0V3M9 10v11M17 3c-2 2-2 6 0 8v10"/></svg>Marida con <b>' . esc_html( implode( ', ', $marida ) ) . '</b></p>';
	}
	return $html . '</div><a class="cym-cata__enlace" href="/#maridaje">¿Dudas con el maridaje? Usa el recomendador →</a></div>';
}

add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( $product ) {
		echo cym_cata_html( $product->get_id() ); // phpcs:ignore
	}
}, 25 );

/** Aviso del precio por botella al elegir la caja de 6. */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( $product && $product->is_type( 'variable' ) ) {
		echo '<p class="cym-caja" aria-live="polite"></p>';
	}
} );

/** Notas de cata bajo el nombre en las tarjetas de producto. */
add_action( 'woocommerce_after_shop_loop_item_title', function () {
	$notas = get_post_meta( get_the_ID(), '_cym_notas', true );
	if ( $notas ) {
		echo '<p class="cym-tarjeta-notas">' . esc_html( $notas ) . '</p>';
	}
}, 6 );

/** Precio de los vinos: "Desde" el precio de la botella (tachado si está en oferta), no un rango hasta la caja. */
add_filter( 'woocommerce_variable_price_html', function ( $html, $product ) {
	$min = (float) $product->get_variation_price( 'min', true );
	$reg = (float) $product->get_variation_regular_price( 'min', true );
	$txt = ( $reg > $min ) ? '<del aria-hidden="true">' . wc_price( $reg ) . '</del> <ins>' . wc_price( $min ) . '</ins>' : wc_price( $min );
	return '<span class="cym-desde">Desde</span> ' . $txt;
}, 10, 2 );

/** En las tarjetas de vinos, el botón dice "Elegir formato". */
add_filter( 'woocommerce_product_add_to_cart_text', function ( $texto, $product ) {
	return $product->is_type( 'variable' ) ? 'Elegir formato' : $texto;
}, 10, 2 );

/** Si el pedido tiene envío gratis, no mostrar el estándar de pago (sí el exprés). */
add_filter( 'woocommerce_package_rates', function ( $tarifas ) {
	$hay_gratis = false;
	foreach ( $tarifas as $t ) {
		if ( 'free_shipping' === $t->get_method_id() ) {
			$hay_gratis = true;
		}
	}
	if ( $hay_gratis ) {
		$estandar = (int) get_option( 'cym_envio_estandar' );
		foreach ( $tarifas as $clave => $t ) {
			if ( 'flat_rate' === $t->get_method_id() && (int) $t->get_instance_id() === $estandar ) {
				unset( $tarifas[ $clave ] );
			}
		}
	}
	return $tarifas;
}, 100 );

/** Venta de alcohol: casilla obligatoria de mayoría de edad en el pago. */
add_action( 'woocommerce_init', function () {
	if ( function_exists( 'woocommerce_register_additional_checkout_field' ) ) {
		woocommerce_register_additional_checkout_field( array(
			'id'       => 'cepa-y-mesa/mayor-de-edad',
			'label'    => 'Confirmo que soy mayor de 18 años',
			'location' => 'order',
			'type'     => 'checkbox',
			'required' => true,
		) );
	}
} );

/** Ventana de mayoría de edad la primera vez que se entra en la tienda. */
add_action( 'wp_footer', function () {
	?>
	<div class="cym-edad" id="cym-edad" role="dialog" aria-modal="true" aria-labelledby="cym-edad-titulo" hidden>
		<div class="cym-edad__caja">
			<svg class="cym-edad__copa" viewBox="0 0 40 40" aria-hidden="true"><path d="M12 4h16c0 9-2 15-8 15S12 13 12 4z"/><path d="M12.6 10h14.8c-.6 5-2.6 8-7.4 8s-6.8-3-7.4-8z" class="lleno"/><path d="M20 19v13M13 35h14"/></svg>
			<p class="cym-ceja cym-ceja--oscura"><span></span>Cepa y Mesa</p>
			<h2 id="cym-edad-titulo">¿Tienes 18 años o más?</h2>
			<p>Vendemos vino y solo podemos hacerlo a mayores de edad. Bebe con moderación.</p>
			<div class="cym-edad__botones">
				<button type="button" class="cym-btn" data-edad="si">Sí, tengo 18 o más</button>
				<button type="button" class="cym-btn cym-btn--linea" data-edad="no">No</button>
			</div>
			<p class="cym-edad__no" hidden>Lo sentimos: para entrar en la tienda tienes que ser mayor de edad. ¡Te esperamos cuando cumplas 18!</p>
		</div>
	</div>
	<?php
} );

/** El pago de prueba deja el pedido como "Procesando", igual que un pago con tarjeta. */
add_filter( 'woocommerce_cheque_process_payment_order_status', function () {
	return 'processing';
} );

/** Sin referencias (SKU) en una tienda de ejemplo. */
add_filter( 'wc_product_sku_enabled', '__return_false' );

/** Comillas normales en lugar de « » en todos los textos de la tienda. */
function cym_comillas( $texto ) {
	return ( is_string( $texto ) && false !== strpbrk( $texto, '«»' ) ) ? str_replace( array( '«', '»' ), '"', $texto ) : $texto;
}
add_filter( 'gettext', 'cym_comillas', 99 );
add_filter( 'ngettext', 'cym_comillas', 99 );
add_filter( 'gettext_with_context', 'cym_comillas', 99 );
add_filter( 'woocommerce_add_message', 'cym_comillas', 99 );
add_filter( 'woocommerce_add_success', 'cym_comillas', 99 );
add_filter( 'woocommerce_add_error', 'cym_comillas', 99 );
add_filter( 'woocommerce_add_notice', 'cym_comillas', 99 );
add_action( 'wp_enqueue_scripts', function () {
	$js = "(function(){if(!window.wp||!wp.hooks)return;var f=function(t){return typeof t==='string'?t.replace(/[\\u00ab\\u00bb]/g,'\"'):t;};['i18n.gettext','i18n.ngettext','i18n.gettext_with_context','i18n.ngettext_with_context'].forEach(function(h){wp.hooks.addFilter(h,'cym/comillas',f,99);});})();";
	wp_add_inline_script( 'wp-i18n', $js, 'after' );
}, 1 );
add_filter( 'load_script_translations', function ( $json ) {
	return is_string( $json ) ? str_replace( array( '«', '»', '«', '»' ), '\"', $json ) : $json;
}, 99 );

/** Las páginas se revalidan siempre: así nadie ve precios o carritos antiguos. */
add_action( 'send_headers', function () {
	if ( ! is_admin() ) {
		header( 'Cache-Control: no-cache, must-revalidate, max-age=0', true );
	}
}, 99 );

/** Tienda de ejemplo: que no aparezca en buscadores. */
add_filter( 'wp_robots', function ( $robots ) {
	$robots['noindex']  = true;
	$robots['nofollow'] = true;
	return $robots;
} );
