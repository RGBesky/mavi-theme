<?php
/**
 * Title: Couverture avec icône
 * Slug: mavi/cover-icon
 * Description: Image de couverture pleine largeur avec emoji superposé, style page Notion.
 * Categories: mavi
 * Keywords: cover, couverture, icône, emoji, header
 * Viewport Width: 1200
 */
?>

<!-- wp:group {"layout":{"type":"default"},"className":"mavi-cover-icon"} -->
<div class="wp-block-group mavi-cover-icon">

	<!-- wp:cover {"dimRatio":30,"minHeight":280,"minHeightUnit":"px","isDark":true,"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"className":"mavi-cover-icon__image"} -->
	<div class="wp-block-cover is-dark mavi-cover-icon__image" style="min-height: clamp(150px, 30vw, 280px); padding: 0;">
		<span aria-hidden="true" class="wp-block-cover__background has-background-dim-30 has-background-dim"></span>
		<div class="wp-block-cover__inner-container">
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center"></p>
			<!-- /wp:paragraph -->
		</div>
	</div>
	<!-- /wp:cover -->

	<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"margin":{"top":"-50px"}},"position":{"type":"relative"}},"className":"mavi-cover-icon__emoji-wrapper"} -->
	<div class="wp-block-group mavi-cover-icon__emoji-wrapper" style="margin-top: clamp(-30px, -5vw, -50px);">
		<!-- wp:paragraph {"style":{"typography":{"fontSize":"clamp(3rem, 8vw, 4.5rem)","lineHeight":"1"}},"className":"mavi-cover-icon__emoji"} -->
		<p class="mavi-cover-icon__emoji" style="font-size: clamp(3rem, 8vw, 4.5rem); line-height: 1;">🚀</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
