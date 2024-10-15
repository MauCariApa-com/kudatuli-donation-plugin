<?php
/**
 * Plugin Name: Kudatuli Donation Plugin
 * Description: A simple donation plugin with Ko-fi integration and webhook handling.
 * Version: 1.0
 * Author: Kudatuli Project, MauCariApa.com
 */

// Include necessary files
require_once 'includes/admin-menu.php';
require_once 'includes/donation-processing.php';
require_once 'includes/email-processing.php';
require_once 'includes/functions.php';
require_once 'includes/meta-boxes.php';
require_once 'includes/pdf-generation.php';
require_once 'includes/post-type.php';
require_once 'includes/shortcodes.php';

// Enqueue CSS for the plugin
function kudatuli_enqueue_styles() {
    wp_enqueue_style('kudatuli-donation-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('kudatuli-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array(), null, true);
    wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'kudatuli_enqueue_styles');

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}