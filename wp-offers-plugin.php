<?php
/*
Plugin Name: WP Offers Plugin
Description: A plugin to display offers from an external API.
Version: 1.0
*/

// Hook to enqueue styles and scripts for the block editor and front-end
function wp_offers_enqueue_scripts() {
    // Enqueue styles for the block and fonts
    wp_enqueue_style('wp-offers-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_style('wp-offers-font-style', plugin_dir_url(__FILE__) . 'assets/font/css/font-awesome.min.css');

    // Enqueue scripts for the slider and block
    wp_enqueue_script('deposits-slider', plugin_dir_url(__FILE__) . 'assets/js/slider.js', array(), null, true);
    wp_register_script('offers-block', plugin_dir_url(__FILE__) . 'blocks/offers-block.js', array('wp-blocks', 'wp-components', 'wp-editor'), null, true);
}

// Add action hooks to enqueue scripts and include necessary files
add_action('enqueue_block_editor_assets', 'wp_offers_enqueue_scripts');
add_action('wp_enqueue_scripts', 'wp_offers_enqueue_scripts');

// Include necessary files for the plugin
require_once plugin_dir_path(__FILE__) . 'includes/block/class-offers-block.php';
require_once plugin_dir_path(__FILE__) . 'includes/api/class-api-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/cache/class-cached-api.php';

