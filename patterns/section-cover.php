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

<!-- wp:cover {"dimRatio":50,"minHeight":400,"minHeightUnit":"px","align":"full","style":{"spacing":{"padding":{"top":"clamp(2rem, 5vw, 3rem)","bottom":"clamp(2rem, 5vw, 3rem)","left":"clamp(1rem, 4vw, 2rem)","right":"clamp(1rem, 4vw, 2rem)"}}},"className":"mavi-section-cover"} -->
<div class="wp-block-cover alignfull mavi-section-cover" style="min-height: clamp(200px, 30vh, 400px); padding-top: clamp(2rem, 5vw, 3rem); padding-right: clamp(1rem, 4vw, 2rem); padding-bottom: clamp(2rem, 5vw, 3rem); padding-left: clamp(1rem, 4vw, 2rem);">
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
