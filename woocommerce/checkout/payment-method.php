<?php
/**
 * Output a single payment method - Gomie Ceramic Modern Editorial
 *
 * @package Gomie
 * @version 12.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$gateway_id = esc_attr($gateway->id);
$is_bank = in_array($gateway_id, array('bacs', 'vietqr', 'bank_transfer'));
$is_cod  = in_array($gateway_id, array('cod', 'cash_on_delivery'));
?>

<li class="wc_payment_method payment_method_<?php echo $gateway_id; ?> gomie-payment-card-item mb-3">
    <input id="payment_method_<?php echo $gateway_id; ?>" type="radio" class="input-radio gomie-payment-radio visually-hidden" name="payment_method" value="<?php echo $gateway_id; ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />

    <label for="payment_method_<?php echo $gateway_id; ?>" class="gomie-payment-card-label d-flex align-items-center justify-content-between p-3 rounded-3">
        <div class="d-flex align-items-center gap-3">
            <span class="gomie-custom-radio-circle"></span>
            
            <div class="payment-method-icon-box">
                <?php if ($is_bank) : ?>
                    <i class="fa-solid fa-qrcode text-primary fs-5"></i>
                <?php elseif ($is_cod) : ?>
                    <i class="fa-solid fa-hand-holding-dollar text-success fs-5"></i>
                <?php else : ?>
                    <i class="fa-regular fa-credit-card text-secondary fs-5"></i>
                <?php endif; ?>
            </div>

            <div class="payment-title-group">
                <span class="d-block fw-semibold text-dark payment-main-title">
                    <?php echo $gateway->get_title(); ?>
                </span>
                <?php if ($is_bank) : ?>
                    <span class="d-block text-muted small">Quét mã VietQR hoặc chuyển khoản 24/7</span>
                <?php elseif ($is_cod) : ?>
                    <span class="d-block text-muted small">Kiểm tra kiện hàng trước khi thanh toán tiền mặt</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="payment-badge-col text-end">
            <?php if ($is_bank) : ?>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-1 small fw-normal">
                    Khuyên dùng
                </span>
            <?php elseif ($is_cod) : ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small fw-normal">
                    Đồng kiểm
                </span>
            <?php else : ?>
                <?php echo $gateway->get_icon(); ?>
            <?php endif; ?>
        </div>
    </label>

    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo $gateway_id; ?> gomie-payment-desc-box p-3 rounded-bottom-3 mt-1" <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
