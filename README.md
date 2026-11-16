# Cepa y Mesa · tienda WooCommerce de demostración

Tienda de vinos de Jumilla, Yecla y Bullas, clásicos de Ribera y Rioja y una despensa gourmet: cada vino se compra en botella o en caja de 6 con descuento, y la portada tiene un recomendador de maridaje que te dice qué vino abrir según lo que vas a cocinar.

**Verla publicada:** https://cepa-y-mesa.dania360.com/

## Qué hay en este repositorio
Solo el código hecho a medida para esta tienda; WordPress y WooCommerce no se incluyen.

```
tema/cepa-y-mesa/      Tema hijo de Twenty Twenty-Five: plantillas de bloques, estilos (theme.json), tipografías y JavaScript
plugin/cepa-y-mesa-tienda/    Plugin propio: funciones de la tienda, datos del catálogo y montaje automático
```

## Cómo está hecha
- WordPress con WooCommerce 11, en el hosting de Hostinger, con su propio subdominio y certificado de seguridad
- Tema hijo propio sobre Twenty Twenty-Five: paleta granate, crema y oliva, tipografías DM Serif Display y Outfit servidas desde la propia web, cabecera, pie y portada a medida
- Portada con foto a pantalla completa, titular animado, tarjeta flotante del vino del mes, cinta de frases en movimiento y secciones que aparecen al hacer scroll
- Tienda, carrito, pago y direcciones de la web en español, con la traducción oficial de WooCommerce

## Catálogo y compra
- 15 productos en 5 categorías: tintos, blancos y rosados, espumosos y dulces, despensa gourmet y lotes
- 8 vinos en dos formatos, botella o caja de 6 con un 10 % de descuento; al elegir la caja, la ficha dice cuánto sale cada botella y cuánto ahorras
- Ficha de cata en cada vino: notas, barras de cuerpo, fruta y frescura, temperatura de servicio y con qué marida
- Ficha técnica con D.O., uva, crianza y graduación
- Ofertas con precio tachado (también en la caja) y un lote regalo con 4,90 € de ahorro
- Fotos de producto creadas para la marca
- Envío estándar a 4,90 €, gratis desde 49 € (entonces el estándar de pago desaparece) y exprés en 24 h a 7,90 €
- Cupón de bienvenida BIENVENIDA10 con un 10 % de descuento
- Casilla obligatoria "Confirmo que soy mayor de 18 años" en el pago: sin marcarla no deja hacer el pedido
- Venta cruzada en el carrito: con cada vino propone el queso y la almendra
- Pago de prueba que no pide tarjeta ni cobra nada y termina en la página de pedido recibido
- Dos pedidos de prueba completos: caja de 6 en oferta con cupón y envío gratis, y desde el móvil con envío exprés

## Detalles
- Sin plugins de pago: todo lo propio está en un plugin hecho a medida para la tienda
- Recomendador "¿Qué vas a cocinar hoy?": seis platos, cada uno con el estilo de vino, por qué funciona, temperatura, copa y cuándo abrirlo, dos vinos de la tienda y algo de la despensa para picar
- Ventana de mayoría de edad la primera vez que se entra en la tienda
- Montaje automático del catálogo, los envíos, el pago y el cupón desde el propio plugin
- Lista para conectar Stripe, Redsys o Bizum cuando sea una tienda real

## Cómo instalarlo
1. WordPress 6.6 o superior con WooCommerce activo.
2. Copia `tema/cepa-y-mesa` en `wp-content/themes/` y actívalo (necesita Twenty Twenty-Five instalado).
3. Copia `plugin/cepa-y-mesa-tienda` en `wp-content/plugins/` y actívalo.
4. El plugin incluye un montaje por pasos que crea las categorías, los productos, los envíos y las páginas; se desactiva solo al terminar.

Tipografías de Google Fonts con licencia SIL Open Font License, incluidas en `tema/cepa-y-mesa/assets/fonts`.

## Sobre esta tienda
Diseño y desarrollo de [Dania360](https://dania360.com). Es una tienda de ejemplo: la marca y los productos son inventados, las fotos se crearon para la marca y el pago es de prueba, no cobra nada. El código se publica para enseñar cómo está hecha; no tiene licencia de uso.

Más tiendas en el portafolio: https://tiendas.dania360.com
