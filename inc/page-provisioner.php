<?php
/**
 * Gomie Auto Page Provisioner & Route Sync
 * Ensures all essential brand templates and pages are active and mapped upon theme activation or push.
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

/**
 * Auto-provision all core Gomie pages with correct templates
 */
function gomie_auto_provision_all_pages() {
    $theme_dir = get_stylesheet_directory();

    $core_pages = array(
        'cau-chuyen' => array(
            'title'    => 'Chuyện của Gomie',
            'template' => 'page-cau-chuyen.php',
        ),
        'san-pham' => array(
            'title'    => 'Sản phẩm',
            'template' => 'page-san-pham.php',
            'is_shop'  => true,
        ),
        'mau-men' => array(
            'title'    => 'Bảng Màu Men Gốm',
            'template' => 'page-mau-men.php',
        ),
        'chia-se' => array(
            'title'    => 'Góc Chia Sẻ',
            'template' => 'page-chia-se.php',
            'is_posts' => true,
        ),
        'contact' => array(
            'title'    => 'Liên Hệ',
            'template' => 'page-contact.php',
        ),
        'lien-he' => array(
            'title'    => 'Liên Hệ',
            'template' => 'page-lien-he.php',
        ),
        'nha-hang' => array(
            'title'    => 'Giải Pháp Gốm Sứ Cho Nhà Hàng & F&B',
            'template' => 'page-nha-hang.php',
        ),
        'khach-san' => array(
            'title'    => 'Giải Pháp Gốm Sứ Cho Khách Sạn & Resort',
            'template' => 'page-khach-san.php',
        ),
        'qua-tang' => array(
            'title'    => 'Quà Tặng Gốm Sứ Doanh Nghiệp',
            'template' => 'page-qua-tang.php',
        ),
        'chung-nhan' => array(
            'title'    => 'Chứng Nhận & Minh Bạch Sản Phẩm',
            'template' => 'page-chung-nhan.php',
        ),
        'huong-dan-su-dung' => array(
            'title'    => 'Hướng Dẫn Sử Dụng & Bảo Quản',
            'template' => 'page-huong-dan-su-dung.php',
        ),
        'loai-san-pham' => array(
            'title'    => 'Phân Loại Sản Phẩm',
            'template' => 'page-loai-san-pham.php',
        ),
        'heart-of-craftsmanship' => array(
            'title'    => 'Heart of Craftsmanship',
            'template' => 'page-heart-of-craftsmanship.php',
        ),
        'policy' => array(
            'title'    => 'Chính Sách Bảo Mật & Điều Khoản Gomie',
            'template' => 'page-policy.php',
        ),
        'chinh-sach-doi-tra' => array(
            'title'    => 'Chính Sách Đổi Trả & Bảo Hành Gốm Sứ',
            'template' => 'page-chinh-sach-doi-tra.php',
        ),
        'chinh-sach-thanh-toan' => array(
            'title'    => 'Chính Sách Thanh Toán & Hóa Đơn',
            'template' => 'page-chinh-sach-thanh-toan.php',
        ),
        'gio-hang' => array(
            'title'    => 'Giỏ Hàng',
            'template' => 'page-gio-hang.php',
            'is_cart'  => true,
        ),
        'thanh-toan' => array(
            'title'       => 'Thanh Toán',
            'template'    => 'page-thanh-toan.php',
            'is_checkout' => true,
        ),
        'bao-gia' => array(
            'title'    => 'Báo Giá Dự Án & Quà Tặng Doanh Nghiệp',
            'template' => 'page-bao-gia.php',
        ),
    );

    foreach ($core_pages as $slug => $data) {
        $page = get_page_by_path($slug);
        $page_id = 0;

        if (!$page) {
            // Create page if it does not exist
            $page_id = wp_insert_post(array(
                'post_title'     => $data['title'],
                'post_name'      => $slug,
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            ));
        } else {
            $page_id = $page->ID;
        }

        if ($page_id && !is_wp_error($page_id)) {
            // Assign custom template
            if (!empty($data['template']) && file_exists($theme_dir . '/' . $data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $data['template']);
            }

            // Sync WooCommerce core pages
            if (!empty($data['is_shop'])) {
                update_option('woocommerce_shop_page_id', $page_id);
            }
            if (!empty($data['is_cart'])) {
                update_option('woocommerce_cart_page_id', $page_id);
            }
            if (!empty($data['is_checkout'])) {
                update_option('woocommerce_checkout_page_id', $page_id);
            }
            if (!empty($data['is_posts'])) {
                update_option('page_for_posts', $page_id);
            }
        }
    }

    // Set Front Page if not configured
    $front_page = get_page_by_path('trang-chu');
    if (!$front_page) {
        // try finding any page titled Trang chủ
        $home_query = get_posts(array(
            'post_type'   => 'page',
            'title'       => 'Trang chủ',
            'numberposts' => 1,
        ));
        if (!empty($home_query)) {
            $front_page = $home_query[0];
        }
    }
    if ($front_page) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front_page->ID);
    }
}

// Hook into theme activation
add_action('after_switch_theme', 'gomie_auto_provision_all_pages');

// Self-healing check: runs once if flag is not set
add_action('admin_init', function() {
    if (!get_option('gomie_pages_provisioned_v2')) {
        gomie_auto_provision_all_pages();
        update_option('gomie_pages_provisioned_v2', 1);
    }
});

/**
 * Handle AJAX contact & quote submissions
 */
function gomie_handle_contact_form_ajax() {
    $nonce = isset($_POST['contact_nonce']) ? sanitize_text_field($_POST['contact_nonce']) : '';
    if (!wp_verify_nonce($nonce, 'gomie_contact_nonce')) {
        // Fallback check for basic protection
        if (!isset($_POST['name']) || !isset($_POST['phone'])) {
            wp_send_json_error('Yêu cầu không hợp lệ.');
        }
    }

    $name     = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $phone    = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $email    = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $company  = isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '';
    $type     = isset($_POST['interest_type']) ? sanitize_text_field($_POST['interest_type']) : '';
    $product  = isset($_POST['product']) ? sanitize_text_field($_POST['product']) : '';
    if (!empty($product)) {
        $type = !empty($type) ? "{$type} - [Sản phẩm/Men: {$product}]" : "Sản phẩm/Men: {$product}";
    }
    $quantity = isset($_POST['quantity_range']) ? sanitize_text_field($_POST['quantity_range']) : '';
    $message  = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

    if (empty($name) || empty($phone)) {
        wp_send_json_error('Vui lòng điền họ tên và số điện thoại.');
    }

    // Save lead record into WordPress options or custom transient
    $leads = get_option('gomie_customer_inquiries', array());
    if (!is_array($leads)) $leads = array();

    $new_lead = array(
        'name'       => $name,
        'phone'      => $phone,
        'email'      => $email,
        'company'    => $company,
        'type'       => $type,
        'quantity'   => $quantity,
        'message'    => $message,
        'created_at' => current_time('mysql'),
        'ip'         => isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '',
    );
    array_unshift($leads, $new_lead);
    // Keep last 100 leads
    if (count($leads) > 100) {
        $leads = array_slice($leads, 0, 100);
    }
    update_option('gomie_customer_inquiries', $leads);

    // Send email alert to admin
    $admin_email = get_option('admin_email');
    $subject = '[Gomie Ceramic] Yêu cầu tư vấn mới từ: ' . $name;
    $body = "Bạn vừa nhận được yêu cầu liên hệ mới:\n\n"
          . "Họ tên: {$name}\n"
          . "Điện thoại: {$phone}\n"
          . "Email: {$email}\n"
          . "Công ty / Đơn vị: {$company}\n"
          . "Lĩnh vực quan tâm: {$type}\n"
          . "Số lượng: {$quantity}\n"
          . "Nội dung: {$message}\n\n"
          . "Thời gian: " . current_time('d/m/Y H:i');
    
    @wp_mail($admin_email, $subject, $body);

    wp_send_json_success('Yêu cầu của bạn đã được gửi thành công!');
}
add_action('wp_ajax_gomie_contact_form', 'gomie_handle_contact_form_ajax');
add_action('wp_ajax_nopriv_gomie_contact_form', 'gomie_handle_contact_form_ajax');
