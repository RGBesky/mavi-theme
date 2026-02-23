<?php
/**
 * Title: Carrousel d'images
 * Slug: mavi/image-carousel
 * Description: Carrousel d'images horizontal avec navigation, propulsé par Splide.js.
 * Categories: mavi
 * Keywords: carrousel, carousel, slider, images, splide, galerie
 * Viewport Width: 720
 */
?>

<!-- wp:group {"className":"mavi-carousel splide","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} -->
<div class="wp-block-group mavi-carousel splide" style="padding-top: var(--wp--preset--spacing--30); padding-bottom: var(--wp--preset--spacing--30);">

	<!-- wp:group {"className":"splide__track","layout":{"type":"default"}} -->
	<div class="wp-block-group splide__track">

		<!-- wp:group {"className":"splide__list","layout":{"type":"flex","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"0"}}} -->
		<div class="wp-block-group splide__list">

			<!-- wp:group {"className":"splide__slide","layout":{"type":"constrained"}} -->
			<div class="wp-block-group splide__slide">
				<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":"4px"}}} -->
				<figure class="wp-block-image size-large" style="border-radius: 4px;">
					<img src="" alt="Image 1" style="border-radius: 4px;" />
				</figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"splide__slide","layout":{"type":"constrained"}} -->
			<div class="wp-block-group splide__slide">
				<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":"4px"}}} -->
				<figure class="wp-block-image size-large" style="border-radius: 4px;">
					<img src="" alt="Image 2" style="border-radius: 4px;" />
				</figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"splide__slide","layout":{"type":"constrained"}} -->
			<div class="wp-block-group splide__slide">
				<!-- wp:image {"sizeSlug":"large","style":{"border":{"radius":"4px"}}} -->
				<figure class="wp-block-image size-large" style="border-radius: 4px;">
					<img src="" alt="Image 3" style="border-radius: 4px;" />
				</figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
