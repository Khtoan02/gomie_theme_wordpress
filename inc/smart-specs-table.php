<?php
/**
 * Smart Specs Table with Excel/Sheets Direct Paste Parser (Code tay 100%)
 * Cho phép dán trực tiếp dữ liệu dạng bảng từ Excel, Google Sheets (\t) hoặc văn bản "Tên: Giá trị"
 * 
 * @package Gomie
 * @author TD Classic Architecture
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Đăng ký Metabox trong trang quản trị WooCommerce
add_action('add_meta_boxes', function () {
    add_meta_box(
        'gomie_specs_box',
        '📊 Bảng Thông Số Kỹ Thuật (Hỗ trợ dán từ Excel / Sheets)',
        'gomie_render_specs_metabox',
        'product',
        'normal',
        'high'
    );
});

// 2. Render Metabox trong Admin
function gomie_render_specs_metabox($post) {
    wp_nonce_field('gomie_specs_save', 'gomie_specs_nonce');
    $specs = get_post_meta($post->ID, '_gomie_product_specs', true);
    if (!is_array($specs)) {
        $specs = array();
    }
    ?>
    <div style="margin-bottom: 12px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <button type="button" class="button button-primary" id="gomie-add-spec-row">+ Thêm thông số</button>
        <button type="button" class="button" id="gomie-open-smart-paste">📋 Dán nhanh từ Excel / Văn bản</button>
        <button type="button" class="button button-link-delete" id="gomie-clear-all-specs" style="margin-left: auto;">Xóa toàn bộ</button>
    </div>

    <!-- Modal Dán Nhanh -->
    <div id="gomie-paste-modal" style="display:none; background:#f9f9f9; border:1px solid #ccd0d4; padding:14px; margin-bottom:14px; border-radius:6px;">
        <p style="margin-top:0;"><strong>Dán nội dung từ Excel / Google Sheets (2 cột) hoặc định dạng <code>Tên: Giá trị</code>:</strong></p>
        <textarea id="gomie-paste-input" rows="6" style="width:100%; font-family:monospace; font-size:12px; padding:8px;" placeholder="Chất liệu	Gốm sứ cao cấp Bát Tràng&#10;Nhiệt độ nung	1.300°C khử chì cadmium&#10;Kích thước: Rộng 11.5cm, Cao 6cm&#10;Xuất xứ: Bát Tràng, Gia Lâm, Hà Nội"></textarea>
        <div style="margin-top:10px; display:flex; gap:8px;">
            <button type="button" class="button button-primary" id="gomie-apply-smart-paste">Nhập dữ liệu</button>
            <button type="button" class="button" id="gomie-close-smart-paste">Hủy</button>
        </div>
    </div>

    <table class="widefat striped" id="gomie-specs-table">
        <thead>
            <tr>
                <th style="width: 35%;">Tên thông số</th>
                <th>Giá trị</th>
                <th style="width: 50px; text-align: center;">Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specs)): ?>
                <?php foreach ($specs as $index => $item): ?>
                    <tr>
                        <td><input type="text" name="gomie_specs[<?php echo $index; ?>][name]" value="<?php echo esc_attr($item['name']); ?>" style="width:100%;" /></td>
                        <td><input type="text" name="gomie_specs[<?php echo $index; ?>][val]" value="<?php echo esc_attr($item['val']); ?>" style="width:100%;" /></td>
                        <td style="text-align: center;"><button type="button" class="button button-link-delete gomie-remove-row">&times;</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
    (function($){
        var tbody = $('#gomie-specs-table tbody');

        function createRow(name, val) {
            var idx = tbody.find('tr').length;
            var html = '<tr>' +
                '<td><input type="text" name="gomie_specs[' + idx + '][name]" value="' + $('<div>').text(name).html() + '" style="width:100%;" /></td>' +
                '<td><input type="text" name="gomie_specs[' + idx + '][val]" value="' + $('<div>').text(val).html() + '" style="width:100%;" /></td>' +
                '<td style="text-align:center;"><button type="button" class="button button-link-delete gomie-remove-row">&times;</button></td>' +
                '</tr>';
            tbody.append(html);
        }

        $('#gomie-add-spec-row').on('click', function(){
            createRow('', '');
        });

        tbody.on('click', '.gomie-remove-row', function(){
            $(this).closest('tr').remove();
        });

        $('#gomie-clear-all-specs').on('click', function(){
            if(confirm('Bạn có chắc chắn muốn xóa tất cả thông số?')) {
                tbody.empty();
            }
        });

        $('#gomie-open-smart-paste').on('click', function(){
            $('#gomie-paste-modal').toggle();
        });

        $('#gomie-close-smart-paste').on('click', function(){
            $('#gomie-paste-modal').hide();
        });

        $('#gomie-apply-smart-paste').on('click', function(){
            var text = $('#gomie-paste-input').val().trim();
            if(!text) return;

            var lines = text.split('\n');
            lines.forEach(function(line){
                line = line.trim();
                if(!line) return;

                var name = '', val = '';
                if(line.indexOf('\t') !== -1) {
                    var parts = line.split('\t');
                    name = parts[0] ? parts[0].trim() : '';
                    val  = parts.slice(1).join(' ').trim();
                } else if(line.indexOf(':') !== -1) {
                    var parts = line.split(':');
                    name = parts[0] ? parts[0].trim() : '';
                    val  = parts.slice(1).join(':').trim();
                } else {
                    name = line;
                    val  = '';
                }

                if(name || val) {
                    createRow(name, val);
                }
            });

            $('#gomie-paste-input').val('');
            $('#gomie-paste-modal').hide();
        });

        // Hỗ trợ bắt trực tiếp phím Ctrl+V / Cmd+V trên các ô input
        tbody.on('paste', 'input', function(e){
            var pasted = (e.originalEvent || e).clipboardData.getData('text/plain');
            if(pasted && (pasted.indexOf('\t') !== -1 || pasted.indexOf('\n') !== -1)) {
                e.preventDefault();
                var lines = pasted.trim().split('\n');
                lines.forEach(function(line){
                    var parts = line.split('\t');
                    if(parts.length >= 2) {
                        createRow(parts[0].trim(), parts.slice(1).join(' ').trim());
                    }
                });
            }
        });
    })(jQuery);
    </script>
    <?php
}

// 3. Lưu dữ liệu Metabox
add_action('save_post', function ($post_id) {
    if (!isset($_POST['gomie_specs_nonce']) || !wp_verify_nonce($_POST['gomie_specs_nonce'], 'gomie_specs_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['gomie_specs']) && is_array($_POST['gomie_specs'])) {
        $clean_specs = array();
        foreach ($_POST['gomie_specs'] as $row) {
            $name = isset($row['name']) ? sanitize_text_field($row['name']) : '';
            $val  = isset($row['val'])  ? sanitize_text_field($row['val'])  : '';
            if ($name !== '' || $val !== '') {
                $clean_specs[] = array('name' => $name, 'val' => $val);
            }
        }
        update_post_meta($post_id, '_gomie_product_specs', $clean_specs);
    } else {
        delete_post_meta($post_id, '_gomie_product_specs');
    }
});

// 4. Helper Frontend để lấy và hiển thị thông số
if (!function_exists('gomie_get_product_specs')) {
    function gomie_get_product_specs($product_id = null) {
        if (!$product_id) {
            $product_id = get_the_ID();
        }
        $specs = get_post_meta($product_id, '_gomie_product_specs', true);
        return is_array($specs) ? $specs : array();
    }
}
