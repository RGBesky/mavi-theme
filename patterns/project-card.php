<?php
/**
 * Title: Carte de projet (Portfolio)
 * Slug: mavi/project-card
 * Description: Carte de projet pour le portfolio avec image, titre, description et technologies.
 * Categories: mavi
 * Keywords: portfolio, projet, carte, card, galerie
 * Viewport Width: 720
 */
?>

<!-- wp:group {"style":{"border":{"radius":"8px","width":"1px","color":"var:preset|color|notion-gray-bg"},"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|30","left":"0","right":"0"}},"overflow":"hidden"},"layout":{"type":"constrained"},"className":"mavi-project-card"} -->
<div class="wp-block-group mavi-project-card" style="border: 1px solid var(--wp--preset--color--notion-gray-bg); border-radius: 8px; padding-top: 0; padding-right: 0; padding-bottom: var(--wp--preset--spacing--30); padding-left: 0; overflow: hidden;">

	<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":{"topLeft":"8px","topRight":"8px","bottomLeft":"0px","bottomRight":"0px"}},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
	<figure class="wp-block-image size-large" style="margin-top: 0; margin-bottom: 0; border-top-left-radius: 8px; border-top-right-radius: 8px;">
		<img src="" alt="Aperçu du projet" style="border-top-left-radius: 8px; border-top-right-radius: 8px;" />
	</figure>
	<!-- /wp:image -->

	<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group" style="padding-top: var(--wp--preset--spacing--30); padding-left: var(--wp--preset--spacing--30); padding-right: var(--wp--preset--spacing--30);">

		<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|large"}}} -->
		<h3 class="wp-block-heading" style="font-size: var(--wp--preset--font-size--large);">Nom du projet</h3>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|secondary"},"typography":{"fontSize":"var:preset|font-size|small"}}} -->
		<p style="color: var(--wp--preset--color--secondary); font-size: var(--wp--preset--font-size--small);">Courte description du projet, objectif principal et résultat obtenu.</p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|10","margin":{"top":"var:preset|spacing|20"}}}} -->
		<div class="wp-block-group" style="margin-top: var(--wp--preset--spacing--20);">
			<!-- wp:paragraph {"style":{"color":{"background":"var:preset|color|notion-blue-bg","text":"var:preset|color|notion-blue-text"},"typography":{"fontSize":"0.75rem"},"spacing":{"padding":{"top":"2px","bottom":"2px","left":"8px","right":"8px"}},"border":{"radius":"4px"}},"className":"mavi-tag"} -->
			<p class="mavi-tag" style="border-radius: 4px; color: var(--wp--preset--color--notion-blue-text); background-color: var(--wp--preset--color--notion-blue-bg); padding: 2px 8px; font-size: 0.75rem;">Flutter</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"style":{"color":{"background":"var:preset|color|notion-purple-bg","text":"var:preset|color|notion-purple-text"},"typography":{"fontSize":"0.75rem"},"spacing":{"padding":{"top":"2px","bottom":"2px","left":"8px","right":"8px"}},"border":{"radius":"4px"}},"className":"mavi-tag"} -->
			<p class="mavi-tag" style="border-radius: 4px; color: var(--wp--preset--color--notion-purple-text); background-color: var(--wp--preset--color--notion-purple-bg); padding: 2px 8px; font-size: 0.75rem;">Dart</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
