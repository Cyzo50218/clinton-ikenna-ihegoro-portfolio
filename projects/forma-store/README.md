# FORMA Store - Custom WordPress and WooCommerce Theme

FORMA Store is a locally developed practice storefront built with a custom WordPress theme and WooCommerce. This repository folder contains the active theme source, not a complete WordPress installation.

## What the theme demonstrates

- A custom PHP homepage and storefront shell.
- Responsive header, mobile navigation, search controls, and product presentation.
- WooCommerce product cards, product pages, cart fragments, and catalog integration.
- Catalog filters for price range, sale items, and in-stock products.
- A browser-local wishlist that uses the WooCommerce catalog data.
- Custom CSS design tokens, responsive layouts, and reduced-motion handling.
- A demo-only newsletter flow that accepts reserved invalid test email addresses and does not send messages.

## Repository structure

- theme/ - the active forma-store WordPress theme.
- theme/inc/ - WooCommerce catalog and demo-store enhancements.
- theme/assets/ - stylesheets, JavaScript, and locally licensed font files.

## Local setup

1. Set up WordPress and install WooCommerce.
2. Copy the theme/ directory into wp-content/themes/forma-store.
3. Activate FORMA Store in WordPress Appearance > Themes.
4. Add your own licensed campaign images to the media paths referenced by front-page.php, or update those paths to match your media library.
5. Add WooCommerce products, categories, and product images. The homepage queries real WooCommerce product records.
6. Create the standard Shop, Cart, Checkout, and My Account pages and configure the store menu.

Elementor was present in the local practice environment for optional page building. The homepage and WooCommerce shell are implemented with theme templates rather than Elementor widgets.

## What is intentionally not included

This is a curated theme-source publication. It does not include:

- WordPress core or wp-config.php.
- A database export, local admin accounts, practice orders, or customer records.
- The wp-content/uploads media library or WooCommerce sample product photography.
- Elementor, Elementor Pro, WooCommerce, or other plugin source directories.
- Local server scripts, logs, backups, or Novamira development artifacts.

The theme references campaign and product media stored in the WordPress uploads library. Those assets are not bundled here; supply photography that you own or are licensed to use.

## Demo status and limitations

This is a **local learning and portfolio project**, not an operational online store. The local build used a practice-only checkout flow. No real payment gateway, fulfillment, customer support, production email, tax configuration, or live shipping service is connected. The demo signup accepts only reserved invalid test email addresses and sends no email.

Do not use this project to collect real payment or customer information without a separate production-readiness review and proper service configuration.

## Requirements and licensing

- WordPress 6.8 or later (theme metadata).
- PHP 8.0 or later (theme metadata).
- WooCommerce.
- Theme header declares GPL-2.0-or-later.
- Font license notices are included alongside the font files in theme/assets/fonts/.