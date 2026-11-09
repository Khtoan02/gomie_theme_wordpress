<?php
/**
 * Force Checkout Template Refresh
 * Run this script to clear caches and force template refresh for checkout
 * Access: /wp-content/themes/gomie/force-checkout-refresh.php
 */

// Load WordPress
require_once('../../../wp-load.php');

if (!current_user_can('manage_options')) {
    die('Access denied. Please login as administrator.');
}

echo '<h1>Force Checkout Template Refresh</h1>';

// Clear WordPress cache
if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
    echo '<p>✅ WordPress cache cleared</p>';
}

// Clear WooCommerce cache
if (class_exists('WC_Cache_Helper')) {
    WC_Cache_Helper::get_transient_version('shipping', true);
    echo '<p>✅ WooCommerce cache cleared</p>';
}

// Flush rewrite rules
flush_rewrite_rules();
echo '<p>✅ Rewrite rules flushed</p>';

// Check template files
$templates_to_check = array(
    'woocommerce/checkout.php',
    'woocommerce/checkout/form-checkout.php',
    'assets/css/checkout-page.css',
    'assets/js/checkout-page.js',
    'page-checkout.php'
);

echo '<h2>Template Files Status:</h2>';
foreach ($templates_to_check as $template) {
    $file_path = get_template_directory() . '/' . $template;
    $status = file_exists($file_path) ? '✅ Exists' : '❌ Missing';
    $size = file_exists($file_path) ? ' (' . filesize($file_path) . ' bytes)' : '';
    echo '<p>' . $template . ': ' . $status . $size . '</p>';
}

// Check WooCommerce pages
echo '<h2>WooCommerce Pages:</h2>';
if (function_exists('wc_get_page_id')) {
    $checkout_page_id = wc_get_page_id('checkout');
    if ($checkout_page_id > 0) {
        $checkout_page = get_post($checkout_page_id);
        echo '<p>Checkout Page: <a href="' . get_permalink($checkout_page_id) . '">' . $checkout_page->post_title . '</a> (Slug: ' . $checkout_page->post_name . ')</p>';
    }
}

// Force template refresh by touching files
$checkout_template = get_template_directory() . '/woocommerce/checkout.php';
if (file_exists($checkout_template)) {
    touch($checkout_template);
    echo '<p>✅ Checkout template touched (forced refresh)</p>';
}

$checkout_form_template = get_template_directory() . '/woocommerce/checkout/form-checkout.php';
if (file_exists($checkout_form_template)) {
    touch($checkout_form_template);
    echo '<p>✅ Checkout form template touched (forced refresh)</p>';
}

echo '<h2>Next Steps:</h2>';
echo '<ol>';
echo '<li>Add some items to cart first</li>';
echo '<li>Visit your checkout page: <a href="' . wc_get_checkout_url() . '">' . wc_get_checkout_url() . '</a></li>';
echo '<li>Check if the new Gomie design is now showing</li>';
echo '<li>If still showing old design, check browser cache (Ctrl+F5)</li>';
echo '<li>View page source to see if gomie-checkout-container class is present</li>';
echo '</ol>';

echo '<p><strong>Refresh completed!</strong> Please test your checkout page now.</p>';

// Add some CSS for this debug page
echo '<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h1 { color: #0073aa; }
h2 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
p { margin: 5px 0; }
a { color: #0073aa; }
ol { background: #f9f9f9; padding: 20px; border-radius: 5px; }
</style>';
?>

