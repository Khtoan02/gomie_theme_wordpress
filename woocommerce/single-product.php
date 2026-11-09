<?php
/**
 * The Template for displaying all single products
 *
 * @package Gomie
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="gomie-single-product-page py-4">
    <div class="container" style="max-width: 1350px;">
        <!-- Breadcrumbs -->
        <nav class="gomie-product-breadcrumb mb-4">
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'delimiter'   => '',
                    'wrap_before' => '<ol class="breadcrumb gomie-breadcrumb">',
                    'wrap_after'  => '</ol>',
                    'before'      => '<li class="breadcrumb-item">',
                    'after'       => '</li>',
                    'home'        => _x('Trang chủ', 'breadcrumb', 'gomie-theme'),
                ));
            }
            ?>
        </nav>

        <?php
        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile;
        ?>
    </div>
</div>

<?php
get_footer('shop');
