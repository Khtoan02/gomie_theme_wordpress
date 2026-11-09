<?php
/**
 * Template Name: Thanh Toán - Gomie Ceramic
 * Description: WooCommerce Checkout Page template (Modern Editorial V12)
 *
 * @package Gomie
 * @version 12.0.0
 */

defined('ABSPATH') || exit;

get_header(); 
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
                <i class="fa-solid fa-shield-halved me-1"></i> GOMIE CERAMIC · BẢO MẬT &amp; AN TOÀN
            </span>
            <h1 class="checkout-title-v11 fw-bold text-dark mt-2 mb-2">
                Thanh Toán <span class="highlight-orange">Đơn Hàng Gốm Sứ</span>
            </h1>
            <p class="checkout-desc-v11 text-muted mx-auto">
                Điền thông tin nhận hàng để Gomie đóng gói kiệt tác gốm sứ chuyển đến tận tay bạn với cam kết đồng kiểm và bảo hiểm rơi vỡ 100%.
            </p>
        </div>

        <!-- Main Checkout Content -->
        <div class="checkout-main-content-area">
            <?php
            while ( have_posts() ) :
                the_post();
                echo do_shortcode( '[woocommerce_checkout]' );
            endwhile;
            ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
