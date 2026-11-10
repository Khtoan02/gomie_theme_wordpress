<?php
/**
 * TD Classic Performance & UX Optimization Core (Zero-Plugin Architecture)
 * Tối ưu Core Web Vitals (LCP, CLS, INP), Transient DB Cache, Defer JS, Debloat WooCommerce.
 *
 * @package Gomie
 * @author TD Classic Architecture
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Tối ưu bộ nhớ PHP
if (!defined('WP_MEMORY_LIMIT')) {
    define('WP_MEMORY_LIMIT', '256M');
}

// 2. Tạo robots.txt vật lý tĩnh để chống timeout khi Google Lighthouse / PageSpeed quét
function gomie_opt_ensure_static_robots_txt() {
    $robots_file = ABSPATH . 'robots.txt';
    if (!file_exists($robots_file) || filesize($robots_file) < 20) {
        $content = "User-agent: *\nDisallow: /wp-admin/\nAllow: /wp-admin/admin-ajax.php\nDisallow: /*?add-to-cart=\nSitemap: " . esc_url(home_url('/sitemap_index.xml')) . "\n";
        @file_put_contents($robots_file, $content);
    }
}
add_action('init', 'gomie_opt_ensure_static_robots_txt');

// 3. Dọn rác WP Head (Emojis, WP-Embed)
function gomie_opt_cleanup_wp_head() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    if (!is_admin()) {
        wp_deregister_script('wp-embed');
    }
}
add_action('init', 'gomie_opt_cleanup_wp_head');

// 4. Tắt Speculative Loading của WP Core (Tránh lãng phí tài nguyên PHP Worker)
add_filter('wp_speculation_rules_configuration', '__return_null');

// 5. Preload LCP Images ở <head> (Bảo đảm LCP < 1.2s)
function gomie_opt_preload_lcp_images() {
    // DNS-prefetch & preconnect cho Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    if (is_front_page()) {
        // Preload logo hoặc ảnh hero lớn
        $hero_bg = get_template_directory_uri() . '/assets/images/glazes/Background-1.png';
        echo '<link rel="preload" href="' . esc_url($hero_bg) . '" as="image" fetchpriority="high">' . "\n";
    } elseif (is_singular('product') || is_singular('post')) {
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if ($thumbnail_url) {
            echo '<link rel="preload" href="' . esc_url($thumbnail_url) . '" as="image" fetchpriority="high">' . "\n";
        }
    }
}
add_action('wp_head', 'gomie_opt_preload_lcp_images', 1);

// 6. Gán defer cho Javascript không thiết yếu (Tối ưu INP / TBT < 50ms)
add_filter('script_loader_tag', function ($tag, $handle, $src) {
    if (is_admin()) return $tag;

    // Danh sách scripts cần defer để không chặn dựng hình
    $defer_scripts = array(
        'font-awesome',
        'bootstrap',
        'gomie-main',
        'gomie-page-transitions',
        'gomie-shop-page',
        'gomie-cart-page',
        'gomie-checkout-page',
        'gomie-video-player',
        'aos',
        'swiper',
        'lucide-icons'
    );

    if ((in_array($handle, $defer_scripts, true) || strpos($src, 'googletagmanager.com') !== false) && strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    return $tag;
}, 10, 3);

// 7. Tải CSS ngoài không chặn render (Non-render-blocking CSS cho font và icon)
add_filter('style_loader_tag', function ($html, $handle, $href, $media) {
    if (is_admin()) return $html;

    $non_blocking_styles = array('font-awesome', 'gomie-google-fonts');

    if (in_array($handle, $non_blocking_styles, true)) {
        return '<link rel="stylesheet" id="' . esc_attr($handle) . '-css" href="' . esc_url($href) . '" media="print" onload="this.media=\'all\'">' . "\n" .
               '<noscript><link rel="stylesheet" id="' . esc_attr($handle) . '-noscript-css" href="' . esc_url($href) . '"></noscript>' . "\n";
    }
    return $html;
}, 10, 4);

// 8. WooCommerce Debloater - Chỉ tải scripts/styles khi vào trang bán hàng
add_action('wp_enqueue_scripts', function () {
    if (function_exists('is_woocommerce')) {
        // Luôn gỡ bỏ blocks style và layout mặc định thừa thãi
        wp_dequeue_style('wc-blocks-style');
        wp_deregister_style('wc-blocks-style');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');

        // Trên các trang nội dung không phải WooCommerce (Trang chủ, Tin tức, Giới thiệu, v.v.)
        if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_singular('product') && !is_page_template('page-san-pham.php') && !is_page('san-pham')) {
            wp_dequeue_style('woocommerce-general');
            wp_dequeue_script('wc-add-to-cart');
            wp_dequeue_script('wc-cart-fragments');
            wp_dequeue_script('woocommerce');
            wp_dequeue_script('wc-jquery-blockui');
            wp_dequeue_script('wc-js-cookie');
            wp_dequeue_script('sourcebuster-js');
            wp_dequeue_script('wc-order-attribution');
        }
    }
}, 9999);

// 9. Caching Headers cho LiteSpeed & Edge CDN (Server Level)
function gomie_opt_enable_server_cache_headers() {
    if (is_admin() || is_user_logged_in()) return;
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET') return;
    if (function_exists('is_cart') && is_cart()) return;
    if (function_exists('is_checkout') && is_checkout()) return;

    if (!headers_sent()) {
        header('X-LiteSpeed-Cache-Control: public, max-age=86400');
        header('Cache-Control: public, max-age=3600, stale-while-revalidate=86400');
    }
}
add_action('send_headers', 'gomie_opt_enable_server_cache_headers', 1);

function gomie_opt_purge_server_cache() {
    if (!headers_sent()) {
        header('X-LiteSpeed-Purge: *');
    }
}
add_action('save_post', 'gomie_opt_purge_server_cache');
add_action('edit_terms', 'gomie_opt_purge_server_cache');

// 10. Transient DB Query Cache cho danh mục & sản phẩm
function gomie_get_cached_products($category_slug = '', $limit = 8) {
    $cache_key = 'gomie_prods_' . sanitize_key($category_slug) . '_' . intval($limit);
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $args = array(
        'post_type'              => 'product',
        'posts_per_page'         => $limit,
        'post_status'            => 'publish',
        'no_found_rows'          => true, // Bỏ đếm tổng số dòng để tối ưu SQL
        'update_post_meta_cache' => true,
        'update_post_term_cache' => false,
    );

    if (!empty($category_slug)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        );
    }

    $query = new WP_Query($args);
    $results = $query->posts;
    set_transient($cache_key, $results, DAY_IN_SECONDS);
    return $results;
}

function gomie_clear_all_transients() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_gomie_%' OR option_name LIKE '_transient_timeout_gomie_%'");
}
add_action('save_post_product', 'gomie_clear_all_transients');
add_action('edited_product_cat', 'gomie_clear_all_transients');
