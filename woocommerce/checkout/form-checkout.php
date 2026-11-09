<?php
/**
 * Checkout Form - Simplified & Clean
 *
 * @package Gomie
 * @version 13.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<div class="gomie-checkout-wrapper">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="row g-4">
            
            <!-- Cột Trái: Thông tin giao hàng & Ghi chú (col-lg-7) -->
            <div class="col-lg-7">
                <div class="gomie-checkout-box p-4 bg-white rounded-3 shadow-sm border">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">Thông tin giao hàng</h5>

                    <div class="checkout-billing-fields">
                        <?php if ($checkout->get_checkout_fields()) : ?>
                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                            <div class="checkout-billing-inputs">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>

                            <!-- Ghi chú đơn hàng -->
                            <div class="order-notes-wrap mt-3 pt-3 border-top">
                                <label for="order_comments" class="form-label fw-semibold text-dark small mb-1">
                                    Ghi chú đơn hàng (tùy chọn)
                                </label>
                                <textarea name="order_comments" class="form-control" id="order_comments" placeholder="Lưu ý cho người bán hoặc shipper..." rows="2"></textarea>
                            </div>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Cột Phải: Tóm tắt đơn hàng & Thanh toán (col-lg-5) -->
            <div class="col-lg-5">
                <div class="gomie-order-summary-box p-4 bg-white rounded-3 shadow-sm border">
                    <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom">Đơn hàng của bạn</h5>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
