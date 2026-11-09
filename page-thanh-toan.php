<?php
/**
 * Template Name: Thanh Toán - Gomie Ceramic
 * Description: WooCommerce Checkout Page template (Simplified & Minimalist)
 *
 * @package Gomie
 * @version 13.0.0
 */

defined('ABSPATH') || exit;

get_header(); 
?>

<div class="gomie-editorial-checkout-canvas py-4">
    <div class="container">
        
        <h1 class="checkout-page-title fw-bold text-dark mb-4 fs-3">Thanh toán</h1>

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
