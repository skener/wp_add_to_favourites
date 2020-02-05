<?php

/**
 * Plugin name: Add to favourites button plugin
 * Plugin URI:        https://skener.github.io/cv
 * Description:       Add selected posts to favourites.
 * Version:           1.0.0
 * Author:            Andriy Tserkovnyk <skenerster@gmail.com>
 * Author URI:        https://skener.github.io/cv
 * Text Domain:       skener
 *
 * @package WordPress.
 */


require __DIR__.'./functions.php';
add_filter('the_content', 'wf_favor_func');
add_action('wp_enqueue_scripts', 'load_plug_scripts');
add_action( 'wp_ajax_wf_add', 'ajax_wf_add' );
add_action( 'wp_ajax_wf_del', 'ajax_wf_del' );