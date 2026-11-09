<?php
/**
 * Empty cart page - Gomie Theme Custom Design Editorial V11
 *
 * @package Gomie
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$theme_uri = get_template_directory_uri();
?>

<div class="gomie-cart-empty-wrapper text-center py-5">
    <div class="empty-cart-card mx-auto">
        <div class="empty-icon-circle mb-4">
            <i class="fa-solid fa-basket-shopping"></i>
        </div>
        
        <span class="empty-pill-badge mb-2">GOMIE CERAMIC · GIỎ HÀNG</span>
        
        <h2 class="empty-cart-title mt-2 mb-3">Giỏ hàng của bạn đang trống</h2>
        
        <p class="empty-cart-desc mx-auto mb-4">
            Chưa có sản phẩm gốm sứ nào được thêm vào giỏ. Hãy ghé thăm bộ sưu tập gốm Bát Tràng thủ công để chọn cho không gian ẩm thực của bạn những tác phẩm men hỏa biến tuyệt sắc nhất.
        </p>
        
        <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-gomie-shop-now">
            <i class="fa-solid fa-bag-shopping me-2"></i> Khám phá Bộ Sưu Tập Gốm Sứ
        </a>
    </div>

    <!-- Suggested Featured Collections Below Empty State -->
    <div class="cart-empty-suggestions mt-5 pt-4">
        <div class="suggestion-header mb-4">
            <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">Gợi Ý Dành Riêng Cho Bạn</span>
            <h3 class="fw-bold text-dark mt-1">Các Dòng Men Bát Tràng Được Yêu Thích</h3>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4">
                <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="suggestion-card-mini d-block text-decoration-none">
                    <div class="sug-img-wrap">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-saphire.png'); ?>" alt="Men Sapphire" loading="lazy" />
                    </div>
                    <div class="sug-info mt-2">
                        <h4 class="sug-title mb-0">Men Sapphire Đại Dương</h4>
                        <span class="sug-badge">Sắc xanh kiêu hãnh</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="suggestion-card-mini d-block text-decoration-none">
                    <div class="sug-img-wrap">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-canh-gian.png'); ?>" alt="Men Cánh Gián" loading="lazy" />
                    </div>
                    <div class="sug-info mt-2">
                        <h4 class="sug-title mb-0">Men Cánh Gián Trầm Ấm</h4>
                        <span class="sug-badge">Hồn quê mộc mạc</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="suggestion-card-mini d-block text-decoration-none">
                    <div class="sug-img-wrap">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-xanh-song-bien.png'); ?>" alt="Men Xanh Hỏa Biến" loading="lazy" />
                    </div>
                    <div class="sug-info mt-2">
                        <h4 class="sug-title mb-0">Men Xanh Hỏa Biến 1.300°C</h4>
                        <span class="sug-badge">Biến ảo ngẫu sinh</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
