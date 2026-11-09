<?php
/**
 * WooCommerce Integration for Gomie Theme
 * Optimizes WooCommerce compatibility and styling
 *
 * @package Gomie
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WooCommerce Theme Support
 */
function gomie_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'gomie_woocommerce_support');

/**
 * Remove WooCommerce default styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Custom WooCommerce wrapper
 */
function gomie_woocommerce_wrapper_start() {
    echo '<div class="woocommerce-wrapper container">';
}

function gomie_woocommerce_wrapper_end() {
    echo '</div>';
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'gomie_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'gomie_woocommerce_wrapper_end', 10);

/**
 * Modify WooCommerce breadcrumb
 */
function gomie_woocommerce_breadcrumb_defaults() {
    return array(
        'delimiter'   => '<i class="fas fa-chevron-right"></i>',
        'wrap_before' => '<nav class="woocommerce-breadcrumb gomie-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '<span>',
        'after'       => '</span>',
        'home'        => _x('Trang chủ', 'breadcrumb', 'gomie-theme'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'gomie_woocommerce_breadcrumb_defaults');

/**
 * Change products per page
 */
function gomie_woocommerce_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'gomie_woocommerce_products_per_page', 20);

/**
 * Custom product columns
 */
function gomie_woocommerce_loop_columns() {
    return 4; // 4 products per row
}
add_filter('loop_shop_columns', 'gomie_woocommerce_loop_columns');

/**
 * Modify WooCommerce product loop
 */
function gomie_woocommerce_product_loop_start() {
    echo '<div class="gomie-product-grid woocommerce-products">';
}

function gomie_woocommerce_product_loop_end() {
    echo '</div>';
}

remove_action('woocommerce_output_all_notices', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 5);

// Replace default product loop
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_action('woocommerce_before_shop_loop', 'gomie_shop_controls', 20);

/**
 * Custom shop controls
 */
function gomie_shop_controls() {
    ?>
    <div class="shop-controls d-flex justify-content-between align-items-center mb-4">
        <div class="shop-results">
            <?php woocommerce_result_count(); ?>
        </div>
        <div class="shop-ordering">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>
    <?php
}

/**
 * Custom product card template
 */
function gomie_woocommerce_template_loop_product_link_open() {
    return '<div class="gomie-product-item"><div class="gomie-product-card apple-style"><div class="product-image-wrapper"><a href="' . get_the_permalink() . '" class="product-image-link">';
}

function gomie_woocommerce_template_loop_product_link_close() {
    return '</a></div>';
}

// Modify WooCommerce hooks for custom product cards
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

/**
 * Remove default WooCommerce sidebar
 */
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Custom add to cart messages
 */
function gomie_woocommerce_add_to_cart_message_html($message, $products) {
    $titles = array();
    $count = 0;
    
    if (is_array($products)) {
        foreach ($products as $product_id => $qty) {
            $titles[] = ($qty > 1 ? absint($qty) . ' &times; ' : '') . sprintf(_x('&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce'), strip_tags(get_the_title($product_id)));
            $count += $qty;
        }
    }
    
    $titles = array_filter($titles);
    $added_text = sprintf(_n(
        '%s đã được thêm vào giỏ hàng.',
        '%s đã được thêm vào giỏ hàng.',
        $count,
        'gomie-theme'
    ), wc_format_list_of_items($titles));
    
    $message = sprintf(
        '<span class="gomie-notice-text">%s</span> <a href="%s" class="button wc-forward btn-gomie-notice">%s</a>',
        $added_text,
        esc_url(wc_get_cart_url()),
        esc_html__('Xem giỏ hàng', 'gomie-theme')
    );
    
    return $message;
}
add_filter('wc_add_to_cart_message_html', 'gomie_woocommerce_add_to_cart_message_html', 10, 2);

/**
 * Custom WooCommerce pagination
 */
function gomie_woocommerce_pagination() {
    if (wc_get_loop_prop('total_pages') <= 1) {
        return;
    }
    ?>
    <nav class="woocommerce-pagination gomie-pagination">
        <?php
        echo paginate_links(apply_filters('woocommerce_pagination_args', array(
            'base'         => esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false)))),
            'format'       => '',
            'add_args'     => false,
            'current'      => max(1, get_query_var('paged')),
            'total'        => wc_get_loop_prop('total_pages'),
            'prev_text'    => '<i class="fas fa-chevron-left"></i> ' . __('Trước', 'gomie-theme'),
            'next_text'    => __('Tiếp', 'gomie-theme') . ' <i class="fas fa-chevron-right"></i>',
            'type'         => 'list',
            'end_size'     => 3,
            'mid_size'     => 3,
        )));
        ?>
    </nav>
    <?php
}

remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'gomie_woocommerce_pagination', 10);

/**
 * Custom no products found message
 */
function gomie_woocommerce_no_products_found() {
    ?>
    <div class="no-products-found">
        <div class="no-products-content text-center">
            <i class="fas fa-search"></i>
            <h3><?php _e('Không tìm thấy sản phẩm', 'gomie-theme'); ?></h3>
            <p><?php _e('Không có sản phẩm nào phù hợp với lựa chọn của bạn.', 'gomie-theme'); ?></p>
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-gomie">
                <i class="fas fa-arrow-left"></i>
                <?php _e('Quay lại cửa hàng', 'gomie-theme'); ?>
            </a>
        </div>
    </div>
    <?php
}

remove_action('woocommerce_no_products_found', 'wc_no_products_found');
add_action('woocommerce_no_products_found', 'gomie_woocommerce_no_products_found');

/**
 * Optimize WooCommerce for performance
 */
function gomie_woocommerce_optimize() {
    // Remove WooCommerce generator tag
    remove_action('wp_head', array('WC_Frontend_Scripts', 'get_script_data'), 5);
    
    // Remove WooCommerce styles on non-WooCommerce pages
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'gomie_woocommerce_optimize', 100);

/**
 * Custom WooCommerce CSS classes
 */
function gomie_woocommerce_body_class($classes) {
    if (is_woocommerce()) {
        $classes[] = 'gomie-woocommerce';
    }
    
    if (is_shop()) {
        $classes[] = 'gomie-shop';
    }
    
    if (is_cart()) {
        $classes[] = 'gomie-cart';
    }
    
    if (is_checkout()) {
        $classes[] = 'gomie-checkout';
    }
    
    if (is_account_page()) {
        $classes[] = 'gomie-account';
    }
    
    if (is_product_category()) {
        $classes[] = 'gomie-product-category';
        
        $term = get_queried_object();
        if ($term) {
            $classes[] = 'gomie-category-' . $term->slug;
        }
    }
    
    return $classes;
}
add_filter('body_class', 'gomie_woocommerce_body_class');

/**
 * AJAX add to cart for shop page
 */
function gomie_ajax_add_to_cart() {
    if (!wp_verify_nonce($_POST['nonce'], 'gomie_add_to_cart')) {
        wp_send_json_error('Invalid nonce');
        return;
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity']) ?: 1;
    
    $result = WC()->cart->add_to_cart($product_id, $quantity);
    
    if ($result) {
        wp_send_json_success(array(
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total()
        ));
    } else {
        wp_send_json_error('Không thể thêm sản phẩm vào giỏ hàng');
    }
}
add_action('wp_ajax_gomie_add_to_cart', 'gomie_ajax_add_to_cart');
add_action('wp_ajax_nopriv_gomie_add_to_cart', 'gomie_ajax_add_to_cart');

/**
 * Structured data for shop page
 */
function gomie_shop_structured_data() {
    if (!is_shop()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Store',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        'sameAs' => array(),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => 'Sản phẩm gốm sứ thủ công',
            'itemListElement' => array()
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'gomie_shop_structured_data');

/**
 * Initialize WooCommerce integration
 */
function gomie_init_woocommerce() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Additional WooCommerce customizations can be added here
}
add_action('init', 'gomie_init_woocommerce');

/**
 * Ensure WooCommerce pages exist with correct slugs
 */
function gomie_ensure_woocommerce_pages() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Check if cart page exists with Vietnamese slug
    $cart_page_id = wc_get_page_id('cart');
    if ($cart_page_id > 0) {
        $cart_page = get_post($cart_page_id);
        if ($cart_page && $cart_page->post_name !== 'gio-hang') {
            // Update cart page slug to Vietnamese
            wp_update_post(array(
                'ID' => $cart_page_id,
                'post_name' => 'gio-hang'
            ));
        }
    }
}
add_action('admin_init', 'gomie_ensure_woocommerce_pages');

/**
 * Force WooCommerce to use our custom templates
 */
function gomie_force_woocommerce_templates($template) {
    if (is_cart()) {
        // Force load our custom cart template
        $cart_template = get_template_directory() . '/woocommerce/cart.php';
        if (file_exists($cart_template)) {
            return $cart_template;
        }
    }
    
    if (is_checkout()) {
        // Force load our custom checkout template
        $checkout_template = get_template_directory() . '/woocommerce/checkout.php';
        if (file_exists($checkout_template)) {
            return $checkout_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'gomie_force_woocommerce_templates', 999);

/**
 * Override WooCommerce template parts
 */
function gomie_override_woocommerce_templates($template, $template_name, $template_path) {
    // Override cart templates
    if ($template_name === 'cart/cart.php') {
        $custom_template = get_template_directory() . '/woocommerce/cart/cart.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    
    if ($template_name === 'cart/cart-empty.php') {
        $custom_template = get_template_directory() . '/woocommerce/cart/cart-empty.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    
    // Override checkout templates
    if ($template_name === 'checkout/form-checkout.php') {
        $custom_template = get_template_directory() . '/woocommerce/checkout/form-checkout.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter('woocommerce_locate_template', 'gomie_override_woocommerce_templates', 10, 3);

/**
 * Force our templates to be used everywhere
 */
function gomie_force_woocommerce_templates_everywhere() {
    // Force cart templates
    if (is_cart() || (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'get_refreshed_fragments')) {
        wp_enqueue_style('cart-page', get_template_directory_uri() . '/assets/css/cart-page.css', array('gomie-style'), GOMIE_THEME_VERSION);
        wp_enqueue_script('cart-page-js', get_template_directory_uri() . '/assets/js/cart-page.js', array('jquery'), GOMIE_THEME_VERSION, true);
    }
    
    // Force checkout templates
    if (is_checkout()) {
        wp_enqueue_style('checkout-page', get_template_directory_uri() . '/assets/css/checkout-page.css', array('gomie-style'), GOMIE_THEME_VERSION);
        wp_enqueue_script('checkout-page-js', get_template_directory_uri() . '/assets/js/checkout-page.js', array('jquery'), GOMIE_THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'gomie_force_woocommerce_templates_everywhere', 999);

/**
 * Handle Vietnamese cart URL redirect
 */
function gomie_handle_cart_url() {
    // Check if we're accessing /gio-hang
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, '/gio-hang') !== false) {
        // If WooCommerce is active, redirect to proper cart page
        if (function_exists('wc_get_cart_url')) {
            $cart_url = wc_get_cart_url();
            // If current URL is not the cart URL, redirect
            if ($request_uri !== parse_url($cart_url, PHP_URL_PATH)) {
                wp_redirect($cart_url);
                exit;
            }
        }
    }
}
add_action('template_redirect', 'gomie_handle_cart_url', 1);

/**
 * Add rewrite rule for Vietnamese cart URL
 */
function gomie_add_cart_rewrite_rules() {
    add_rewrite_rule('^gio-hang/?$', 'index.php?page_id=' . wc_get_page_id('cart'), 'top');
}
add_action('init', 'gomie_add_cart_rewrite_rules');

/**
 * Force checkout page to refresh when cart is updated
 */
function gomie_force_checkout_refresh() {
    if (is_checkout() && !is_wc_endpoint_url()) {
        // Add script to refresh checkout when cart changes
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Listen for cart updates
            $(document.body).on('updated_wc_div wc_fragments_refreshed', function() {
                // Refresh checkout page to update totals
                if ($('.woocommerce-checkout').length) {
                    $(document.body).trigger('update_checkout');
                }
            });
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'gomie_force_checkout_refresh');

/**
 * Ensure cart calculations are always up to date
 */
function gomie_ensure_cart_calculations() {
    if (is_admin()) {
        return;
    }
    
    // Always calculate totals when cart is accessed
    if (WC()->cart && !WC()->cart->is_empty()) {
        WC()->cart->calculate_totals();
    }
}
add_action('wp_loaded', 'gomie_ensure_cart_calculations');


/**
 * =============================================================================
 * GOMIE CERAMIC - VIETNAM CHECKOUT OPTIMIZATION
 * Tinh gon form thanh toan cho thi truong Viet Nam (Ten, SDT, Dia chi, Email)
 * Tu dong luu thong tin cho khach hang co tai khoan dung lai cho cac lan sau
 * =============================================================================
 */

// 1. Tinh gon cac truong checkout
add_filter("woocommerce_checkout_fields", "gomie_simplify_vietnam_checkout_fields", 9999);
function gomie_simplify_vietnam_checkout_fields($fields) {
    // Chi giu lai 4 truong thiet yeu trong billing
    $fields["billing"]["billing_first_name"] = array(
        "label"        => __("Họ và tên người nhận", "gomie-theme"),
        "placeholder"  => __("Ví dụ: Nguyễn Văn An", "gomie-theme"),
        "required"     => true,
        "class"        => array("form-row-wide"),
        "clear"        => true,
        "priority"     => 10,
        "autocomplete" => "name",
    );

    $fields["billing"]["billing_phone"] = array(
        "label"        => __("Số điện thoại nhận hàng", "gomie-theme"),
        "placeholder"  => __("Ví dụ: 0912 345 678 (Shipper sẽ gọi trước khi giao)", "gomie-theme"),
        "required"     => true,
        "type"         => "tel",
        "class"        => array("form-row-wide"),
        "clear"        => true,
        "priority"     => 20,
        "autocomplete" => "tel",
    );

    $fields["billing"]["billing_address_1"] = array(
        "label"        => __("Địa chỉ nhận hàng chi tiết", "gomie-theme"),
        "placeholder"  => __("Số nhà, ngõ/đường, phường/xã, quận/huyện, tỉnh/thành phố", "gomie-theme"),
        "required"     => true,
        "class"        => array("form-row-wide"),
        "clear"        => true,
        "priority"     => 30,
        "autocomplete" => "street-address",
    );

    $fields["billing"]["billing_email"] = array(
        "label"        => __("Địa chỉ Email nhận thông tin đơn hàng", "gomie-theme"),
        "placeholder"  => __("email@example.com (để nhận xác nhận & mã vận đơn)", "gomie-theme"),
        "required"     => true,
        "type"         => "email",
        "class"        => array("form-row-wide"),
        "clear"        => true,
        "priority"     => 40,
        "autocomplete" => "email",
    );

    // Xoa bo toan bo cac truong khong phu hop tai Viet Nam
    unset($fields["billing"]["billing_last_name"]);
    unset($fields["billing"]["billing_company"]);
    unset($fields["billing"]["billing_country"]);
    unset($fields["billing"]["billing_address_2"]);
    unset($fields["billing"]["billing_city"]);
    unset($fields["billing"]["billing_state"]);
    unset($fields["billing"]["billing_postcode"]);

    // Tat hoan toan muc giao hang toi dia chi khac
    unset($fields["shipping"]);

    // Toi uu muc ghi chu don hang
    if (isset($fields["order"]["order_comments"])) {
        $fields["order"]["order_comments"]["label"] = __("Ghi chú giao hàng (tùy chọn)", "gomie-theme");
        $fields["order"]["order_comments"]["placeholder"] = __("Ví dụ: Giao giờ hành chính, bọc lót chống sốc cẩn thận giúp tôi...", "gomie-theme");
        $fields["order"]["order_comments"]["class"] = array("form-row-wide");
    }

    if (isset($fields["account"]["createaccount"])) {
        $fields["account"]["createaccount"]["label"] = __("Lưu thông tin này cho các lần mua sau (Tạo tài khoản)", "gomie-theme");
    }

    return $fields;
}

// 2. Tinh gon billing fields mac dinh
add_filter("woocommerce_billing_fields", "gomie_simplify_billing_fields_direct", 9999);
function gomie_simplify_billing_fields_direct($fields) {
    if (isset($fields["billing_first_name"])) {
        $fields["billing_first_name"]["label"] = __("Họ và tên người nhận", "gomie-theme");
        $fields["billing_first_name"]["placeholder"] = __("Ví dụ: Nguyễn Văn An", "gomie-theme");
        $fields["billing_first_name"]["class"] = array("form-row-wide");
        $fields["billing_first_name"]["priority"] = 10;
    }
    if (isset($fields["billing_phone"])) {
        $fields["billing_phone"]["label"] = __("Số điện thoại nhận hàng", "gomie-theme");
        $fields["billing_phone"]["placeholder"] = __("Ví dụ: 0912 345 678 (Shipper sẽ gọi trước khi giao)", "gomie-theme");
        $fields["billing_phone"]["required"] = true;
        $fields["billing_phone"]["class"] = array("form-row-wide");
        $fields["billing_phone"]["priority"] = 20;
    }
    if (isset($fields["billing_address_1"])) {
        $fields["billing_address_1"]["label"] = __("Địa chỉ nhận hàng chi tiết", "gomie-theme");
        $fields["billing_address_1"]["placeholder"] = __("Số nhà, ngõ/đường, phường/xã, quận/huyện, tỉnh/thành phố", "gomie-theme");
        $fields["billing_address_1"]["class"] = array("form-row-wide");
        $fields["billing_address_1"]["priority"] = 30;
    }
    if (isset($fields["billing_email"])) {
        $fields["billing_email"]["label"] = __("Địa chỉ Email nhận thông tin đơn hàng", "gomie-theme");
        $fields["billing_email"]["placeholder"] = __("email@example.com (để nhận xác nhận & mã vận đơn)", "gomie-theme");
        $fields["billing_email"]["class"] = array("form-row-wide");
        $fields["billing_email"]["priority"] = 40;
    }

    unset($fields["billing_last_name"]);
    unset($fields["billing_company"]);
    unset($fields["billing_country"]);
    unset($fields["billing_address_2"]);
    unset($fields["billing_city"]);
    unset($fields["billing_state"]);
    unset($fields["billing_postcode"]);

    return $fields;
}

// 3. Tu dong xu ly du lieu khi submit (tach ho ten, gan quoc gia VN, thanh pho mac dinh)
add_filter("woocommerce_checkout_posted_data", "gomie_process_vietnam_checkout_data");
function gomie_process_vietnam_checkout_data($data) {
    if (!empty($data["billing_first_name"]) && empty($data["billing_last_name"])) {
        $name_parts = explode(" ", trim($data["billing_first_name"]));
        if (count($name_parts) > 1) {
            $data["billing_first_name"] = array_shift($name_parts);
            $data["billing_last_name"]  = implode(" ", $name_parts);
        } else {
            $data["billing_last_name"]  = $data["billing_first_name"];
        }
    }

    // Luon mac dinh quoc gia Viet Nam
    $data["billing_country"] = "VN";
    $data["shipping_country"] = "VN";

    if (empty($data["billing_city"])) {
        $data["billing_city"] = "Việt Nam";
    }
    $data["shipping_city"] = $data["billing_city"];

    $data["shipping_first_name"] = $data["billing_first_name"];
    $data["shipping_last_name"]  = $data["billing_last_name"];
    $data["shipping_address_1"]  = $data["billing_address_1"];
    $data["shipping_phone"]      = $data["billing_phone"];

    return $data;
}

// 4. Bo qua kiem tra bat buoc cho cac truong da an
add_filter("woocommerce_default_address_fields", "gomie_override_default_address_fields", 9999);
function gomie_override_default_address_fields($fields) {
    if (isset($fields["last_name"])) {
        $fields["last_name"]["required"] = false;
    }
    if (isset($fields["city"])) {
        $fields["city"]["required"] = false;
    }
    if (isset($fields["state"])) {
        $fields["state"]["required"] = false;
    }
    if (isset($fields["postcode"])) {
        $fields["postcode"]["required"] = false;
    }
    return $fields;
}

// 5. Tu dong dien (Pre-fill) thong tin da luu cho khach hang co tai khoan
add_filter("woocommerce_checkout_get_value", "gomie_prefill_saved_user_checkout_data", 10, 2);
function gomie_prefill_saved_user_checkout_data($value, $input) {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        
        // Ho va ten gop
        if ($input === "billing_first_name") {
            $first = get_user_meta($user_id, "billing_first_name", true);
            $last  = get_user_meta($user_id, "billing_last_name", true);
            if ($first || $last) {
                return trim($first . " " . $last);
            }
            $user_data = get_userdata($user_id);
            if ($user_data && !empty($user_data->display_name)) {
                return $user_data->display_name;
            }
        }
        
        // So dien thoai
        if ($input === "billing_phone") {
            $phone = get_user_meta($user_id, "billing_phone", true);
            if ($phone) {
                return $phone;
            }
        }
        
        // Dia chi
        if ($input === "billing_address_1") {
            $addr = get_user_meta($user_id, "billing_address_1", true);
            if ($addr) {
                return $addr;
            }
        }
        
        // Email
        if ($input === "billing_email") {
            $email = get_user_meta($user_id, "billing_email", true);
            if ($email) {
                return $email;
            }
            $user_data = get_userdata($user_id);
            if ($user_data && !empty($user_data->user_email)) {
                return $user_data->user_email;
            }
        }
    }
    return $value;
}

// 6. Tu dong LUU thong tin vao tai khoan khach hang khi dat hang de su dung cac lan sau
add_action("woocommerce_checkout_update_user_meta", "gomie_save_checkout_data_to_user_account", 10, 2);
function gomie_save_checkout_data_to_user_account($user_id, $posted_data) {
    if (!$user_id) {
        return;
    }

    if (!empty($posted_data["billing_first_name"])) {
        $name_parts = explode(" ", trim($posted_data["billing_first_name"]));
        if (count($name_parts) > 1) {
            $first = array_shift($name_parts);
            $last  = implode(" ", $name_parts);
        } else {
            $first = $posted_data["billing_first_name"];
            $last  = "";
        }
        update_user_meta($user_id, "billing_first_name", sanitize_text_field($first));
        update_user_meta($user_id, "billing_last_name", sanitize_text_field($last));
        update_user_meta($user_id, "first_name", sanitize_text_field($first));
        update_user_meta($user_id, "last_name", sanitize_text_field($last));
    }

    if (!empty($posted_data["billing_phone"])) {
        update_user_meta($user_id, "billing_phone", sanitize_text_field($posted_data["billing_phone"]));
    }

    if (!empty($posted_data["billing_address_1"])) {
        update_user_meta($user_id, "billing_address_1", sanitize_text_field($posted_data["billing_address_1"]));
        update_user_meta($user_id, "shipping_address_1", sanitize_text_field($posted_data["billing_address_1"]));
    }

    update_user_meta($user_id, "billing_country", "VN");
    update_user_meta($user_id, "shipping_country", "VN");
}
