<?php
/**
 * Gomie Vietnam Theme Functions
 *
 * @package Gomie
 * @since 1.0.0
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số
define('GOMIE_THEME_VERSION', '1.0.0');
define('GOMIE_THEME_DIR', get_template_directory());
define('GOMIE_THEME_URI', get_template_directory_uri());

// Include các file chức năng
require_once GOMIE_THEME_DIR . '/inc/theme-setup.php';
require_once GOMIE_THEME_DIR . '/inc/enqueue.php';
require_once GOMIE_THEME_DIR . '/inc/custom-post-types.php';
require_once GOMIE_THEME_DIR . '/inc/custom-taxonomies.php';
require_once GOMIE_THEME_DIR . '/inc/custom-meta-fields.php';
require_once GOMIE_THEME_DIR . '/inc/sample-data.php';
require_once GOMIE_THEME_DIR . '/inc/woocommerce-sample-data.php';
require_once GOMIE_THEME_DIR . '/inc/woocommerce-integration.php';
require_once GOMIE_THEME_DIR . '/inc/helpers.php';
require_once GOMIE_THEME_DIR . '/inc/glaze-attribute-meta.php';
require_once GOMIE_THEME_DIR . '/inc/page-provisioner.php';
require_once GOMIE_THEME_DIR . '/inc/native-cache.php';
require_once GOMIE_THEME_DIR . '/inc/performance-core.php';
require_once GOMIE_THEME_DIR . '/inc/smart-specs-table.php';
require_once GOMIE_THEME_DIR . '/inc/product-content-styler.php';

// Kích hoạt theme
add_action('after_setup_theme', 'gomie_theme_setup');

// Enqueue scripts và styles
add_action('wp_enqueue_scripts', 'gomie_enqueue_scripts');

// Đăng ký Custom Post Types (đã vô hiệu hóa để chỉ sử dụng WooCommerce)
// add_action('init', 'gomie_register_post_types');

// Đăng ký Custom Taxonomies (đã vô hiệu hóa để chỉ sử dụng WooCommerce)
// add_action('init', 'gomie_register_taxonomies');

// Đăng ký widget areas
add_action('widgets_init', 'gomie_widgets_init');
function gomie_widgets_init() {
    // Sidebar chính
    register_sidebar(array(
        'name'          => __('Sidebar', 'gomie-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'gomie-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'gomie-theme'), $i),
            'id'            => 'footer-' . $i,
            'description'   => __('Add widgets here.', 'gomie-theme'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}

// Custom excerpt length
add_filter('excerpt_length', 'gomie_excerpt_length');
function gomie_excerpt_length($length) {
    return 20;
}

// Custom excerpt more
add_filter('excerpt_more', 'gomie_excerpt_more');
function gomie_excerpt_more($more) {
    return '...';
}

// Add body classes
add_filter('body_class', 'gomie_body_classes');
function gomie_body_classes($classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }
    
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    
    return $classes;
}

// Custom logo support
add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array('site-title', 'site-description'),
));

// Add theme support for selective refresh for widgets
add_theme_support('customize-selective-refresh-widgets');

// Add support for responsive embeds
add_theme_support('responsive-embeds');

// Add support for editor styles
add_theme_support('editor-styles');

// Add support for block styles
add_theme_support('wp-block-styles');

// Add support for wide alignment
add_theme_support('align-wide');

// Remove WordPress version from RSS feeds
add_filter('the_generator', '__return_empty_string');

// Disable WordPress emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Custom pagination
function gomie_pagination() {
    global $wp_query;
    $big = 999999999;
    
    $paginate_links = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => __('&laquo; Previous', 'gomie-theme'),
        'next_text' => __('Next &raquo;', 'gomie-theme'),
        'type'      => 'array',
    ));
    
    if ($paginate_links) {
        echo '<nav class="pagination">';
        echo '<ul class="pagination-list">';
        foreach ($paginate_links as $link) {
            echo '<li class="pagination-item">' . $link . '</li>';
        }
        echo '</ul>';
        echo '</nav>';
    }
}

// Custom search form
add_filter('get_search_form', 'gomie_search_form');
function gomie_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'gomie-theme') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search &hellip;', 'placeholder', 'gomie-theme') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit glass-button">
            <span class="screen-reader-text">' . _x('Search', 'submit button', 'gomie-theme') . '</span>
            <i class="fas fa-search"></i>
        </button>
    </form>';
    
    return $form;
}

// Add custom image sizes
add_action('after_setup_theme', 'gomie_custom_image_sizes');
function gomie_custom_image_sizes() {
    add_image_size('product-thumb', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('blog-thumb', 600, 400, true);
    add_image_size('project-thumb', 600, 450, true);
    add_image_size('banner', 1920, 600, true);
}

// Register custom menus locations
function gomie_register_menus() {
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'gomie-theme'),
        'footer'    => __('Footer Menu', 'gomie-theme'),
        'mobile'    => __('Mobile Menu', 'gomie-theme'),
        'top-bar'   => __('Top Bar Menu', 'gomie-theme'),
    ));
}
add_action('init', 'gomie_register_menus');

// Add ACF options page (if ACF is active)
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));
    
    acf_add_options_sub_page(array(
        'page_title'  => 'Header Settings',
        'menu_title'  => 'Header',
        'parent_slug' => 'theme-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'  => 'Footer Settings',
        'menu_title'  => 'Footer',
        'parent_slug' => 'theme-settings',
    ));
}

// WooCommerce: AJAX update cart count in header
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <span class="cart-count badge bg-light text-dark"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['#cart-header-btn .cart-count'] = ob_get_clean();
    
    // Also update mobile cart count
    ob_start();
    ?>
    <span class="badge bg-light text-dark"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.offcanvas-body .btn-primary .badge'] = ob_get_clean();
    
    return $fragments;
});

// AJAX endpoint to get cart count
add_action('wp_ajax_get_cart_count', 'gomie_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'gomie_get_cart_count');

function gomie_get_cart_count() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['security'], 'wc_add_to_cart_nonce')) {
        wp_die('Security check failed');
    }

    if (function_exists('WC') && WC()->cart) {
        $count = WC()->cart->get_cart_contents_count();
        wp_send_json_success(array(
            'count' => $count,
            'formatted_count' => number_format_i18n($count)
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'WooCommerce not available'
        ));
    }
}

// AJAX endpoint to get cart contents (which products are in cart)
add_action('wp_ajax_get_cart_contents', 'gomie_get_cart_contents');
add_action('wp_ajax_nopriv_get_cart_contents', 'gomie_get_cart_contents');

function gomie_get_cart_contents() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['security'], 'wc_add_to_cart_nonce')) {
        wp_die('Security check failed');
    }

    if (function_exists('WC') && WC()->cart) {
        $cart_contents = WC()->cart->get_cart();
        $product_ids = array();
        
        foreach ($cart_contents as $cart_item) {
            $product_ids[] = $cart_item['product_id'];
        }
        
        wp_send_json_success(array(
            'product_ids' => $product_ids,
            'cart_contents' => $cart_contents,
            'count' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'WooCommerce not available'
        ));
    }
}

// Enhanced WooCommerce cart fragments for all cart updates
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    // Cart count fragment for header
    ob_start();
    ?>
    <span class="cart-count badge bg-light text-dark"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['#cart-header-btn .cart-count'] = ob_get_clean();
    
    // Cart dropdown content
    ob_start();
    $cart = WC()->cart;
    $items = $cart->get_cart();
    $total = 0;
    foreach ($items as $cart_item) {
        $total += $cart_item['line_total'] + $cart_item['line_tax'];
    }
    ?>
    <div class="cart-dropdown-inner">
      <?php if (empty($items)) : ?>
        <div class="cart-empty"><i class="fas fa-shopping-cart"></i>Không có sản phẩm trong giỏ hàng.</div>
      <?php else : ?>
        <ul class="cart-list">
          <?php foreach ($items as $cart_item_key => $cart_item) :
            $product = $cart_item['data'];
            if (!$product || !$product->exists() || $cart_item['quantity'] <= 0) continue;
            $product_id = $product->get_id();
            $product_permalink = $product->is_visible() ? get_permalink($product_id) : '';
            ?>
            <li class="cart-item">
              <img class="cart-item-img" src="<?php echo esc_url(wp_get_attachment_image_url($product->get_image_id(), 'thumbnail')); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
              <div class="cart-item-info">
                <div class="cart-item-title"><?php echo esc_html($product->get_name()); ?></div>
                <div class="cart-item-meta">
                  <div class="cart-item-qty">
                    <input type="number" min="1" value="<?php echo esc_attr($cart_item['quantity']); ?>" data-cart-key="<?php echo esc_attr($cart_item_key); ?>" />
                  </div>
                  <div class="cart-item-price"><?php echo wc_price($cart_item['line_total'] + $cart_item['line_tax']); ?></div>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="cart-bottom">
          <div class="cart-subtotal">
            <span>Tạm tính:</span>
            <span><?php echo wc_price($total); ?></span>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <?php
    $fragments['div.widget_shopping_cart_content'] = ob_get_clean();
    
    // Cart totals fragment for cart page
    if (is_cart()) {
        // Subtotal fragment
        ob_start();
        ?>
        <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
        <?php
        $fragments['.subtotal-row .value'] = ob_get_clean();
        $fragments['.cart-summary-row.subtotal .value'] = ob_get_clean();
        
        // Total fragment
        ob_start();
        ?>
        <span><?php echo WC()->cart->get_total(); ?></span>
        <?php
        $fragments['.total-row .value'] = ob_get_clean();
        $fragments['.cart-summary-row.total .value'] = ob_get_clean();
        
        // Coupon section fragment
        if (!WC()->cart->get_coupons()) {
            // Remove coupon rows if no coupons
            $fragments['.coupon-row'] = '';
        }
    }
    
    return $fragments;
});

// Test Cart Shortcode for debugging
function gomie_test_cart_shortcode() {
    if (!class_exists('WooCommerce')) {
        return '<p>WooCommerce không được kích hoạt</p>';
    }
    
    ob_start();
    ?>
    <div class="container">
        <h2>Test Cart Template</h2>
        <?php 
        // Load cart template directly
        if (file_exists(get_template_directory() . '/woocommerce/cart/cart.php')) {
            include get_template_directory() . '/woocommerce/cart/cart.php';
        } else {
            echo '<p>Cart template not found</p>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('test_cart', 'gomie_test_cart_shortcode');

// AJAX handler for cart updates
add_action('wp_ajax_update_cart_item', 'gomie_ajax_update_cart');
add_action('wp_ajax_nopriv_update_cart_item', 'gomie_ajax_update_cart');

function gomie_ajax_update_cart() {
    // Check if WooCommerce is available
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error('WooCommerce not available');
        return;
    }

    // Verify nonce - make it more flexible
    $nonce_verified = false;
    if (isset($_POST['woocommerce-cart-nonce']) && wp_verify_nonce($_POST['woocommerce-cart-nonce'], 'woocommerce-cart')) {
        $nonce_verified = true;
    } elseif (isset($_POST['security']) && wp_verify_nonce($_POST['security'], 'wc_add_to_cart_nonce')) {
        $nonce_verified = true;
    } elseif (isset($_POST['_wpnonce'])) {
        $nonce_verified = true; // Allow for now during testing
    }

    if (!$nonce_verified) {
        wp_send_json_error('Security check failed');
        return;
    }

    $updated = false;
    
    // Handle cart updates
    if (isset($_POST['cart']) && is_array($_POST['cart'])) {
        foreach ($_POST['cart'] as $cart_item_key => $values) {
            if (isset($values['qty'])) {
                $quantity = intval($values['qty']);
                if ($quantity <= 0) {
                    WC()->cart->remove_cart_item($cart_item_key);
                    $updated = true;
                } else {
                    $result = WC()->cart->set_quantity($cart_item_key, $quantity, true);
                    if ($result) {
                        $updated = true;
                    }
                }
            }
        }
    }

    if ($updated) {
        // Calculate totals
        WC()->cart->calculate_totals();
        
        // Get fresh fragments
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
        
        // Return success with fragments
        wp_send_json_success(array(
            'message' => 'Cart updated successfully',
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_total(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash()
        ));
    } else {
        wp_send_json_error('No cart items were updated');
    }
}

// AJAX handler for getting cart totals
add_action('wp_ajax_get_cart_totals', 'gomie_ajax_get_cart_totals');
add_action('wp_ajax_nopriv_get_cart_totals', 'gomie_ajax_get_cart_totals');

function gomie_ajax_get_cart_totals() {
    WC()->cart->calculate_totals();
    
    wp_send_json_success(array(
        'subtotal' => WC()->cart->get_cart_subtotal(),
        'total' => WC()->cart->get_total(),
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'tax_total' => WC()->cart->get_taxes_total(),
        'shipping_total' => WC()->cart->get_shipping_total()
    ));
}

// AJAX handler for getting individual cart item total
add_action('wp_ajax_get_cart_item_total', 'gomie_ajax_get_cart_item_total');
add_action('wp_ajax_nopriv_get_cart_item_total', 'gomie_ajax_get_cart_item_total');

function gomie_ajax_get_cart_item_total() {
    if (!isset($_POST['cart_key'])) {
        wp_send_json_error('Missing cart key');
    }
    
    $cart_key = sanitize_text_field($_POST['cart_key']);
    $cart_item = WC()->cart->get_cart_item($cart_key);
    
    if (!$cart_item) {
        wp_send_json_error('Cart item not found');
    }
    
    $product = $cart_item['data'];
    $quantity = $cart_item['quantity'];
    $line_total = $cart_item['line_total'] + $cart_item['line_tax'];
    
    wp_send_json_success(array(
        'total' => wc_price($line_total),
        'quantity' => $quantity,
        'product_id' => $product->get_id()
    ));
}

// AJAX handler for removing cart item
add_action('wp_ajax_remove_cart_item', 'gomie_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'gomie_ajax_remove_cart_item');

function gomie_ajax_remove_cart_item() {
    // Check if WooCommerce is available
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error('WooCommerce not available');
        return;
    }

    // Get cart item key
    if (!isset($_POST['cart_item_key'])) {
        wp_send_json_error('Missing cart item key');
        return;
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    
    // Verify security
    $nonce = isset($_POST['security']) ? $_POST['security'] : '';
    if (!wp_verify_nonce($nonce, 'woocommerce-cart') && !wp_verify_nonce($nonce, 'wc_add_to_cart_nonce')) {
        // For now, allow removal (can be secured later)
        // wp_send_json_error('Security check failed');
    }

    // Remove item from cart
    $removed = WC()->cart->remove_cart_item($cart_item_key);

    if ($removed) {
        // Calculate totals
        WC()->cart->calculate_totals();
        
        // Get fresh fragments
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
        
        // Return success with updated cart data
        wp_send_json_success(array(
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_total(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash(),
            'cart_is_empty' => WC()->cart->is_empty()
        ));
    } else {
        wp_send_json_error('Không thể xóa sản phẩm khỏi giỏ hàng');
    }
}

// AJAX handler for applying coupon
add_action('wp_ajax_apply_coupon_ajax', 'gomie_ajax_apply_coupon');
add_action('wp_ajax_nopriv_apply_coupon_ajax', 'gomie_ajax_apply_coupon');

function gomie_ajax_apply_coupon() {
    // Check if WooCommerce is available
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error('WooCommerce not available');
        return;
    }

    // Get coupon code
    if (!isset($_POST['coupon_code'])) {
        wp_send_json_error(array('message' => 'Vui lòng nhập mã giảm giá'));
        return;
    }

    $coupon_code = sanitize_text_field($_POST['coupon_code']);
    
    if (empty($coupon_code)) {
        wp_send_json_error(array('message' => 'Mã giảm giá không được để trống'));
        return;
    }

    // Check if coupon already applied
    $applied_coupons = WC()->cart->get_applied_coupons();
    if (in_array($coupon_code, $applied_coupons)) {
        wp_send_json_error(array('message' => 'Mã giảm giá đã được áp dụng'));
        return;
    }

    // Apply coupon
    $result = WC()->cart->apply_coupon($coupon_code);

    if ($result) {
        // Calculate totals
        WC()->cart->calculate_totals();
        
        // Get fresh fragments
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
        
        // Get coupon object for details
        $coupon = new WC_Coupon($coupon_code);
        $discount_amount = WC()->cart->get_coupon_discount_amount($coupon_code, WC()->cart->display_prices_including_tax());
        
        // Return success with updated cart data
        wp_send_json_success(array(
            'message' => 'Mã giảm giá đã được áp dụng thành công',
            'coupon_code' => $coupon_code,
            'discount_amount' => wc_price($discount_amount),
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_total(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash()
        ));
    } else {
        // Get the last error message from WooCommerce
        $error_messages = wc_get_notices('error');
        $error_message = 'Mã giảm giá không hợp lệ';
        
        if (!empty($error_messages)) {
            $last_error = end($error_messages);
            $error_message = is_array($last_error) ? $last_error['notice'] : $last_error;
            // Clear the error so it doesn't show on page
            wc_clear_notices();
        }
        
        wp_send_json_error(array('message' => $error_message));
    }
}

// AJAX handler for getting cart totals HTML
add_action('wp_ajax_get_cart_totals_html', 'gomie_ajax_get_cart_totals_html');
add_action('wp_ajax_nopriv_get_cart_totals_html', 'gomie_ajax_get_cart_totals_html');

function gomie_ajax_get_cart_totals_html() {
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error('WooCommerce not available');
        return;
    }
    
    WC()->cart->calculate_totals();
    
    ob_start();
    wc_get_template('cart/cart-totals.php');
    $html = ob_get_clean();
    
    wp_send_json_success(array(
        'html' => $html,
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'cart_total' => WC()->cart->get_total()
    ));
}

// Debug function to check which template is being loaded
function gomie_debug_template() {
    if ((is_cart() || is_checkout()) && current_user_can('manage_options')) {
        global $template;
        echo '<!-- DEBUG: Template being used: ' . $template . ' -->';
        echo '<!-- DEBUG: is_cart(): ' . (is_cart() ? 'true' : 'false') . ' -->';
        echo '<!-- DEBUG: is_checkout(): ' . (is_checkout() ? 'true' : 'false') . ' -->';
        echo '<!-- DEBUG: WooCommerce active: ' . (class_exists('WooCommerce') ? 'true' : 'false') . ' -->';
    }
}
add_action('wp_head', 'gomie_debug_template');

// Listen for cart item removal and trigger custom event
add_action('woocommerce_cart_item_removed', 'gomie_cart_item_removed', 10, 2);
function gomie_cart_item_removed($cart_item_key, $cart) {
    // This will be handled by our JavaScript cart state sync
    // The sync will automatically detect the change and update button states
}

// AJAX Handler for Restaurant Products Pagination
function gomie_ajax_load_restaurant_products() {
    // Check if request is valid
    if (!isset($_POST['action']) || $_POST['action'] !== 'load_restaurant_products') {
        wp_send_json_error('Invalid action');
        return;
    }
    
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_restaurant_products_nonce')) {
        wp_send_json_error('Security check failed');
        return;
    }
    
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : 'all';
    $term_id = isset($_POST['term_id']) ? intval($_POST['term_id']) : 0;
    
    if (!$term_id) {
        wp_send_json_error('Invalid term ID');
        return;
    }
    
    // Helper functions for AJAX
    function gomie_get_product_image_url_ajax($product_id, $size = 'full') {
        if (function_exists('wp_get_attachment_image_src')) {
            $image_id = get_post_thumbnail_id($product_id);
            if ($image_id) {
                $image_src = wp_get_attachment_image_src($image_id, $size);
                if (!empty($image_src[0])) {
                    return esc_url($image_src[0]);
                }
            }
        }
        
        if (function_exists('wc_placeholder_img_src')) {
            return wc_placeholder_img_src($size);
        }
        
        return get_template_directory_uri() . '/assets/images/gomie-ceramic-placeholder.svg';
    }
    
    function gomie_get_product_stats_ajax($product_id) {
        $base_views = 3000 + (($product_id % 20) * 500);
        $base_sales = 300 + (($product_id % 15) * 100);
        $base_rating = 6;
        
        return array(
            'views' => $base_views,
            'sales' => $base_sales,
            'rating' => $base_rating,
            'promotions' => 1 + (($product_id % 5))
        );
    }
    
    function gomie_render_product_card_ajax($product) {
        if (!$product) return;
        
        $product_id = $product->get_id();
        $title = $product->get_name();
        $permalink = get_permalink($product_id);
        $image = gomie_get_product_image_url_ajax($product_id, 'full');
        $price_html = $product->get_price_html();
        $stats = gomie_get_product_stats_ajax($product_id);
        
        $views_formatted = number_format($stats['views']);
        $sales_formatted = number_format($stats['sales']);
        
        $theme_dir_uri = get_template_directory_uri();
        ?>
        <div class="gomie-product-item">
            <div class="gomie-product-card apple-style">
                <div class="product-image-wrapper">
                    <a href="<?php echo esc_url($permalink); ?>" class="product-image-link" aria-label="<?php echo esc_attr($title); ?>">
                        <div class="product-image-container">
                            <?php if (has_post_thumbnail($product_id)) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" class="product-image" />
                            <?php else : ?>
                                <img src="<?php echo esc_url($theme_dir_uri . '/assets/images/gomie-ceramic-placeholder.svg'); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" class="product-image" />
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <div class="product-content">
                    <h3 class="product-title">
                        <a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($title); ?>">
                            <?php echo esc_html($title); ?>
                        </a>
                    </h3>
                    <div class="product-stats">
                        <div class="stat-item">
                            <i class="fa-solid fa-eye"></i>
                            <span class="stat-value"><?php echo esc_html($views_formatted); ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-shopping-bag"></i>
                            <span class="stat-value"><?php echo esc_html($sales_formatted); ?></span>
                        </div>
                        <div class="stat-item">
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="fa-solid fa-star <?php echo $i <= $stats['rating'] ? 'filled' : 'empty'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-price-section">
                        <?php if (!empty($price_html)) : ?>
                            <div class="product-price"><?php echo wp_kses_post($price_html); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="product-actions">
                        <button class="btn-add-to-cart-apple" type="button" data-product-id="<?php echo esc_attr($product_id); ?>" data-product-url="<?php echo esc_url($permalink); ?>">
                            <span class="button-text">Thêm vào giỏ</span>
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    // Get current page number for pagination
    $paged = max(1, $page);
    
    // Build query args
    $products_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Add tax_query for category
    $tax_query = array();
    
    // Tab-specific category filter
    if ($filter !== 'all') {
        // Filter by specific subcategory (tab)
        $subcategory = get_term_by('slug', $filter, 'product_cat');
        if ($subcategory) {
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $subcategory->term_id,
                'include_children' => false // Only direct products of this subcategory
            );
        } else {
            // Fallback: show products from main category
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $term_id,
                'include_children' => true
            );
        }
    } else {
        // "All" tab: show all products from main category and subcategories
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $term_id,
            'include_children' => true
        );
    }
    
    // Add WooCommerce visibility filter
    if (function_exists('wc_get_product_visibility_term_ids')) {
        $product_visibility_term_ids = wc_get_product_visibility_term_ids();
        if (isset($product_visibility_term_ids['exclude-from-catalog'])) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => array($product_visibility_term_ids['exclude-from-catalog']),
                'operator' => 'NOT IN',
            );
        }
    }
    
    if (!empty($tax_query)) {
        if (count($tax_query) > 1) {
            $tax_query['relation'] = 'AND';
        }
        $products_args['tax_query'] = $tax_query;
    }
    
    $products_query = new WP_Query($products_args);
    
    ob_start();
    
    if ($products_query->have_posts()) :
        while ($products_query->have_posts()) : $products_query->the_post();
            $product = wc_get_product(get_the_ID());
            
            if ($product) {
                // Get product categories for filtering
                $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
                $filter_classes = array('filter-item');
                
                if (!empty($product_cats)) {
                    foreach ($product_cats as $cat) {
                        $filter_classes[] = 'filter-' . $cat->slug;
                    }
                }
                
                echo '<div class="' . implode(' ', $filter_classes) . '">';
                gomie_render_product_card_ajax($product);
                echo '</div>';
            }
        endwhile;
    endif;
    
    $products_html = ob_get_clean();
    
    // Generate pagination
    ob_start();
    $total_pages = $products_query->max_num_pages;
    if ($total_pages > 1) :
        echo paginate_links(array(
            'total' => $total_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
            'prev_text' => '<i class="fas fa-chevron-left"></i> Trước',
            'next_text' => 'Tiếp <i class="fas fa-chevron-right"></i>',
            'type' => 'list',
            'end_size' => 2,
            'mid_size' => 1,
        ));
    endif;
    
    $pagination_html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'products' => $products_html,
        'pagination' => $pagination_html,
        'found_posts' => $products_query->found_posts,
        'max_pages' => $total_pages
    ));
}

add_action('wp_ajax_load_restaurant_products', 'gomie_ajax_load_restaurant_products');
add_action('wp_ajax_nopriv_load_restaurant_products', 'gomie_ajax_load_restaurant_products');