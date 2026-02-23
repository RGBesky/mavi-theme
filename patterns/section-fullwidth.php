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

<!-- wp:group {"align":"full","style":{"color":{"background":"var:preset|color|notion-gray-bg"},"spacing":{"padding":{"top":"clamp(2rem, 5vw, 3rem)","bottom":"clamp(2rem, 5vw, 3rem)","left":"clamp(1rem, 4vw, 2rem)","right":"clamp(1rem, 4vw, 2rem)"}},"className":"mavi-section"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull mavi-section" style="background-color: var(--wp--preset--color--notion-gray-bg); padding-top: clamp(2rem, 5vw, 3rem); padding-right: clamp(1rem, 4vw, 2rem); padding-bottom: clamp(2rem, 5vw, 3rem); padding-left: clamp(1rem, 4vw, 2rem);">

	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Titre de la section</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Contenu de votre section. Vous pouvez ajouter n'importe quel bloc ici.</p>
	<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
