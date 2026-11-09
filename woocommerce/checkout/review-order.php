<?php
/**
 * Review order table - Gomie Ceramic Modern Editorial Design
 * Shows product thumbnails, quantity pills, and clean price summary (Shopify/Apple-grade UX)
 *
 * @package Gomie
 * @version 11.0.0
 */

defined('ABSPATH') || exit;
?>

<div class="gomie-checkout-review-order-table">
    
    <!-- 1. Product Items List with Thumbnails -->
    <div class="checkout-products-list">
        <?php
        do_action('woocommerce_review_order_before_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                
                // Get thumbnail with fallback
                $thumbnail = '';
                if (has_post_thumbnail($_product->get_id())) {
                    $thumbnail = get_the_post_thumbnail($_product->get_id(), array(72, 72), array('class' => 'checkout-product-img'));
                } elseif ($_product->get_parent_id() && has_post_thumbnail($_product->get_parent_id())) {
                    $thumbnail = get_the_post_thumbnail($_product->get_parent_id(), array(72, 72), array('class' => 'checkout-product-img'));
                } else {
                    $fallback_url = function_exists('gomie_get_post_thumbnail_src') ? gomie_get_post_thumbnail_src($_product->get_id()) : wc_placeholder_img_src();
                    $thumbnail = '<img src="' . esc_url($fallback_url) . '" alt="' . esc_attr($_product->get_name()) . '" class="checkout-product-img" />';
                }
                ?>
                <div class="checkout-product-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    
                    <!-- Left: Thumbnail with Quantity Badge -->
                    <div class="checkout-product-thumb-box">
                        <?php echo $thumbnail; ?>
                        <span class="checkout-qty-badge"><?php echo esc_html($cart_item['quantity']); ?></span>
                    </div>

                    <!-- Center: Product Info -->
                    <div class="checkout-product-info">
                        <div class="checkout-product-title">
                            <?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?>
                        </div>
                        <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                        <div class="checkout-product-unit-price text-muted">
                            <?php echo WC()->cart->get_product_price($_product); ?>
                        </div>
                    </div>

                    <!-- Right: Subtotal -->
                    <div class="checkout-product-subtotal">
                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                    </div>
                </div>
                <?php
            }
        }

        do_action('woocommerce_review_order_after_cart_contents');
        ?>
    </div>

    <!-- 2. Totals Summary -->
    <div class="checkout-totals-summary">
        
        <!-- Subtotal -->
        <div class="totals-row">
            <span class="totals-label">Tạm tính:</span>
            <span class="totals-value"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <!-- Coupons -->
        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <div class="totals-row totals-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                <span class="totals-label"><?php wc_cart_totals_coupon_label($coupon); ?></span>
                <span class="totals-value text-success">-<?php wc_cart_totals_coupon_html($coupon); ?></span>
            </div>
        <?php endforeach; ?>

        <!-- Shipping -->
        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php do_action('woocommerce_review_order_before_shipping'); ?>
            <div class="totals-row totals-shipping">
                <span class="totals-label">Vận chuyển &amp; bảo hiểm rơi vỡ:</span>
                <span class="totals-value"><?php wc_cart_totals_shipping_html(); ?></span>
            </div>
            <?php do_action('woocommerce_review_order_after_shipping'); ?>
        <?php endif; ?>

        <!-- Fees -->
        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <div class="totals-row totals-fee">
                <span class="totals-label"><?php echo esc_html($fee->name); ?>:</span>
                <span class="totals-value"><?php wc_cart_totals_fee_html($fee); ?></span>
            </div>
        <?php endforeach; ?>

        <!-- Taxes -->
        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
            <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
                <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                    <div class="totals-row totals-tax tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                        <span class="totals-label"><?php echo esc_html($tax->label); ?>:</span>
                        <span class="totals-value"><?php echo wp_kses_post($tax->formatted_amount); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="totals-row totals-tax">
                    <span class="totals-label"><?php echo esc_html(WC()->countries->tax_or_vat()); ?>:</span>
                    <span class="totals-value"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Grand Total -->
        <?php do_action('woocommerce_review_order_before_order_total'); ?>
        <div class="totals-row totals-grand-total">
            <div>
                <span class="grand-total-label">Tổng thanh toán:</span>
                <span class="grand-total-sub text-muted d-block">Đã bao gồm VAT &amp; bảo hiểm vận chuyển</span>
            </div>
            <span class="grand-total-value"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>
        <?php do_action('woocommerce_review_order_after_order_total'); ?>

    </div>

</div>
