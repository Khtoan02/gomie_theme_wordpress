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
     * Thông tin hình ảnh mẫu và thông số căn chỉnh quang học tương ứng slug
     */
    public static function get_curated_asset_info($slug) {
        $clean = sanitize_title(str_replace('men-', '', $slug));
        $map = array(
            'sapphire'          => array('img' => 'Gomie-men-saphire.png', 'scale' => '1.05', 'shift_y' => '13px'),
            'canh-gian'         => array('img' => 'Gomie-men-canh-gian.png', 'scale' => '1.086', 'shift_y' => '23px'),
            'gam-vang'          => array('img' => 'Gomie-men-gam-vang.png', 'scale' => '0.98', 'shift_y' => '10.5px'),
            'hoa-bien'          => array('img' => 'Gomie-men-xanh-song-bien.png', 'scale' => '1.01', 'shift_y' => '15px'),
            'song-bien'         => array('img' => 'Gomie-men-xanh-song-bien.png', 'scale' => '1.01', 'shift_y' => '15px'),
            'xanh-song-bien'    => array('img' => 'Gomie-men-xanh-song-bien.png', 'scale' => '1.01', 'shift_y' => '15px'),
            'xanh-hoa-bien'     => array('img' => 'Gomie-men-xanh-song-bien.png', 'scale' => '1.01', 'shift_y' => '15px'),
            'reu'               => array('img' => 'Gomie-men-reu.png', 'scale' => '0.903', 'shift_y' => '-11px'),
            'ngoc-trai'         => array('img' => 'xanh-ngoc-tach-nen-955x800.png', 'scale' => '0.933', 'shift_y' => '2px'),
            'xanh-ngoc'         => array('img' => 'xanh-ngoc-tach-nen-955x800.png', 'scale' => '0.933', 'shift_y' => '2px'),
            'hong-tuyet'        => array('img' => 'Bo-hong-tuyet-mh-955x800.png', 'scale' => '0.915', 'shift_y' => '1px'),
            'nau-tuyet'         => array('img' => 'Gomie-men-nau-tuyet.png', 'scale' => '1.00', 'shift_y' => '15.5px'),
            'thien-thanh'       => array('img' => 'bo-mau-men-955x800.png', 'scale' => '0.916', 'shift_y' => '1.5px'),
            'xanh-thien-thanh'  => array('img' => 'bo-mau-men-955x800.png', 'scale' => '0.916', 'shift_y' => '1.5px'),
        );
        return $map[$clean] ?? array('img' => 'bo-mau-men-955x800.png', 'scale' => '1.0', 'shift_y' => '0px');
    }

    /**
     * Thông tin cốt truyện và miêu tả theo slug
     */
    public static function get_curated_text_info($slug) {
        $clean = sanitize_title(str_replace('men-', '', $slug));
        $map = array(
            'sapphire' => array(
                'storyline' => 'Một khoảng xanh sâu thẳm và kiêu hãnh',
                'desc'      => 'Sapphire mang sắc xanh thẫm đầy cuốn hút, gợi mặt biển khi chiều buông và bầu trời trước giờ lên đèn. Vừa tĩnh tại vừa có cá tính, sắc men đem tới nét sang trọng riêng cho bàn ăn mang tinh thần đương đại.',
            ),
            'canh-gian' => array(
                'storyline' => 'Nét trầm ấm của những điều thân thuộc',
                'desc'      => 'Trong sắc nâu sóng sánh của men Cánh Gián là cảm giác thân quen như gian bếp chiều muộn. Vẻ đẹp mộc mạc, có chiều sâu ấy khiến những món gốm trở nên gần gũi, như đã thuộc về mỗi bữa cơm nhà từ lâu.',
            ),
            'gam-vang' => array(
                'storyline' => 'Ánh vàng nâng niu những cuộc sum vầy',
                'desc'      => 'Gấm Vàng gợi sắc nắng dịu trải trên mặt bàn, vừa rạng rỡ vừa đằm thắm. Sắc men đem lại nét trang nhã cho từng món gốm, để cả bữa ăn thường ngày cũng có chút dư vị của một dịp đặc biệt.',
            ),
            'hoa-bien' => array(
                'storyline' => 'Bản hòa sắc không ngừng biến chuyển',
                'desc'      => 'Xanh Hỏa Biến cuốn hút bởi những lớp xanh chuyển sắc mềm mại, gợi dòng nước luôn đổi thay dưới ánh sáng. Vẻ đẹp ấy không nằm ở sự đồng nhất, mà ở những biến chuyển đầy ngẫu hứng.',
            ),
            'song-bien' => array(
                'storyline' => 'Bản hòa sắc không ngừng biến chuyển',
                'desc'      => 'Xanh Hỏa Biến cuốn hút bởi những lớp xanh chuyển sắc mềm mại, gợi dòng nước luôn đổi thay dưới ánh sáng. Vẻ đẹp ấy không nằm ở sự đồng nhất, mà ở những biến chuyển đầy ngẫu hứng.',
            ),
            'xanh-song-bien' => array(
                'storyline' => 'Bản hòa sắc không ngừng biến chuyển',
                'desc'      => 'Xanh Hỏa Biến cuốn hút bởi những lớp xanh chuyển sắc mềm mại, gợi dòng nước luôn đổi thay dưới ánh sáng. Vẻ đẹp ấy không nằm ở sự đồng nhất, mà ở những biến chuyển đầy ngẫu hứng.',
            ),
            'reu' => array(
                'storyline' => 'Mang bình yên của thiên nhiên vào nhà',
                'desc'      => 'Sắc Rêu như mảng xanh lặng lẽ giữa khu vườn sau mưa, trầm dịu và đầy sức sống. Trên mỗi món gốm, màu men gợi một nhịp sống thư thả, nơi những khoảnh khắc thường nhật cũng đáng để dừng lại.',
            ),
            'ngoc-trai' => array(
                'storyline' => 'Sự thanh khiết trong từng khoảnh khắc',
                'desc'      => 'Ngọc Trai tựa ánh sáng dịu trên bề mặt gốm, trong trẻo mà không lạnh lẽo. Sự tinh giản của sắc men nhường chỗ cho dáng gốm lên tiếng, mang đến vẻ thanh lịch bền lâu cho bàn ăn.',
            ),
            'xanh-ngoc' => array(
                'storyline' => 'Sự thanh khiết trong từng khoảnh khắc',
                'desc'      => 'Ngọc Trai tựa ánh sáng dịu trên bề mặt gốm, trong trẻo mà không lạnh lẽo. Sự tinh giản của sắc men nhường chỗ cho dáng gốm lên tiếng, mang đến vẻ thanh lịch bền lâu cho bàn ăn.',
            ),
            'hong-tuyet' => array(
                'storyline' => 'Dịu dàng như một lời thì thầm',
                'desc'      => 'Hồng Tuyết mang vẻ thanh tao của sắc hồng phớt nhẹ, êm như cánh hoa vừa chạm sương. Không tìm cách nổi bật, màu men tạo nên một nét duyên kín đáo, đủ làm không gian bàn ăn mềm mại.',
            ),
            'nau-tuyet' => array(
                'storyline' => 'Vẻ đẹp lắng lại cùng thời gian',
                'desc'      => 'Nâu Tuyết gợi những gam đất bình yên, nơi màu sắc không phô bày mà lặng lẽ lưu giữ cảm xúc. Có chút trầm mặc, chút ấm áp, sắc men làm nổi bật nét đẹp giản dị và chiều sâu của tác phẩm.',
            ),
            'thien-thanh' => array(
                'storyline' => 'Sắc xanh dịu mát của bầu trời',
                'desc'      => 'Men Xanh Thiên Thanh gợi cảm giác trong trẻo, nhẹ nhàng như sắc trời thanh bình. Gam xanh dịu mát đem đến điểm nhấn tươi sáng cho bàn ăn, đồng thời dễ kết hợp với các sắc men trung tính.',
            ),
            'xanh-thien-thanh' => array(
                'storyline' => 'Sắc xanh dịu mát của bầu trời',
                'desc'      => 'Men Xanh Thiên Thanh gợi cảm giác trong trẻo, nhẹ nhàng như sắc trời thanh bình. Gam xanh dịu mát đem đến điểm nhấn tươi sáng cho bàn ăn, đồng thời dễ kết hợp với các sắc men trung tính.',
            ),
        );
        return $map[$clean] ?? array(
            'storyline' => 'Kiệt tác men nung 1.300°C độc bản Bát Tràng',
            'desc'      => 'Tác phẩm gốm sứ thủ công mang hồn cốt đất và kỹ nghệ nung hỏa biến gia truyền hơn 500 năm, bảo đảm an toàn chuẩn y tế và thẩm mỹ mỹ nghệ đương đại.'
        );
    }

    /**
     * Lấy toàn bộ danh sách màu men ĐỘNG từ hệ thống WooCommerce
     * Đồng bộ trực tiếp từ các thuộc tính màu sắc (pa_mau-sac, pa_sac-men...)
     */
    public static function get_active_glazes() {
        $glazes = array();
        $seen_slugs = array();

        foreach (self::$taxonomies as $tax) {
            if (!taxonomy_exists($tax)) {
                continue;
            }

            $terms = get_terms(array(
                'taxonomy'   => $tax,
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC'
            ));

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            foreach ($terms as $term) {
                $slug = $term->slug;
                $clean_slug = sanitize_title(str_replace('men-', '', $slug));
                if (isset($seen_slugs[$slug]) || isset($seen_slugs[$clean_slug])) {
                    continue;
                }
                $seen_slugs[$slug] = true;
                $seen_slugs[$clean_slug] = true;

                // Color
                $color = get_term_meta($term->term_id, 'glaze_color', true);
                if (empty($color)) {
                    $color = self::get_fallback_color($slug);
                }

                // Image URL
                $img_url = get_term_meta($term->term_id, 'glaze_image_url', true);
                if (empty($img_url)) {
                    $img_id = get_term_meta($term->term_id, 'glaze_image_id', true);
                    if ($img_id) {
                        $img_url = wp_get_attachment_image_url($img_id, 'large') ?: wp_get_attachment_image_url($img_id, 'full');
                    }
                }

                // Fallback image asset nếu chưa tải ảnh lên
                $scale = '1.0';
                $shift_y = '0px';
                if (empty($img_url)) {
                    $asset_info = self::get_curated_asset_info($slug);
                    $img_url = get_template_directory_uri() . '/assets/images/glazes/' . $asset_info['img'];
                    $scale = $asset_info['scale'];
                    $shift_y = $asset_info['shift_y'];
                }

                // Storyline & Description
                $storyline = get_term_meta($term->term_id, 'glaze_storyline', true);
                $desc = $term->description;

                $curated = self::get_curated_text_info($slug);
                if (empty($storyline)) {
                    $storyline = $curated['storyline'];
                }
                if (empty($desc)) {
                    $desc = $curated['desc'];
                }

                // Name formatting (Title Case tiếng Việt)
                $name = mb_convert_case(trim($term->name), MB_CASE_TITLE, 'UTF-8');
                if (!preg_match('/^Men\s+/ui', $name)) {
                    $name = 'Men ' . $name;
                }

                $glazes[] = array(
                    'id'        => $term->term_id,
                    'name'      => $name,
                    'slug'      => $slug,
                    'color'     => $color,
                    'img_url'   => $img_url,
                    'scale'     => $scale,
                    'shift_y'   => $shift_y,
                    'storyline' => $storyline,
                    'desc'      => $desc,
                    'count'     => $term->count,
                    'link'      => esc_url(add_query_arg('glaze', $slug, home_url('/san-pham/'))),
                );
            }
        }

        // Fallback nếu hệ thống chưa có term nào
        if (empty($glazes)) {
            $default_slugs = array('men-sapphire', 'men-canh-gian', 'men-gam-vang', 'men-xanh-song-bien', 'men-reu', 'men-ngoc-trai', 'men-hong-tuyet', 'men-nau-tuyet', 'men-xanh-thien-thanh');
            foreach ($default_slugs as $ds) {
                $asset = self::get_curated_asset_info($ds);
                $txt = self::get_curated_text_info($ds);
                $clean = sanitize_title(str_replace('men-', '', $ds));
                $name = 'Men ' . ucwords(str_replace('-', ' ', $clean));
                $glazes[] = array(
                    'id'        => 0,
                    'name'      => $name,
                    'slug'      => $ds,
                    'color'     => self::get_fallback_color($ds),
                    'img_url'   => get_template_directory_uri() . '/assets/images/glazes/' . $asset['img'],
                    'scale'     => $asset['scale'],
                    'shift_y'   => $asset['shift_y'],
                    'storyline' => $txt['storyline'],
                    'desc'      => $txt['desc'],
                    'count'     => 0,
                    'link'      => esc_url(add_query_arg('glaze', $ds, home_url('/san-pham/'))),
                );
            }
        }

        return $glazes;
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

// Global Helper
if (!function_exists('gomie_get_active_glazes')) {
    function gomie_get_active_glazes() {
        return Gomie_Glaze_Attribute_Meta::get_active_glazes();
    }
}

// Khởi chạy
Gomie_Glaze_Attribute_Meta::init();
