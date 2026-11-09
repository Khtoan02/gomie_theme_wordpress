<?php
/**
 * Custom Post Types - GOMIE Theme
 * Only essential post types for ceramic business
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Types
 */
function gomie_register_post_types() {
    
    // Chỉ giữ lại Blog Posts (mặc định của WordPress)
    // Không tạo custom post types cho sản phẩm vì sẽ sử dụng WooCommerce
    
    // Flush rewrite rules on theme activation
    if (get_option('gomie_theme_activated')) {
        flush_rewrite_rules();
        delete_option('gomie_theme_activated');
    }
}

// Set flag on theme activation
add_action('after_switch_theme', function() {
    add_option('gomie_theme_activated', true);
});

// Vô hiệu hóa tất cả custom post types đã tạo trước đó
function gomie_disable_custom_post_types() {
    // Unregister post types if they exist
    if (post_type_exists('san-pham')) {
        unregister_post_type('san-pham');
    }
    if (post_type_exists('du-an')) {
        unregister_post_type('du-an');
    }
    if (post_type_exists('giai-phap')) {
        unregister_post_type('giai-phap');
    }
    if (post_type_exists('tuyen-dung')) {
        unregister_post_type('tuyen-dung');
    }
}

// Chạy khi theme được kích hoạt
add_action('init', 'gomie_disable_custom_post_types', 20);