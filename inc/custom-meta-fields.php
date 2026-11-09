<?php
/**
 * Custom Meta Fields
 *
 * @package Gomie
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes for products
 */
function gomie_add_product_meta_boxes() {
    add_meta_box(
        'product_details',
        'Thông tin sản phẩm',
        'gomie_product_details_callback',
        'san-pham',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gomie_add_product_meta_boxes');

/**
 * Product details meta box callback
 */
function gomie_product_details_callback($post) {
    wp_nonce_field('gomie_save_product_meta', 'gomie_product_meta_nonce');
    
    $product_price = get_post_meta($post->ID, '_product_price', true);
    $product_old_price = get_post_meta($post->ID, '_product_old_price', true);
    $product_sku = get_post_meta($post->ID, '_product_sku', true);
    $product_brand = get_post_meta($post->ID, '_product_brand', true);
    $product_model = get_post_meta($post->ID, '_product_model', true);
    $product_warranty = get_post_meta($post->ID, '_product_warranty', true);
    $product_power = get_post_meta($post->ID, '_product_power', true);
    $product_resolution = get_post_meta($post->ID, '_product_resolution', true);
    $product_size = get_post_meta($post->ID, '_product_size', true);
    $product_color = get_post_meta($post->ID, '_product_color', true);
    $product_material = get_post_meta($post->ID, '_product_material', true);
    $product_rating = get_post_meta($post->ID, '_product_rating', true);
    $product_featured = get_post_meta($post->ID, '_product_featured', true);
    $product_badge = get_post_meta($post->ID, '_product_badge', true);
    $product_specs = get_post_meta($post->ID, '_product_specs', true);
    $product_features = get_post_meta($post->ID, '_product_features', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="product_price">Giá hiện tại</label>
            </th>
            <td>
                <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>" class="regular-text" placeholder="VD: 2,500,000 VNĐ" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_old_price">Giá cũ</label>
            </th>
            <td>
                <input type="text" id="product_old_price" name="product_old_price" value="<?php echo esc_attr($product_old_price); ?>" class="regular-text" placeholder="VD: 3,000,000 VNĐ" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_sku">Mã sản phẩm (SKU)</label>
            </th>
            <td>
                <input type="text" id="product_sku" name="product_sku" value="<?php echo esc_attr($product_sku); ?>" class="regular-text" placeholder="VD: GM-001" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_brand">Thương hiệu</label>
            </th>
            <td>
                <input type="text" id="product_brand" name="product_brand" value="<?php echo esc_attr($product_brand); ?>" class="regular-text" placeholder="VD: Gomie Ceramic" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_model">Model</label>
            </th>
            <td>
                <input type="text" id="product_model" name="product_model" value="<?php echo esc_attr($product_model); ?>" class="regular-text" placeholder="VD: GM-2024" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_warranty">Bảo hành</label>
            </th>
            <td>
                <input type="text" id="product_warranty" name="product_warranty" value="<?php echo esc_attr($product_warranty); ?>" class="regular-text" placeholder="VD: 3 năm" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_power">Công suất</label>
            </th>
            <td>
                <input type="text" id="product_power" name="product_power" value="<?php echo esc_attr($product_power); ?>" class="regular-text" placeholder="VD: 100W" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_resolution">Độ phân giải</label>
            </th>
            <td>
                <input type="text" id="product_resolution" name="product_resolution" value="<?php echo esc_attr($product_resolution); ?>" class="regular-text" placeholder="VD: 1920x1080" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_size">Kích thước</label>
            </th>
            <td>
                <input type="text" id="product_size" name="product_size" value="<?php echo esc_attr($product_size); ?>" class="regular-text" placeholder="VD: 55 inch" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_color">Màu sắc</label>
            </th>
            <td>
                <input type="text" id="product_color" name="product_color" value="<?php echo esc_attr($product_color); ?>" class="regular-text" placeholder="VD: Đen, Trắng" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_material">Chất liệu</label>
            </th>
            <td>
                <input type="text" id="product_material" name="product_material" value="<?php echo esc_attr($product_material); ?>" class="regular-text" placeholder="VD: Nhôm, Thép" />
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_rating">Đánh giá (1-5)</label>
            </th>
            <td>
                <select id="product_rating" name="product_rating">
                    <option value="">Chọn đánh giá</option>
                    <option value="1" <?php selected($product_rating, '1'); ?>>1 sao</option>
                    <option value="2" <?php selected($product_rating, '2'); ?>>2 sao</option>
                    <option value="3" <?php selected($product_rating, '3'); ?>>3 sao</option>
                    <option value="4" <?php selected($product_rating, '4'); ?>>4 sao</option>
                    <option value="5" <?php selected($product_rating, '5'); ?>>5 sao</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_featured">Sản phẩm nổi bật</label>
            </th>
            <td>
                <input type="checkbox" id="product_featured" name="product_featured" value="yes" <?php checked($product_featured, 'yes'); ?> />
                <label for="product_featured">Hiển thị trên trang chủ</label>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_badge">Badge</label>
            </th>
            <td>
                <select id="product_badge" name="product_badge">
                    <option value="">Không có</option>
                    <option value="hot" <?php selected($product_badge, 'hot'); ?>>Bán chạy</option>
                    <option value="new" <?php selected($product_badge, 'new'); ?>>Mới</option>
                    <option value="sale" <?php selected($product_badge, 'sale'); ?>>Giảm giá</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_specs">Thông số kỹ thuật</label>
            </th>
            <td>
                <textarea id="product_specs" name="product_specs" rows="5" class="large-text" placeholder="Nhập thông số kỹ thuật chi tiết..."><?php echo esc_textarea($product_specs); ?></textarea>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="product_features">Tính năng nổi bật</label>
            </th>
            <td>
                <textarea id="product_features" name="product_features" rows="5" class="large-text" placeholder="Nhập các tính năng nổi bật, mỗi tính năng một dòng..."><?php echo esc_textarea($product_features); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save product meta data
 */
function gomie_save_product_meta($post_id) {
    // Check nonce
    if (!isset($_POST['gomie_product_meta_nonce']) || !wp_verify_nonce($_POST['gomie_product_meta_nonce'], 'gomie_save_product_meta')) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save meta fields
    $meta_fields = array(
        'product_price',
        'product_old_price',
        'product_sku',
        'product_brand',
        'product_model',
        'product_warranty',
        'product_power',
        'product_resolution',
        'product_size',
        'product_color',
        'product_material',
        'product_rating',
        'product_badge',
        'product_specs',
        'product_features'
    );
    
    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Handle checkbox
    $featured = isset($_POST['product_featured']) ? 'yes' : 'no';
    update_post_meta($post_id, '_product_featured', $featured);
}
add_action('save_post', 'gomie_save_product_meta');

/**
 * Helper function to get product meta
 */
function gomie_get_product_meta($post_id, $key, $default = '') {
    $value = get_post_meta($post_id, '_' . $key, true);
    return !empty($value) ? $value : $default;
}

/**
 * Helper function to get product category (legacy CPT)
 */
if (!function_exists('gomie_cpt_get_product_category')) {
    function gomie_cpt_get_product_category($post_id) {
        $terms = get_the_terms($post_id, 'danh-muc-san-pham');
        if ($terms && !is_wp_error($terms)) {
            return $terms[0]->name;
        }
        return '';
    }
}

/**
 * Helper function to get product brand (legacy CPT)
 */
if (!function_exists('gomie_cpt_get_product_brand')) {
    function gomie_cpt_get_product_brand($post_id) {
        $terms = get_the_terms($post_id, 'thuong-hieu');
        if ($terms && !is_wp_error($terms)) {
            return $terms[0]->name;
        }
        return '';
    }
} 