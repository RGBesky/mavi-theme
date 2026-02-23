<?php
/**
 * Title: Carrousel de contenu
 * Slug: mavi/content-carousel
 * Description: Carrousel de cartes swipables pouvant contenir tout type de contenu (texte, images, listes…). Comme un slider de cartes.
 * Categories: mavi
 * Keywords: carrousel, carousel, slider, cartes, cards, swipe, contenu
 * Viewport Width: 1200
 */
?>

<!-- wp:group {"className":"mavi-content-carousel splide","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-group mavi-content-carousel splide" style="padding-top: var(--wp--preset--spacing--40); padding-bottom: var(--wp--preset--spacing--40);">

<!-- wp:group {"className":"splide__track","layout":{"type":"default"}} -->
<div class="wp-block-group splide__track">

<!-- wp:group {"className":"splide__list","layout":{"type":"flex","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-group splide__list">

<!-- wp:group {"className":"splide__slide","layout":{"type":"default"}} -->
<div class="wp-block-group splide__slide">
<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--accent">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">🚀</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Titre de la carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Ajoutez ici n'importe quel contenu : texte, images, listes, boutons… Chaque carte est swipable.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"splide__slide","layout":{"type":"default"}} -->
<div class="wp-block-group splide__slide">
<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--accent">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">💡</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Deuxième carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Vous pouvez avoir autant de cartes que souhaité. Dupliquez simplement un bloc « splide__slide ».</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"splide__slide","layout":{"type":"default"}} -->
<div class="wp-block-group splide__slide">
<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--navy","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--navy">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">🎯</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Troisième carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Bordure navy en haut en utilisant la classe mavi-slide-card--navy. Remplacez par --accent pour le terracotta.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"splide__slide","layout":{"type":"default"}} -->
<div class="wp-block-group splide__slide">
<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--accent">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">✨</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Quatrième carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Le contenu est libre : ajoutez des images, des listes, des boutons — tout fonctionne dans les cartes.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
