<?php
/**
 * Title: Timeline verticale
 * Slug: mavi/timeline
 * Description: Vue chronologique verticale pour afficher un parcours, des jalons ou des événements.
 * Categories: mavi
 * Keywords: timeline, chronologie, parcours, étapes
 * Viewport Width: 720
 */
?>

<!-- wp:group {"layout":{"type":"constrained"},"className":"mavi-timeline","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-group mavi-timeline" style="padding-top: var(--wp--preset--spacing--40); padding-bottom: var(--wp--preset--spacing--40);">

	<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="margin-bottom: var(--wp--preset--spacing--50);">Mon parcours</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"mavi-timeline__item","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-group mavi-timeline__item" style="margin-bottom: var(--wp--preset--spacing--40);">
		<!-- wp:group {"className":"mavi-timeline__marker","layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0"}}} -->
		<div class="wp-block-group mavi-timeline__marker">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem","lineHeight":"1"}},"className":"mavi-timeline__icon"} -->
			<p class="mavi-timeline__icon" style="font-size: 1.5rem; line-height: 1;">🎓</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"mavi-timeline__content","layout":{"type":"constrained"}} -->
		<div class="wp-block-group mavi-timeline__content">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|small","fontWeight":"600"},"color":{"text":"var:preset|color|accent"}}} -->
			<p style="color: var(--wp--preset--color--accent); font-size: var(--wp--preset--font-size--small); font-weight: 600;">2024</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|large"},"spacing":{"margin":{"top":"var:preset|spacing|10"}}}} -->
			<h3 class="wp-block-heading" style="font-size: var(--wp--preset--font-size--large); margin-top: var(--wp--preset--spacing--10);">Titre de l'événement</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|secondary"}}} -->
			<p style="color: var(--wp--preset--color--secondary);">Description de cet événement, réalisation ou jalon important dans votre parcours.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"mavi-timeline__item","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-group mavi-timeline__item" style="margin-bottom: var(--wp--preset--spacing--40);">
		<!-- wp:group {"className":"mavi-timeline__marker","layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0"}}} -->
		<div class="wp-block-group mavi-timeline__marker">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem","lineHeight":"1"}},"className":"mavi-timeline__icon"} -->
			<p class="mavi-timeline__icon" style="font-size: 1.5rem; line-height: 1;">💼</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"mavi-timeline__content","layout":{"type":"constrained"}} -->
		<div class="wp-block-group mavi-timeline__content">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|small","fontWeight":"600"},"color":{"text":"var:preset|color|accent"}}} -->
			<p style="color: var(--wp--preset--color--accent); font-size: var(--wp--preset--font-size--small); font-weight: 600;">2022</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|large"},"spacing":{"margin":{"top":"var:preset|spacing|10"}}}} -->
			<h3 class="wp-block-heading" style="font-size: var(--wp--preset--font-size--large); margin-top: var(--wp--preset--spacing--10);">Deuxième événement</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|secondary"}}} -->
			<p style="color: var(--wp--preset--color--secondary);">Une autre étape marquante. Dupliquez ces blocs pour ajouter autant de jalons que nécessaire.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"mavi-timeline__item","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-group mavi-timeline__item" style="margin-bottom: var(--wp--preset--spacing--40);">
		<!-- wp:group {"className":"mavi-timeline__marker","layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0"}}} -->
		<div class="wp-block-group mavi-timeline__marker">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.5rem","lineHeight":"1"}},"className":"mavi-timeline__icon"} -->
			<p class="mavi-timeline__icon" style="font-size: 1.5rem; line-height: 1;">🚀</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"mavi-timeline__content","layout":{"type":"constrained"}} -->
		<div class="wp-block-group mavi-timeline__content">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|small","fontWeight":"600"},"color":{"text":"var:preset|color|accent"}}} -->
			<p style="color: var(--wp--preset--color--accent); font-size: var(--wp--preset--font-size--small); font-weight: 600;">2020</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|large"},"spacing":{"margin":{"top":"var:preset|spacing|10"}}}} -->
			<h3 class="wp-block-heading" style="font-size: var(--wp--preset--font-size--large); margin-top: var(--wp--preset--spacing--10);">Troisième événement</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"color":{"text":"var:preset|color|secondary"}}} -->
			<p style="color: var(--wp--preset--color--secondary);">Le début de l'aventure. Chaque jalon peut contenir des images, liens et autres blocs.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
