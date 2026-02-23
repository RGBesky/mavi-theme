<?php
/**
 * Title: Section pleine largeur
 * Slug: mavi/section-fullwidth
 * Description: Conteneur pleine largeur avec fond coloré pour regrouper des blocs.
 * Categories: mavi-sections
 * Keywords: section, fullwidth, fond, background, notion
 * Viewport Width: 1200
 */
?>

<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|notion-gray-bg"},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained"},"className":"mavi-section"} -->
<div class="wp-block-group alignfull mavi-section" style="background-color: var(--wp--preset--color--notion-gray-bg); padding-top: var(--wp--preset--spacing--60); padding-right: var(--wp--preset--spacing--30); padding-bottom: var(--wp--preset--spacing--60); padding-left: var(--wp--preset--spacing--30);">

	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Titre de la section</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Contenu de votre section. Vous pouvez ajouter n'importe quel bloc ici.</p>
	<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
