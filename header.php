<?php
/**
 * The header for our theme
 *
 * @package Gomie
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'gomie-theme'); ?></a>
    
    <header id="masthead" class="site-header gomie-editorial-header">
        <!-- 1. Top Header - Contact Info (Left) & Search / Cart / Quote Actions (Right) -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-content d-flex justify-content-between align-items-center">
                    <div class="header-top-left d-flex align-items-center gap-2 gap-md-3">
                        <?php
                        $phone = gomie_get_option('phone_number', '0335 059 889');
                        $email = gomie_get_option('email_address', 'support@gomie.vn');
                        ?>
                        <div class="top-info-item d-flex align-items-center gap-1">
                            <i class="fa-solid fa-phone text-orange"></i>
                            <span class="info-label text-muted">Hotline:</span>
                            <a href="tel:<?php echo gomie_format_phone($phone); ?>" class="contact-link fw-bold text-orange"><?php echo esc_html($phone); ?></a>
                        </div>
                        <span class="top-pipe d-none d-sm-inline">·</span>
                        <div class="top-info-item d-none d-sm-flex align-items-center gap-1">
                            <i class="fa-solid fa-envelope text-orange"></i>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link"><?php echo esc_html($email); ?></a>
                        </div>
                        <span class="top-pipe d-none d-md-inline">·</span>
                        <div class="social-links-minimal d-none d-md-flex align-items-center gap-1">
                            <a href="<?php echo esc_url(gomie_get_option('facebook_url', '#')); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="<?php echo esc_url(gomie_get_option('youtube_url', '#')); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                            <a href="<?php echo esc_url(gomie_get_option('zalo_url', '#')); ?>" target="_blank" rel="noopener" aria-label="Zalo"><i class="fa-solid fa-comment-dots"></i></a>
                        </div>
                    </div>

                    <!-- Right on Top Header: Search, Cart & Báo Giá -->
                    <div class="header-top-right d-none d-xl-flex align-items-center gap-2">
                        <!-- Search Icon Button -->
                        <button type="button" class="nav-action-icon search-trigger" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Tìm kiếm sản phẩm" title="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                        <!-- Cart Dropdown Button -->
                        <div class="cart-header-wrapper position-relative">
                            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-action-icon cart-trigger" id="cart-header-btn" tabindex="0" title="Giỏ hàng">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span class="cart-count cart-pill-badge" id="gomie-cart-count">
                                    <?php echo (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : '0'; ?>
                                </span>
                            </a>
                            <div class="cart-dropdown" id="cart-dropdown" style="display:none; position:absolute; right:0; top:calc(100% + 12px); z-index:9999; min-width:340px;"></div>
                        </div>

                        <!-- Quote Trigger CTA -->
                        <a href="#contact-popup" class="btn-header-quote popup-trigger ms-1">
                            <span>Báo giá</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Header Branding Row (Large Prominent Centered Logo) -->
        <div class="header-branding-row">
            <div class="container">
                <div class="branding-row-inner d-flex align-items-center justify-content-between justify-content-xl-center">
                    
                    <!-- Mobile Menu Button (Left on Mobile) -->
                    <div class="mobile-toggle-wrapper d-xl-none">
                        <button class="mobile-menu-toggle" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Menu">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>

                    <!-- Center: Prominent Large Logo -->
                    <div class="site-branding text-center">
                        <?php if (has_custom_logo()) : ?>
                            <div class="custom-logo-wrapper">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="gomie-editorial-logo-link">
                                <div class="logo-seal-box">
                                    <svg width="60" height="60" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="56" height="56" rx="14" fill="url(#gomie-seal-gradient-lg)"/>
                                        <path d="M28 12C28 12 19.5 21.5 19.5 29C19.5 33.6944 23.3056 37.5 28 37.5C32.6944 37.5 36.5 33.6944 36.5 29C36.5 21.5 28 12 28 12Z" stroke="white" stroke-width="2.5" stroke-linejoin="round"/>
                                        <path d="M28 37.5V44M21 44H35" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                        <path d="M14 28C14 28 18.5 29 19.5 29" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                        <path d="M42 28C42 28 37.5 29 36.5 29" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                                        <circle cx="28" cy="22.5" r="2" fill="white"/>
                                        <defs>
                                            <linearGradient id="gomie-seal-gradient-lg" x1="0" y1="0" x2="56" y2="56" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#f47a20"/>
                                                <stop offset="1" stop-color="#d95d08"/>
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="logo-text-block">
                                    <span class="site-title">Gomie</span>
                                    <span class="site-tagline">HEART OF CRAFTSMANSHIP</span>
                                    <span class="site-sub">Ceramics &amp; Déco Objects · Bát Tràng</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Actions (Right on Mobile) -->
                    <div class="mobile-actions-wrapper d-xl-none d-flex align-items-center gap-2">
                        <button type="button" class="nav-action-icon" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-action-icon position-relative" aria-label="Giỏ hàng">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <?php if (function_exists('WC') && WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
                                <span class="cart-pill-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- 3. Navigation Bar (100% Pure Centered Menu) -->
        <div class="header-nav-row">
            <div class="container position-relative">
                <div class="header-nav-inner d-flex align-items-center justify-content-center">
                    
                    <!-- Sticky mini logo (displays only when scrolled sticky) -->
                    <?php
                    $sticky_logo_url = '';
                    if (has_custom_logo()) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_img_src   = wp_get_attachment_image_src($custom_logo_id, 'medium');
                        if (!empty($logo_img_src[0])) {
                            $sticky_logo_url = $logo_img_src[0];
                        }
                    }
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="sticky-logo-pill d-none" aria-label="<?php bloginfo('name'); ?>">
                        <?php if (!empty($sticky_logo_url)) : ?>
                            <img src="<?php echo esc_url($sticky_logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="sticky-logo-img" />
                        <?php else : ?>
                            <span class="sticky-logo-text">Gomie</span>
                        <?php endif; ?>
                    </a>

                    <!-- 100% Centered Menu Links -->
                    <nav class="main-navigation flex-grow-1 text-center">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'gomie-nav-menu d-flex justify-content-center align-items-center list-unstyled mb-0',
                            'fallback_cb'    => 'gomie_default_primary_menu',
                            'walker'         => new Premium_Walker_Nav_Menu(),
                        ));
                        ?>
                    </nav>

                    <!-- Sticky Quick Actions (displays only when scrolled sticky) -->
                    <div class="sticky-nav-actions d-none align-items-center gap-2">
                        <button type="button" class="nav-action-icon search-trigger" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Tìm kiếm sản phẩm" title="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-action-icon position-relative" title="Giỏ hàng">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span class="cart-count cart-pill-badge">
                                <?php echo (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : '0'; ?>
                            </span>
                        </a>
                        <a href="#contact-popup" class="btn-header-quote popup-trigger ms-1">
                            <span>Báo giá</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="fas fa-search text-primary me-2"></i>
                        Tìm kiếm sản phẩm
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="search-form-wrapper">
                        <?php get_search_form(); ?>
                    </div>
                    <div class="search-suggestions mt-3">
                        <small class="text-muted">Từ khóa phổ biến:</small>
                        <div class="mt-2">
                            <span class="badge bg-light text-dark me-2">Bát đĩa</span>
                            <span class="badge bg-light text-dark me-2">Ấm chén</span>
                            <span class="badge bg-light text-dark me-2">Gốm nhà hàng</span>
                            <span class="badge bg-light text-dark">Quà tặng gốm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="mobileMenuLabel">
                <i class="fas fa-bars text-primary me-2"></i>
                Menu
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
                <div class="p-3 border-bottom offcanvas-quick-contact d-flex gap-3">
                    <a href="tel:<?php echo gomie_format_phone($phone); ?>" class="btn btn-outline-primary flex-fill">
                        <i class="fas fa-phone-alt me-2"></i> <?php echo esc_html($phone); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-outline-secondary flex-fill">
                        <i class="fas fa-envelope me-2"></i> Email
                    </a>
                </div>
                
                <!-- Mobile Cart -->
                <div class="p-3 border-bottom">
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                        <?php if (function_exists('WC') && WC()->cart) : ?>
                            <span class="badge bg-light text-dark"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-menu',
                'container'      => false,
                    'menu_class'     => 'mobile-nav-menu list-unstyled mb-0',
                'fallback_cb'    => 'gomie_default_primary_menu',
                'walker'         => new Mobile_Walker_Nav_Menu(),
            ));
            ?>
                <div class="offcanvas-section border-top p-3">
                    <h6 class="text-uppercase text-muted mb-2">Danh mục</h6>
                    <div class="offcanvas-categories d-grid gap-2">
                        <a href="<?php echo esc_url(home_url('/nha-hang/')); ?>" class="btn btn-light text-start"><i class="fas fa-utensils me-2 text-primary"></i> Nhà hàng <small class="text-muted d-block">Bộ đồ ăn & Trang trí</small></a>
                        <a href="<?php echo esc_url(home_url('/khach-san/')); ?>" class="btn btn-light text-start"><i class="fas fa-bed me-2 text-primary"></i> Khách sạn <small class="text-muted d-block">Đồ dùng phòng & Không gian</small></a>
                        <a href="<?php echo esc_url(home_url('/qua-tang/')); ?>" class="btn btn-light text-start"><i class="fas fa-gift me-2 text-primary"></i> Quà tặng <small class="text-muted d-block">Quà tặng Doanh nghiệp & In logo</small></a>
                    </div>
                </div>
                <div class="offcanvas-section border-top p-3">
                    <h6 class="text-uppercase text-muted mb-2">Thông tin</h6>
                    <div class="company-item">
                        <a href="<?php echo esc_url(home_url('/chung-nhan/')); ?>" class="company-link"><i class="fas fa-shield-alt me-2 text-primary"></i> Chứng nhận an toàn</a>
                        <a href="<?php echo esc_url(home_url('/cau-chuyen/')); ?>" class="company-link"><i class="fas fa-heart me-2 text-primary"></i> Chuyện của Gomie</a>
                    </div>
                </div>
                <div class="offcanvas-section border-top p-3">
                    <h6 class="text-uppercase text-muted mb-2">Kết nối với chúng tôi</h6>
                    <div class="offcanvas-social social-icons d-flex gap-2">
                        <a href="<?php echo esc_url(gomie_get_option('facebook_url', '#')); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo esc_url(gomie_get_option('youtube_url', '#')); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="<?php echo esc_url(gomie_get_option('linkedin_url', '#')); ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="<?php echo esc_url(gomie_get_option('zalo_url', '#')); ?>" target="_blank" rel="noopener" aria-label="Zalo"><i class="fas fa-comments"></i></a>
                    </div>
                </div>
            <div class="p-3 border-top mt-3">
                <a href="#contact-popup" class="btn btn-primary w-100 popup-trigger">
                    <i class="fas fa-paper-plane me-2"></i>
                    Yêu cầu báo giá
                </a>
            </div>
        </div>
    </div>
        
    <div id="main-content" class="site-content">