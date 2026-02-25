<?php
/**
 * Title: Carrousel de contenu
 * Slug: mavi/content-carousel
 * Description: Carrousel de cartes swipables. Pour ajouter une carte : dupliquez un bloc « Carte ». Pour en retirer : supprimez-le.
 * Categories: mavi
 * Keywords: carrousel, carousel, slider, cartes, cards, swipe, contenu
 * Viewport Width: 1200
 */
?>

<!-- wp:group {"className":"mavi-content-carousel mavi-fw-350","layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"1.25rem","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-group mavi-content-carousel mavi-fw-350" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--accent">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">🚀</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Titre de la carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Votre contenu ici. Dupliquez ce bloc pour en ajouter, supprimez-le pour en retirer.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--accent">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">💡</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Deuxième carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Chaque carte a une largeur fixe. Changez mavi-fw-350 en mavi-fw-400 sur le conteneur pour élargir.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mavi-slide-card mavi-slide-card--navy","layout":{"type":"constrained"}} -->
<div class="wp-block-group mavi-slide-card mavi-slide-card--navy">
<!-- wp:paragraph {"className":"mavi-slide-card__icon"} -->
<p class="mavi-slide-card__icon">🎯</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Troisième carte</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Variantes : --accent (terracotta) ou --navy (bleu marine) pour la bordure haute.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
