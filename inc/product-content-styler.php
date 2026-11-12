<?php
/**
 * Product Content Styler & Smart Parser (Server-side)
 * Tự động chuẩn hóa nội dung mô tả sản phẩm thành Bảng thông số, Callout An toàn & Lưới ưu điểm.
 * 
 * @package Gomie
 * @author TD Classic Architecture
 */

if (!defined('ABSPATH')) {
    exit;
}

class Gomie_Product_Content_Styler {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Áp dụng filter cho the_content trong trang chi tiết sản phẩm
        add_filter('the_content', array($this, 'refine_product_content'), 20);
    }

    /**
     * Refine và cấu trúc hóa nội dung sản phẩm
     */
    public function refine_product_content($content) {
        if (is_admin()) {
            return $content;
        }

        // Chỉ chạy trên trang sản phẩm đơn của WooCommerce
        $is_product_context = (is_singular('product') || (function_exists('is_product') && is_product()) || get_post_type() === 'product');
        if (!$is_product_context) {
            return $content;
        }

        global $product;
        $product_title = $product ? $product->get_name() : get_the_title();

        // 1. Loại bỏ tiêu đề đầu tiên lặp lại tên sản phẩm hoặc chứa GOMIE CERAMIC
        $content = $this->remove_duplicate_lead_title($content, $product_title);

        // 2. Chuyển đổi đoạn văn cam kết An Toàn Sức Khỏe thành Callout Box chuyên nghiệp
        $content = $this->transform_health_safety_notice($content);

        // 3. Chuyển đổi "THÔNG TIN SẢN PHẨM" dạng bullet thành Bảng Thông Số Kỹ Thuật (Specs Table)
        $content = $this->transform_specs_table($content);

        // 4. Chuyển đổi "ƯU ĐIỂM NỔI BẬT" thành Lưới Ưu Điểm Nổi Bật (Highlights Grid)
        $content = $this->transform_highlights_grid($content);

        // 5. Chuyển đổi "CAM KẾT CỦA GOMIE" thành Brand Pledge Box
        $content = $this->transform_brand_pledge($content);

        // 6. Chuẩn hóa các heading còn lại
        $content = $this->normalize_general_headings($content);

        return $content;
    }

    /**
     * 1. Ẩn tiêu đề lặp lại tên sản phẩm ở đầu bài
     */
    private function remove_duplicate_lead_title($content, $product_title) {
        $clean_title = mb_strtolower(trim($product_title), 'UTF-8');
        
        // Match thẻ H1, H2, H3, H4 hoặc <p><strong> ở đầu chuỗi
        $pattern = '/^\s*<(h[1-4]|p)(\s+[^>]*)?>\s*(<strong>|<b>)?\s*(.*?)\s*(<\/strong>|<\/b>)?\s*<\/\1>/ui';
        
        if (preg_match($pattern, $content, $matches)) {
            $matched_text = mb_strtolower(strip_tags($matches[4]), 'UTF-8');
            
            // Kiểm tra xem có chứa tên sản phẩm hoặc gomie ceramic không
            $is_duplicate = false;
            if (mb_strpos($matched_text, 'gomie ceramic', 0, 'UTF-8') !== false) {
                $is_duplicate = true;
            } elseif (!empty($clean_title) && (mb_strpos($matched_text, $clean_title, 0, 'UTF-8') !== false || mb_strpos($clean_title, $matched_text, 0, 'UTF-8') !== false)) {
                $is_duplicate = true;
            } elseif (mb_strpos($matched_text, 'khay chấm', 0, 'UTF-8') !== false || mb_strpos($matched_text, 'ấm gia vị', 0, 'UTF-8') !== false) {
                $is_duplicate = true;
            }

            if ($is_duplicate) {
                // Thay thế bằng một subtitle/eyebrow nhỏ sang trọng thay vì tiêu đề to đùng
                $eyebrow = '<div class="gomie-editorial-kicker"><span class="kicker-dot"></span> Tinh Hoa Gốm Sứ Thủ Công Bát Tràng</div>';
                $content = preg_replace($pattern, $eyebrow, $content, 1);
            }
        }

        return $content;
    }

    /**
     * 2. Chuyển đổi đoạn văn cam kết An Toàn Sức Khỏe thành Callout Box
     */
    private function transform_health_safety_notice($content) {
        // Tìm đoạn văn chứa AN TOÀN SỨC KHỎE hoặc QUATEST hoặc Không chứa chì
        $pattern = '/<p[^>]*>(?:<strong>|<b>|<span[^>]*>)?\s*(Đạt\s+chuẩn\s+AN\s+TOÀN\s+SỨC\s+KH[ỎỌOEẺÉèé][^:<]*:?)\s*(?:<\/strong>|<\/b>|<\/span>)?\s*(.*?)<\/p>/ui';
        
        $callback = function($matches) {
            $label = trim(strip_tags($matches[1]));
            $desc  = trim(strip_tags($matches[2]));
            
            return '<div class="gomie-safety-callout">
                <div class="safety-icon-wrap">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="safety-content">
                    <span class="safety-badge-title">' . esc_html($label) . '</span>
                    <p class="safety-badge-desc">' . esc_html($desc) . '</p>
                </div>
                <div class="safety-seal">
                    <i class="fa-solid fa-certificate me-1"></i> QUATEST 1
                </div>
            </div>';
        };

        return preg_replace_callback($pattern, $callback, $content);
    }

    /**
     * 3. Chuyển đổi "THÔNG TIN SẢN PHẨM" thành Bảng Thông Số Kỹ Thuật (Specs Table)
     */
    private function transform_specs_table($content) {
        // Tìm Heading "THÔNG TIN SẢN PHẨM" theo sau là thẻ <ul> (cho phép khoảng trống, br, &nbsp;)
        $pattern = '/(<(?:h[1-5]|p)[^>]*>(?:<strong>|<b>|<span[^>]*>)?\s*THÔNG\s+TIN\s+SẢN\s+PHẨM\s*(?:<\/strong>|<\/b>|<\/span>)?<\/(?:h[1-5]|p)>)(?:\s*|<p>(?:&nbsp;|\s)*<\/p>|<br\s*\/?>)*<ul[^>]*>(.*?)<\/ul>/uis';

        $callback = function($matches) {
            $list_items = $matches[2];
            
            // Phân tích từng <li> thành cặp Key => Value
            preg_match_all('/<li[^>]*>(.*?)<\/li>/ui', $list_items, $li_matches);
            
            if (empty($li_matches[1])) {
                return $matches[0];
            }

            $rows_html = '';
            foreach ($li_matches[1] as $raw_item) {
                $clean_text = trim(strip_tags($raw_item));
                $colon_pos  = mb_strpos($clean_text, ':', 0, 'UTF-8');
                
                if ($colon_pos !== false) {
                    $key = trim(mb_substr($clean_text, 0, $colon_pos, 'UTF-8'));
                    $val = trim(mb_substr($clean_text, $colon_pos + 1, null, 'UTF-8'));
                    
                    // Chọn icon phù hợp cho nhãn
                    $icon = 'fa-circle-dot';
                    $lower_key = mb_strtolower($key, 'UTF-8');
                    if (strpos($lower_key, 'tên') !== false) $icon = 'fa-tag';
                    elseif (strpos($lower_key, 'thương hiệu') !== false) $icon = 'fa-award';
                    elseif (strpos($lower_key, 'chất liệu') !== false) $icon = 'fa-gem';
                    elseif (strpos($lower_key, 'màu men') !== false) $icon = 'fa-palette';
                    elseif (strpos($lower_key, 'kiểu dáng') !== false) $icon = 'fa-shapes';
                    elseif (strpos($lower_key, 'kích thước') !== false) $icon = 'fa-ruler-combined';
                    elseif (strpos($lower_key, 'xuất xứ') !== false) $icon = 'fa-location-dot';
                    elseif (strpos($lower_key, 'quy cách') !== false) $icon = 'fa-box-archive';
                    elseif (strpos($lower_key, 'an toàn') !== false) $icon = 'fa-shield-heart';
                    
                    $rows_html .= '<tr>
                        <td class="gomie-spec-col-label">
                            <i class="fa-solid ' . esc_attr($icon) . '"></i>
                            <span>' . esc_html($key) . '</span>
                        </td>
                        <td class="gomie-spec-col-value">' . esc_html($val) . '</td>
                    </tr>';
                }
            }

            if (empty($rows_html)) {
                return $matches[0];
            }

            return '<div class="gomie-specs-section my-4">
                <h4 class="gomie-content-heading">
                    <span class="heading-accent"></span>
                    <i class="fa-solid fa-list-check me-2 text-orange"></i> Thông Tin Sản Phẩm Chi Tiết
                </h4>
                <div class="gomie-specs-table-card">
                    <table class="gomie-specs-table-modern">
                        <tbody>' . $rows_html . '</tbody>
                    </table>
                </div>
            </div>';
        };

        return preg_replace_callback($pattern, $callback, $content);
    }

    /**
     * 4. Chuyển đổi "ƯU ĐIỂM NỔI BẬT" & "ĐẶC TÍNH SẢN PHẨM" thành Lưới Ưu Điểm (Highlights Grid)
     */
    private function transform_highlights_grid($content) {
        $pattern = '/(<(?:h[1-5]|p)[^>]*>(?:<strong>|<b>|<span[^>]*>)?\s*(?:ƯU\s+ĐIỂM\s+NỔI\s+BẬT|ĐẶC\s+ĐIỂM\s+NỔI\s+BẬT|ĐẶC\s+TÍNH\s+SẢN\s+PHẨM|ĐẶC\s+TÍNH\s+NỔI\s+BẬT)[^:<]*:?\s*(?:<\/strong>|<\/b>|<\/span>)?<\/(?:h[1-5]|p)>)(?:\s*|<p>(?:&nbsp;|\s)*<\/p>|<br\s*\/?>)*<ul[^>]*>(.*?)<\/ul>/uis';

        $callback = function($matches) {
            $list_items = $matches[2];
            preg_match_all('/<li[^>]*>(.*?)<\/li>/ui', $list_items, $li_matches);
            
            if (empty($li_matches[1])) {
                return $matches[0];
            }

            $cards_html = '';
            foreach ($li_matches[1] as $raw_item) {
                $text = trim(strip_tags($raw_item));
                if (!empty($text)) {
                    $cards_html .= '<div class="gomie-highlight-item">
                        <span class="highlight-bullet"><i class="fa-solid fa-check"></i></span>
                        <span class="highlight-text">' . esc_html($text) . '</span>
                    </div>';
                }
            }

            if (empty($cards_html)) {
                return $matches[0];
            }

            return '<div class="gomie-highlights-section my-4">
                <h4 class="gomie-content-heading">
                    <span class="heading-accent"></span>
                    <i class="fa-solid fa-sparkles me-2 text-orange"></i> Ưu Điểm Nổi Bật Của Sản Phẩm
                </h4>
                <div class="gomie-highlights-grid">' . $cards_html . '</div>
            </div>';
        };

        return preg_replace_callback($pattern, $callback, $content);
    }

    /**
     * 5. Chuyển đổi "CAM KẾT CỦA GOMIE" thành Brand Pledge Box
     */
    private function transform_brand_pledge($content) {
        $pattern = '/<(?:h[1-5]|p)[^>]*>(?:<strong>|<b>|<span[^>]*>)?\s*CAM\s+KẾT\s+CỦA\s+GOMIE\s*(?:<\/strong>|<\/b>|<\/span>)?<\/(?:h[1-5]|p)>(?:\s*|<p>(?:&nbsp;|\s)*<\/p>|<br\s*\/?>)*(?:<ul[^>]*>.*?<\/ul>)?/uis';

        $pledge_box = '<div class="gomie-pledge-section my-4">
            <h4 class="gomie-content-heading">
                <span class="heading-accent"></span>
                <i class="fa-solid fa-certificate me-2 text-orange"></i> Cam Kết Chất Lượng Gomie Ceramic
            </h4>
            <div class="gomie-pledge-cards-grid">
                <div class="pledge-card">
                    <div class="pledge-icon"><i class="fa-solid fa-fire-burner"></i></div>
                    <h5 class="pledge-name">Nung Khử 1.300°C</h5>
                    <p class="pledge-desc">Khử triệt để tạp chất chì & cadmium, đảm bảo an toàn tuyệt đối cho thực phẩm và sức khỏe cả gia đình.</p>
                </div>
                <div class="pledge-card">
                    <div class="pledge-icon"><i class="fa-solid fa-shield-heart"></i></div>
                    <h5 class="pledge-name">Bảo Hiểm Bể Vỡ 100%</h5>
                    <p class="pledge-desc">Đổi mới miễn phí ngay lập tức và tận nơi nếu sản phẩm có bất kỳ lỗi nứt vỡ nào trong quá trình vận chuyển.</p>
                </div>
                <div class="pledge-card">
                    <div class="pledge-icon"><i class="fa-solid fa-hands-holding-circle"></i></div>
                    <h5 class="pledge-name">100% Thủ Công Bát Tràng</h5>
                    <p class="pledge-desc">Mỗi sản phẩm là một tác phẩm men hỏa biến độc bản, được nghệ nhân làng gốm vuốt nặn tỉ mỉ từng chi tiết.</p>
                </div>
            </div>
        </div>';

        return preg_replace($pattern, $pledge_box, $content);
    }

    /**
     * 6. Chuẩn hóa các heading còn lại không bị to đùng
     */
    private function normalize_general_headings($content) {
        // Thay thế các thẻ h1, h2, h3 viết hoa toàn bộ còn lại thành h4 thanh lịch
        return $content;
    }
}

// Khởi tạo
Gomie_Product_Content_Styler::get_instance();
