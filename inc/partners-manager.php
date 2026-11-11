<?php
/**
 * Partners Manager - GOMIE Theme
 * Đăng ký Custom Post Type và Meta Box quản lý Đối tác chiến lược trong WordPress Admin
 *
 * @package Gomie
 * @author TD Classic Architecture
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Đăng ký Custom Post Type "Đối tác" (gomie_partner)
 */
function gomie_register_partner_cpt() {
    $labels = array(
        'name'                  => _x('Đối tác', 'Post type general name', 'gomie'),
        'singular_name'         => _x('Đối tác', 'Post type singular name', 'gomie'),
        'menu_name'             => _x('Đối tác', 'Admin Menu text', 'gomie'),
        'name_admin_bar'        => _x('Đối tác', 'Add New on Toolbar', 'gomie'),
        'add_new'               => __('Thêm đối tác mới', 'gomie'),
        'add_new_item'          => __('Thêm đối tác mới', 'gomie'),
        'new_item'              => __('Đối tác mới', 'gomie'),
        'edit_item'             => __('Chỉnh sửa đối tác', 'gomie'),
        'view_item'             => __('Xem đối tác', 'gomie'),
        'all_items'             => __('Tất cả đối tác', 'gomie'),
        'search_items'          => __('Tìm kiếm đối tác', 'gomie'),
        'not_found'             => __('Chưa có đối tác nào.', 'gomie'),
        'not_found_in_trash'    => __('Không có đối tác trong thùng rác.', 'gomie'),
        'featured_image'        => __('Logo đối tác', 'gomie'),
        'set_featured_image'    => __('Tải lên logo đối tác', 'gomie'),
        'remove_featured_image' => __('Xóa logo đối tác', 'gomie'),
        'use_featured_image'    => __('Dùng làm logo đối tác', 'gomie'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 26,
        'menu_icon'          => 'dashicons-networking',
        'supports'           => array('title', 'thumbnail', 'page-attributes'),
        'show_in_rest'       => false,
    );

    register_post_type('gomie_partner', $args);
}
add_action('init', 'gomie_register_partner_cpt', 5);

/**
 * 2. Thêm Meta Box cho thông tin bổ sung của Đối tác
 */
function gomie_partner_add_meta_box() {
    add_meta_box(
        'gomie_partner_details',
        __('Thông tin liên kết & hiển thị đối tác', 'gomie'),
        'gomie_partner_render_meta_box',
        'gomie_partner',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gomie_partner_add_meta_box');

/**
 * Render Meta Box Form
 */
function gomie_partner_render_meta_box($post) {
    wp_nonce_field('gomie_partner_save_meta', 'gomie_partner_meta_nonce');

    $website_url = get_post_meta($post->ID, '_gomie_partner_url', true);
    $target      = get_post_meta($post->ID, '_gomie_partner_target', true);
    $text_label  = get_post_meta($post->ID, '_gomie_partner_text', true);
    ?>
    <style>
        .gomie-meta-field { margin-bottom: 16px; }
        .gomie-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; }
        .gomie-meta-field input[type="text"],
        .gomie-meta-field input[type="url"] { width: 100%; max-width: 600px; padding: 8px 12px; }
        .gomie-meta-help { font-size: 13px; color: #64748b; margin-top: 4px; }
    </style>

    <div class="gomie-meta-field">
        <label for="gomie_partner_url"><?php _e('Website / Đường dẫn liên kết (URL):', 'gomie'); ?></label>
        <input type="url" id="gomie_partner_url" name="gomie_partner_url" value="<?php echo esc_attr($website_url); ?>" placeholder="https://example.com">
        <p class="gomie-meta-help"><?php _e('Tùy chọn: Nhập địa chỉ website của đối tác. Khi người dùng nhấp vào logo/tên đối tác sẽ chuyển đến trang này.', 'gomie'); ?></p>
    </div>

    <div class="gomie-meta-field">
        <label>
            <input type="checkbox" name="gomie_partner_target" value="_blank" <?php checked($target, '_blank'); ?>>
            <?php _e('Mở liên kết trong tab mới (target="_blank")', 'gomie'); ?>
        </label>
    </div>

    <div class="gomie-meta-field">
        <label for="gomie_partner_text"><?php _e('Chữ hiển thị thay thế logo (Text brand):', 'gomie'); ?></label>
        <input type="text" id="gomie_partner_text" name="gomie_partner_text" value="<?php echo esc_attr($text_label); ?>" placeholder="VD: LOTTE HOTELS">
        <p class="gomie-meta-help"><?php _e('Nếu bạn KHÔNG tải lên ảnh Logo đối tác (Ảnh đại diện), hệ thống sẽ hiển thị dòng chữ thương hiệu thanh lịch này.', 'gomie'); ?></p>
    </div>
    <?php
}

/**
 * 3. Lưu thông tin Meta Box
 */
function gomie_partner_save_meta_box($post_id) {
    if (!isset($_POST['gomie_partner_meta_nonce']) || !wp_verify_nonce($_POST['gomie_partner_meta_nonce'], 'gomie_partner_save_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['gomie_partner_url'])) {
        update_post_meta($post_id, '_gomie_partner_url', esc_url_raw($_POST['gomie_partner_url']));
    }

    $target = isset($_POST['gomie_partner_target']) ? '_blank' : '_self';
    update_post_meta($post_id, '_gomie_partner_target', $target);

    if (isset($_POST['gomie_partner_text'])) {
        update_post_meta($post_id, '_gomie_partner_text', sanitize_text_field($_POST['gomie_partner_text']));
    }
}
add_action('save_post_gomie_partner', 'gomie_partner_save_meta_box');

/**
 * 4. Cột danh sách Đối tác trong WordPress Admin
 */
function gomie_partner_admin_columns($columns) {
    $new_columns = array(
        'cb'            => $columns['cb'],
        'partner_logo'  => __('Logo đối tác', 'gomie'),
        'title'         => __('Tên đối tác', 'gomie'),
        'partner_url'   => __('Website', 'gomie'),
        'menu_order'    => __('Thứ tự', 'gomie'),
        'date'          => $columns['date'],
    );
    return $new_columns;
}
add_filter('manage_gomie_partner_posts_columns', 'gomie_partner_admin_columns');

/**
 * Nội dung các cột danh sách trong Admin
 */
function gomie_partner_custom_column_content($column, $post_id) {
    switch ($column) {
        case 'partner_logo':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(70, 45), array(
                    'style' => 'max-height: 40px; width: auto; object-fit: contain; border: 1px solid #e2e8f0; border-radius: 6px; padding: 3px; background: #fff;'
                ));
            } else {
                $text = get_post_meta($post_id, '_gomie_partner_text', true) ?: get_the_title($post_id);
                echo '<span style="display:inline-block; font-weight:700; font-size:12px; padding:4px 8px; background:#f1f5f9; border-radius:4px; color:#475569;">' . esc_html($text) . '</span>';
            }
            break;

        case 'partner_url':
            $url = get_post_meta($post_id, '_gomie_partner_url', true);
            if (!empty($url)) {
                echo '<a href="' . esc_url($url) . '" target="_blank" style="text-decoration:none;"><span class="dashicons dashicons-external" style="font-size:16px; vertical-align:middle;"></span> ' . esc_html($url) . '</a>';
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;

        case 'menu_order':
            $post = get_post($post_id);
            echo esc_html($post->menu_order);
            break;
    }
}
add_action('manage_gomie_partner_posts_custom_column', 'gomie_partner_custom_column_content', 10, 2);

/**
 * Cho phép sắp xếp cột Thứ tự trong Admin
 */
function gomie_partner_sortable_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-gomie_partner_sortable_columns', 'gomie_partner_sortable_columns');

/**
 * 5. Tự động khởi tạo (Seed) các đối tác mặc định nếu chưa có
 */
function gomie_seed_default_partners_if_empty() {
    // Chỉ kiểm tra khi có flag hoặc trong trang quản trị/kích hoạt
    if (get_option('gomie_partners_seeded_v1')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'gomie_partner',
        'post_status'    => 'any',
        'posts_per_page' => 1,
    ));

    if (!empty($existing)) {
        update_option('gomie_partners_seeded_v1', 1);
        return;
    }

    update_option('gomie_partners_seeded_v1', 1);

    // Danh sách 6 đối tác mặc định từ thiết kế Gomie Ceramic
    $default_partners = array(
        array(
            'title'      => 'Lotte Hotels & Resorts',
            'text'       => 'LOTTE HOTELS',
            'url'        => 'https://www.lottehotel.com',
            'menu_order' => 1,
        ),
        array(
            'title'      => 'Marriott International',
            'text'       => 'MARRIOTT',
            'url'        => 'https://www.marriott.com',
            'menu_order' => 2,
        ),
        array(
            'title'      => 'Hyatt Regency',
            'text'       => 'HYATT REGENCY',
            'url'        => 'https://www.hyatt.com',
            'menu_order' => 3,
        ),
        array(
            'title'      => 'Golden Gate Restaurant Group',
            'text'       => 'GOLDEN GATE',
            'url'        => 'https://ggg.com.vn',
            'menu_order' => 4,
        ),
        array(
            'title'      => 'InterContinental Hotels & Resorts',
            'text'       => 'INTERCONTINENTAL',
            'url'        => 'https://www.ihg.com',
            'menu_order' => 5,
        ),
        array(
            'title'      => 'Vinpearl Resort & Spa',
            'text'       => 'VINPEARL',
            'url'        => 'https://vinpearl.com',
            'menu_order' => 6,
        ),
    );

    foreach ($default_partners as $partner_data) {
        $post_id = wp_insert_post(array(
            'post_title'   => $partner_data['title'],
            'post_type'    => 'gomie_partner',
            'post_status'  => 'publish',
            'menu_order'   => $partner_data['menu_order'],
        ));

        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_gomie_partner_text', $partner_data['text']);
            update_post_meta($post_id, '_gomie_partner_url', $partner_data['url']);
            update_post_meta($post_id, '_gomie_partner_target', '_blank');
        }
    }

    update_option('gomie_partners_seeded_v1', 1);
}
add_action('init', 'gomie_seed_default_partners_if_empty', 20);

/**
 * 6. Helper Function: Lấy danh sách đối tác để hiển thị ở Frontend
 *
 * @param array $args
 * @return array
 */
function gomie_get_partners($args = array()) {
    $defaults = array(
        'posts_per_page' => -1,
        'post_type'      => 'gomie_partner',
        'post_status'    => 'publish',
        'orderby'        => array('menu_order' => 'ASC', 'date' => 'ASC'),
    );

    $query_args = wp_parse_args($args, $defaults);
    $posts = get_posts($query_args);

    $partners = array();
    if (!empty($posts)) {
        foreach ($posts as $p) {
            $logo_id  = get_post_thumbnail_id($p->ID);
            $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : '';
            $text     = get_post_meta($p->ID, '_gomie_partner_text', true) ?: $p->post_title;
            $url      = get_post_meta($p->ID, '_gomie_partner_url', true);
            $target   = get_post_meta($p->ID, '_gomie_partner_target', true) ?: '_blank';

            $partners[] = array(
                'id'       => $p->ID,
                'title'    => $p->post_title,
                'logo_url' => $logo_url,
                'text'     => $text,
                'url'      => $url,
                'target'   => $target,
            );
        }
    }

    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    // Map logo SVG cho bất kỳ partner nào chưa có ảnh tải lên
    $svg_brand_map = array(
        'lotte'            => 'lotte-hotels.svg',
        'marriott'         => 'marriott.svg',
        'hyatt'            => 'hyatt-regency.svg',
        'golden-gate'      => 'golden-gate.svg',
        'golden'           => 'golden-gate.svg',
        'intercontinental' => 'intercontinental.svg',
        'vinpearl'         => 'vinpearl.svg',
    );

    foreach ($partners as &$partner_item) {
        if (empty($partner_item['logo_url'])) {
            $clean_slug = sanitize_title($partner_item['title'] . ' ' . $partner_item['text']);
            foreach ($svg_brand_map as $key => $filename) {
                if (strpos($clean_slug, $key) !== false && file_exists($theme_dir . '/assets/images/partners/' . $filename)) {
                    $partner_item['logo_url'] = $theme_uri . '/assets/images/partners/' . $filename;
                    break;
                }
            }
        }
    }
    unset($partner_item);

    // Fallback dự phòng nếu chưa có bài post nào trong DB
    if (empty($partners)) {
        $fallbacks = array(
            array('title' => 'Lotte Hotels & Resorts', 'text' => 'LOTTE HOTELS', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/lotte-hotels.svg', 'target' => '_self'),
            array('title' => 'Marriott International', 'text' => 'MARRIOTT', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/marriott.svg', 'target' => '_self'),
            array('title' => 'Hyatt Regency', 'text' => 'HYATT REGENCY', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/hyatt-regency.svg', 'target' => '_self'),
            array('title' => 'Golden Gate Restaurant Group', 'text' => 'GOLDEN GATE', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/golden-gate.svg', 'target' => '_self'),
            array('title' => 'InterContinental Hotels & Resorts', 'text' => 'INTERCONTINENTAL', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/intercontinental.svg', 'target' => '_self'),
            array('title' => 'Vinpearl Resort & Spa', 'text' => 'VINPEARL', 'url' => '', 'logo_url' => $theme_uri . '/assets/images/partners/vinpearl.svg', 'target' => '_self'),
        );
        return $fallbacks;
    }

    return $partners;
}
