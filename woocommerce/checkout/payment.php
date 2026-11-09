<?php
/**
 * Checkout Payment Section - Simplified & Clean
 *
 * @package Gomie
 * @version 13.0.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment gomie-payment-clean-wrap mt-4 pt-3 border-top">
    
    <div class="payment-header mb-3">
        <h5 class="fw-bold fs-6 text-dark m-0">Phương thức thanh toán</h5>
    </div>

    <?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods list-unstyled p-0 m-0">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                }
            } else {
                echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info p-3 rounded-3 bg-light">';
                wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice');
                echo '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>

    <div class="form-row place-order mt-3">
        <noscript>
            <?php
            printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>"><?php esc_html_e('Update totals', 'woocommerce'); ?></button>
        </noscript>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <button type="submit" class="button alt btn-gomie-order-clean w-100" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place order', 'woocommerce'); ?>" data-value="<?php esc_attr_e('Place order', 'woocommerce'); ?>">
            <span class="fw-bold fs-6 main-text">Đặt hàng</span>
        </button>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>

</div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
