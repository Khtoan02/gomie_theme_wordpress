<?php
/**
 * Custom Taxonomies - GOMIE Theme
 * Only essential taxonomies for ceramic business
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Taxonomies
 */
function gomie_register_taxonomies() {
    // Không tạo custom taxonomies vì sẽ sử dụng WooCommerce product categories
    // Chỉ giữ lại WordPress default categories và tags
}

// Vô hiệu hóa tất cả custom taxonomies đã tạo trước đó
function gomie_disable_custom_taxonomies() {
    // Unregister taxonomies if they exist
    if (taxonomy_exists('danh-muc-san-pham')) {
        unregister_taxonomy('danh-muc-san-pham');
    }
    if (taxonomy_exists('thuong-hieu')) {
        unregister_taxonomy('thuong-hieu');
    }
    if (taxonomy_exists('loai-du-an')) {
        unregister_taxonomy('loai-du-an');
    }
    if (taxonomy_exists('nganh-giai-phap')) {
        unregister_taxonomy('nganh-giai-phap');
    }
    if (taxonomy_exists('vi-tri-tuyen-dung')) {
        unregister_taxonomy('vi-tri-tuyen-dung');
    }
    if (taxonomy_exists('dia-diem-lam-viec')) {
        unregister_taxonomy('dia-diem-lam-viec');
    }
}

// Chạy khi theme được kích hoạt
add_action('init', 'gomie_disable_custom_taxonomies', 20);