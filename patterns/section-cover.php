<?php
/**
 * Title: Section avec image de fond
 * Slug: mavi/section-cover
 * Description: Section pleine largeur avec image de fond et contenu superposé.
 * Categories: mavi-sections
 * Keywords: section, cover, image, fond, background
 * Viewport Width: 1200
 */
?>

<!-- wp:cover {"dimRatio":50,"minHeight":400,"minHeightUnit":"px","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"className":"mavi-section-cover"} -->
<div class="wp-block-cover alignfull mavi-section-cover" style="min-height: 400px; padding-top: var(--wp--preset--spacing--60); padding-right: var(--wp--preset--spacing--30); padding-bottom: var(--wp--preset--spacing--60); padding-left: var(--wp--preset--spacing--30);">
	<span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span>
	<div class="wp-block-cover__inner-container">

		<!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#ffffff"}}} -->
		<h2 class="wp-block-heading has-text-align-center" style="color: #ffffff;">Titre de la section</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ffffffcc"}}} -->
		<p class="has-text-align-center" style="color: #ffffffcc;">Description ou sous-titre de cette section avec image de fond.</p>
		<!-- /wp:paragraph -->

	</div>
</div>
<!-- /wp:cover -->
