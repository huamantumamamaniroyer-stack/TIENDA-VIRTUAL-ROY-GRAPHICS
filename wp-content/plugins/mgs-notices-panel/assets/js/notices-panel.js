(function () {
	var cfg = window.mgsNoticesPanel;
	if (!cfg) return;
	var p = cfg.prefix;
	var panel, badge, button, empty;

	function init() {
		button = document.querySelector('#wp-admin-bar-' + p + ' > a');
		badge = document.querySelector('#wp-admin-bar-' + p + ' .' + p + '-count');
		var wrap = document.getElementById('wpbody-content');
		if (!button || !wrap) return;

		panel = document.createElement('div');
		panel.id = p + '-panel';
		panel.hidden = true;

		// messaggio mostrato quando non resta nessuna notice da leggere
		empty = document.createElement('div');
		empty.className = p + '-empty';
		var icon = document.createElement('span');
		icon.className = 'dashicons dashicons-coffee';
		icon.setAttribute('aria-hidden', 'true');
		var title = document.createElement('strong');
		title.textContent = cfg.emptyTitle;
		var text = document.createElement('p');
		text.textContent = cfg.emptyText;
		empty.append(icon, title, text);
		panel.appendChild(empty);
		document.body.appendChild(panel);

		button.addEventListener('click', function (e) {
			e.preventDefault();
			panel.hidden = !panel.hidden;
		});
		document.addEventListener('click', function (e) {
			if (!panel.hidden && !panel.contains(e.target) && !button.contains(e.target)) panel.hidden = true;
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') panel.hidden = true;
		});

		collect();
		// notifiche chiuse via ajax: vengono nascoste o rimosse dal pannello, il contatore deve scalare
		new MutationObserver(recount).observe(panel, {
			childList: true,
			subtree: true,
			attributes: true,
			attributeFilter: ['style', 'class', 'hidden']
		});
		// WordPress sposta le notice dopo .wp-header-end e i plugin ne aggiungono in ritardo
		new MutationObserver(collect).observe(wrap, { childList: true, subtree: true });
	}

	function collect() {
		if (!cfg.selector) return;
		var found;
		try {
			found = document.querySelectorAll(cfg.selector);
		} catch (err) {
			return; // selettore non valido arrivato dal filtro: niente da raccogliere
		}
		found.forEach(function (el) {
			if (panel.contains(el)) return;
			el.classList.add(p + '-moved');
			panel.appendChild(el);
		});
		recount();
	}

	function recount() {
		var n = 0;
		panel.querySelectorAll('.' + p + '-moved').forEach(function (el) {
			if (getComputedStyle(el).display !== 'none') n++;
		});
		badge.textContent = n;
		badge.hidden = n === 0;
		// solo se cambia: anche riassegnare lo stesso valore fa scattare l'observer del pannello
		if (empty.hidden !== n > 0) empty.hidden = n > 0;
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
	else init();
})();
