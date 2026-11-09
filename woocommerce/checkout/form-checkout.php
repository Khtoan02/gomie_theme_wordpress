<?php
/**
 * Checkout Form - Gomie Theme Custom Design
 * Professional checkout design matching cart page styling
 *
 * @package Gomie
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<div class="gomie-checkout-container">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="checkout-content-wrapper">
            <!-- Checkout Fields -->
            <div class="checkout-fields-section">
                <!-- Customer Information -->
                <div class="checkout-section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            <span>Thông tin khách hàng</span>
                        </div>
                    </div>

                    <div class="section-content">
                        <?php if ($checkout->get_checkout_fields()) : ?>
                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                            <div class="checkout-billing-fields">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>

                            <?php if (WC()->cart->needs_shipping_address()) : ?>
                                <div class="checkout-shipping-fields">
                                    <h3>Địa chỉ giao hàng</h3>
                                    <?php do_action('woocommerce_checkout_shipping'); ?>
                                </div>
                            <?php endif; ?>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="checkout-section-card">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            <span>Thông tin bổ sung</span>
                        </div>
                    </div>

                    <div class="section-content">
                        <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                        
                        <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_checkout_order_notes_field'))) : ?>
                            <div class="order-notes-section">
                                <label for="order_comments">Ghi chú đơn hàng (tùy chọn)</label>
                                <textarea name="order_comments" class="input-text" id="order_comments" placeholder="Ghi chú về đơn hàng của bạn, ví dụ: yêu cầu đặc biệt cho việc giao hàng..." rows="4"></textarea>
                            </div>
                        <?php endif; ?>

                        <?php do_action('woocommerce_checkout_after_order_review_heading'); ?>
                    </div>
                </div>
            </div>

            <!-- Order Review -->
            <div class="checkout-review-section">
                <div class="order-review-card">
                    <!-- Order Review Header -->
                    <div class="section-header">
                        <div class="section-title">
                            <i class="fas fa-receipt"></i>
                            <span>Xem lại đơn hàng</span>
                        </div>
                        <div class="section-badge">
                            <?php echo WC()->cart->get_cart_contents_count(); ?> sản phẩm
                        </div>
                    </div>

                    <!-- Order Review Content -->
                    <div class="order-review-content">
                        <?php do_action('woocommerce_checkout_before_order_review'); ?>

                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>

                        <?php do_action('woocommerce_checkout_after_order_review'); ?>
                    </div>

                    <!-- Payment Methods -->
                    <div class="payment-section">
                        <div class="payment-header">
                            <i class="fas fa-credit-card"></i>
                            <span>Phương thức thanh toán</span>
                        </div>

                        <div class="payment-methods">
                            <?php if (WC()->cart->needs_payment()) : ?>
                                <ul class="wc_payment_methods payment_methods methods">
                                    <?php
                                    if (!empty($available_gateways = WC()->payment_gateways()->get_available_payment_gateways())) {
                                        foreach ($available_gateways as $gateway) {
                                            wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                                        }
                                    } else {
                                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')) . '</li>'; // @codingStandardsIgnoreLine
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Terms and Privacy -->
                        <div class="checkout-terms">
                            <?php do_action('woocommerce_checkout_terms_and_conditions'); ?>
                        </div>

                        <!-- Place Order Button -->
                        <div class="place-order-section">
                            <?php do_action('woocommerce_review_order_before_submit'); ?>

                            <button type="submit" class="button alt place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place order', 'woocommerce'); ?>" data-value="<?php esc_attr_e('Place order', 'woocommerce'); ?>">
                                <div class="button-content">
                                    <div class="button-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="button-text">
                                        <span class="main-text"><?php echo apply_filters('woocommerce_order_button_text', esc_html__('Đặt hàng', 'woocommerce')); ?></span>
                                        <span class="sub-text">Thanh toán an toàn</span>
                                    </div>
                                    <div class="button-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </button>

                            <?php do_action('woocommerce_review_order_after_submit'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

