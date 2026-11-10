<?php
/**
 * Template Name: Giỏ Hàng - Gomie Ceramic
 * Page template for Vietnamese cart page (Editorial V11)
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header(); 
$theme_uri = get_template_directory_uri();
?>

<div class="gomie-editorial-cart-canvas">
    <div class="container py-4 py-md-5">
        
        <!-- Breadcrumbs -->
        <nav class="cart-breadcrumb-v11 mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="cart-header-v11 text-center mb-4">
            <span class="cart-pill-badge mb-2">
                <i class="fa-solid fa-basket-shopping me-1"></i> GOMIE CERAMIC · GIỎ HÀNG
            </span>
            <h1 class="cart-title-v11 fw-bold text-dark mt-2 mb-2">
                Giỏ Hàng <span class="highlight-orange">Gốm Sứ Bát Tràng</span>
            </h1>
            <p class="cart-desc-v11 text-muted mx-auto">
                Kiểm tra các tác phẩm gốm sứ đã chọn, áp dụng mã ưu đãi và tiến hành thanh toán bảo mật.
            </p>
        </div>

        <!-- Main Cart Content -->
        <div class="cart-main-box">
            <?php if (class_exists('WooCommerce')) : ?>
                <?php
                if (WC()->cart->is_empty()) {
                    wc_get_template('cart/cart-empty.php');
                } else {
                    wc_get_template('cart/cart.php');
                }
                ?>
            <?php else : ?>
                <div class="alert alert-warning text-center">
                    Vui lòng kích hoạt WooCommerce để sử dụng tính năng giỏ hàng.
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.gomie-editorial-cart-canvas {
    background-color: #fffdf9;
    background-image: url('<?php echo esc_url($theme_uri . "/assets/images/glazes/Background-1.png"); ?>');
    background-position: top center;
    background-size: 100% auto;
    background-repeat: no-repeat;
    min-height: 85vh;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #2b2b2b;
}

.gomie-editorial-cart-canvas .woocommerce-breadcrumb {
    display: none !important;
}
.cart-breadcrumb-v11 .breadcrumb {
    background: transparent;
    font-size: 0.88rem;
}
.cart-breadcrumb-v11 a {
    color: #8c827a;
    text-decoration: none;
}
.cart-breadcrumb-v11 a:hover {
    color: #e0592a;
}
.cart-breadcrumb-v11 .active {
    color: #e0592a;
    font-weight: 600;
}

.cart-pill-badge {
    display: inline-block;
    padding: 0.35rem 1rem;
    background: rgba(224, 89, 42, 0.08);
    color: #b3471e;
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    border-radius: 999px;
    border: 1px solid rgba(224, 89, 42, 0.25);
}

.cart-title-v11 {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    letter-spacing: -0.5px;
}
.cart-title-v11 .highlight-orange {
    color: #e0592a;
}
.cart-desc-v11 {
    max-width: 600px;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Empty State Card in Cart */
.gomie-cart-empty-wrapper {
    max-width: 860px;
    margin: 0 auto;
}
.empty-cart-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 3rem 2rem;
    border: 1px solid rgba(224, 89, 42, 0.15);
    box-shadow: 0 10px 30px rgba(180, 140, 100, 0.08);
}
.empty-icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(224, 89, 42, 0.1);
    color: #e0592a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}
.empty-pill-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    color: #928b84;
    letter-spacing: 1.5px;
}
.empty-cart-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1a1f2c;
}
.empty-cart-desc {
    max-width: 500px;
    color: #6e6761;
    font-size: 0.95rem;
    line-height: 1.7;
}
.btn-gomie-shop-now {
    display: inline-flex;
    align-items: center;
    background: #e0592a;
    color: #ffffff !important;
    padding: 0.8rem 2rem;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(224, 89, 42, 0.35);
    transition: all 0.25s ease;
}
.btn-gomie-shop-now:hover {
    background: #c4471b;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(224, 89, 42, 0.45);
}

/* Suggested cards */
.suggestion-card-mini {
    background: #ffffff;
    border-radius: 16px;
    padding: 1.25rem 1rem;
    border: 1px solid rgba(224, 89, 42, 0.12);
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    transition: all 0.25s ease;
}
.suggestion-card-mini:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(224, 89, 42, 0.15);
    border-color: rgba(224, 89, 42, 0.3);
}
.sug-img-wrap {
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle, rgba(254, 245, 238, 0.8) 0%, rgba(255, 255, 255, 0.2) 75%);
    border-radius: 12px;
}
.sug-img-wrap img {
    max-height: 120px;
    max-width: 90%;
    object-fit: contain;
    filter: drop-shadow(0 6px 10px rgba(0,0,0,0.08));
}
.sug-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1a1f2c;
}
.sug-badge {
    font-size: 0.78rem;
    color: #e0592a;
    font-weight: 500;
}
</style>

<?php get_footer(); ?>
