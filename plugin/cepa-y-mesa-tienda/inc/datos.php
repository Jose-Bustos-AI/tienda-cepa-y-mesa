<?php
/**
 * Catálogo de la tienda de ejemplo Cepa y Mesa.
 */
defined( 'ABSPATH' ) || exit;

/** Formatos de los vinos: la caja de 6 lleva un 10 % de descuento. */
const CYM_BOTELLA = 'Botella';
const CYM_CAJA    = 'Caja de 6 (-10 %)';

function cym_categorias() {
	return array(
		'tintos'             => array( 'Tintos', 'Monastrell del altiplano murciano y clásicos de Ribera y Rioja.' ),
		'blancos-y-rosados'  => array( 'Blancos y rosados', 'Frescos, aromáticos y pensados para la mesa de cada día.' ),
		'espumosos-y-dulces' => array( 'Espumosos y dulces', 'Para brindar y para la sobremesa.' ),
		'despensa'           => array( 'Despensa gourmet', 'Aceite, queso, ibéricos, conservas y frutos secos de productores pequeños.' ),
		'lotes'              => array( 'Lotes y regalo', 'Cajas preparadas para regalar o para darse un capricho.' ),
	);
}

/** Precio de la caja de 6 con el 10 % de descuento. */
function cym_precio_caja( $botella ) {
	return round( $botella * 6 * 0.9, 2 );
}

/**
 * Cada vino lleva: precio por botella (y oferta si la hay), ficha técnica,
 * notas de cata, perfil del 1 al 5 (cuerpo, fruta y frescura) y con qué marida.
 */
function cym_productos() {
	return array(
		array(
			'slug' => 'penarrubia-monastrell-joven', 'nombre' => 'Peñarrubia Monastrell Joven', 'tipo' => 'vino', 'cat' => array( 'tintos' ), 'img' => 'monastrell.jpg', 'orden' => 1, 'destacado' => true,
			'precio' => 7.90,
			'corta' => 'Monastrell de Jumilla sin paso por barrica: fruta negra madura, violeta y un trago fácil. El tinto de diario.',
			'larga' => 'Viñedo en vaso de más de 40 años sobre suelos calizos del altiplano de Jumilla. Vendimia nocturna a mano y fermentación en depósito para conservar toda la fruta. Un tinto jugoso y sin aristas que funciona igual con unas tapas que con una pizza.',
			'notas' => 'Mora · ciruela · violeta', 'perfil' => array( 3, 5, 3 ),
			'ficha' => array( 'D.O.' => 'Jumilla', 'Uva' => 'Monastrell', 'Crianza' => 'Joven, sin barrica', 'Graduación' => '14 %', 'Servir a' => '14 - 16 °C' ),
			'marida' => array( 'Embutidos', 'Pizza y pasta', 'Carnes a la brasa' ),
		),
		array(
			'slug' => 'lomas-de-yecla-crianza', 'nombre' => 'Lomas de Yecla Crianza', 'tipo' => 'vino', 'cat' => array( 'tintos' ), 'img' => 'yecla.jpg', 'orden' => 2, 'destacado' => true,
			'precio' => 12.90,
			'corta' => 'Monastrell con 12 meses en roble francés: cereza negra, cacao y especias dulces. Nuestro vino del mes.',
			'larga' => 'De una pequeña bodega familiar de Yecla que trabaja sus propias viñas en el paraje de Las Lomas. Doce meses en barrica de roble francés y otros seis en botella antes de salir. Elegante, con taninos pulidos y un final largo a cacao.',
			'notas' => 'Cereza negra · cacao · clavo', 'perfil' => array( 4, 4, 3 ),
			'ficha' => array( 'D.O.' => 'Yecla', 'Uva' => 'Monastrell 85 % y Syrah 15 %', 'Crianza' => '12 meses en roble francés', 'Graduación' => '14,5 %', 'Servir a' => '16 - 17 °C' ),
			'marida' => array( 'Cordero asado', 'Quesos curados', 'Guisos' ),
		),
		array(
			'slug' => 'paramo-crianza', 'nombre' => 'Páramo Crianza', 'tipo' => 'vino', 'cat' => array( 'tintos' ), 'img' => 'ribera.jpg', 'orden' => 3,
			'precio' => 16.90,
			'corta' => 'Tempranillo de Ribera del Duero: fruta roja, regaliz y vainilla, con estructura para la carne.',
			'larga' => 'Tinta Fina de viñedos a 850 metros de altitud en la Ribera burgalesa, donde las noches frías dan uvas con mucha acidez y color. Catorce meses en barrica de roble francés y americano.',
			'notas' => 'Frambuesa · regaliz · vainilla', 'perfil' => array( 4, 4, 4 ),
			'ficha' => array( 'D.O.' => 'Ribera del Duero', 'Uva' => 'Tempranillo (Tinta Fina)', 'Crianza' => '14 meses en roble', 'Graduación' => '14 %', 'Servir a' => '16 - 18 °C' ),
			'marida' => array( 'Chuletón', 'Lechazo', 'Setas' ),
		),
		array(
			'slug' => 'ladera-norte-reserva', 'nombre' => 'Ladera Norte Reserva', 'tipo' => 'vino', 'cat' => array( 'tintos' ), 'img' => 'rioja.jpg', 'orden' => 4, 'destacado' => true,
			'precio' => 19.90, 'oferta' => 17.90,
			'corta' => 'Rioja Reserva de viñas viejas: ciruela pasa, cuero y tabaco dulce. Ahora en oferta.',
			'larga' => 'Tempranillo y Graciano de viñas plantadas en los años 60 en la ladera norte de la Sierra de Cantabria. Veinte meses en barrica y dos años de reposo en botella: un clásico riojano, sedoso y con mucha profundidad.',
			'notas' => 'Ciruela pasa · cuero · tabaco dulce', 'perfil' => array( 5, 3, 3 ),
			'ficha' => array( 'D.O.' => 'Rioja', 'Uva' => 'Tempranillo 90 % y Graciano 10 %', 'Crianza' => '20 meses en roble', 'Graduación' => '14 %', 'Servir a' => '17 - 18 °C' ),
			'marida' => array( 'Carnes rojas', 'Caza', 'Quesos curados' ),
		),
		array(
			'slug' => 'bruma-albarino', 'nombre' => 'Bruma Albariño', 'tipo' => 'vino', 'cat' => array( 'blancos-y-rosados' ), 'img' => 'albarino.jpg', 'orden' => 5, 'destacado' => true,
			'precio' => 13.90,
			'corta' => 'Albariño de las Rías Baixas: melocotón, flor blanca y un fondo salino que pide marisco.',
			'larga' => 'Del valle del Salnés, a pocos kilómetros del mar. Seis meses sobre sus lías finas, que le dan volumen sin perder la frescura atlántica.',
			'notas' => 'Melocotón · flor blanca · salinidad', 'perfil' => array( 3, 4, 5 ),
			'ficha' => array( 'D.O.' => 'Rías Baixas', 'Uva' => 'Albariño', 'Crianza' => '6 meses sobre lías', 'Graduación' => '12,5 %', 'Servir a' => '8 - 10 °C' ),
			'marida' => array( 'Marisco', 'Pescado a la plancha', 'Sushi' ),
		),
		array(
			'slug' => 'sol-de-rueda-verdejo', 'nombre' => 'Sol de Rueda Verdejo', 'tipo' => 'vino', 'cat' => array( 'blancos-y-rosados' ), 'img' => 'verdejo.jpg', 'orden' => 6,
			'precio' => 8.90,
			'corta' => 'Verdejo fresco y aromático: hierba recién cortada, lima y un toque amargo muy agradable.',
			'larga' => 'Vendimia nocturna para que la uva llegue fría a la bodega y conserve todos sus aromas. Un blanco directo y alegre para el aperitivo, ensaladas y arroces.',
			'notas' => 'Hinojo · lima · manzana verde', 'perfil' => array( 2, 4, 5 ),
			'ficha' => array( 'D.O.' => 'Rueda', 'Uva' => 'Verdejo', 'Crianza' => 'Joven', 'Graduación' => '13 %', 'Servir a' => '7 - 9 °C' ),
			'marida' => array( 'Aperitivo', 'Ensaladas', 'Arroces' ),
		),
		array(
			'slug' => 'aurora-rosado-bullas', 'nombre' => 'Aurora Rosado', 'tipo' => 'vino', 'cat' => array( 'blancos-y-rosados' ), 'img' => 'rosado.jpg', 'orden' => 7,
			'precio' => 7.50, 'oferta' => 6.50,
			'corta' => 'Rosado de Monastrell de Bullas: fresa, granada y un final fresco. Para el arroz del domingo.',
			'larga' => 'Sangrado de Monastrell tras unas horas de contacto con la piel, lo justo para darle ese color frambuesa. De viñedos de montaña de la D.O. Bullas, en el noroeste de Murcia.',
			'notas' => 'Fresa · granada · pétalo de rosa', 'perfil' => array( 2, 5, 4 ),
			'ficha' => array( 'D.O.' => 'Bullas', 'Uva' => 'Monastrell', 'Crianza' => 'Joven', 'Graduación' => '12,5 %', 'Servir a' => '8 - 10 °C' ),
			'marida' => array( 'Arroces', 'Pasta', 'Cocina asiática' ),
		),
		array(
			'slug' => 'burbuja-cava-brut-nature', 'nombre' => 'Burbuja Cava Brut Nature', 'tipo' => 'vino', 'cat' => array( 'espumosos-y-dulces' ), 'img' => 'cava.jpg', 'orden' => 8,
			'precio' => 11.90,
			'corta' => 'Cava sin azúcar añadido y con 18 meses en rima: burbuja fina, manzana y pan tostado.',
			'larga' => 'Macabeo, Xarel·lo y Parellada con segunda fermentación en botella y 18 meses de crianza. Seco, cremoso y con una burbuja muy fina. No solo para brindar: con fritos y marisco es imbatible.',
			'notas' => 'Manzana · pan tostado · almendra', 'perfil' => array( 2, 3, 5 ),
			'ficha' => array( 'D.O.' => 'Cava', 'Uva' => 'Macabeo, Xarel·lo y Parellada', 'Crianza' => '18 meses en rima', 'Graduación' => '11,5 %', 'Servir a' => '6 - 8 °C' ),
			'marida' => array( 'Aperitivo', 'Fritos', 'Marisco' ),
		),
		array(
			'slug' => 'siesta-moscatel', 'nombre' => 'Siesta Moscatel dulce 50 cl', 'tipo' => 'simple', 'cat' => array( 'espumosos-y-dulces' ), 'img' => 'moscatel.jpg', 'orden' => 9,
			'precio' => 10.90, 'peso' => 0.9,
			'corta' => 'Moscatel de Alejandría de vendimia tardía: miel, albaricoque y azahar. Botella de 50 cl.',
			'larga' => 'Uvas que se dejan en la cepa hasta que empiezan a pasificarse, para concentrar su dulzor natural. Ideal con postres, quesos azules o foie, y muy frío solo, como sobremesa.',
			'notas' => 'Miel · albaricoque · azahar', 'perfil' => array( 4, 5, 3 ),
			'ficha' => array( 'Uva' => 'Moscatel de Alejandría', 'Crianza' => 'Vendimia tardía', 'Graduación' => '15 %', 'Servir a' => '6 - 8 °C' ),
			'marida' => array( 'Postres', 'Quesos azules', 'Foie' ),
		),
		array(
			'slug' => 'aceite-virgen-extra-500', 'nombre' => 'Aceite de oliva virgen extra 500 ml', 'tipo' => 'simple', 'cat' => array( 'despensa' ), 'img' => 'aceite.jpg', 'orden' => 10,
			'precio' => 12.90, 'peso' => 0.95,
			'corta' => 'Cosecha temprana de una almazara de Moratalla: verde, afrutado y con un picor suave al final.',
			'larga' => 'Aceitunas cornicabra y picual recogidas en octubre, todavía verdes, y molturadas en frío el mismo día. Botella de vidrio oscuro para protegerlo de la luz.',
		),
		array(
			'slug' => 'queso-de-murcia-al-vino', 'nombre' => 'Queso de Murcia al vino, cuña de 400 g', 'tipo' => 'simple', 'cat' => array( 'despensa' ), 'img' => 'queso.jpg', 'orden' => 11, 'destacado' => true,
			'precio' => 11.50, 'peso' => 0.45,
			'corta' => 'Queso de cabra murciana con la corteza bañada en vino tinto de Jumilla. Suave, cremoso y un poco ácido.',
			'larga' => 'Leche pasteurizada de cabra murciano-granadina. Durante la maduración, la corteza se baña en vino tinto, que le da ese color violeta y un aroma afrutado. Cuña envasada al vacío.',
		),
		array(
			'slug' => 'jamon-iberico-loncheado', 'nombre' => 'Jamón ibérico de cebo loncheado 100 g', 'tipo' => 'simple', 'cat' => array( 'despensa' ), 'img' => 'jamon.jpg', 'orden' => 12,
			'precio' => 9.90, 'peso' => 0.15,
			'corta' => 'Loncheado a cuchillo y envasado en sobre de 100 g. Sácalo 15 minutos antes para que la grasa brille.',
			'larga' => 'Jamón de cebo ibérico 50 % raza ibérica con 30 meses de curación en bodega natural. Las lonchas se separan con papel para que no se peguen.',
		),
		array(
			'slug' => 'almendra-marcona-frita', 'nombre' => 'Almendra marcona frita con sal 200 g', 'tipo' => 'simple', 'cat' => array( 'despensa' ), 'img' => 'almendras.jpg', 'orden' => 13,
			'precio' => 5.90, 'peso' => 0.22,
			'corta' => 'Almendra marcona del Campo de Cartagena, frita en aceite de oliva y con sal en escamas.',
			'larga' => 'La marcona es más redonda, más dulce y más mantecosa que otras almendras. La freímos en aceite de oliva en lotes pequeños y la envasamos en tarro de cristal.',
		),
		array(
			'slug' => 'ventresca-de-bonito', 'nombre' => 'Ventresca de bonito del norte en aceite', 'tipo' => 'simple', 'cat' => array( 'despensa' ), 'img' => 'ventresca.jpg', 'orden' => 14,
			'precio' => 9.50, 'peso' => 0.2,
			'corta' => 'La parte más jugosa del bonito del norte, en aceite de oliva. Lata de 110 g.',
			'larga' => 'Bonito del norte pescado con caña en el Cantábrico y elaborado a mano en una conservera familiar de Santoña. Perfecta con pimientos asados o en una ensalada de tomate.',
		),
		array(
			'slug' => 'lote-mesa-para-dos', 'nombre' => 'Lote Mesa para dos', 'tipo' => 'simple', 'cat' => array( 'lotes' ), 'img' => 'lote.jpg', 'orden' => 15, 'destacado' => true,
			'precio' => 39.80, 'oferta' => 34.90, 'peso' => 2.2,
			'corta' => 'Lomas de Yecla Crianza, queso de Murcia al vino, almendra marcona y ventresca de bonito en caja de madera. Ahorras 4,90 €.',
			'larga' => 'Todo lo necesario para una cena improvisada: un tinto con crianza, un queso que le va de maravilla, algo para picar y una conserva para abrir. Se envía en caja de madera con paja y una tarjeta para escribir una dedicatoria en las notas del pedido.',
		),
	);
}

/**
 * Recomendador de maridaje: cada plato con el estilo de vino que mejor le va,
 * cómo servirlo, dos vinos de la tienda y algo de la despensa para acompañar.
 */
function cym_platos() {
	return array(
		'carnes' => array(
			'nombre' => 'Carnes y asados', 'estilo' => 'Tinto con crianza',
			'porque' => 'Los taninos del tinto con barrica limpian la grasa de la carne y la carne suaviza los taninos: cada bocado pide otro trago.',
			'servir' => array( 'Temperatura' => '16 - 18 °C', 'Copa' => 'Grande, tipo burdeos', 'Ábrelo' => '30 min antes', 'Truco' => 'Si hace calor, 10 min en la nevera' ),
			'vinos' => array( 'ladera-norte-reserva', 'paramo-crianza' ), 'picar' => 'jamon-iberico-loncheado',
		),
		'arroces' => array(
			'nombre' => 'Arroces y paella', 'estilo' => 'Rosado o blanco fresco',
			'porque' => 'Un rosado con fruta roja aguanta el sofrito y el azafrán sin tapar el sabor del arroz, y su frescura no cansa.',
			'servir' => array( 'Temperatura' => '8 - 10 °C', 'Copa' => 'Mediana, de blanco', 'Ábrelo' => 'Al servir', 'Truco' => 'Ten la botella en una cubitera' ),
			'vinos' => array( 'aurora-rosado-bullas', 'sol-de-rueda-verdejo' ), 'picar' => 'almendra-marcona-frita',
		),
		'pescado' => array(
			'nombre' => 'Pescado y marisco', 'estilo' => 'Blanco atlántico o cava',
			'porque' => 'La acidez y el punto salino del albariño realzan el sabor a mar; las burbujas del cava limpian el paladar entre bocado y bocado.',
			'servir' => array( 'Temperatura' => '6 - 9 °C', 'Copa' => 'Fina, de blanco o flauta', 'Ábrelo' => 'Al servir', 'Truco' => 'Nunca lo metas en el congelador' ),
			'vinos' => array( 'bruma-albarino', 'burbuja-cava-brut-nature' ), 'picar' => 'ventresca-de-bonito',
		),
		'quesos' => array(
			'nombre' => 'Quesos y embutidos', 'estilo' => 'Monastrell joven o con crianza',
			'porque' => 'La fruta madura de la Monastrell abraza la sal y la grasa del queso y del ibérico. Un clásico murciano que nunca falla.',
			'servir' => array( 'Temperatura' => '15 - 17 °C', 'Copa' => 'Mediana, de tinto', 'Ábrelo' => '15 min antes', 'Truco' => 'Saca el queso de la nevera media hora antes' ),
			'vinos' => array( 'lomas-de-yecla-crianza', 'penarrubia-monastrell-joven' ), 'picar' => 'queso-de-murcia-al-vino',
		),
		'pasta' => array(
			'nombre' => 'Pasta y pizza', 'estilo' => 'Tinto joven y afrutado',
			'porque' => 'La acidez del tomate pide un tinto con mucha fruta y poco tanino: refresca y no deja sabor metálico.',
			'servir' => array( 'Temperatura' => '14 - 16 °C', 'Copa' => 'Mediana, de tinto', 'Ábrelo' => 'Al servir', 'Truco' => 'Un poco más fresco de lo normal le sienta bien' ),
			'vinos' => array( 'penarrubia-monastrell-joven', 'aurora-rosado-bullas' ), 'picar' => 'aceite-virgen-extra-500',
		),
		'postres' => array(
			'nombre' => 'Postres', 'estilo' => 'Dulce natural o espumoso',
			'porque' => 'La regla de oro: el vino tiene que ser al menos igual de dulce que el postre. Si no, el vino parece amargo.',
			'servir' => array( 'Temperatura' => '6 - 8 °C', 'Copa' => 'Pequeña, de vino dulce', 'Ábrelo' => 'Al servir', 'Truco' => 'Una vez abierto aguanta dos semanas en la nevera' ),
			'vinos' => array( 'siesta-moscatel', 'burbuja-cava-brut-nature' ), 'picar' => 'almendra-marcona-frita',
		),
	);
}
