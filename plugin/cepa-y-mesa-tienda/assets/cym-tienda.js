/* Cepa y Mesa Tienda: recomendador de maridaje, aviso de la caja de 6 y ventana de mayoría de edad. */
(function () {
	var CAJA = 'Caja de 6 (-10 %)';
	var euros = function (n) { return n.toFixed(2).replace('.', ',') + ' €'; };

	// Pestañas del recomendador, con teclado.
	document.querySelectorAll('.cym-mar').forEach(function (bloque) {
		var tabs = Array.prototype.slice.call(bloque.querySelectorAll('[role=tab]'));
		function elegir(tab, foco) {
			tabs.forEach(function (t) {
				var activo = t === tab;
				t.setAttribute('aria-selected', activo ? 'true' : 'false');
				t.tabIndex = activo ? 0 : -1;
				var panel = document.getElementById(t.getAttribute('aria-controls'));
				if (panel) { panel.hidden = !activo; if (activo) { panel.classList.remove('entra'); void panel.offsetWidth; panel.classList.add('entra'); } }
			});
			if (foco) tab.focus();
		}
		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () { elegir(tab); });
			tab.addEventListener('keydown', function (e) {
				var n = null;
				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') n = tabs[(i + 1) % tabs.length];
				if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') n = tabs[(i - 1 + tabs.length) % tabs.length];
				if (e.key === 'Home') n = tabs[0];
				if (e.key === 'End') n = tabs[tabs.length - 1];
				if (n) { e.preventDefault(); elegir(n, true); }
			});
		});
	});

	// En la ficha del vino: cuánto sale la botella si eliges la caja de 6.
	var aviso = document.querySelector('.cym-caja');
	var form = document.querySelector('form.variations_form');
	if (aviso && form && window.jQuery) {
		var variaciones = [];
		try { variaciones = JSON.parse(form.getAttribute('data-product_variations')) || []; } catch (e) {}
		var botella = variaciones.filter(function (v) { return v.attributes.attribute_formato !== CAJA; })[0];
		var poner = function (texto) { aviso.textContent = texto; aviso.classList.toggle('visible', !!texto); };
		window.jQuery(form).on('found_variation', function (e, v) {
			if (v.attributes.attribute_formato === CAJA && botella) {
				var ahorro = botella.display_price * 6 - v.display_price;
				poner('Te sale a ' + euros(v.display_price / 6) + ' la botella: ahorras ' + euros(ahorro) + ' frente a 6 botellas sueltas.');
			} else {
				poner('¿Lo abres a menudo? En caja de 6 cada botella te sale un 10 % más barata.');
			}
		}).on('reset_data', function () { poner(''); });
	}

	// Ventana de mayoría de edad: solo la primera vez.
	var edad = document.getElementById('cym-edad');
	if (edad) {
		var dicho = null;
		try { dicho = localStorage.getItem('cym_edad'); } catch (e) {}
		if (dicho !== 'si') {
			edad.hidden = false;
			document.documentElement.classList.add('cym-bloqueo');
			var primero = edad.querySelector('[data-edad="si"]');
			if (primero) setTimeout(function () { primero.focus(); }, 50);
		}
		edad.addEventListener('click', function (e) {
			var b = e.target.closest('[data-edad]');
			if (!b) return;
			if (b.getAttribute('data-edad') === 'si') {
				try { localStorage.setItem('cym_edad', 'si'); } catch (err) {}
				edad.classList.add('fuera');
				document.documentElement.classList.remove('cym-bloqueo');
				setTimeout(function () { edad.hidden = true; }, 400);
			} else {
				edad.querySelector('.cym-edad__no').hidden = false;
			}
		});
	}

	function avisar(el) {
		if (window.jQuery) window.jQuery(el).trigger('change');
		else el.dispatchEvent(new Event('change', { bubbles: true }));
	}

	// Ficha del vino: el desplegable de formato pasa a ser botones con su precio.
	var formu = document.querySelector('form.variations_form');
	if (formu) {
		var form = formu;
		var variaciones = [];
		try { variaciones = JSON.parse(form.getAttribute('data-product_variations')) || []; } catch (e) { variaciones = []; }
		var grupos = [];
		form.querySelectorAll('table.variations select').forEach(function (sel) {
			var etiqueta = form.querySelector('label[for="' + sel.id + '"]');
			var grupo = document.createElement('div');
			grupo.className = 'cym-pildoras';
			grupo.setAttribute('role', 'group');
			if (etiqueta) { etiqueta.id = etiqueta.id || 'cym-et-' + sel.id; grupo.setAttribute('aria-labelledby', etiqueta.id); }
			Array.prototype.forEach.call(sel.options, function (op) {
				if (!op.value) return;
				var b = document.createElement('button');
				b.type = 'button';
				b.setAttribute('data-valor', op.value);
				b.textContent = op.textContent;
				if (sel.name === 'attribute_formato') {
					var v = variaciones.filter(function (x) { return x.attributes && x.attributes.attribute_formato === op.value; })[0];
					if (v) { var s = document.createElement('small'); s.textContent = euros(v.display_price); b.appendChild(s); }
				}
				b.addEventListener('click', function () { sel.value = op.value; avisar(sel); });
				grupo.appendChild(b);
			});
			sel.parentNode.insertBefore(grupo, sel);
			sel.classList.add('cym-oculto');
			sel.setAttribute('tabindex', '-1');
			grupos.push({ sel: sel, grupo: grupo });
		});
		var pintar = function () {
			grupos.forEach(function (g) {
				g.grupo.querySelectorAll('button').forEach(function (b) {
					var valor = b.getAttribute('data-valor'), existe = false;
					Array.prototype.forEach.call(g.sel.options, function (op) { if (op.value === valor && !op.disabled) existe = true; });
					b.disabled = !existe;
					b.setAttribute('aria-pressed', g.sel.value === valor ? 'true' : 'false');
				});
			});
		};
		if (grupos.length) {
			form.classList.add('cym-con-pildoras');
			form.addEventListener('change', pintar);
			if (window.jQuery) window.jQuery(form).on('change woocommerce_update_variation_values reset_data found_variation', function () { setTimeout(pintar, 0); });
			pintar();
		}
	}

	// Cantidad con botones de menos y más.
	document.querySelectorAll('form.cart .quantity').forEach(function (caja) {
		var campo = caja.querySelector('input.qty');
		if (!campo || campo.type === 'hidden' || caja.querySelector('.cym-cant')) return;
		caja.classList.add('cym-cantidad');
		[['−', -1, 'Quitar una unidad'], ['+', 1, 'Añadir una unidad']].forEach(function (d) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'cym-cant';
			b.textContent = d[0];
			b.setAttribute('aria-label', d[2]);
			b.addEventListener('click', function () {
				var paso = parseFloat(campo.step) || 1, min = parseFloat(campo.min) || 1, max = parseFloat(campo.max) || Infinity;
				var n = (parseFloat(campo.value) || 0) + d[1] * paso;
				campo.value = Math.max(min, Math.min(max, n));
				avisar(campo);
			});
			if (d[1] < 0) caja.insertBefore(b, caja.firstChild); else caja.appendChild(b);
		});
	});

	// Carrito: cuánto falta para el envío gratis.
	var carrito = document.querySelector('.wp-block-woocommerce-cart');
	if (carrito && window.CYM && CYM.envioGratis) {
		var barra = document.createElement('div');
		barra.className = 'cym-envio';
		barra.hidden = true;
		barra.innerHTML = '<p class="cym-envio__texto" aria-live="polite"></p><div class="cym-envio__pista" aria-hidden="true"><span></span></div>';
		carrito.parentNode.insertBefore(barra, carrito);
		var texto = barra.querySelector('.cym-envio__texto'), relleno = barra.querySelector('.cym-envio__pista span');
		var ultimo = null;
		var actualizar = function () {
			var tienda = window.wp && wp.data && wp.data.select('wc/store/cart');
			if (!tienda) return;
			var datos = tienda.getCartData(), t = datos && datos.totals;
			if (!t || !datos.itemsCount) { barra.hidden = true; ultimo = null; return; }
			var div = Math.pow(10, t.currency_minor_unit || 2);
			var total = (parseInt(t.total_items, 10) - parseInt(t.total_discount || 0, 10)) / div;
			if (total === ultimo) return;
			ultimo = total;
			var falta = CYM.envioGratis - total;
			barra.hidden = false;
			barra.classList.toggle('cym-envio--hecho', falta <= 0);
			texto.textContent = falta > 0 ? 'Te faltan ' + euros(falta) + ' para el envío gratis.' : 'Ya tienes el envío estándar gratis.';
			relleno.style.width = Math.max(4, Math.min(100, (total / CYM.envioGratis) * 100)) + '%';
		};
		var enganchar = function (intentos) {
			if (window.wp && wp.data && wp.data.select('wc/store/cart')) { wp.data.subscribe(actualizar); actualizar(); }
			else if (intentos > 0) setTimeout(function () { enganchar(intentos - 1); }, 400);
		};
		enganchar(25);
	}
})();
