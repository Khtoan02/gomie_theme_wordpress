<?php
/**
 * Debug Checkout Page - Temporary debug file
 * Check this file by visiting: /wp-content/themes/gomie/debug-checkout.php
 */

// Load WordPress
require_once('../../../wp-load.php');

echo '<h1>Debug Checkout Page</h1>';

echo '<h2>WooCommerce Status:</h2>';
echo class_exists('WooCommerce') ? '✅ WooCommerce is active' : '❌ WooCommerce is not active';

echo '<h2>Checkout Page Info:</h2>';
if (function_exists('wc_get_page_id')) {
    $checkout_page_id = wc_get_page_id('checkout');
    echo '<p>Checkout Page ID: ' . $checkout_page_id . '</p>';
    
    if ($checkout_page_id > 0) {
        $checkout_page = get_post($checkout_page_id);
        echo '<p>Checkout Page Title: ' . $checkout_page->post_title . '</p>';
        echo '<p>Checkout Page Slug: ' . $checkout_page->post_name . '</p>';
        echo '<p>Checkout Page Status: ' . $checkout_page->post_status . '</p>';
        echo '<p>Checkout Page URL: <a href="' . get_permalink($checkout_page_id) . '">' . get_permalink($checkout_page_id) . '</a></p>';
    }
}

echo '<h2>Theme Templates:</h2>';
$theme_dir = get_template_directory();
$checkout_templates = array(
    'woocommerce/checkout.php',
    'woocommerce/checkout/form-checkout.php', 
    'page-checkout.php',
    'assets/css/checkout-page.css',
    'assets/js/checkout-page.js'
);

foreach ($checkout_templates as $template) {
    $template_path = $theme_dir . '/' . $template;
    echo '<p>' . $template . ': ' . (file_exists($template_path) ? '✅ Exists' : '❌ Not found') . '</p>';
}

echo '<h2>Current URL Test:</h2>';
echo '<p>Current URL: ' . $_SERVER['REQUEST_URI'] . '</p>';
echo '<p>Is Checkout: ' . (function_exists('is_checkout') && is_checkout() ? '✅ Yes' : '❌ No') . '</p>';

echo '<h2>WooCommerce Pages:</h2>';
if (function_exists('wc_get_page_permalink')) {
    $pages = array('shop', 'cart', 'checkout', 'myaccount');
    foreach ($pages as $page) {
        echo '<p>' . ucfirst($page) . ': <a href="' . wc_get_page_permalink($page) . '">' . wc_get_page_permalink($page) . '</a></p>';
    }
}

echo '<h2>Force Template Test:</h2>';
echo '<p>Try accessing checkout page with cart items to see if custom template loads.</p>';
echo '<p>Look for "gomie-checkout-container" class in page source.</p>';
?>

