<?php
/**
 * Standalone Native HTML Page Cache (Code Tay 100% - Zero Plugin)
 * Tạo bản tĩnh HTML siêu nhẹ giúp đưa TTFB về 20ms - 50ms không cần plugin bên thứ 3.
 * 
 * @package Gomie
 * @author TD Classic Architecture
 */

if (!defined('ABSPATH')) {
    exit;
}

class WP_Speed_UX_Native_Cache {

    private static $instance = null;
    private $cache_dir = '';

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->cache_dir = WP_CONTENT_DIR . '/cache/wp_native_cache';

        // Bắt đầu caching ở frontend (priority 0 để phục vụ tức thì)
        add_action('template_redirect', array($this, 'maybe_serve_or_capture_cache'), 0);

        // Tự động xóa cache khi nội dung thay đổi
        add_action('save_post', array($this, 'purge_cache'));
        add_action('edit_terms', array($this, 'purge_cache'));
        add_action('switch_theme', array($this, 'purge_cache'));
        add_action('woocommerce_update_product', array($this, 'purge_cache'));

        // AJAX Purge từ Admin
        add_action('wp_ajax_wp_purge_native_cache', array($this, 'ajax_purge_cache'));
    }

    /**
     * Kiểm tra điều kiện request có được phép cache hay không
     */
    private function can_cache() {
        // Không cache khi trong trang admin hoặc người dùng đã đăng nhập
        if (is_admin() || is_user_logged_in()) {
            return false;
        }

        // Chỉ cache request GET và HEAD
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'HEAD') {
            return false;
        }

        // Bỏ qua các trang động của WooCommerce (giỏ hàng, thanh toán, tài khoản)
        if (function_exists('is_cart') && is_cart()) return false;
        if (function_exists('is_checkout') && is_checkout()) return false;
        if (function_exists('is_account_page') && is_account_page()) return false;

        // Bỏ qua trang đăng nhập & admin
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($uri, 'wp-login.php') !== false || strpos($uri, 'wp-admin') !== false) {
            return false;
        }

        // Bỏ qua search và các query string ngoại trừ phân trang và lọc men
        if (!empty($_GET)) {
            $allowed_keys = array('page', 'paged', 'glaze', 'pa_mau-sac', 'cat', 'category');
            foreach (array_keys($_GET) as $key) {
                if (!in_array($key, $allowed_keys, true)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function ensure_cache_dir() {
        if (!is_dir($this->cache_dir)) {
            @mkdir($this->cache_dir, 0755, true);
        }
    }

    /**
     * Tạo khóa cache định danh duy nhất (tách biệt mobile và desktop)
     */
    private function get_cache_file() {
        $this->ensure_cache_dir();
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri  = $_SERVER['REQUEST_URI'] ?? '/';
        $is_mobile = wp_is_mobile() ? '_mob' : '_desk';
        
        $hash = md5($host . '|' . $uri . '|' . $is_mobile);
        return $this->cache_dir . '/' . $hash . '.html';
    }

    /**
     * Trả về HTML tĩnh nếu có sẵn hoặc bắt đầu hứng buffer
     */
    public function maybe_serve_or_capture_cache() {
        if (!$this->can_cache()) {
            return;
        }

        $cache_file = $this->get_cache_file();

        // 1. Phục vụ cache nếu file còn tươi (< 24 giờ)
        if (file_exists($cache_file) && (time() - filemtime($cache_file) < 86400)) {
            $cached_html = @file_get_contents($cache_file);
            if (!empty($cached_html) && strlen($cached_html) > 1000) {
                if (!headers_sent()) {
                    header('Content-Type: text/html; charset=UTF-8');
                    header('X-Cache-Engine: HIT (Native Handcrafted - TTFB < 50ms)');
                }
                echo $cached_html;
                echo "\n<!-- Native Cache HIT: " . date('Y-m-d H:i:s', filemtime($cache_file)) . " -->";
                exit;
            }
        }

        // 2. Chưa có cache: Bắt đầu hứng output buffer
        ob_start(array($this, 'capture_and_save_cache'));
    }

    /**
     * Callback hứng output buffer và ghi file tĩnh
     */
    public function capture_and_save_cache($buffer) {
        // Chỉ lưu cache với phản hồi hợp lệ HTTP 200 và có nội dung thực
        if (strlen($buffer) > 1000 && http_response_code() === 200) {
            $this->ensure_cache_dir();
            $cache_file = $this->get_cache_file();
            @file_put_contents($cache_file, $buffer);
        }
        return $buffer;
    }

    /**
     * Xóa sạch toàn bộ file cache tĩnh
     */
    public function purge_cache() {
        $this->ensure_cache_dir();
        if (is_dir($this->cache_dir)) {
            $files = glob($this->cache_dir . '/*.html');
            if ($files) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    /**
     * AJAX Endpoint xóa cache từ giao diện quản trị
     */
    public function ajax_purge_cache() {
        check_ajax_referer('wp_purge_cache_nonce', 'nonce');
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }

        $this->purge_cache();
        wp_send_json_success(array('message' => 'Đã xóa toàn bộ HTML Cache tĩnh!'));
    }
}

// Khởi chạy
WP_Speed_UX_Native_Cache::get_instance();
