# MAVI by Besky — Thème WordPress "Notion Style"

## Cadrage du projet

---

## 🎯 Vision

Créer un thème WordPress FSE (Full Site Editing) nommé **MAVI by Besky** reproduisant fidèlement le look & feel d'une page Notion, destiné à un site personnel de type **carte de visite + portfolio + blog**.

Le développement est réalisé en **vibe coding** avec VS Code + GitHub Copilot (Claude Opus 4.6), sans écriture manuelle de code.

---

## 📋 Fiche projet

| Élément | Détail |
|---|---|
| **Nom du thème** | MAVI by Besky |
| **Type** | Thème WordPress FSE (Block Theme) |
| **Porteur** | Robert GASTON |
| **Hébergement** | IONOS (mutualisé) |
| **Stack** | VS Code + GitHub Copilot + Claude Opus 4.6 |
| **Budget temps** | Quelques semaines à quelques mois |
| **Niveau WP initial** | Débutant (première expérience WordPress) |
| **Expérience vibe coding** | 4 apps Flutter produites en 15 jours |

---

## 🏗️ Architecture technique

### Choix du FSE (Full Site Editing)

- **Décision :** Thème FSE plutôt que thème classique PHP.
- **Raison du choix :** Personnalisation native via `theme.json`, édition visuelle dans l'admin, direction officielle WP, approche "blocs" cohérente avec le style Notion.
- **Thème classique rejeté :** Plus de code manuel, personnalisation typo/couleurs non native, architecture vieillissante.
- **Fallback :** Revenir au classique si FSE s'avère trop limitant.

### Structure du thème

```
mavi-theme/
├── assets/
│   ├── css/                    # Styles custom
│   ├── js/                     # Scripts (carrousel, scroll…)
│   └── fonts/                  # Typographies custom
├── parts/
│   ├── header.html             # En-tête du site
│   └── footer.html             # Pied de page
├── patterns/                   # Patterns réutilisables (blocs Notion)
│   ├── callout.php
│   ├── toggle.php
│   ├── quote-notion.php
│   ├── cover-icon.php
│   └── image-carousel.php
├── templates/
│   ├── index.html              # Template par défaut
│   ├── front-page.html         # Accueil carte de visite
│   ├── single.html             # Article de blog
│   ├── page.html               # Page statique
│   ├── archive.html            # Liste d'articles
│   └── page-portfolio.html     # Template portfolio
├── functions.php               # Enqueue scripts, blocs custom
├── style.css                   # Métadonnées du thème
├── theme.json                  # Design system (typo, couleurs, espacements)
├── screenshot.png              # Aperçu du thème
└── projet.md                   # Ce fichier
```

---

## 🎨 Design System — Style Notion

### Typographie

| Rôle | Police | Détail |
|---|---|---|
| Corps de texte | Inter ou système sans-serif | Comme Notion |
| Titres | Paramétrable (serif ou sans-serif) | Via l'admin |
| Code | Monospace (JetBrains Mono, Fira Code, ou système) | Blocs de code |
| Tailles | 14px → 40px | Échelle harmonieuse |
| Graisses | Regular (400) et Bold (700) minimum | |

> Personnalisable par l'utilisateur dans l'admin WordPress via `theme.json`.

### Palette de couleurs Notion

| Couleur | Texte | Fond | Usage |
|---|---|---|---|
| Gris | `#787774` | `#F1F1EF` | Texte secondaire, fonds neutres |
| Marron | `#9F6B53` | `#F4EEEE` | Callouts, accents chauds |
| Orange | `#D9730D` | `#FBECDD` | Avertissements, highlights |
| Jaune | `#CB912F` | `#FBF3DB` | Notes, astuces |
| Vert | `#448361` | `#EDF3EC` | Succès, validations |
| Bleu | `#337EA9` | `#E7F3F8` | Liens, informations |
| Violet | `#9065B0` | `#F6F3F9` | Créativité, tags |
| Rose | `#C14C8A` | `#FAF1F5` | Accents féminins |
| Rouge | `#D44C47` | `#FDEBEC` | Erreurs, urgences |

- **Fond par défaut :** Blanc (`#FFFFFF`) ou crème léger
- **Fond personnalisable :** L'utilisateur peut changer le fond global dans l'admin
- **Mode sombre :** Prévu en V2 (pas prioritaire)

### Espacements

- **Largeur max de contenu :** 720px par défaut (comme Notion) — mode plein écran activable par page
- **Marges latérales :** Généreuses, centrées
- **Espacement entre blocs :** Aéré, cohérent
- **Approche :** Responsive first (Mobile → Tablette → Desktop)

---

## 📦 Fonctionnalités détaillées

### Blocs "style Notion" à développer

| Bloc | Description | Priorité | Mapping WordPress |
|---|---|---|---|
| **Callout** | Encadré coloré avec icône emoji à gauche | 🔴 Haute | Bloc Groupe + fond coloré + emoji |
| **Toggle** | Contenu repliable/dépliable avec flèche | 🔴 Haute | Bloc natif "Détails" (Details) |
| **Citation stylisée** | Barre latérale gauche + typo italique | 🟡 Moyenne | Bloc natif "Citation" stylisé |
| **Couverture + icône** | Image pleine largeur + emoji superposé | 🔴 Haute | Bloc natif "Couverture" + positionnement |
| **Séparateur** | Ligne fine (3 styles : trait, pointillés, points) | 🟢 Basse | Bloc natif "Séparateur" stylisé |
| **Code block** | Coloration syntaxique + bouton copier | 🟡 Moyenne | Bloc natif "Code" + JS copie |
| **Carrousel d'images** | Slider horizontal avec navigation tactile | 🔴 Haute | Custom pattern + Splide.js |
| **Tableau scrollable** | Scroll horizontal pour colonnes larges | 🔴 Haute | Bloc natif "Tableau" + CSS overflow |
| **Image scrollable** | Scroll horizontal pour visuels panoramiques | 🔴 Haute | Bloc natif "Image" + CSS overflow |
| **Section** | Conteneur pleine largeur avec fond personnalisable | 🔴 Haute | Bloc Groupe pleine largeur |
| **Colonnes avancées** | Multi-colonnes responsive, imbriquables | 🔴 Haute | Bloc natif "Colonnes" enrichi |
| **Page plein écran** | Option full width par page (supprime la contrainte 720px) | 🔴 Haute | Template full-width ou attribut de page |
| **Timeline** | Vue chronologique (horizontale ou verticale) | 🔴 Haute | Custom pattern + CSS/JS |
| **Table des matières** | TOC auto-générée à partir des titres | 🟡 Moyenne | JS auto-scan des headings |

### Pages du site

#### 1. Accueil — Carte de visite
- Photo ou avatar
- Nom, titre, courte bio
- Liens sociaux / contact
- Navigation vers les sections
- Style épuré, centré, Notion-like

#### 2. Parcours personnel
- Timeline ou liste structurée
- Expériences, formations, jalons
- Icônes/emojis pour chaque entrée

#### 3. Portfolio
- Galerie de réalisations (vue grille ou galerie)
- Chaque projet : image, titre, description, technologies, lien
- Filtrage par catégorie souhaitable
- Carrousel d'images par projet

#### 4. Blog
- Liste d'articles avec aperçu
- Page article : couverture + icône, contenu riche avec tous les blocs Notion
- Pagination ou scroll infini

### Fonctionnalités transversales

- **Responsive first** — Mobile → Tablette → Desktop
- **Personnalisation typo** — Via l'admin WordPress (`theme.json`)
- **Personnalisation couleurs** — Fond de page + texte via l'admin
- **Scroll horizontal** — Tableaux larges et images panoramiques scrollables dans leur conteneur
- **Carrousels d'images** — Bloc dédié avec navigation
- **Bases de données inline** — ❌ Exclu du périmètre

---

## 🚫 Hors périmètre (V1)

- Bases de données inline style Notion (vues table, board, galerie…)
- Mode sombre (envisagé V2)
- Multilingue
- E-commerce
- Espace membres / authentification
- Commentaires avancés

---

## 🛠️ Environnement de développement

| Élément | Détail |
|---|---|
| **Machine** | HP Laptop 15s-fq5004sf — i7-1255U — 16 Go RAM — SSD 512 Go |
| **OS** | Ubuntu 24.04.4 LTS |
| **IDE** | VS Code (snap) + GitHub Copilot (actif) |
| **IA** | Claude Opus 4.6 via Copilot |
| **Versioning** | Git + GitHub (SSH ed25519) |
| **WP local** | wp-env (Docker) — recommandé pour le dev de thèmes FSE |
| **Hébergement prod** | IONOS (mutualisé) |
| **Navigateurs test** | Brave (Chromium) + LibreWolf (Firefox) |

### Outils recommandés

- **Extension "Create Block Theme"** : Permet de modifier le design visuellement dans l'éditeur de site WordPress puis d'exporter automatiquement les changements dans `theme.json` et les templates HTML.
- **wp-env** : Environnement WordPress local officiel basé sur Docker. Se lance avec `npx @wordpress/env start`.
- **Splide.js** : Bibliothèque de carrousel légère et éprouvée pour les blocs carrousel/slider.

---

## 📅 Plan d'action en 8 étapes

| # | Étape | Description |
|---|---|---|
| 1 | **Environnement** | WordPress local (wp-env), structure du thème FSE, dépôt Git GitHub |
| 2 | **Design system** | `theme.json` : typographies, couleurs Notion, espacements, presets |
| 3 | **Templates de base** | Header, footer, page, single post, archive |
| 4 | **Blocs custom Notion** | Callouts, toggles, citations, séparateurs, couverture + icône |
| 5 | **Carrousel + scroll** | Bloc carrousel (Splide.js), overflow scroll tableaux/images |
| 6 | **Pages du site** | Accueil carte de visite, parcours (timeline), portfolio, blog |
| 7 | **Responsive & polish** | Tests mobile, ajustements CSS, micro-interactions |
| 8 | **Déploiement IONOS** | Mise en production sur hébergement mutualisé |

---

## ⚠️ Risques identifiés

| Risque | Impact | Mitigation |
|---|---|---|
| Documentation FSE moins abondante | Moyen | Compenser avec Copilot + Opus + doc officielle WP |
| Copilot moins précis sur `theme.json` | Faible | Valider systématiquement contre la doc officielle |
| Carrousel : complexité JS | Moyen | Utiliser Splide.js (lib éprouvée) plutôt que from scratch |
| Responsive fine-tuning chronophage | Moyen | Mobile-first dès le départ, tester à chaque étape |
| Compatibilité IONOS mutualisé | Faible | WordPress standard, pas de dépendances serveur spécifiques |
| Syntaxe des blocs HTML FSE | Moyen | Toujours valider le JSON dans les commentaires `<!-- wp:... -->` |

---

## ✅ Critères de validation (Definition of Done)

- [ ] Le thème s'installe et s'active sans erreur sur WordPress 6.x
- [ ] Toutes les pages (accueil, parcours, portfolio, blog) sont fonctionnelles
- [ ] Tous les blocs Notion listés sont opérationnels
- [ ] Le carrousel d'images fonctionne avec navigation tactile
- [ ] Les sections et colonnes avancées fonctionnent avec fonds personnalisables
- [ ] Le mode plein écran fonctionne et est activable par page
- [ ] La timeline affiche correctement des jalons avec navigation responsive
- [ ] Le scroll horizontal des tableaux et images fonctionne
- [ ] Le site est responsive sur mobile, tablette et desktop
- [ ] La personnalisation typo et couleurs fonctionne depuis l'admin
- [ ] Le site est déployé et accessible sur IONOS
- [ ] Tests validés sur Brave (Chromium) et LibreWolf (Firefox)
- [ ] Code versionné sur GitHub, commits propres

---

## 📚 Références

- [WordPress FSE — Documentation officielle](https://developer.wordpress.org/themes/block-themes/)
- [theme.json — Référence complète](https://developer.wordpress.org/themes/global-settings-and-styles/)
- [Inkling — Thème Notion existant (inspiration)](https://developer.wordpress.org/themes/getting-started/)
- [Splide.js — Carrousel léger](https://splidejs.com/)
- [GitHub Copilot + WordPress](https://github.com/features/copilot)
- [Extension Create Block Theme](https://wordpress.org/plugins/create-block-theme/)

---

*Dernière mise à jour : 23 février 2026*
