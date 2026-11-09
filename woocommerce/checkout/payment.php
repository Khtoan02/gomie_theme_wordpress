<?php
/**
 * Checkout Payment Section - Gomie Ceramic Modern Editorial
 * Custom payment gateway selector with card UI and prominent place order button
 *
 * @package Gomie
 * @version 12.0.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment gomie-payment-modern-wrap mt-4 pt-3 border-top">
    
    <div class="payment-section-header mb-3">
        <h5 class="fw-bold fs-6 text-dark d-flex align-items-center gap-2 mb-1">
            <i class="fa-solid fa-credit-card text-primary"></i>
            <span>Phương thức thanh toán</span>
        </h5>
        <p class="text-muted small m-0">Lựa chọn hình thức thanh toán an toàn, tiện lợi</p>
    </div>

    <?php if (WC()->cart && WC()->cart->needs_payment()) : ?>
        <ul class="wc_payment_methods payment_methods methods list-unstyled p-0 m-0 gomie-payment-methods-grid">
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

    <div class="form-row place-order mt-4">
        <noscript>
            <?php
            printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>"><?php esc_html_e('Update totals', 'woocommerce'); ?></button>
        </noscript>

        <!-- Terms & Policies Notice -->
        <div class="checkout-privacy-policy-text text-muted mb-3" style="font-size: 0.82rem; line-height: 1.5;">
            <i class="fa-solid fa-shield-halved text-success me-1"></i>
            Thông tin cá nhân của bạn được bảo mật tuyệt đối. Bằng cách đặt hàng, bạn đồng ý với <a href="<?php echo esc_url(home_url('/policy/')); ?>" target="_blank" class="text-decoration-underline text-secondary">Chính sách bảo mật</a> và <a href="<?php echo esc_url(home_url('/chinh-sach-doi-tra/')); ?>" target="_blank" class="text-decoration-underline text-secondary">Chính sách đồng kiểm &amp; đổi trả</a> của Gomie Ceramic.
        </div>

        <?php do_action('woocommerce_review_order_before_submit'); ?>

        <!-- Premium Place Order Button -->
        <button type="submit" class="button alt btn-gomie-place-order w-100" name="woocommerce_checkout_place_order" id="place_order" value="<?php esc_attr_e('Place order', 'woocommerce'); ?>" data-value="<?php esc_attr_e('Place order', 'woocommerce'); ?>">
            <div class="btn-order-main-text d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-lock"></i>
                <span class="fw-bold fs-5 main-text">HOÀN TẤT ĐẶT HÀNG</span>
            </div>
            <span class="btn-order-sub-text d-block sub-text">Đồng kiểm tận tay · Bảo hiểm rơi vỡ 100%</span>
        </button>

        <?php do_action('woocommerce_review_order_after_submit'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
    </div>

    <!-- Trust Badges Footer -->
    <div class="payment-trust-footer mt-3 pt-3 border-top text-center">
        <div class="d-flex justify-content-center align-items-center flex-wrap gap-3 text-muted" style="font-size: 0.8rem;">
            <span><i class="fa-solid fa-fire-burner text-primary me-1"></i> Nung khử 1.300°C</span>
            <span><i class="fa-solid fa-box-open text-primary me-1"></i> Kiểm hàng trước khi nhận</span>
            <span><i class="fa-solid fa-rotate-left text-primary me-1"></i> 1 đổi 1 trong 7 ngày</span>
        </div>
    </div>

</div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
