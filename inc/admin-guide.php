<?php
/**
 * MAVI by Besky — Guide & Infobulles Admin
 *
 * Ajoute des pointeurs (tooltips) WordPress natifs pour guider
 * l'utilisateur dans la prise en main du thème.
 *
 * Les infobulles s'affichent une seule fois et sont masquées
 * quand l'utilisateur clique "Compris". Elles reviennent
 * via Apparence → Guide MAVI (bouton réinitialiser).
 *
 * @package Mavi
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mavi_Admin_Guide {

	/**
	 * Clé meta user pour stocker les pointeurs déjà vus.
	 */
	const META_KEY = 'mavi_dismissed_pointers';

	/**
	 * Tous les pointeurs du thème.
	 */
	private static function get_pointers() {
		return array(

			// ── Dashboard ──
			'mavi_welcome' => array(
				'screen'  => 'dashboard',
				'target'  => '#wp-admin-bar-site-name',
				'edge'    => 'top',
				'align'   => 'left',
				'title'   => '👋 Bienvenue sur MAVI by Besky !',
				'content' => '<p>Votre thème WordPress est prêt. Voici quelques repères :</p>
					<ul style="list-style:disc;padding-left:1.2em;margin:0.5em 0;">
						<li><strong>Apparence → Éditeur</strong> : modifiez les templates, headers et footers</li>
						<li><strong>Outils → Import Notion</strong> : importez vos pages Notion (export HTML zippé)</li>
						<li><strong>Patterns MAVI</strong> : dans l\'éditeur, insérez des blocs pré-faits (carrousels, callouts, timelines…)</li>
					</ul>',
			),

			// ── Apparence ──
			'mavi_appearance' => array(
				'screen'  => 'themes',
				'target'  => '#menu-appearance',
				'edge'    => 'right',
				'align'   => 'middle',
				'title'   => '🎨 Personnaliser le thème',
				'content' => '<p><strong>Apparence → Éditeur</strong> ouvre l\'éditeur complet du site (FSE).</p>
					<p>Depuis là vous pouvez :</p>
					<ul style="list-style:disc;padding-left:1.2em;margin:0.5em 0;">
						<li>Changer de <strong>header</strong> (Logo+Nav, Centré, ou Minimal)</li>
						<li>Changer de <strong>footer</strong> (Complet ou Minimal)</li>
						<li>Modifier les <strong>couleurs et polices</strong> dans Styles</li>
						<li>Éditer chaque <strong>template</strong> de page</li>
					</ul>',
			),

			// ── Éditeur de page ──
			'mavi_editor_patterns' => array(
				'screen'  => 'post',
				'target'  => '.edit-post-header-toolbar__inserter-toggle, .editor-document-tools__inserter-toggle',
				'edge'    => 'bottom',
				'align'   => 'left',
				'title'   => '🧩 Patterns MAVI',
				'content' => '<p>Cliquez sur le <strong>+</strong> puis l\'onglet <strong>Compositions</strong> → catégorie <strong>MAVI</strong>.</p>
					<p>Vous y trouverez des blocs prêts à l\'emploi :</p>
					<ul style="list-style:disc;padding-left:1.2em;margin:0.5em 0;">
						<li>📝 Callouts (info, succès, attention, danger)</li>
						<li>🎠 Carrousel d\'images ou de contenu</li>
						<li>📊 Timeline, Project Card</li>
						<li>💬 Citation Notion-style</li>
						<li>📑 Table des matières auto</li>
					</ul>',
			),

			// ── Outils ──
			'mavi_tools_notion' => array(
				'screen'  => 'tools',
				'target'  => '#menu-tools',
				'edge'    => 'right',
				'align'   => 'middle',
				'title'   => '📥 Import Notion',
				'content' => '<p>Allez dans <strong>Outils → Import Notion</strong> pour importer vos pages.</p>
					<p><strong>Comment faire :</strong></p>
					<ol style="padding-left:1.2em;margin:0.5em 0;">
						<li>Dans Notion : <em>⋯ → Export → HTML</em></li>
						<li>Vous obtenez un fichier <code>.zip</code></li>
						<li>Uploadez-le ici, les pages deviennent des articles/pages WordPress avec blocs Gutenberg</li>
					</ol>',
			),

			// ── Éditeur de site (FSE) ──
			'mavi_site_editor' => array(
				'screen'  => 'site-editor',
				'target'  => '.edit-site-layout__sidebar-region, .edit-site-navigation-panel',
				'edge'    => 'right',
				'align'   => 'top',
				'title'   => '⚙️ Éditeur de site complet',
				'content' => '<p>Ici vous pouvez modifier la structure globale du site :</p>
					<ul style="list-style:disc;padding-left:1.2em;margin:0.5em 0;">
						<li><strong>Modèles</strong> : page d\'accueil, article, archive…</li>
						<li><strong>Composants</strong> : changez de header ou footer en cliquant dessus → <em>Remplacer</em></li>
						<li><strong>Styles</strong> : couleurs, polices, espacements globaux</li>
					</ul>
					<p>💡 Pour changer de header : cliquez dessus → sidebar droite → <strong>Remplacer</strong></p>',
			),
		);
	}

	/**
	 * Initialise le guide.
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_pointers' ) );
		add_action( 'admin_menu', array( __CLASS__, 'add_guide_page' ) );
		add_action( 'wp_ajax_mavi_dismiss_pointer', array( __CLASS__, 'ajax_dismiss' ) );
		add_action( 'admin_post_mavi_reset_guide', array( __CLASS__, 'handle_reset' ) );

		// Ajouter un lien rapide dans la barre admin
		add_action( 'admin_bar_menu', array( __CLASS__, 'admin_bar_link' ), 100 );

		// Widget tableau de bord
		add_action( 'wp_dashboard_setup', array( __CLASS__, 'add_dashboard_widget' ) );
	}

	/**
	 * Ajoute un widget au tableau de bord.
	 */
	public static function add_dashboard_widget() {
		wp_add_dashboard_widget(
			'mavi_guide_widget',
			'💡 MAVI — Accès rapide',
			array( __CLASS__, 'render_dashboard_widget' )
		);

		// Remonter le widget en haut
		global $wp_meta_boxes;
		$widget = $wp_meta_boxes['dashboard']['normal']['core']['mavi_guide_widget'] ?? null;
		if ( $widget ) {
			unset( $wp_meta_boxes['dashboard']['normal']['core']['mavi_guide_widget'] );
			$wp_meta_boxes['dashboard']['normal']['high']['mavi_guide_widget'] = $widget;
		}
	}

	/**
	 * Contenu du widget tableau de bord.
	 */
	public static function render_dashboard_widget() {
		?>
		<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
			<a href="<?php echo admin_url( 'site-editor.php' ); ?>" class="button" style="text-align:center;">
				🎨 Éditeur de site
			</a>
			<a href="<?php echo admin_url( 'tools.php?page=mavi-notion-import' ); ?>" class="button" style="text-align:center;">
				📥 Import Notion
			</a>
			<a href="<?php echo admin_url( 'themes.php?page=mavi-guide' ); ?>" class="button" style="text-align:center;">
				💡 Guide complet
			</a>
			<a href="<?php echo admin_url( 'post-new.php?post_type=page' ); ?>" class="button" style="text-align:center;">
				📄 Nouvelle page
			</a>
		</div>
		<p style="margin:12px 0 4px;color:#666;font-size:0.9em;">
			💡 Dans l'éditeur, cliquez <strong>+</strong> → <strong>Compositions</strong> → <strong>MAVI</strong> pour les patterns prêts à l'emploi.
		</p>
		<?php
	}

	/**
	 * Ajoute un lien "Guide MAVI" dans la barre admin.
	 */
	public static function admin_bar_link( $wp_admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$wp_admin_bar->add_node( array(
			'id'    => 'mavi-guide',
			'title' => '💡 Guide MAVI',
			'href'  => admin_url( 'themes.php?page=mavi-guide' ),
			'meta'  => array(
				'title' => 'Aide et guide du thème MAVI',
			),
		) );
	}

	/**
	 * Page du guide dans Apparence.
	 */
	public static function add_guide_page() {
		add_theme_page(
			'Guide MAVI',
			'💡 Guide MAVI',
			'edit_posts',
			'mavi-guide',
			array( __CLASS__, 'render_guide_page' )
		);
	}

	/**
	 * Rendu de la page guide.
	 */
	public static function render_guide_page() {
		$reset_url = wp_nonce_url( admin_url( 'admin-post.php?action=mavi_reset_guide' ), 'mavi_reset_guide' );
		?>
		<div class="wrap" style="max-width: 800px;">
			<h1 style="display:flex;align-items:center;gap:0.5em;">💡 Guide du thème MAVI by Besky</h1>
			<p style="font-size: 1.1em; color: #555;">Tout ce qu'il faut savoir pour utiliser votre thème.</p>

			<hr>

			<!-- Section 1 : Premiers pas -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">🚀 Premiers pas</h2>
				<ol style="font-size:1em;line-height:1.8;">
					<li>Allez dans <strong>Apparence → Éditeur</strong> pour voir et modifier la structure du site</li>
					<li>Ajoutez votre <strong>logo</strong> : Réglages → Général → Identité du site</li>
					<li>Changez le <strong>titre du site</strong> depuis le même endroit</li>
					<li>Créez des pages (Accueil, À propos, Portfolio…) depuis <strong>Pages → Ajouter</strong></li>
				</ol>
			</div>

			<!-- Section 2 : Headers & Footers -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">🔄 Changer de Header ou Footer</h2>
				<p>Le thème propose <strong>3 headers</strong> et <strong>2 footers</strong> interchangeables :</p>
				<table class="widefat striped" style="margin:1em 0;">
					<thead>
						<tr><th>Composant</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr><td><strong>En-tête — Logo + Navigation</strong></td><td>Logo à gauche, menu à droite (par défaut)</td></tr>
						<tr><td><strong>En-tête — Centré</strong></td><td>Logo et menu centrés</td></tr>
						<tr><td><strong>En-tête — Minimal</strong></td><td>Titre seul, sans logo ni navigation</td></tr>
						<tr><td><strong>Pied de page — Complet</strong></td><td>Fond navy, titre, copyright, réseaux sociaux</td></tr>
						<tr><td><strong>Pied de page — Minimal</strong></td><td>Simple ligne copyright sur fond sable</td></tr>
					</tbody>
				</table>
				<p><strong>Comment changer :</strong></p>
				<ol>
					<li>Allez dans <strong>Apparence → Éditeur</strong></li>
					<li>Ouvrez un <strong>modèle</strong> (ex: Page d'accueil)</li>
					<li>Cliquez sur le <strong>header</strong> ou le <strong>footer</strong></li>
					<li>Dans la sidebar droite, cliquez <strong>Remplacer</strong></li>
					<li>Choisissez la variante souhaitée</li>
				</ol>
			</div>

			<!-- Section 3 : Patterns -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">🧩 Blocs & Patterns MAVI</h2>
				<p>Quand vous éditez une page, cliquez le <strong>+</strong> en haut à gauche → onglet <strong>Compositions</strong> → catégorie <strong>MAVI</strong>.</p>
				<table class="widefat striped" style="margin:1em 0;">
					<thead>
						<tr><th>Pattern</th><th>Usage</th></tr>
					</thead>
					<tbody>
						<tr><td>📝 <strong>Callout</strong> (info, succès, attention, danger)</td><td>Encadrés colorés pour mettre en avant une info</td></tr>
						<tr><td>🎠 <strong>Carrousel d'images</strong></td><td>Slider d'images swipable</td></tr>
						<tr><td>🃏 <strong>Carrousel de contenu</strong></td><td>Cartes swipables avec tout type de contenu</td></tr>
						<tr><td>📊 <strong>Timeline</strong></td><td>Frise chronologique verticale</td></tr>
						<tr><td>🗂️ <strong>Project Card</strong></td><td>Carte projet avec image, tags, description</td></tr>
						<tr><td>💬 <strong>Citation</strong></td><td>Citation élégante style Notion</td></tr>
						<tr><td>📑 <strong>Table des matières</strong></td><td>Sommaire auto-généré depuis les titres</td></tr>
						<tr><td>🖼️ <strong>Cover + Icon</strong></td><td>Bandeau image avec emoji superposé</td></tr>
						<tr><td>📐 <strong>Section pleine largeur</strong></td><td>Section de contenu full-width</td></tr>
					</tbody>
				</table>
			</div>

			<!-- Section 4 : Import Notion -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">📥 Importer depuis Notion</h2>
				<ol style="font-size:1em;line-height:1.8;">
					<li>Dans Notion, ouvrez la page à exporter</li>
					<li>Cliquez <strong>⋯ → Exporter → Format HTML</strong></li>
					<li>Vous obtenez un fichier <code>.zip</code></li>
					<li>Dans WordPress, allez dans <strong><a href="<?php echo admin_url( 'tools.php?page=mavi-notion-import' ); ?>">Outils → Import Notion</a></strong></li>
					<li>Uploadez le zip → les pages deviennent des articles WordPress avec blocs Gutenberg</li>
				</ol>
				<p>Les images sont automatiquement importées dans la bibliothèque de médias.</p>
			</div>

			<!-- Section 5 : Templates -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">📄 Templates de page</h2>
				<p>Quand vous éditez une page, dans la sidebar droite → <strong>Modèle</strong>, vous pouvez choisir :</p>
				<table class="widefat striped" style="margin:1em 0;">
					<thead>
						<tr><th>Template</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr><td><strong>Page</strong></td><td>Page standard avec header + footer</td></tr>
						<tr><td><strong>Page avec bandeau</strong></td><td>Grande image de couverture en haut</td></tr>
						<tr><td><strong>Plein écran</strong></td><td>Contenu sans marges latérales</td></tr>
						<tr><td><strong>Page sans bandeau</strong></td><td>Contenu seul, pas de couverture</td></tr>
						<tr><td><strong>Page sans en-tête</strong></td><td>Pas de header (landing page, etc.)</td></tr>
						<tr><td><strong>Portfolio</strong></td><td>Mise en page pour projets</td></tr>
					</tbody>
				</table>
			</div>

			<!-- Section 6 : Couleurs -->
			<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:1.5em 0;">
				<h2 style="margin-top:0;">🎨 Palette de couleurs IIACA</h2>
				<div style="display:flex;flex-wrap:wrap;gap:0.5em;margin:1em 0;">
					<?php
					$colors = array(
						'#2C3A54' => 'Navy',
						'#5A6A7E' => 'Bleu gris',
						'#C1593B' => 'Terracotta',
						'#D97B5A' => 'Terracotta clair',
						'#FAF5EE' => 'Crème',
						'#F0E8DC' => 'Sable',
						'#FFFFFF' => 'Blanc',
						'#D9CEBD' => 'Bordure',
					);
					foreach ( $colors as $hex => $name ) :
						$text = in_array( $hex, array( '#FAF5EE', '#F0E8DC', '#FFFFFF', '#D9CEBD' ) ) ? '#2C3A54' : '#fff';
						?>
						<span style="background:<?php echo $hex; ?>;color:<?php echo $text; ?>;padding:0.4em 0.8em;border-radius:4px;font-size:0.85em;border:1px solid #ddd;">
							<?php echo esc_html( $name ); ?> <code style="color:<?php echo $text; ?>;font-size:0.8em;"><?php echo $hex; ?></code>
						</span>
					<?php endforeach; ?>
				</div>
				<p>Ces couleurs sont disponibles dans le sélecteur de couleurs de l'éditeur.</p>
			</div>

			<!-- Réinitialiser les infobulles -->
			<div style="background:#f0f0f1;border:1px solid #ddd;border-radius:8px;padding:1.5em;margin:2em 0;">
				<h3 style="margin-top:0;">🔄 Revoir les infobulles</h3>
				<p>Si vous avez fermé les infobulles d'aide et souhaitez les revoir :</p>
				<a href="<?php echo esc_url( $reset_url ); ?>" class="button button-secondary">Réinitialiser les infobulles</a>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueue les scripts de pointeurs WordPress.
	 */
	public static function enqueue_pointers( $hook ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$dismissed = self::get_dismissed();
		$pointers  = self::get_pointers();
		$screen    = get_current_screen();

		if ( ! $screen ) {
			return;
		}

		// Trouver les pointeurs pour cet écran
		$active = array();
		foreach ( $pointers as $id => $pointer ) {
			if ( in_array( $id, $dismissed, true ) ) {
				continue;
			}

			// Correspondance écran
			$match = false;
			if ( $pointer['screen'] === $screen->id ) {
				$match = true;
			} elseif ( $pointer['screen'] === 'post' && in_array( $screen->base, array( 'post', 'page' ), true ) ) {
				$match = true;
			} elseif ( $pointer['screen'] === 'tools' && $screen->id === 'tools_page_mavi-notion-import' ) {
				$match = true;
			}

			if ( $match ) {
				$active[ $id ] = $pointer;
			}
		}

		if ( empty( $active ) ) {
			return;
		}

		// Charger le CSS/JS natif des pointeurs WordPress
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );

		// Injecter le JS
		$js = '';
		foreach ( $active as $id => $pointer ) {
			$js .= sprintf(
				'jQuery(document).ready(function($){
					var target = $("%s");
					if (target.length === 0) return;
					target.first().pointer({
						content: "<h3>%s</h3><div style=\"padding:0 12px 12px\">%s</div>",
						position: { edge: "%s", align: "%s" },
						pointerWidth: 380,
						close: function() {
							$.post(ajaxurl, {
								action: "mavi_dismiss_pointer",
								pointer: "%s",
								_wpnonce: "%s"
							});
						}
					}).pointer("open");
				});' . "\n",
				esc_js( $pointer['target'] ),
				esc_js( $pointer['title'] ),
				$pointer['content'],
				esc_js( $pointer['edge'] ),
				esc_js( $pointer['align'] ),
				esc_js( $id ),
				wp_create_nonce( 'mavi_dismiss_pointer' )
			);
		}

		wp_add_inline_script( 'wp-pointer', $js );
	}

	/**
	 * AJAX : marquer un pointeur comme vu.
	 */
	public static function ajax_dismiss() {
		check_ajax_referer( 'mavi_dismiss_pointer', '_wpnonce' );

		if ( ! isset( $_POST['pointer'] ) ) {
			wp_die();
		}

		$pointer   = sanitize_key( $_POST['pointer'] );
		$dismissed = self::get_dismissed();

		if ( ! in_array( $pointer, $dismissed, true ) ) {
			$dismissed[] = $pointer;
			update_user_meta( get_current_user_id(), self::META_KEY, $dismissed );
		}

		wp_die();
	}

	/**
	 * Réinitialiser les infobulles.
	 */
	public static function handle_reset() {
		check_admin_referer( 'mavi_reset_guide' );

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( 'Accès non autorisé.' );
		}

		delete_user_meta( get_current_user_id(), self::META_KEY );

		wp_redirect( admin_url( 'themes.php?page=mavi-guide&reset=1' ) );
		exit;
	}

	/**
	 * Récupère la liste des pointeurs déjà fermés.
	 */
	private static function get_dismissed() {
		$dismissed = get_user_meta( get_current_user_id(), self::META_KEY, true );
		return is_array( $dismissed ) ? $dismissed : array();
	}
}

// Initialiser le guide
Mavi_Admin_Guide::init();
