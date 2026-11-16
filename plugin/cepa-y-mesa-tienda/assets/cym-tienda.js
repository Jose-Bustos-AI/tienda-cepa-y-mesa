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
})();
