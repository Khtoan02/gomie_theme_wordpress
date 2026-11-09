<?php
/**
 * Enqueue scripts and styles
 *
 * @package Gomie
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles - OPTIMIZED VERSION
 */
function gomie_enqueue_scripts() {
    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        array(),
        '5.3.2'
    );
    
    // Theme stylesheet
    wp_enqueue_style('gomie-style', get_stylesheet_uri(), array('bootstrap'), GOMIE_THEME_VERSION);

    // Google Fonts
    wp_enqueue_style('gomie-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Global flags for optimization
    $is_woocommerce_page = (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy());
    $is_category_page = (is_product_category() && (is_product_category('nha-hang') || is_product_category('khach-san') || is_product_category('qua-tang')));
    $aos_loaded = false;

    // Vendor CSS (if any)
    if (file_exists(get_template_directory() . '/assets/css/vendor.css')) {
        wp_enqueue_style('gomie-vendor', get_template_directory_uri() . '/assets/css/vendor.css', array(), GOMIE_THEME_VERSION);
    }

    // Main CSS
    if (file_exists(get_template_directory() . '/assets/css/main.css')) {
        wp_enqueue_style('gomie-main', get_template_directory_uri() . '/assets/css/main.css', array('gomie-style'), GOMIE_THEME_VERSION);
    }

    // GOMIE Colors CSS
    if (file_exists(get_template_directory() . '/assets/css/gomie-colors.css')) {
        wp_enqueue_style('gomie-colors', get_template_directory_uri() . '/assets/css/gomie-colors.css', array('gomie-style', 'gomie-main'), GOMIE_THEME_VERSION);
    }

    // Editorial Header CSS (Modern centered logo & UX/UI navigation)
    if (file_exists(get_template_directory() . '/assets/css/editorial-header.css')) {
        wp_enqueue_style('gomie-editorial-header', get_template_directory_uri() . '/assets/css/editorial-header.css', array('gomie-style', 'gomie-colors'), filemtime(get_template_directory() . '/assets/css/editorial-header.css'));
    }

    // Add to Cart Buttons CSS - Global styling for consistent button behavior
    if (file_exists(get_template_directory() . '/assets/css/add-to-cart-buttons.css')) {
        wp_enqueue_style('add-to-cart-buttons', get_template_directory_uri() . '/assets/css/add-to-cart-buttons.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
    }

    // Custom Video Player CSS
    if (file_exists(get_template_directory() . '/assets/css/custom-video-player.css')) {
        wp_enqueue_style('custom-video-player', get_template_directory_uri() . '/assets/css/custom-video-player.css', array('gomie-style'), GOMIE_THEME_VERSION);
    }

    // Homepage Products CSS
    if (file_exists(get_template_directory() . '/assets/css/homepage-products.css')) {
        wp_enqueue_style('homepage-products', get_template_directory_uri() . '/assets/css/homepage-products.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
    }

    // HEART Values Infographic CSS (Cache-busted with filemtime)
    if (file_exists(get_template_directory() . '/assets/css/heart-values.css')) {
        wp_enqueue_style('heart-values-css', get_template_directory_uri() . '/assets/css/heart-values.css', array('gomie-style', 'homepage-products'), filemtime(get_template_directory() . '/assets/css/heart-values.css'));
    }

    // Footer New CSS
    if (file_exists(get_template_directory() . '/assets/css/footer-new.css')) {
        wp_enqueue_style('footer-new', get_template_directory_uri() . '/assets/css/footer-new.css', array('gomie-style'), GOMIE_THEME_VERSION);
    }

    // Unified Category CSS - for restaurant, hotel, and gift categories (OPTIMIZED)
    if ($is_category_page) {
        wp_enqueue_style('restaurant-category', get_template_directory_uri() . '/assets/css/restaurant-category.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
        
        // AOS (Animate On Scroll) for animations - Load only once
        if (!$aos_loaded) {
            wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
            $aos_loaded = true;
        }
    }



    // Vendor JS (if any)
    if (file_exists(get_template_directory() . '/assets/js/vendor.js')) {
        wp_enqueue_script('gomie-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array('jquery'), GOMIE_THEME_VERSION, true);
    }

    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );
    
    // Main JS
    if (file_exists(get_template_directory() . '/assets/js/main.js')) {
        wp_enqueue_script('gomie-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap'), GOMIE_THEME_VERSION, true);
    }

    // Custom Video Player JS
    if (file_exists(get_template_directory() . '/assets/js/custom-video-player.js')) {
        wp_enqueue_script('custom-video-player', get_template_directory_uri() . '/assets/js/custom-video-player.js', array('jquery'), GOMIE_THEME_VERSION, true);
    }

    // WooCommerce Scripts - OPTIMIZED LOADING
    $wc_scripts = array();
    
    // Homepage Products JS
    if (file_exists(get_template_directory() . '/assets/js/homepage-products.js')) {
        wp_enqueue_script('homepage-products', get_template_directory_uri() . '/assets/js/homepage-products.js', array('jquery', 'bootstrap'), GOMIE_THEME_VERSION, true);
        $wc_scripts[] = 'homepage-products';
    }

    // Cart Management Scripts - Only load essential ones, merge functionality
    if (class_exists('WooCommerce')) {
        // Primary cart state manager (combines functionality from multiple cart scripts)
        if (file_exists(get_template_directory() . '/assets/js/cart-state-manager.js')) {
            wp_enqueue_script('cart-state-manager', get_template_directory_uri() . '/assets/js/cart-state-manager.js', array('jquery'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'cart-state-manager';
        }

        // Header cart updater (essential for UI updates)
        if (file_exists(get_template_directory() . '/assets/js/header-cart-updater.js')) {
            wp_enqueue_script('header-cart-updater', get_template_directory_uri() . '/assets/js/header-cart-updater.js', array('jquery'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'header-cart-updater';
        }

        // Cart Test Helper - Development/testing only (only if ?cart_debug=1)
        if (file_exists(get_template_directory() . '/assets/js/cart-test-helper.js') && 
            isset($_GET['cart_debug']) &&
            (WP_DEBUG || in_array($_SERVER['HTTP_HOST'], array('localhost', '127.0.0.1')) || strpos($_SERVER['HTTP_HOST'], '.local') !== false)) {
            wp_enqueue_script('cart-test-helper', get_template_directory_uri() . '/assets/js/cart-test-helper.js', array('jquery', 'header-cart-updater'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'cart-test-helper';
        }
    }



    // Unified Category JavaScript - OPTIMIZED (restaurant, hotel, gift)
    if ($is_category_page) {
        // AOS (Animate On Scroll) JavaScript - Load only once if not already loaded
        if (!wp_script_is('aos-js', 'enqueued')) {
            wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
            // Initialize AOS only once
            wp_add_inline_script('aos-js', 'AOS.init({ duration: 800, once: true, offset: 50 });');
        }
        
        // Restaurant Category JavaScript (reused for all categories)
        if (file_exists(get_template_directory() . '/assets/js/restaurant-category.js')) {
            wp_enqueue_script('restaurant-category', get_template_directory_uri() . '/assets/js/restaurant-category.js', array('jquery', 'bootstrap', 'aos-js'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'restaurant-category';
        }
    }



    // Shop Page CSS & JS - OPTIMIZED LOADING
    if ($is_woocommerce_page) {
        // Shop Page CSS (depends on homepage-products.css for base styles)
        wp_enqueue_style('shop-page', get_template_directory_uri() . '/assets/css/shop-page.css', array('homepage-products', 'gomie-colors'), GOMIE_THEME_VERSION);
        
        // Only load AOS if not already loaded
        if (!wp_script_is('aos-js', 'enqueued') && !$aos_loaded) {
            wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
            wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
            // Initialize AOS only once
            wp_add_inline_script('aos-js', 'AOS.init({ duration: 800, once: true, offset: 50 });');
            $aos_loaded = true;
        }
        
        // Shop-specific assets
        if (is_shop()) {
            // Swiper CSS & JS for carousels
            wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
            wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array('jquery'), '10.0.0', true);
            
            // Shop Carousel CSS
            wp_enqueue_style('shop-carousel', get_template_directory_uri() . '/assets/css/shop-carousel.css', array('homepage-products', 'gomie-colors', 'swiper-css'), GOMIE_THEME_VERSION);
            
            // Shop Carousel JavaScript
            wp_enqueue_script('shop-carousel-js', get_template_directory_uri() . '/assets/js/shop-carousel.js', array('jquery', 'swiper-js'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'shop-carousel-js';
        }
        
        // Shop Page JavaScript
        if (file_exists(get_template_directory() . '/assets/js/shop-page.js')) {
            wp_enqueue_script('shop-page-js', get_template_directory_uri() . '/assets/js/shop-page.js', array('jquery'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'shop-page-js';
        }
    }



    // Cart Page CSS & JS - Load on cart page
    if (is_cart()) {
        // Cart Page CSS
        wp_enqueue_style('cart-page', get_template_directory_uri() . '/assets/css/cart-page.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
        
        // Cart Page JavaScript
        if (file_exists(get_template_directory() . '/assets/js/cart-page.js')) {
            wp_enqueue_script('cart-page-js', get_template_directory_uri() . '/assets/js/cart-page.js', array('jquery', 'wc-cart'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'cart-page-js';
            
            // Localize script with WooCommerce parameters
            wp_localize_script('cart-page-js', 'gomie_cart_params', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'cart_url' => wc_get_cart_url(),
                'nonce' => wp_create_nonce('woocommerce-cart'),
                'wc_ajax_nonce' => wp_create_nonce('wc_add_to_cart_nonce'),
                'currency_symbol' => get_woocommerce_currency_symbol(),
                'currency_position' => get_option('woocommerce_currency_pos'),
                'thousand_separator' => wc_get_price_thousand_separator(),
                'decimal_separator' => wc_get_price_decimal_separator(),
                'number_decimals' => wc_get_price_decimals()
            ));
        }
        
        // Cart Fallback System - Always load on cart page for reliability
        if (file_exists(get_template_directory() . '/assets/js/cart-fallback.js')) {
            wp_enqueue_script('cart-fallback-js', get_template_directory_uri() . '/assets/js/cart-fallback.js', array('jquery'), GOMIE_THEME_VERSION, true);
        }
    }



    // Checkout Page CSS & JS - Load on checkout page
    if (is_checkout()) {
        // Checkout Page CSS
        wp_enqueue_style('checkout-page', get_template_directory_uri() . '/assets/css/checkout-page.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
        
        // Checkout Page JavaScript
        if (file_exists(get_template_directory() . '/assets/js/checkout-page.js')) {
            wp_enqueue_script('checkout-page-js', get_template_directory_uri() . '/assets/js/checkout-page.js', array('jquery', 'wc-checkout'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'checkout-page-js';
            
            // Localize script with WooCommerce parameters
            wp_localize_script('checkout-page-js', 'gomie_checkout_params', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'checkout_url' => wc_get_checkout_url(),
                'nonce' => wp_create_nonce('woocommerce-process_checkout'),
                'currency_symbol' => get_woocommerce_currency_symbol(),
                'is_user_logged_in' => is_user_logged_in()
            ));
        }
    }

    // Single Product Page CSS & JS - Load on product detail page
    if (function_exists('is_product') && is_product()) {
        if (file_exists(get_template_directory() . '/assets/css/single-product.css')) {
            wp_enqueue_style('gomie-single-product', get_template_directory_uri() . '/assets/css/single-product.css', array('gomie-style', 'gomie-colors', 'homepage-products'), GOMIE_THEME_VERSION);
        }
        if (file_exists(get_template_directory() . '/assets/js/single-product.js')) {
            wp_enqueue_script('gomie-single-product-js', get_template_directory_uri() . '/assets/js/single-product.js', array('jquery'), GOMIE_THEME_VERSION, true);
            $wc_scripts[] = 'gomie-single-product-js';
        }
    }

    // Usage Guide Page CSS - Load on /huong-dan-su-dung/
    if (is_page('huong-dan-su-dung') || is_page_template('page-huong-dan-su-dung.php')) {
        if (file_exists(get_template_directory() . '/assets/css/usage-guide.css')) {
            wp_enqueue_style('gomie-usage-guide', get_template_directory_uri() . '/assets/css/usage-guide.css', array('gomie-style', 'gomie-colors'), GOMIE_THEME_VERSION);
        }
    }

    // Types & Glazes Pages CSS - Load on /loai-san-pham/ and /mau-men/
    if (is_page('loai-san-pham') || is_page('mau-men') || is_page_template('page-loai-san-pham.php') || is_page_template('page-mau-men.php')) {
        if (file_exists(get_template_directory() . '/assets/css/types-and-glazes.css')) {
            wp_enqueue_style('gomie-types-glazes', get_template_directory_uri() . '/assets/css/types-and-glazes.css', array('gomie-style', 'gomie-colors', 'homepage-products'), GOMIE_THEME_VERSION);
        }
    }



    if (!file_exists(get_template_directory() . '/assets/js/homepage-products.js')) {
        // Create a placeholder main.js
        wp_enqueue_script('gomie-main-inline', '', array('jquery'), GOMIE_THEME_VERSION, true);
        wp_add_inline_script('gomie-main-inline', '
            (function($) {
                "use strict";
                
                // Header scroll effect
                $(window).on("scroll", function() {
                    if ($(this).scrollTop() > 100) {
                        $(".site-header").addClass("scrolled");
                    } else {
                        $(".site-header").removeClass("scrolled");
                    }
                });
                
                // Mobile menu toggle
                $(".mobile-menu-toggle").on("click", function() {
                    $("body").toggleClass("mobile-menu-active");
                });
                
                // Smooth scroll for anchor links
                $("a[href^=\'#\']").on("click", function(e) {
                    var target = $(this.getAttribute("href"));
                    if (target.length) {
                        e.preventDefault();
                        $("html, body").animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                    }
                });
                
                // Search toggle
                $(".search-toggle").on("click", function() {
                    $(".header-search").toggleClass("active");
                });
                
                // Initialize animations on scroll
                function initScrollAnimations() {
                    var animateElements = $(".animate-on-scroll");
                    
                    function checkIfInView() {
                        var windowHeight = $(window).height();
                        var windowTopPosition = $(window).scrollTop();
                        var windowBottomPosition = (windowTopPosition + windowHeight);
                        
                        $.each(animateElements, function() {
                            var element = $(this);
                            var elementHeight = element.outerHeight();
                            var elementTopPosition = element.offset().top;
                            var elementBottomPosition = (elementTopPosition + elementHeight);
                            
                            if ((elementBottomPosition >= windowTopPosition) &&
                                (elementTopPosition <= windowBottomPosition)) {
                                element.addClass("in-view");
                            }
                        });
                    }
                    
                    $(window).on("scroll resize", checkIfInView);
                    $(window).trigger("scroll");
                }
                
                initScrollAnimations();
                
            })(jQuery);
        ');
    }

    // OPTIMIZED WooCommerce Localization - Load once for all scripts (moved to end)
    if (function_exists('WC') && !empty($wc_scripts)) {
        $wc_params = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'wc_ajax_nonce' => wp_create_nonce('wc_add_to_cart_nonce'),
            'i18n_view_cart' => esc_attr__('View cart', 'woocommerce'),
            'cart_url' => apply_filters('woocommerce_add_to_cart_redirect', wc_get_cart_url(), null),
            'is_cart' => is_cart(),
            'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
        );
        
        // Localize for all WooCommerce scripts
        foreach ($wc_scripts as $script_handle) {
            wp_localize_script($script_handle, 'wc_add_to_cart_params', $wc_params);
        }
    }



    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX
    wp_localize_script('gomie-main', 'gomie_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('gomie_nonce'),
    ));
}

/**
 * Enqueue admin scripts and styles
 */
function gomie_admin_scripts() {
    wp_enqueue_style('gomie-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), GOMIE_THEME_VERSION);
}
add_action('admin_enqueue_scripts', 'gomie_admin_scripts');

/**
 * Add async/defer attributes to scripts
 */
function gomie_script_loader_tag($tag, $handle, $src) {
    // Add async to specific scripts
    $async_scripts = array('font-awesome');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Add defer to specific scripts
    $defer_scripts = array('gomie-main');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'gomie_script_loader_tag', 10, 3);

/**
 * Preload key resources
 */
function gomie_preload_resources() {
    // Preload fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" as="style">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'gomie_preload_resources', 1);