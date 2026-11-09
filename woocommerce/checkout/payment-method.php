<?php
/**
 * Output a single payment method - Simplified & Clean
 *
 * @package Gomie
 * @version 13.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$gateway_id = esc_attr($gateway->id);
?>

<li class="wc_payment_method payment_method_<?php echo $gateway_id; ?> gomie-payment-item mb-2">
    <label for="payment_method_<?php echo $gateway_id; ?>" class="gomie-payment-label d-flex align-items-center gap-3 p-3 rounded-3">
        <input id="payment_method_<?php echo $gateway_id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo $gateway_id; ?>" <?php checked($gateway->chosen, true); ?> data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>" />
        
        <span class="payment-title text-dark">
            <?php echo $gateway->get_title(); ?>
        </span>
    </label>

    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo $gateway_id; ?> p-3 small text-muted bg-light rounded-3 mt-1" <?php if (!$gateway->chosen) : ?>style="display:none;"<?php endif; ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
