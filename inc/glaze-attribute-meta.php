<?php
/**
 * WooCommerce Glaze Attribute Custom Meta (Màu sắc & Ảnh đại diện mẫu men)
 * 
 * Cho phép quản trị viên cấu hình mã màu đại diện (HEX) và ảnh mẫu men
 * trực tiếp trong WordPress Admin -> Sản phẩm -> Các thuộc tính -> Màu sắc (pa_mau-sac).
 * Dữ liệu này tự động đồng bộ sang tất cả các trang: Trang sản phẩm, Trang chi tiết, Trang màu men.
 *
 * @package Gomie
 */

defined('ABSPATH') || exit;

class Gomie_Glaze_Attribute_Meta {

    /**
     * Danh sách taxonomy thuộc tính màu men được hỗ trợ
     */
    private static $taxonomies = array('pa_mau-sac', 'pa_sac-men', 'pa_mau-men', 'pa_color');

    public static function init() {
        foreach (self::$taxonomies as $taxonomy) {
            // Form thêm mới term
            add_action("{$taxonomy}_add_form_fields", array(__CLASS__, 'add_form_fields'), 10, 1);
            // Form chỉnh sửa term
            add_action("{$taxonomy}_edit_form_fields", array(__CLASS__, 'edit_form_fields'), 10, 2);
            // Hook lưu dữ liệu
            add_action("created_{$taxonomy}", array(__CLASS__, 'save_term_fields'), 10, 2);
            add_action("edited_{$taxonomy}", array(__CLASS__, 'save_term_fields'), 10, 2);
            // Cột quản lý trong bảng admin
            add_filter("manage_edit-{$taxonomy}_columns", array(__CLASS__, 'add_columns'));
            add_filter("manage_{$taxonomy}_custom_column", array(__CLASS__, 'render_column_content'), 10, 3);
        }

        // Enqueue media uploader & color picker trong trang quản lý thuộc tính
        add_action('admin_enqueue_scripts', array(__CLASS__, 'admin_scripts'));

        // Khởi tạo giá trị mặc định nếu term chưa có meta
        add_action('admin_init', array(__CLASS__, 'init_default_term_meta'));
    }

    /**
     * Enqueue script & style cho admin
     */
    public static function admin_scripts($hook) {
        if (!in_array($hook, array('edit-tags.php', 'term.php'))) {
            return;
        }
        $screen = get_current_screen();
        if (!$screen || !in_array($screen->taxonomy, self::$taxonomies)) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        // Inline JS xử lý Color Picker & Media Modal
        add_action('admin_footer', array(__CLASS__, 'render_admin_inline_js'));
    }

    /**
     * Form thêm mới term
     */
    public static function add_form_fields($taxonomy) {
        ?>
        <div class="form-field term-glaze-color-wrap">
            <label for="glaze_color"><?php esc_html_e('Mã màu đại diện (HEX)', 'gomie'); ?></label>
            <input type="text" name="glaze_color" id="glaze_color" class="gomie-color-picker" value="#e0592a" data-default-color="#e0592a" />
            <p><?php esc_html_e('Chọn mã màu đặc trưng của sắc men này để hiển thị trên thanh lọc và swatch chấm màu.', 'gomie'); ?></p>
        </div>

        <div class="form-field term-glaze-image-wrap">
            <label><?php esc_html_e('Ảnh đại diện mẫu men gốm', 'gomie'); ?></label>
            <div id="glaze_image_preview" style="margin-bottom: 10px;">
                <img src="" style="max-width: 90px; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; display: none;" />
            </div>
            <input type="hidden" name="glaze_image_id" id="glaze_image_id" value="" />
            <button type="button" class="button gomie-upload-image-btn" data-target="#glaze_image_id" data-preview="#glaze_image_preview img">
                <i class="dashicons dashicons-upload" style="margin-top: 4px;"></i> <?php esc_html_e('Tải lên / Chọn ảnh mẫu men', 'gomie'); ?>
            </button>
            <button type="button" class="button gomie-remove-image-btn" style="display: none;">
                <?php esc_html_e('Xóa ảnh', 'gomie'); ?>
            </button>
            <p><?php esc_html_e('Ảnh mẫu men (gốm cận cảnh, hoa văn hoặc hỏa biến) để hiển thị đồng bộ trên toàn website.', 'gomie'); ?></p>
        </div>
        <?php
    }

    /**
     * Form chỉnh sửa term
     */
    public static function edit_form_fields($term, $taxonomy) {
        $color = get_term_meta($term->term_id, 'glaze_color', true);
        if (empty($color)) {
            $color = self::get_fallback_color($term->slug);
        }

        $image_id = get_term_meta($term->term_id, 'glaze_image_id', true);
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
        if (empty($image_url)) {
            $image_url = get_term_meta($term->term_id, 'glaze_image_url', true);
        }
        ?>
        <tr class="form-field term-glaze-color-wrap">
            <th scope="row"><label for="glaze_color"><?php esc_html_e('Mã màu đại diện (HEX)', 'gomie'); ?></label></th>
            <td>
                <input type="text" name="glaze_color" id="glaze_color" class="gomie-color-picker" value="<?php echo esc_attr($color); ?>" data-default-color="<?php echo esc_attr($color); ?>" />
                <p class="description"><?php esc_html_e('Chọn mã màu đặc trưng của sắc men này để hiển thị trên thanh lọc và swatch chấm màu.', 'gomie'); ?></p>
            </td>
        </tr>

        <tr class="form-field term-glaze-image-wrap">
            <th scope="row"><label><?php esc_html_e('Ảnh đại diện mẫu men gốm', 'gomie'); ?></label></th>
            <td>
                <div id="glaze_image_preview" style="margin-bottom: 10px;">
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd; <?php echo empty($image_url) ? 'display: none;' : ''; ?>" />
                </div>
                <input type="hidden" name="glaze_image_id" id="glaze_image_id" value="<?php echo esc_attr($image_id); ?>" />
                <button type="button" class="button gomie-upload-image-btn" data-target="#glaze_image_id" data-preview="#glaze_image_preview img">
                    <i class="dashicons dashicons-upload" style="margin-top: 4px;"></i> <?php esc_html_e('Tải lên / Chọn ảnh mẫu men', 'gomie'); ?>
                </button>
                <button type="button" class="button gomie-remove-image-btn" style="<?php echo empty($image_url) ? 'display: none;' : ''; ?>">
                    <?php esc_html_e('Xóa ảnh', 'gomie'); ?>
                </button>
                <p class="description"><?php esc_html_e('Ảnh mẫu men (gốm cận cảnh, hoa văn hoặc hỏa biến) để hiển thị đồng bộ trên toàn website.', 'gomie'); ?></p>
            </td>
        </tr>
        <?php
    }

    /**
     * Lưu term meta
     */
    public static function save_term_fields($term_id, $tt_id) {
        if (isset($_POST['glaze_color'])) {
            $color = sanitize_hex_color($_POST['glaze_color']);
            if ($color) {
                update_term_meta($term_id, 'glaze_color', $color);
            }
        }

        if (isset($_POST['glaze_image_id'])) {
            $img_id = absint($_POST['glaze_image_id']);
            if ($img_id > 0) {
                update_term_meta($term_id, 'glaze_image_id', $img_id);
                $url = wp_get_attachment_image_url($img_id, 'full');
                if ($url) {
                    update_term_meta($term_id, 'glaze_image_url', $url);
                }
            } else {
                delete_term_meta($term_id, 'glaze_image_id');
                delete_term_meta($term_id, 'glaze_image_url');
            }
        }
    }

    /**
     * Thêm cột vào bảng danh sách term trong admin
     */
    public static function add_columns($columns) {
        $new_columns = array();
        foreach ($columns as $key => $title) {
            $new_columns[$key] = $title;
            if ($key === 'name') {
                $new_columns['glaze_swatch'] = __('Màu sắc', 'gomie');
                $new_columns['glaze_thumbnail'] = __('Ảnh mẫu men', 'gomie');
            }
        }
        return $new_columns;
    }

    /**
     * Render nội dung cột custom
     */
    public static function render_column_content($content, $column_name, $term_id) {
        if ($column_name === 'glaze_swatch') {
            $term = get_term($term_id);
            $color = get_term_meta($term_id, 'glaze_color', true);
            if (empty($color) && $term) {
                $color = self::get_fallback_color($term->slug);
            }
            if ($color) {
                return '<div style="display: flex; align-items: center; gap: 8px;">
                            <span style="display: inline-block; width: 22px; height: 22px; border-radius: 50%; background-color: ' . esc_attr($color) . '; border: 1px solid rgba(0,0,0,0.15); box-shadow: 0 1px 3px rgba(0,0,0,0.1);"></span>
                            <code style="font-size: 11px;">' . esc_html($color) . '</code>
                        </div>';
            }
        }

        if ($column_name === 'glaze_thumbnail') {
            $img_id = get_term_meta($term_id, 'glaze_image_id', true);
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'thumbnail') : get_term_meta($term_id, 'glaze_image_url', true);
            if ($img_url) {
                return '<img src="' . esc_url($img_url) . '" style="width: 36px; height: 36px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;" />';
            } else {
                return '<span style="color: #999; font-size: 12px;">—</span>';
            }
        }

        return $content;
    }

    /**
     * Render inline JavaScript cho Admin Media & Color Picker
     */
    public static function render_admin_inline_js() {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Khởi tạo WP Color Picker
            if ($.fn.wpColorPicker) {
                $('.gomie-color-picker').wpColorPicker();
            }

            // Xử lý nút Upload ảnh mẫu men
            var mediaFrame;
            $(document).on('click', '.gomie-upload-image-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                var targetInput = $(btn.data('target'));
                var previewImg = $(btn.data('preview'));
                var removeBtn = btn.siblings('.gomie-remove-image-btn');

                if (mediaFrame) {
                    mediaFrame.open();
                    return;
                }

                mediaFrame = wp.media({
                    title: 'Chọn ảnh mẫu men gốm Bát Tràng',
                    button: { text: 'Sử dụng ảnh này' },
                    multiple: false
                });

                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    targetInput.val(attachment.id);
                    var imgUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    previewImg.attr('src', imgUrl).show();
                    removeBtn.show();
                });

                mediaFrame.open();
            });

            // Xử lý nút xóa ảnh mẫu men
            $(document).on('click', '.gomie-remove-image-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                btn.siblings('input[type="hidden"]').val('');
                btn.siblings('#glaze_image_preview').find('img').attr('src', '').hide();
                btn.hide();
            });
        });
        </script>
        <?php
    }

    /**
     * Fallback màu sắc chuẩn Gomie Ceramic theo slug
     */
    public static function get_fallback_color($slug) {
        $slug = sanitize_title(str_replace('men-', '', $slug));
        $palette = array(
            'thien-thanh'     => '#60a5fa',
            'xanh-thien-thanh'=> '#60a5fa',
            'canh-gian'       => '#7c2d12',
            'sapphire'        => '#1a365d',
            'xanh-song-bien'  => '#0284c7',
            'song-bien'       => '#0284c7',
            'hoa-bien'        => '#0284c7',
            'gam-vang'        => '#d97706',
            'reu'             => '#4d7c0f',
            'nau-tuyet'       => '#78350f',
            'xanh-ngoc'       => '#0d9488',
            'ngoc-trai'       => '#0d9488',
            'hong-tuyet'      => '#db2777',
            'doc-ban'         => '#e0592a',
            'men-doc-ban'     => '#e0592a',
            'ran'             => '#b45309',
            'lam'             => '#1d4ed8',
            'tro'             => '#64748b',
        );

        return $palette[$slug] ?? '#c2410c';
    }

    /**
     * Khởi tạo giá trị mặc định cho các term nếu chưa có meta
     */
    public static function init_default_term_meta() {
        if (get_option('gomie_glaze_meta_initialized_v1')) {
            return;
        }

        foreach (self::$taxonomies as $tax) {
            if (!taxonomy_exists($tax)) continue;
            $terms = get_terms(array('taxonomy' => $tax, 'hide_empty' => false));
            if (!is_wp_error($terms) && !empty($terms)) {
                foreach ($terms as $t) {
                    $color = get_term_meta($t->term_id, 'glaze_color', true);
                    if (empty($color)) {
                        $fallback = self::get_fallback_color($t->slug);
                        update_term_meta($t->term_id, 'glaze_color', $fallback);
                    }
                }
            }
        }

        update_option('gomie_glaze_meta_initialized_v1', 1);
    }
}

// Khởi chạy
Gomie_Glaze_Attribute_Meta::init();
