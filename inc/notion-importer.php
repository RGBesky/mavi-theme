<?php
/**
 * MAVI by Besky — Importeur Notion HTML
 *
 * Importe des pages Notion exportées en HTML (zippées) dans WordPress
 * en les convertissant automatiquement en blocs Gutenberg.
 *
 * Structure attendue d'un export Notion HTML :
 * export.zip
 * ├── Page Name abcdef1234567890.html
 * ├── Page Name abcdef1234567890/
 * │   ├── image1.png
 * │   ├── image2.jpg
 * │   └── Sub Page fedcba0987654321.html
 * └── Another Page 1234567890abcdef.html
 *
 * @package Mavi
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe principale de l'importeur Notion.
 */
class Mavi_Notion_Importer {

	/**
	 * Initialise l'importeur : menu admin + handlers.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_admin_page' ) );
		add_action( 'admin_post_mavi_import_notion', array( __CLASS__, 'handle_import' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_styles' ) );
	}

	/**
	 * Ajoute la page d'import dans le menu Outils.
	 */
	public static function add_admin_page() {
		add_management_page(
			'Import Notion',
			'Import Notion',
			'manage_options',
			'mavi-notion-import',
			array( __CLASS__, 'render_admin_page' )
		);
	}

	/**
	 * Styles inline pour la page d'admin.
	 */
	public static function admin_styles( $hook ) {
		if ( $hook !== 'tools_page_mavi-notion-import' ) {
			return;
		}

		wp_add_inline_style( 'wp-admin', '
			.mavi-import-wrap { max-width: 720px; }
			.mavi-import-wrap .card { padding: 1.5rem; margin-bottom: 1rem; }
			.mavi-import-wrap .info-list { list-style: disc; margin-left: 1.5rem; }
			.mavi-import-wrap .info-list li { margin-bottom: 0.4rem; }
			.mavi-import-result { padding: 1rem; border-radius: 4px; margin-top: 1rem; }
			.mavi-import-result.success { background: #EDF3EC; border-left: 4px solid #448361; }
			.mavi-import-result.error { background: #FDEBEC; border-left: 4px solid #D44C47; }
			.mavi-import-result ul { margin: 0.5rem 0 0 1.5rem; }
		' );
	}

	/**
	 * Affiche la page d'import.
	 */
	public static function render_admin_page() {
		$results = get_transient( 'mavi_import_results' );
		if ( $results ) {
			delete_transient( 'mavi_import_results' );
		}

		?>
		<div class="wrap mavi-import-wrap">
			<h1>📥 Import Notion → WordPress</h1>

			<div class="card">
				<h2>Comment ça marche</h2>
				<ol class="info-list">
					<li>Dans Notion, cliquez sur <strong>⋯</strong> → <strong>Exporter</strong></li>
					<li>Choisissez le format <strong>HTML</strong></li>
					<li>Cochez <strong>Inclure les sous-pages</strong> si souhaité</li>
					<li>Téléchargez le fichier <code>.zip</code></li>
					<li>Uploadez-le ci-dessous</li>
				</ol>
			</div>

			<?php if ( $results ) : ?>
				<?php foreach ( $results as $result ) : ?>
					<div class="mavi-import-result <?php echo esc_attr( $result['status'] ); ?>">
						<?php if ( $result['status'] === 'success' ) : ?>
							<strong>✅ <?php echo esc_html( $result['title'] ); ?></strong>
							— <a href="<?php echo esc_url( get_edit_post_link( $result['post_id'] ) ); ?>">Modifier</a>
							| <a href="<?php echo esc_url( get_permalink( $result['post_id'] ) ); ?>" target="_blank">Voir</a>
							<?php if ( ! empty( $result['images'] ) ) : ?>
								<br><small>📸 <?php echo intval( $result['images'] ); ?> image(s) importée(s)</small>
							<?php endif; ?>
						<?php else : ?>
							<strong>❌ Erreur :</strong> <?php echo esc_html( $result['message'] ); ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="card">
				<h2>Importer un export Notion</h2>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
					<?php wp_nonce_field( 'mavi_import_notion', 'mavi_nonce' ); ?>
					<input type="hidden" name="action" value="mavi_import_notion" />

					<table class="form-table">
						<tr>
							<th><label for="notion_zip">Fichier ZIP</label></th>
							<td>
								<input type="file" name="notion_zip" id="notion_zip" accept=".zip" required />
								<p class="description">Export Notion au format HTML (.zip)</p>
							</td>
						</tr>
						<tr>
							<th><label for="post_type">Créer comme</label></th>
							<td>
								<select name="post_type" id="post_type">
									<option value="page">Page</option>
									<option value="post">Article</option>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="post_status">Statut</label></th>
							<td>
								<select name="post_status" id="post_status">
									<option value="draft">Brouillon</option>
									<option value="publish">Publié</option>
								</select>
							</td>
						</tr>
					</table>

					<?php submit_button( '📥 Importer depuis Notion', 'primary', 'submit', true ); ?>
				</form>
			</div>

			<div class="card">
				<h2>Éléments Notion pris en charge</h2>
				<ul class="info-list">
					<li>Titres (H1, H2, H3)</li>
					<li>Paragraphes et texte enrichi (gras, italique, barré, code inline)</li>
					<li>Listes à puces et numérotées</li>
					<li>To-do / Checklist</li>
					<li>Callouts (convertis en pattern MAVI Callout)</li>
					<li>Citations (blockquote)</li>
					<li>Blocs de code</li>
					<li>Images (uploadées dans la médiathèque)</li>
					<li>Séparateurs</li>
					<li>Toggles (convertis en bloc Détails)</li>
					<li>Tableaux</li>
					<li>Liens</li>
				</ul>
			</div>
		</div>
		<?php
	}

	/**
	 * Gère l'upload et l'import.
	 */
	public static function handle_import() {
		// Vérifications de sécurité
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Accès interdit.' );
		}

		if ( ! check_admin_referer( 'mavi_import_notion', 'mavi_nonce' ) ) {
			wp_die( 'Nonce invalide.' );
		}

		if ( empty( $_FILES['notion_zip'] ) || $_FILES['notion_zip']['error'] !== UPLOAD_ERR_OK ) {
			set_transient( 'mavi_import_results', array( array(
				'status'  => 'error',
				'message' => 'Erreur lors de l\'upload du fichier.',
			) ), 60 );
			wp_redirect( admin_url( 'tools.php?page=mavi-notion-import' ) );
			exit;
		}

		$post_type   = sanitize_text_field( $_POST['post_type'] ?? 'page' );
		$post_status = sanitize_text_field( $_POST['post_status'] ?? 'draft' );

		// Extraire le ZIP
		$upload_dir = wp_upload_dir();
		$tmp_dir    = $upload_dir['basedir'] . '/mavi-notion-import-' . wp_generate_uuid4();

		WP_Filesystem();
		$unzip_result = unzip_file( $_FILES['notion_zip']['tmp_name'], $tmp_dir );

		if ( is_wp_error( $unzip_result ) ) {
			set_transient( 'mavi_import_results', array( array(
				'status'  => 'error',
				'message' => 'Impossible de décompresser : ' . $unzip_result->get_error_message(),
			) ), 60 );
			wp_redirect( admin_url( 'tools.php?page=mavi-notion-import' ) );
			exit;
		}

		// Notion double-zippe parfois : vérifier s'il y a un zip imbriqué
		$inner_zips = glob( $tmp_dir . '/*.zip' );
		if ( ! empty( $inner_zips ) && count( glob( $tmp_dir . '/*.html' ) ) === 0 ) {
			foreach ( $inner_zips as $inner_zip ) {
				unzip_file( $inner_zip, $tmp_dir );
				unlink( $inner_zip );
			}
		}

		// Trouver tous les fichiers HTML
		$html_files = self::find_html_files( $tmp_dir );

		if ( empty( $html_files ) ) {
			self::cleanup( $tmp_dir );
			set_transient( 'mavi_import_results', array( array(
				'status'  => 'error',
				'message' => 'Aucun fichier HTML trouvé dans l\'archive. Assurez-vous d\'exporter depuis Notion au format HTML.',
			) ), 60 );
			wp_redirect( admin_url( 'tools.php?page=mavi-notion-import' ) );
			exit;
		}

		$results = array();

		foreach ( $html_files as $html_file ) {
			$result = self::import_single_page( $html_file, $tmp_dir, $post_type, $post_status );
			$results[] = $result;
		}

		// Nettoyage
		self::cleanup( $tmp_dir );

		set_transient( 'mavi_import_results', $results, 60 );
		wp_redirect( admin_url( 'tools.php?page=mavi-notion-import' ) );
		exit;
	}

	/**
	 * Trouve tous les fichiers HTML récursivement.
	 */
	private static function find_html_files( $dir ) {
		$files = array();
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
		);

		foreach ( $iterator as $file ) {
			if ( $file->isFile() && strtolower( $file->getExtension() ) === 'html' ) {
				$files[] = $file->getPathname();
			}
		}

		return $files;
	}

	/**
	 * Importe une seule page Notion.
	 */
	private static function import_single_page( $html_path, $base_dir, $post_type, $post_status ) {
		$html_content = file_get_contents( $html_path );

		if ( ! $html_content ) {
			return array( 'status' => 'error', 'message' => 'Impossible de lire : ' . basename( $html_path ) );
		}

		// Parser le HTML
		$doc = new DOMDocument();
		libxml_use_internal_errors( true );
		$doc->loadHTML( '<?xml encoding="UTF-8">' . $html_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		libxml_clear_errors();

		// Extraire le titre
		$title = self::extract_title( $doc, $html_path );

		// Trouver le dossier d'images associé (même nom que le HTML sans extension)
		$html_dir = dirname( $html_path );
		$html_basename = pathinfo( $html_path, PATHINFO_FILENAME );

		// Notion crée un dossier avec le même nom que le fichier HTML (sans extension)
		$images_dir = $html_dir . '/' . $html_basename;

		// Convertir le body en blocs Gutenberg
		$body = $doc->getElementsByTagName( 'body' )->item( 0 );
		if ( ! $body ) {
			// Essayer article
			$body = $doc->getElementsByTagName( 'article' )->item( 0 );
		}

		if ( ! $body ) {
			return array( 'status' => 'error', 'message' => 'Pas de contenu trouvé dans : ' . basename( $html_path ) );
		}

		$image_count = 0;
		$block_content = self::convert_node_to_blocks( $body, $images_dir, $image_count );

		// Créer le post WordPress
		$post_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => $block_content,
			'post_type'    => $post_type,
			'post_status'  => $post_status,
		) );

		if ( is_wp_error( $post_id ) ) {
			return array(
				'status'  => 'error',
				'message' => 'Erreur création page : ' . $post_id->get_error_message(),
			);
		}

		return array(
			'status'  => 'success',
			'title'   => $title,
			'post_id' => $post_id,
			'images'  => $image_count,
		);
	}

	/**
	 * Extrait le titre depuis le HTML Notion.
	 */
	private static function extract_title( $doc, $html_path ) {
		// 1. Chercher <title>
		$titles = $doc->getElementsByTagName( 'title' );
		if ( $titles->length > 0 ) {
			$title = trim( $titles->item( 0 )->textContent );
			if ( ! empty( $title ) ) {
				return $title;
			}
		}

		// 2. Chercher le premier H1 avec classe page-title
		$xpath = new DOMXPath( $doc );
		$page_titles = $xpath->query( "//*[contains(@class, 'page-title')]" );
		if ( $page_titles->length > 0 ) {
			return trim( $page_titles->item( 0 )->textContent );
		}

		// 3. Premier H1
		$h1s = $doc->getElementsByTagName( 'h1' );
		if ( $h1s->length > 0 ) {
			return trim( $h1s->item( 0 )->textContent );
		}

		// 4. Fallback sur le nom du fichier
		$basename = pathinfo( $html_path, PATHINFO_FILENAME );
		// Supprimer le hash Notion (32 derniers caractères hexadécimaux)
		$title = preg_replace( '/\s+[a-f0-9]{32}$/i', '', $basename );
		$title = preg_replace( '/\s+[a-f0-9]{20,}$/i', '', $title );

		return $title ?: 'Page importée';
	}

	/**
	 * Convertit un nœud DOM en blocs Gutenberg (récursif).
	 */
	private static function convert_node_to_blocks( $node, $images_dir, &$image_count ) {
		$blocks = '';

		foreach ( $node->childNodes as $child ) {
			if ( $child->nodeType === XML_TEXT_NODE ) {
				$text = trim( $child->textContent );
				if ( ! empty( $text ) ) {
					$blocks .= self::make_paragraph( $text );
				}
				continue;
			}

			if ( $child->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			$tag = strtolower( $child->tagName );
			$class = $child->getAttribute( 'class' ) ?? '';

			// Ignorer les éléments de style/script/head/nav/header Notion
			if ( in_array( $tag, array( 'style', 'script', 'head', 'nav', 'link', 'meta' ), true ) ) {
				continue;
			}

			// Ignorer le titre de la page (déjà extrait)
			if ( strpos( $class, 'page-title' ) !== false ) {
				continue;
			}

			// Ignorer le header Notion (icône de page, description vide)
			if ( strpos( $class, 'page-header-icon' ) !== false || strpos( $class, 'page-description' ) !== false ) {
				continue;
			}

			// Traitement par type d'élément Notion
			switch ( true ) {
				// Callout Notion — AVANT les checks de tag car <figure> peut être un callout
				case strpos( $class, 'callout' ) !== false:
					$blocks .= self::make_callout( $child, $images_dir, $image_count );
					break;

				// Headings
				case $tag === 'h1':
					$blocks .= self::make_heading( $child, 1 );
					break;

				case $tag === 'h2':
					$blocks .= self::make_heading( $child, 2 );
					break;

				case $tag === 'h3':
					$blocks .= self::make_heading( $child, 3 );
					break;

				// Toggle Notion
				case $tag === 'details' || strpos( $class, 'toggle' ) !== false:
					$blocks .= self::make_toggle( $child, $images_dir, $image_count );
					break;

				// Quote / Blockquote
				case $tag === 'blockquote':
					$blocks .= self::make_quote( $child );
					break;

				// Code block
				case $tag === 'pre' || ( $tag === 'div' && strpos( $class, 'code' ) !== false ):
					$blocks .= self::make_code( $child );
					break;

				// Lists
				case $tag === 'ul':
					if ( strpos( $class, 'to-do' ) !== false || strpos( $class, 'toggle' ) !== false ) {
						$blocks .= self::make_todo_list( $child );
					} else {
						$blocks .= self::make_list( $child, 'unordered' );
					}
					break;

				case $tag === 'ol':
					$blocks .= self::make_list( $child, 'ordered' );
					break;

				// Images
				case $tag === 'img':
					$blocks .= self::make_image( $child, $images_dir, $image_count );
					break;

				case $tag === 'figure':
					$blocks .= self::make_figure( $child, $images_dir, $image_count );
					break;

				// Separator
				case $tag === 'hr':
					$blocks .= self::make_separator();
					break;

				// Table
				case $tag === 'table':
					$blocks .= self::make_table( $child );
					break;

				// Paragraph
				case $tag === 'p':
					$text = self::get_inner_html( $child );
					if ( ! empty( trim( strip_tags( $text ) ) ) ) {
						$blocks .= self::make_paragraph( $text );
					}
					break;

				// Div / Article / Section — Recurse
				case in_array( $tag, array( 'div', 'article', 'section', 'main', 'header', 'body', 'span' ), true ):
					if ( strpos( $class, 'column-list' ) !== false ) {
						// Colonnes Notion → wp:columns
						$blocks .= self::make_columns( $child, $images_dir, $image_count );
					} else {
						$blocks .= self::convert_node_to_blocks( $child, $images_dir, $image_count );
					}
					break;

				// A (lien seul sur une ligne = probablement un bookmark)
				case $tag === 'a':
					$href = $child->getAttribute( 'href' );
					$text = trim( $child->textContent );
					if ( ! empty( $text ) && ! empty( $href ) ) {
						$blocks .= self::make_paragraph( '<a href="' . esc_url( $href ) . '">' . esc_html( $text ) . '</a>' );
					}
					break;

				default:
					// Fallback : extraire le texte
					$text = trim( $child->textContent );
					if ( ! empty( $text ) ) {
						$blocks .= self::make_paragraph( esc_html( $text ) );
					}
					break;
			}
		}

		return $blocks;
	}

	// =========================================================================
	// Générateurs de blocs Gutenberg
	// =========================================================================

	private static function make_heading( $node, $level ) {
		$text = self::get_inline_content( $node );
		if ( empty( trim( strip_tags( $text ) ) ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:heading {"level":%d} -->' . "\n" .
			'<h%d class="wp-block-heading">%s</h%d>' . "\n" .
			'<!-- /wp:heading -->' . "\n\n",
			$level, $level, $text, $level
		);
	}

	private static function make_paragraph( $content ) {
		$content = trim( $content );
		if ( empty( strip_tags( $content ) ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:paragraph -->' . "\n" .
			'<p>%s</p>' . "\n" .
			'<!-- /wp:paragraph -->' . "\n\n",
			$content
		);
	}

	private static function make_callout( $node, $images_dir = '', &$image_count = 0 ) {
		// Extraire l'icône (premier emoji ou texte d'icône)
		$icon = '💡';
		$content_blocks = '';

		foreach ( $node->childNodes as $child ) {
			if ( $child->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			$child_class = $child->getAttribute( 'class' ) ?? '';

			// Extraire l'icône
			if ( strpos( $child_class, 'icon' ) !== false ) {
				$icon_text = trim( $child->textContent );
				if ( ! empty( $icon_text ) ) {
					$icon = $icon_text;
				}
				continue;
			}

			// Contenu du callout : convertir récursivement pour garder le formatage
			$child_tag = strtolower( $child->tagName );
			if ( $child_tag === 'p' ) {
				$text = self::get_inline_content( $child );
				if ( ! empty( trim( strip_tags( $text ) ) ) ) {
					$content_blocks .= self::make_paragraph( $text );
				}
			} elseif ( in_array( $child_tag, array( 'div', 'span' ), true ) ) {
				// Notion wraps callout paragraphs in <div style="display:contents">
				$content_blocks .= self::convert_callout_inner( $child, $images_dir, $image_count );
			} else {
				$content_blocks .= self::convert_node_to_blocks( $child, $images_dir, $image_count );
			}
		}

		// Fallback si aucun bloc extrait
		if ( empty( trim( $content_blocks ) ) ) {
			$text = trim( $node->textContent );
			// Retirer l'icône du texte si elle est au début
			if ( ! empty( $icon ) && mb_strpos( $text, $icon ) === 0 ) {
				$text = trim( mb_substr( $text, mb_strlen( $icon ) ) );
			}
			if ( empty( $text ) ) {
				return '';
			}
			$content_blocks = self::make_paragraph( esc_html( $text ) );
		}

		// Déterminer la couleur basée sur la CLASSE (pas le style inline)
		$bg_color = self::detect_callout_color( $node );

		return sprintf(
			'<!-- wp:group {"style":{"color":{"background":"var:preset|color|%s"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}},"border":{"radius":"4px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"},"className":"mavi-callout"} -->' . "\n" .
			'<div class="wp-block-group mavi-callout" style="border-radius: 4px; background-color: var(--wp--preset--color--%s); padding: var(--wp--preset--spacing--30);">' . "\n" .
			'<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.25rem"}},"className":"mavi-callout__icon"} -->' . "\n" .
			'<p class="mavi-callout__icon" style="font-size: 1.25rem;">%s</p>' . "\n" .
			'<!-- /wp:paragraph -->' . "\n" .
			'<!-- wp:group {"layout":{"type":"constrained"},"className":"mavi-callout__content"} -->' . "\n" .
			'<div class="wp-block-group mavi-callout__content">' . "\n" .
			'%s' .
			'</div>' . "\n" .
			'<!-- /wp:group -->' . "\n" .
			'</div>' . "\n" .
			'<!-- /wp:group -->' . "\n\n",
			$bg_color, $bg_color, esc_html( $icon ), $content_blocks
		);
	}

	/**
	 * Convertit le contenu interne d'un callout (divs display:contents contenant des <p>).
	 */
	private static function convert_callout_inner( $node, $images_dir, &$image_count ) {
		$blocks = '';
		foreach ( $node->childNodes as $child ) {
			if ( $child->nodeType === XML_TEXT_NODE ) {
				$text = trim( $child->textContent );
				if ( ! empty( $text ) ) {
					$blocks .= self::make_paragraph( esc_html( $text ) );
				}
				continue;
			}
			if ( $child->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			$child_tag = strtolower( $child->tagName );
			$child_class = $child->getAttribute( 'class' ) ?? '';

			if ( $child_tag === 'p' ) {
				$text = self::get_inline_content( $child );
				if ( ! empty( trim( strip_tags( $text ) ) ) ) {
					$blocks .= self::make_paragraph( $text );
				}
			} elseif ( in_array( $child_tag, array( 'div', 'span' ), true ) && strpos( $child_class, 'icon' ) === false ) {
				$blocks .= self::convert_callout_inner( $child, $images_dir, $image_count );
			} elseif ( strpos( $child_class, 'icon' ) === false ) {
				$blocks .= self::convert_node_to_blocks( $child, $images_dir, $image_count );
			}
		}
		return $blocks;
	}

	/**
	 * Détecte la couleur d'un callout Notion à partir de la classe CSS.
	 * Notion utilise des classes comme : block-color-blue_background, block-color-teal_background, etc.
	 */
	private static function detect_callout_color( $node ) {
		$class = $node->getAttribute( 'class' ) ?? '';
		$style = $node->getAttribute( 'style' ) ?? '';
		$source = $class . ' ' . $style;

		$color_map = array(
			'blue'   => 'notion-blue-bg',
			'teal'   => 'notion-green-bg',
			'green'  => 'notion-green-bg',
			'red'    => 'notion-red-bg',
			'pink'   => 'notion-red-bg',
			'orange' => 'notion-orange-bg',
			'purple' => 'notion-purple-bg',
			'gray'   => 'notion-gray-bg',
			'grey'   => 'notion-gray-bg',
			'brown'  => 'notion-orange-bg',
		);

		foreach ( $color_map as $key => $value ) {
			if ( stripos( $source, $key ) !== false ) {
				return $value;
			}
		}

		return 'notion-yellow-bg';
	}

	private static function make_toggle( $node, $images_dir, &$image_count ) {
		$summary = 'Toggle';
		$content = '';

		// <details> contient <summary> + contenu
		foreach ( $node->childNodes as $child ) {
			if ( $child->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			if ( strtolower( $child->tagName ) === 'summary' ) {
				$summary = trim( $child->textContent );
			} else {
				$content .= self::convert_node_to_blocks( $child, $images_dir, $image_count );
			}
		}

		if ( empty( $content ) ) {
			$content = '<!-- wp:paragraph -->' . "\n" . '<p>' . trim( $node->textContent ) . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		}

		return sprintf(
			'<!-- wp:details -->' . "\n" .
			'<details class="wp-block-details">' . "\n" .
			'<summary>%s</summary>' . "\n" .
			'%s' .
			'</details>' . "\n" .
			'<!-- /wp:details -->' . "\n\n",
			esc_html( $summary ), $content
		);
	}

	private static function make_quote( $node ) {
		$text = self::get_inline_content( $node );
		if ( empty( trim( strip_tags( $text ) ) ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:quote {"className":"mavi-quote"} -->' . "\n" .
			'<blockquote class="wp-block-quote mavi-quote">' . "\n" .
			'<!-- wp:paragraph -->' . "\n" .
			'<p>%s</p>' . "\n" .
			'<!-- /wp:paragraph -->' . "\n" .
			'</blockquote>' . "\n" .
			'<!-- /wp:quote -->' . "\n\n",
			$text
		);
	}

	private static function make_code( $node ) {
		$code_node = $node->getElementsByTagName( 'code' )->item( 0 );
		$code = $code_node ? $code_node->textContent : $node->textContent;
		$code = trim( $code );

		if ( empty( $code ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:code -->' . "\n" .
			'<pre class="wp-block-code"><code>%s</code></pre>' . "\n" .
			'<!-- /wp:code -->' . "\n\n",
			esc_html( $code )
		);
	}

	private static function make_list( $node, $type = 'unordered' ) {
		$tag = $type === 'ordered' ? 'ol' : 'ul';
		$attrs = $type === 'ordered' ? '{"ordered":true}' : '';

		$items = '';
		foreach ( $node->childNodes as $li ) {
			if ( $li->nodeType !== XML_ELEMENT_NODE || strtolower( $li->tagName ) !== 'li' ) {
				continue;
			}

			$text = self::get_inline_content( $li );
			$items .= '<!-- wp:list-item -->' . "\n" .
			           '<li>' . $text . '</li>' . "\n" .
			           '<!-- /wp:list-item -->' . "\n";
		}

		if ( empty( $items ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:list %s -->' . "\n" .
			'<%s>%s</%s>' . "\n" .
			'<!-- /wp:list -->' . "\n\n",
			$attrs, $tag, $items, $tag
		);
	}

	private static function make_todo_list( $node ) {
		$items = '';
		foreach ( $node->childNodes as $li ) {
			if ( $li->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			$checkbox = $li->getElementsByTagName( 'input' )->item( 0 );
			$checked = $checkbox && $checkbox->getAttribute( 'checked' ) !== null;
			$text = trim( $li->textContent );

			$prefix = $checked ? '☑️ ' : '☐ ';
			$items .= '<!-- wp:list-item -->' . "\n" .
			           '<li>' . $prefix . esc_html( $text ) . '</li>' . "\n" .
			           '<!-- /wp:list-item -->' . "\n";
		}

		if ( empty( $items ) ) {
			return '';
		}

		return sprintf(
			'<!-- wp:list -->' . "\n" .
			'<ul>%s</ul>' . "\n" .
			'<!-- /wp:list -->' . "\n\n",
			$items
		);
	}

	private static function make_image( $node, $images_dir, &$image_count ) {
		$src = $node->getAttribute( 'src' );
		$alt = $node->getAttribute( 'alt' ) ?? '';

		if ( empty( $src ) ) {
			return '';
		}

		// Uploader l'image dans la médiathèque
		$wp_url = self::upload_notion_image( $src, $images_dir );
		if ( ! $wp_url ) {
			return '';
		}

		$image_count++;

		return sprintf(
			'<!-- wp:image {"sizeSlug":"large"} -->' . "\n" .
			'<figure class="wp-block-image size-large"><img src="%s" alt="%s" /></figure>' . "\n" .
			'<!-- /wp:image -->' . "\n\n",
			esc_url( $wp_url ), esc_attr( $alt )
		);
	}

	private static function make_figure( $node, $images_dir, &$image_count ) {
		$img = $node->getElementsByTagName( 'img' )->item( 0 );
		if ( $img ) {
			return self::make_image( $img, $images_dir, $image_count );
		}

		// Si pas d'image, traiter comme du contenu normal
		$text = trim( $node->textContent );
		if ( ! empty( $text ) ) {
			return self::make_paragraph( esc_html( $text ) );
		}

		return '';
	}

	private static function make_separator() {
		return '<!-- wp:separator -->' . "\n" .
		       '<hr class="wp-block-separator has-alpha-channel-opacity" />' . "\n" .
		       '<!-- /wp:separator -->' . "\n\n";
	}

	/**
	 * Convertit une column-list Notion en blocs wp:columns.
	 */
	private static function make_columns( $node, $images_dir, &$image_count ) {
		$columns = array();

		// Parcourir les enfants pour trouver les colonnes
		foreach ( $node->childNodes as $child ) {
			if ( $child->nodeType !== XML_ELEMENT_NODE ) {
				continue;
			}

			$child_class = $child->getAttribute( 'class' ) ?? '';

			// Notion enveloppe chaque colonne dans <div style="display:contents"><div class="column">
			if ( strpos( $child_class, 'column' ) !== false && strpos( $child_class, 'column-list' ) === false ) {
				$col_content = self::convert_node_to_blocks( $child, $images_dir, $image_count );
				if ( ! empty( trim( $col_content ) ) ) {
					$columns[] = $col_content;
				}
			} else {
				// Dig into display:contents wrappers
				foreach ( $child->childNodes as $inner ) {
					if ( $inner->nodeType !== XML_ELEMENT_NODE ) {
						continue;
					}
					$inner_class = $inner->getAttribute( 'class' ) ?? '';
					if ( strpos( $inner_class, 'column' ) !== false && strpos( $inner_class, 'column-list' ) === false ) {
						$col_content = self::convert_node_to_blocks( $inner, $images_dir, $image_count );
						if ( ! empty( trim( $col_content ) ) ) {
							$columns[] = $col_content;
						}
					}
				}
			}
		}

		// Fallback : si aucune colonne trouvée, traiter comme du contenu linéaire
		if ( empty( $columns ) ) {
			return self::convert_node_to_blocks( $node, $images_dir, $image_count );
		}

		// Construire le bloc wp:columns
		$output = '<!-- wp:columns -->' . "\n" . '<div class="wp-block-columns">' . "\n";

		foreach ( $columns as $col_content ) {
			$output .= '<!-- wp:column -->' . "\n" .
			            '<div class="wp-block-column">' . "\n" .
			            $col_content .
			            '</div>' . "\n" .
			            '<!-- /wp:column -->' . "\n";
		}

		$output .= '</div>' . "\n" . '<!-- /wp:columns -->' . "\n\n";

		return $output;
	}

	private static function make_table( $node ) {
		$doc = $node->ownerDocument;
		$html = $doc->saveHTML( $node );

		// Nettoyer les attributs Notion et garder la table brute
		$html = preg_replace( '/\s(class|style|id|data-[a-z-]+)="[^"]*"/i', '', $html );

		return sprintf(
			'<!-- wp:table -->' . "\n" .
			'<figure class="wp-block-table">%s</figure>' . "\n" .
			'<!-- /wp:table -->' . "\n\n",
			$html
		);
	}

	// =========================================================================
	// Utilitaires
	// =========================================================================

	/**
	 * Récupère le contenu inline d'un nœud (gras, italique, code, liens).
	 */
	private static function get_inline_content( $node ) {
		$html = self::get_inner_html( $node );

		// Convertir les balises Notion → HTML standard
		$html = preg_replace( '/<strong[^>]*>/', '<strong>', $html );
		$html = preg_replace( '/<em[^>]*>/', '<em>', $html );
		$html = preg_replace( '/<code[^>]*>/', '<code>', $html );
		$html = preg_replace( '/<a\s+href="([^"]*)"[^>]*>/', '<a href="$1">', $html );

		// Supprimer les spans Notion (garder le contenu)
		$html = preg_replace( '/<span[^>]*>/', '', $html );
		$html = str_replace( '</span>', '', $html );

		// Supprimer les div inline
		$html = preg_replace( '/<div[^>]*>/', '', $html );
		$html = str_replace( '</div>', '', $html );

		return trim( $html );
	}

	/**
	 * Récupère le HTML interne d'un nœud.
	 */
	private static function get_inner_html( $node ) {
		$doc = $node->ownerDocument;
		$html = '';
		foreach ( $node->childNodes as $child ) {
			$html .= $doc->saveHTML( $child );
		}
		return $html;
	}

	/**
	 * Upload une image Notion dans la médiathèque WordPress.
	 */
	private static function upload_notion_image( $src, $images_dir ) {
		// Si c'est une URL externe, la télécharger
		if ( filter_var( $src, FILTER_VALIDATE_URL ) ) {
			return self::sideload_image_from_url( $src );
		}

		// Chemin relatif → chemin absolu
		$src_decoded = urldecode( $src );
		$image_path  = realpath( $images_dir . '/' . $src_decoded );

		// Chercher aussi dans le dossier parent
		if ( ! $image_path || ! file_exists( $image_path ) ) {
			$image_path = realpath( dirname( $images_dir ) . '/' . $src_decoded );
		}

		// Chercher juste le nom du fichier dans le dossier images
		if ( ( ! $image_path || ! file_exists( $image_path ) ) && is_dir( $images_dir ) ) {
			$filename = basename( $src_decoded );
			$found = glob( $images_dir . '/' . $filename );
			if ( ! empty( $found ) ) {
				$image_path = $found[0];
			}
		}

		if ( ! $image_path || ! file_exists( $image_path ) ) {
			return false;
		}

		// Copier dans le dossier temporaire de WordPress
		$tmp_file = wp_tempnam( basename( $image_path ) );
		copy( $image_path, $tmp_file );

		$file_array = array(
			'name'     => sanitize_file_name( basename( $image_path ) ),
			'tmp_name' => $tmp_file,
		);

		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$attachment_id = media_handle_sideload( $file_array, 0 );

		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $tmp_file );
			return false;
		}

		return wp_get_attachment_url( $attachment_id );
	}

	/**
	 * Télécharge une image depuis une URL externe.
	 */
	private static function sideload_image_from_url( $url ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$tmp = download_url( $url );
		if ( is_wp_error( $tmp ) ) {
			return false;
		}

		$file_array = array(
			'name'     => sanitize_file_name( basename( wp_parse_url( $url, PHP_URL_PATH ) ) ),
			'tmp_name' => $tmp,
		);

		$attachment_id = media_handle_sideload( $file_array, 0 );

		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $tmp );
			return false;
		}

		return wp_get_attachment_url( $attachment_id );
	}

	/**
	 * Supprime récursivement un dossier temporaire.
	 */
	private static function cleanup( $dir ) {
		if ( ! is_dir( $dir ) ) {
			return;
		}

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS ),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach ( $iterator as $file ) {
			if ( $file->isDir() ) {
				rmdir( $file->getPathname() );
			} else {
				unlink( $file->getPathname() );
			}
		}

		rmdir( $dir );
	}
}

// Initialiser l'importeur
Mavi_Notion_Importer::init();
