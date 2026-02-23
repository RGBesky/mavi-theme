<?php
/**
 * Title: Callout Avertissement (orange)
 * Slug: mavi/callout-warning
 * Description: Callout orange pour les avertissements.
 * Categories: mavi
 * Keywords: callout, warning, avertissement, orange, notion
 * Viewport Width: 720
 */
?>

<!-- wp:group {"style":{"color":{"background":"var:preset|color|notion-orange-bg"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}},"border":{"radius":"4px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"},"className":"mavi-callout"} -->
<div class="wp-block-group mavi-callout" style="border-radius: 4px; background-color: var(--wp--preset--color--notion-orange-bg); padding-top: var(--wp--preset--spacing--30); padding-right: var(--wp--preset--spacing--30); padding-bottom: var(--wp--preset--spacing--30); padding-left: var(--wp--preset--spacing--30);">

	<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.25rem"}},"className":"mavi-callout__icon"} -->
	<p class="mavi-callout__icon" style="font-size: 1.25rem;">⚠️</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"layout":{"type":"constrained"},"className":"mavi-callout__content"} -->
	<div class="wp-block-group mavi-callout__content">
		<!-- wp:paragraph -->
		<p>Attention ! Cet avertissement mérite votre vigilance.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
