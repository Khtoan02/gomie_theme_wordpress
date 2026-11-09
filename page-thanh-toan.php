<?php
/**
 * Template Name: Thanh Toán - Gomie Ceramic
 * Description: WooCommerce Checkout Page template (Editorial V11)
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header(); 
$theme_uri = get_template_directory_uri();
?>

<div class="gomie-editorial-checkout-canvas">
    <div class="container py-4 py-md-5">
        
        <!-- Breadcrumbs -->
        <nav class="checkout-breadcrumb-v11 mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="<?php echo esc_url(wc_get_cart_url()); ?>">Giỏ hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="checkout-header-v11 text-center mb-4">
            <span class="checkout-pill-badge mb-2">
                <i class="fa-solid fa-shield-halved me-1"></i> GOMIE CERAMIC · BẢO MẬT & AN TOÀN
            </span>
            <h1 class="checkout-title-v11 fw-bold text-dark mt-2 mb-2">
                Thanh Toán <span class="highlight-orange">Đơn Hàng Gốm Sứ</span>
            </h1>
            <p class="checkout-desc-v11 text-muted mx-auto">
                Điền thông tin nhận hàng để Gomie chuẩn bị và đóng gói kiệt tác gốm sứ chuyển đến tận tay bạn với bảo hiểm rơi vỡ 100%.
            </p>
        </div>

        <!-- Main Checkout Content -->
        <div class="checkout-main-box">
            <?php
            while ( have_posts() ) :
                the_post();
                echo do_shortcode( '[woocommerce_checkout]' );
            endwhile;
            ?>
        </div>

    </div>
</div>

<style>
.gomie-editorial-checkout-canvas {
    background: #fbf8f3 url('<?php echo esc_url($theme_uri . "/assets/images/glazes/Background-1.png"); ?>') repeat;
    min-height: 85vh;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #2b2b2b;
}

.gomie-editorial-checkout-canvas .woocommerce-breadcrumb {
    display: none !important;
}
.woocommerce-form-coupon-toggle .woocommerce-info {
    max-width: 760px;
    margin: 0 auto 1.5rem !important;
    border-radius: 999px !important;
    text-align: center;
    border: 1px solid rgba(224, 89, 42, 0.2) !important;
    background: #ffffff !important;
    font-size: 0.95rem;
}
.woocommerce-form-coupon-toggle .woocommerce-info a {
    color: #e0592a !important;
    font-weight: 700;
}
    background: transparent;
    font-size: 0.88rem;
}
.checkout-breadcrumb-v11 a {
    color: #8c827a;
    text-decoration: none;
}
.checkout-breadcrumb-v11 a:hover {
    color: #e0592a;
}
.checkout-breadcrumb-v11 .active {
    color: #e0592a;
    font-weight: 600;
}

.checkout-pill-badge {
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

.checkout-title-v11 {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    letter-spacing: -0.5px;
}
.checkout-title-v11 .highlight-orange {
    color: #e0592a;
}
.checkout-desc-v11 {
    max-width: 620px;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Form refinement */
.checkout-main-box {
    background: #ffffff;
    border-radius: 24px;
    padding: 2.5rem 2rem;
    border: 1px solid rgba(224, 89, 42, 0.15);
    box-shadow: 0 10px 30px rgba(180, 140, 100, 0.08);
}
.checkout-main-box h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1f2c;
    border-bottom: 2px solid rgba(224, 89, 42, 0.15);
    padding-bottom: 0.75rem;
    margin-bottom: 1.25rem;
}
.checkout-main-box input.input-text, 
.checkout-main-box textarea,
.checkout-main-box select {
    border-radius: 10px !important;
    border: 1px solid rgba(0,0,0,0.15) !important;
    padding: 0.65rem 1rem !important;
    background: #fbfbfb !important;
    transition: all 0.2s !important;
}
.checkout-main-box input.input-text:focus, 
.checkout-main-box textarea:focus,
.checkout-main-box select:focus {
    border-color: #e0592a !important;
    box-shadow: 0 0 0 3px rgba(224, 89, 42, 0.15) !important;
    background: #fff !important;
    outline: none !important;
}
#place_order, .btn-place-order-enhanced {
    background: #e0592a !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 999px !important;
    padding: 0.9rem 2.5rem !important;
    font-size: 1.05rem !important;
    font-weight: 700 !important;
    box-shadow: 0 8px 20px rgba(224, 89, 42, 0.35) !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
}
#place_order:hover, .btn-place-order-enhanced:hover {
    background: #c4471b !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 12px 28px rgba(224, 89, 42, 0.45) !important;
}
</style>

<?php get_footer(); ?>
