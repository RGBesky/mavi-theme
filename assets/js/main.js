/**
 * MAVI by Besky — Main JavaScript
 *
 * Fonctionnalités :
 * 1. Initialisation des carrousels Splide.js
 * 2. Bouton "Copier" sur les blocs de code
 * 3. Table des matières auto-générée
 */

document.addEventListener('DOMContentLoaded', function () {
	maviInitCarousels();
	maviInitCodeCopy();
	maviInitTableOfContents();
});

/* ==========================================================================
   1. CARROUSELS — Splide.js
   ========================================================================== */

function maviInitCarousels() {
	if (typeof Splide === 'undefined') return;

	// Carrousel d'images classique (1 slide à la fois)
	document.querySelectorAll('.mavi-carousel.splide').forEach(function (carousel) {
		new Splide(carousel, {
			type: 'loop',
			perPage: 1,
			gap: '1rem',
			pagination: true,
			arrows: true,
			autoplay: false,
			pauseOnHover: true,
			lazyLoad: 'nearby',
			breakpoints: {
				768: {
					arrows: false,
				},
			},
		}).mount();
	});

	// Carrousel de contenu (cartes swipables, multi-slides)
	document.querySelectorAll('.mavi-content-carousel.splide').forEach(function (carousel) {
		var perPageAttr = carousel.getAttribute('data-per-page');
		var perPage = perPageAttr ? parseInt(perPageAttr, 10) : 3;
		var fixedWidthAttr = carousel.getAttribute('data-fixed-width');

		var opts = {
			type: 'slide',
			perMove: 1,
			gap: '1.25rem',
			padding: { left: '0.25rem', right: '0.25rem' },
			pagination: true,
			arrows: true,
			autoplay: false,
			pauseOnHover: true,
			autoWidth: false,
			breakpoints: {
				1024: {
					perPage: Math.min(perPage, 2),
				},
				640: {
					perPage: 1,
					arrows: false,
					padding: { left: '0', right: '0' },
				},
			},
		};

		// Prefer fixedWidth for consistent slide sizing
		if (fixedWidthAttr) {
			opts.fixedWidth = fixedWidthAttr;
			opts.breakpoints[640] = {
				fixedWidth: '100%',
				arrows: false,
				padding: { left: '0', right: '0' },
			};
		} else {
			opts.perPage = perPage;
		}

		new Splide(carousel, opts).mount();
	});
}

/* ==========================================================================
   2. COPIE DE CODE — Bouton "Copier" sur les blocs <code>
   ========================================================================== */

function maviInitCodeCopy() {
	const codeBlocks = document.querySelectorAll('.wp-block-code');

	codeBlocks.forEach(function (block) {
		// Éviter les doublons
		if (block.querySelector('.mavi-copy-btn')) return;

		const btn = document.createElement('button');
		btn.className = 'mavi-copy-btn';
		btn.textContent = 'Copier';
		btn.setAttribute('aria-label', 'Copier le code');

		btn.addEventListener('click', function () {
			const code = block.querySelector('code');
			if (!code) return;

			navigator.clipboard.writeText(code.textContent).then(function () {
				btn.textContent = '✓ Copié';
				setTimeout(function () {
					btn.textContent = 'Copier';
				}, 2000);
			}).catch(function () {
				// Fallback pour les navigateurs sans clipboard API
				const textarea = document.createElement('textarea');
				textarea.value = code.textContent;
				textarea.style.position = 'fixed';
				textarea.style.opacity = '0';
				document.body.appendChild(textarea);
				textarea.select();
				document.execCommand('copy');
				document.body.removeChild(textarea);
				btn.textContent = '✓ Copié';
				setTimeout(function () {
					btn.textContent = 'Copier';
				}, 2000);
			});
		});

		block.style.position = 'relative';
		block.appendChild(btn);
	});
}

/* ==========================================================================
   3. TABLE DES MATIÈRES — Auto-générée
   ========================================================================== */

function maviInitTableOfContents() {
	const tocContainers = document.querySelectorAll('.mavi-toc');

	tocContainers.forEach(function (toc) {
		const listContainer = toc.querySelector('.mavi-toc__list');
		if (!listContainer) return;

		// Chercher les headings dans le contenu principal (hors header/footer/toc)
		const article = document.querySelector('.entry-content, .wp-block-post-content, main');
		if (!article) return;

		const headings = article.querySelectorAll('h2, h3, h4');
		if (headings.length === 0) return;

		// Vider le contenu par défaut
		listContainer.innerHTML = '';

		const ul = document.createElement('ul');

		headings.forEach(function (heading, index) {
			// Ignorer les headings dans la TOC elle-même
			if (toc.contains(heading)) return;

			// Ajouter un id si absent
			if (!heading.id) {
				heading.id = 'toc-' + index + '-' + heading.textContent.toLowerCase()
					.replace(/[^a-z0-9àâäéèêëïîôùûüÿç]+/g, '-')
					.replace(/^-|-$/g, '')
					.substring(0, 50);
			}

			const li = document.createElement('li');
			li.className = 'toc-' + heading.tagName.toLowerCase();

			const a = document.createElement('a');
			a.href = '#' + heading.id;
			a.textContent = heading.textContent;

			// Smooth scroll
			a.addEventListener('click', function (e) {
				e.preventDefault();
				heading.scrollIntoView({ behavior: 'smooth', block: 'start' });
				history.pushState(null, null, '#' + heading.id);
			});

			li.appendChild(a);
			ul.appendChild(li);
		});

		listContainer.appendChild(ul);
	});
}
