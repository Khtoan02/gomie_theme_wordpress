<?php
/**
 * WooCommerce Sample Data Generator - GOMIE CERAMIC
 *
 * @package Gomie
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create WooCommerce product categories for Gomie Ceramic
 */
function gomie_create_woo_categories() {
    $categories = array(
        'nha-hang' => array(
            'name' => 'Gốm Nhà Hàng',
            'description' => 'Các dòng sản phẩm gốm sứ thủ công cao cấp chuyên dụng cho nhà hàng, quán ăn',
            'slug' => 'nha-hang'
        ),
        'khach-san' => array(
            'name' => 'Gốm Khách Sạn',
            'description' => 'Bộ đồ ăn và vật phẩm trang trí gốm sứ sang trọng cho khách sạn, resort',
            'slug' => 'khach-san'
        ),
        'qua-tang' => array(
            'name' => 'Gốm Quà Tặng',
            'description' => 'Quà tặng doanh nghiệp, quà tặng lưu niệm gốm sứ Bát Tràng in ấn logo theo yêu cầu',
            'slug' => 'qua-tang'
        ),
        'bat-dia' => array(
            'name' => 'Bát Đĩa Bát Tràng',
            'description' => 'Bát, đĩa, âu gốm sứ cao cấp nung nhiệt độ cao an toàn cho sức khỏe',
            'slug' => 'bat-dia'
        ),
        'am-chen' => array(
            'name' => 'Bộ Ấm Chén Trà',
            'description' => 'Bộ ấm chén men lam, men hỏa biến, men ngọc tinh hoa nghệ nhân gốm Việt',
            'slug' => 'am-chen'
        )
    );
    
    foreach ($categories as $slug => $data) {
        if (!term_exists($slug, 'product_cat')) {
            wp_insert_term($data['name'], 'product_cat', array(
                'description' => $data['description'],
                'slug' => $data['slug']
            ));
        }
    }
}

/**
 * Create sample WooCommerce products for Gomie Ceramic
 */
function gomie_create_woo_products() {
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    $sample_products = array(
        array(
            'title' => 'Bát cơm GTT Mèo Xanh Bát Tràng',
            'content' => 'Bát cơm gốm sứ Bát Tràng họa tiết Mèo Xanh vẽ tay tinh xảo, nung ở 1300 độ C khử hoàn toàn tạp chất, an toàn trong lò vi sóng và máy rửa bát.',
            'excerpt' => 'Bát cơm gốm thủ công họa tiết Mèo Xanh sinh động, men bóng mịn bền đẹp.',
            'category' => 'bat-dia',
            'price' => '60000',
            'regular_price' => '75000',
            'sku' => 'GM-BAT-01',
            'badge' => 'hot',
            'featured' => true,
        ),
        array(
            'title' => 'Đĩa chuối men lá biển thủ công',
            'content' => 'Đĩa gốm sứ tạo hình lá chuối độc đáo phủ men lá biển mộc mạc, phù hợp decor bàn ăn gia đình và nhà hàng phong cách truyền thống.',
            'excerpt' => 'Đĩa tạo hình lá chuối nghệ thuật men lá biển tự nhiên.',
            'category' => 'nha-hang',
            'price' => '320000',
            'regular_price' => '360000',
            'sku' => 'GM-DIA-02',
            'badge' => 'new',
            'featured' => true,
        ),
        array(
            'title' => 'Cốc gốm sứ men hỏa biến Gomie',
            'content' => 'Cốc uống nước men hỏa biến nung nhiệt độ cao, mỗi sản phẩm có sắc thái biến ảo riêng biệt độc bản.',
            'excerpt' => 'Cốc gốm men hỏa biến độc bản, cầm chắc tay, giữ nhiệt tốt.',
            'category' => 'qua-tang',
            'price' => '85000',
            'regular_price' => '100000',
            'sku' => 'GM-COC-03',
            'badge' => 'sale',
            'featured' => true,
        ),
        array(
            'title' => 'Bộ bát đĩa gốm hoa cúc Bát Tràng',
            'content' => 'Bộ bàn ăn gia đình 10 món men kem vẽ hoa cúc chàm truyền thống, trọn bộ tô đĩa bát thìa sang trọng.',
            'excerpt' => 'Bộ đồ ăn 10 món men kem vẽ hoa cúc thủ công cho gia đình.',
            'category' => 'bat-dia',
            'price' => '1250000',
            'regular_price' => '1450000',
            'sku' => 'GM-BD-04',
            'badge' => 'hot',
            'featured' => true,
        ),
        array(
            'title' => 'Bộ ấm chén men lam cổ nghệ nhân',
            'content' => 'Bộ ấm pha trà đạo nghệ nhân tạo hình mộc mạc, lưu hương trà tốt, thích hợp làm quà tặng ngoại giao.',
            'excerpt' => 'Bộ ấm chén men lam cổ Bát Tràng nghệ nhân thủ công.',
            'category' => 'am-chen',
            'price' => '850000',
            'regular_price' => '980000',
            'sku' => 'GM-AC-05',
            'badge' => 'hot',
            'featured' => true,
        ),
        array(
            'title' => 'Bình hoa gốm vuốt tay thủ công Gomie',
            'content' => 'Bình cắm hoa men thô mộc phong cách gốm mộc Wabi Sabi, tạo điểm nhấn nghệ thuật cho không gian sống.',
            'excerpt' => 'Bình hoa dáng mộc vuốt tay thủ công trang trí tinh tế.',
            'category' => 'khach-san',
            'price' => '480000',
            'regular_price' => '550000',
            'sku' => 'GM-BG-06',
            'badge' => 'new',
            'featured' => false,
        )
    );
    
    foreach ($sample_products as $product_data) {
        // Check if product already exists
        $existing_products = wc_get_products(array(
            'sku' => $product_data['sku'],
            'limit' => 1
        ));
        
        if (!empty($existing_products)) {
            continue;
        }
        
        // Create product
        $product = new WC_Product_Simple();
        $product->set_name($product_data['title']);
        $product->set_description($product_data['content']);
        $product->set_short_description($product_data['excerpt']);
        $product->set_sku($product_data['sku']);
        $product->set_regular_price($product_data['regular_price']);
        $product->set_sale_price($product_data['price']);
        $product->set_status('publish');
        
        // Set category
        $category_term = get_term_by('slug', $product_data['category'], 'product_cat');
        if ($category_term) {
            $product->set_category_ids(array($category_term->term_id));
        }
        
        // Set featured
        if ($product_data['featured']) {
            $product->set_featured(true);
        }
        
        // Save product
        $product_id = $product->save();
        
        if ($product_id) {
            // Set product badge as meta
            if (!empty($product_data['badge'])) {
                update_post_meta($product_id, '_product_badge', $product_data['badge']);
            }
        }
    }
}

/**
 * Initialize WooCommerce sample data
 */
function gomie_init_woo_sample_data() {
    // Only run once
    if (get_option('gomie_woo_sample_data_created')) {
        return;
    }
    
    gomie_create_woo_categories();
    gomie_create_woo_products();
    
    update_option('gomie_woo_sample_data_created', true);
}

// Run sample data creation on theme activation
add_action('after_switch_theme', 'gomie_init_woo_sample_data');

// Also run when WooCommerce is activated
add_action('woocommerce_activated', 'gomie_init_woo_sample_data');

// Manual trigger for development
if (isset($_GET['create_woo_sample_data']) && current_user_can('manage_options')) {
    add_action('init', 'gomie_init_woo_sample_data');
}
