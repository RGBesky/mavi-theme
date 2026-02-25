/**
 * MAVI Emoji Picker — Style Notion pour les callouts.
 * Affiche un picker d'emojis quand on clique sur l'icône d'un callout dans Gutenberg.
 */
(function () {
	'use strict';

	/* ======================================================================
	   1. CATALOGUE D'EMOJIS (organisé comme Notion)
	   ====================================================================== */
	const EMOJI_CATEGORIES = [
		{
			name: '⭐ Favoris',
			emojis: [
				'💡','ℹ️','⚠️','🚨','✅','❌','📌','📝','🔗','💬',
				'🎯','🚀','💪','👉','👀','🔥','⭐','💎','🏆','📣',
			],
		},
		{
			name: '😀 Visages',
			emojis: [
				'😀','😃','😄','😁','😊','🥰','😎','🤔','🤗','😮',
				'😢','😡','🥳','🤩','😴','🤓','🙃','😬','🫡','🫠',
			],
		},
		{
			name: '👋 Mains',
			emojis: [
				'👋','👍','👎','👏','🙌','🤝','✊','✌️','🤞','👆',
				'👇','👈','👉','☝️','🫵','💪','🙏','✍️','🤙','🫶',
			],
		},
		{
			name: '🔔 Objets',
			emojis: [
				'📌','📝','📎','📋','📁','📂','🗂️','📊','📈','📉',
				'🔔','🔕','📣','📢','🔑','🔒','🔓','🏷️','💰','💳',
			],
		},
		{
			name: '💻 Tech',
			emojis: [
				'💻','🖥️','📱','⌨️','🖱️','💾','💿','🌐','📡','🔌',
				'🔋','⚙️','🛠️','🔧','🔩','🧲','🧪','🧬','📐','📏',
			],
		},
		{
			name: '🌿 Nature',
			emojis: [
				'🌿','🌱','🌳','🌸','🌺','🌻','🍀','🍃','🌍','🌞',
				'🌈','❄️','🔥','💧','⚡','🌊','🌙','⭐','☀️','🌤️',
			],
		},
		{
			name: '🎨 Symboles',
			emojis: [
				'✅','❌','⭕','❗','❓','‼️','⁉️','💯','🔴','🟠',
				'🟡','🟢','🔵','🟣','🟤','⚫','⚪','🔶','🔷','♻️',
			],
		},
		{
			name: '🏢 Bureau',
			emojis: [
				'📅','📆','🗓️','📇','📑','📃','📄','📰','🗞️','📚',
				'📖','📒','📓','📔','📕','📗','📘','📙','🗃️','✉️',
			],
		},
	];

	/* ======================================================================
	   2. CRÉER LE PICKER
	   ====================================================================== */
	let pickerEl = null;
	let activeIconBlock = null;
	let searchInput = null;

	function createPicker() {
		if (pickerEl) return pickerEl;

		pickerEl = document.createElement('div');
		pickerEl.className = 'mavi-emoji-picker';
		pickerEl.addEventListener('mousedown', (e) => e.stopPropagation());
		pickerEl.addEventListener('click', (e) => e.stopPropagation());

		// Barre de recherche
		const searchWrap = document.createElement('div');
		searchWrap.className = 'mavi-emoji-picker__search';
		searchInput = document.createElement('input');
		searchInput.type = 'text';
		searchInput.placeholder = 'Rechercher un emoji…';
		searchInput.addEventListener('input', onSearch);
		searchWrap.appendChild(searchInput);
		pickerEl.appendChild(searchWrap);

		// Contenu
		const content = document.createElement('div');
		content.className = 'mavi-emoji-picker__content';

		EMOJI_CATEGORIES.forEach((cat) => {
			const section = document.createElement('div');
			section.className = 'mavi-emoji-picker__section';
			section.dataset.category = cat.name;

			const title = document.createElement('div');
			title.className = 'mavi-emoji-picker__category';
			title.textContent = cat.name;
			section.appendChild(title);

			const grid = document.createElement('div');
			grid.className = 'mavi-emoji-picker__grid';
			cat.emojis.forEach((emoji) => {
				const btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'mavi-emoji-picker__btn';
				btn.textContent = emoji;
				btn.title = emoji;
				btn.addEventListener('click', () => selectEmoji(emoji));
				grid.appendChild(btn);
			});
			section.appendChild(grid);
			content.appendChild(section);
		});

		pickerEl.appendChild(content);
		document.body.appendChild(pickerEl);
		return pickerEl;
	}

	/* ======================================================================
	   3. RECHERCHE
	   ====================================================================== */
	function onSearch() {
		const query = searchInput.value.trim().toLowerCase();
		const sections = pickerEl.querySelectorAll('.mavi-emoji-picker__section');
		sections.forEach((section) => {
			const buttons = section.querySelectorAll('.mavi-emoji-picker__btn');
			let visible = 0;
			buttons.forEach((btn) => {
				// Simple : on ne filtre que si query non vide
				const show = !query || btn.textContent.includes(query);
				btn.style.display = show ? '' : 'none';
				if (show) visible++;
			});
			section.style.display = visible > 0 ? '' : 'none';
		});
	}

	/* ======================================================================
	   4. SÉLECTION D'UN EMOJI
	   ====================================================================== */
	function selectEmoji(emoji) {
		if (!activeIconBlock) return;

		// Remplacer le contenu texte du bloc icône
		activeIconBlock.textContent = emoji;

		// Déclencher un event input pour que Gutenberg enregistre le changement
		activeIconBlock.dispatchEvent(new Event('input', { bubbles: true }));

		closePicker();
	}

	/* ======================================================================
	   5. OUVRIR / FERMER
	   ====================================================================== */
	function openPicker(iconEl) {
		activeIconBlock = iconEl;
		const picker = createPicker();

		// Positionnement sous l'icône
		const rect = iconEl.getBoundingClientRect();
		const editorCanvas = document.querySelector('iframe[name="editor-canvas"]');
		let top = rect.bottom + 8;
		let left = rect.left;

		// Si dans un iframe (WP 6+), ajuster
		if (editorCanvas) {
			const iframeRect = editorCanvas.getBoundingClientRect();
			top = iframeRect.top + rect.bottom + 8;
			left = iframeRect.left + rect.left;
		}

		// Empêcher de dépasser à droite
		const pickerWidth = 320;
		if (left + pickerWidth > window.innerWidth) {
			left = window.innerWidth - pickerWidth - 16;
		}

		picker.style.top = top + 'px';
		picker.style.left = left + 'px';
		picker.style.display = 'block';

		// Reset recherche
		if (searchInput) {
			searchInput.value = '';
			onSearch();
		}

		// Fermer quand on clique ailleurs
		setTimeout(() => {
			document.addEventListener('click', onClickOutside, { once: true });
		}, 10);
	}

	function closePicker() {
		if (pickerEl) {
			pickerEl.style.display = 'none';
		}
		activeIconBlock = null;
	}

	function onClickOutside(e) {
		if (pickerEl && !pickerEl.contains(e.target)) {
			closePicker();
		} else if (pickerEl && pickerEl.style.display === 'block') {
			document.addEventListener('click', onClickOutside, { once: true });
		}
	}

	/* ======================================================================
	   6. ÉCOUTER LES CLICS SUR LES ICÔNES DE CALLOUT
	   ====================================================================== */
	function attachListeners(root) {
		const icons = root.querySelectorAll('.mavi-callout__icon');
		icons.forEach((icon) => {
			if (icon.dataset.emojiPicker) return;
			icon.dataset.emojiPicker = 'true';
			icon.style.cursor = 'pointer';
			icon.title = 'Cliquer pour changer l\'emoji';
			icon.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				openPicker(icon);
			});
		});
	}

	function init() {
		// Observer le DOM pour détecter nouveaux callouts (ajout de blocs)
		const observer = new MutationObserver(() => {
			// Chercher dans le document principal
			attachListeners(document);

			// Chercher dans l'iframe de l'éditeur (WP 6+)
			const iframe = document.querySelector('iframe[name="editor-canvas"]');
			if (iframe && iframe.contentDocument) {
				attachListeners(iframe.contentDocument);
			}
		});

		observer.observe(document.body, { childList: true, subtree: true });

		// Scan initial
		attachListeners(document);

		// Écouter aussi l'iframe
		const checkIframe = setInterval(() => {
			const iframe = document.querySelector('iframe[name="editor-canvas"]');
			if (iframe && iframe.contentDocument) {
				attachListeners(iframe.contentDocument);
				observer.observe(iframe.contentDocument.body, {
					childList: true,
					subtree: true,
				});
				clearInterval(checkIframe);
			}
		}, 500);

		// Stop après 30s
		setTimeout(() => clearInterval(checkIframe), 30000);
	}

	// Lancer à DOMContentLoaded ou immédiatement
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
