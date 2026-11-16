<?php
/**
 * Ficha de producto, página de tienda y portada: piezas a medida de Cepa y Mesa.
 */
defined( 'ABSPATH' ) || exit;

/** Importe a partir del cual el envío estándar es gratis. */
const CYM_ENVIO_GRATIS = 49;

add_action( 'wp_enqueue_scripts', function () {
	wp_localize_script( 'cym-tienda', 'CYM', array( 'envioGratis' => CYM_ENVIO_GRATIS ) );
}, 20 );

/* ---------- Descripción para buscadores y para compartir ---------- */

function cym_descripcion_pagina() {
	if ( is_front_page() ) {
		return 'Vinos de Jumilla, Yecla y Bullas, clásicos de Ribera y Rioja y una despensa gourmet. En botella o en caja de 6 con un 10 % menos. Envío gratis desde 49 €.';
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		return wp_strip_all_tags( get_post_field( 'post_excerpt', get_queried_object_id() ) );
	}
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		return wp_strip_all_tags( term_description() );
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return 'Tintos, blancos, rosados, espumosos y una despensa gourmet para acompañarlos. Cada vino, en botella o en caja de 6 con descuento.';
	}
	return '';
}

add_action( 'wp_head', function () {
	$texto = trim( cym_descripcion_pagina() );
	if ( '' === $texto ) {
		return;
	}
	$imagen = get_theme_file_uri( 'assets/img/portada.jpg' );
	if ( function_exists( 'is_product' ) && is_product() ) {
		$foto = get_the_post_thumbnail_url( get_queried_object_id(), 'large' );
		if ( $foto ) {
			$imagen = $foto;
		}
	}
	echo '<meta name="description" content="' . esc_attr( $texto ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $texto ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $imagen ) . '">' . "\n";
}, 2 );

/* ---------- Ficha de producto ---------- */

/** Devuelve la ficha técnica de un vino (los atributos que no son de variación). */
function cym_tecnica( $product ) {
	$campos = array( 'D.O.', 'Uva', 'Crianza', 'Graduación' );
	$datos  = array();
	foreach ( $product->get_attributes() as $atributo ) {
		if ( ! is_object( $atributo ) || $atributo->get_variation() ) {
			continue;
		}
		if ( in_array( $atributo->get_name(), $campos, true ) ) {
			$datos[ $atributo->get_name() ] = implode( ', ', $atributo->get_options() );
		}
	}
	return $datos;
}

/** Compromisos de la tienda justo debajo del botón de compra. */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$vino   = (bool) get_post_meta( $product->get_id(), '_cym_notas', true );
	$lineas = array(
		$vino ? 'Viaja en caja con separadores para que llegue entero' : 'Sale del almacén en 24 horas',
		'Envío en 48-72 h, gratis desde ' . CYM_ENVIO_GRATIS . ' €',
		$vino ? 'Si una botella llega rota o con defecto, te la reponemos' : 'Si algo llega en mal estado, te lo reponemos',
	);
	echo '<ul class="cym-confianza">';
	foreach ( $lineas as $linea ) {
		echo '<li><svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10.5l4 4 8-9"/></svg>' . esc_html( $linea ) . '</li>';
	}
	echo '</ul>';
}, 31 );

/** Ficha técnica a la vista, sin tener que abrir una pestaña. */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$datos = cym_tecnica( $product );
	if ( ! $datos ) {
		return;
	}
	echo '<div class="cym-origen"><p class="cym-origen__titulo">Ficha técnica</p><dl>';
	foreach ( $datos as $nombre => $valor ) {
		echo '<div><dt>' . esc_html( 'D.O.' === $nombre ? 'Denominación de origen' : $nombre ) . '</dt><dd>' . esc_html( $valor ) . '</dd></div>';
	}
	echo '</dl></div>';
}, 33 );

/** Pestañas: fuera la tabla de atributos (ya está en la ficha técnica), dentro servicio y envíos. */
add_filter( 'woocommerce_product_tabs', function ( $pestanas ) {
	global $product;
	unset( $pestanas['additional_information'] );
	if ( isset( $pestanas['description'] ) ) {
		$pestanas['description']['title'] = 'La historia';
	}
	if ( $product && get_post_meta( $product->get_id(), '_cym_notas', true ) ) {
		$pestanas['cym_servir'] = array(
			'title'    => 'Cómo servirlo',
			'priority' => 20,
			'callback' => function () {
				global $product;
				$servir = $product ? get_post_meta( $product->get_id(), '_cym_servir', true ) : '';
				echo '<h2>Cómo servirlo</h2>';
				if ( $servir ) {
					echo '<p>Sírvelo a ' . esc_html( $servir ) . '. Si en casa hace calor, diez minutos de nevera antes de abrirlo le sientan bien incluso a un tinto.</p>';
				}
				echo '<p>Guarda las botellas tumbadas, a oscuras y lejos de la cocina. Una vez abierta, con su corcho y en la nevera aguanta dos o tres días sin perder la fruta.</p>';
			},
		);
	}
	$pestanas['cym_envios'] = array(
		'title'    => 'Envíos y devoluciones',
		'priority' => 30,
		'callback' => function () {
			echo '<h2>Envíos y devoluciones</h2><p>Envío estándar en 48-72 h por 4,90 €, gratis a partir de ' . (int) CYM_ENVIO_GRATIS . ' €. Envío exprés en 24 h por 7,90 €. Enviamos a toda España.</p><p>Las botellas viajan en cajas con separadores de cartón. Si alguna llega rota o el vino tiene un defecto de corcho, escríbenos con una foto y te la reponemos sin coste.</p>';
		},
	);
	return $pestanas;
}, 20 );

add_filter( 'woocommerce_product_description_heading', function () {
	return 'La historia de este producto';
} );

add_filter( 'woocommerce_product_related_products_heading', function () {
	return 'También te puede gustar';
} );

/* ---------- Página de tienda ---------- */

add_action( 'woocommerce_archive_description', function () {
	if ( is_shop() && ! is_search() ) {
		echo '<p class="cym-tienda__intro">Vinos catados uno a uno y una despensa para acompañarlos. Cada vino, en botella suelta o en caja de 6 con un 10 % menos.</p>';
	}
}, 5 );

/** Accesos rápidos a las categorías encima de la rejilla. */
add_action( 'woocommerce_before_shop_loop', function () {
	if ( ! is_shop() && ! is_product_category() ) {
		return;
	}
	$actual = is_product_category() ? get_queried_object()->slug : '';
	echo '<nav class="cym-filtros" aria-label="Categorías de la tienda"><ul>';
	echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '"' . ( '' === $actual ? ' aria-current="page"' : '' ) . '>Todo</a></li>';
	foreach ( cym_categorias() as $slug => $cat ) {
		$enlace = get_term_link( $slug, 'product_cat' );
		if ( is_wp_error( $enlace ) ) {
			continue;
		}
		echo '<li><a href="' . esc_url( $enlace ) . '"' . ( $slug === $actual ? ' aria-current="page"' : '' ) . '>' . esc_html( $cat[0] ) . '</a></li>';
	}
	echo '</ul></nav>';
}, 15 );

/* ---------- Portada: el vino del mes ---------- */

add_shortcode( 'cym_vino_mes', function () {
	$p = wc_get_product( cym_id_por_slug( 'lomas-de-yecla-crianza' ) );
	if ( ! $p ) {
		return '';
	}
	$notas = array_filter( array_map( 'trim', explode( '·', (string) get_post_meta( $p->get_id(), '_cym_notas', true ) ) ) );
	$datos = cym_tecnica( $p );
	ob_start();
	?>
	<section class="cym-edicion" aria-labelledby="cym-edicion-titulo">
		<div class="cym-edicion__in">
			<a class="cym-edicion__foto cym-revela" href="<?php echo esc_url( $p->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
				<?php echo $p->get_image( 'large', array( 'loading' => 'lazy', 'alt' => '' ) ); // phpcs:ignore ?>
				<span class="cym-edicion__sello">El vino<br>del mes</span>
			</a>
			<div class="cym-edicion__texto">
				<p class="cym-ceja cym-ceja--oscura"><span></span>Lo que estamos abriendo</p>
				<h2 class="cym-titulo" id="cym-edicion-titulo"><?php echo esc_html( $p->get_name() ); ?>, <em>doce meses de barrica.</em></h2>
				<p class="cym-edicion__lead">De una bodega familiar de Yecla que trabaja sus propias viñas. Monastrell con un toque de Syrah, taninos pulidos y un final largo a cacao: el tinto que ponemos cuando hay cordero o un buen queso curado.</p>
				<?php if ( $notas ) : ?>
					<ul class="cym-edicion__notas">
						<?php foreach ( $notas as $nota ) : ?>
							<li><?php echo esc_html( mb_strtoupper( mb_substr( $nota, 0, 1 ) ) . mb_substr( $nota, 1 ) ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $datos ) : ?>
					<dl class="cym-edicion__datos">
						<?php foreach ( array( 'D.O.', 'Uva', 'Graduación' ) as $campo ) : ?>
							<?php if ( isset( $datos[ $campo ] ) ) : ?>
								<div><dt><?php echo esc_html( $campo ); ?></dt><dd><?php echo esc_html( $datos[ $campo ] ); ?></dd></div>
							<?php endif; ?>
						<?php endforeach; ?>
					</dl>
				<?php endif; ?>
				<div class="cym-botones">
					<a class="cym-btn" href="<?php echo esc_url( $p->get_permalink() ); ?>">Ver el vino · desde <?php echo wp_kses_post( wp_strip_all_tags( wc_price( $p->get_price() ) ) ); ?></a>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
} );
