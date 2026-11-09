<?php
/**
 * Cart Page - Gomie Theme Custom Design
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="gomie-cart-container">
    <?php if ( WC()->cart->is_empty() ) : ?>
        <div class="cart-empty-state">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>Giỏ hàng trống</h2>
            <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
            <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="btn-continue-shopping">
                <i class="fas fa-arrow-left"></i>
                Tiếp tục mua sắm
            </a>
        </div>
    <?php else : ?>

    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div class="cart-content-wrapper">
            <!-- Cart Items Section -->
            <div class="cart-items-section">
                <div class="cart-items-header">
                    <div class="section-title">
                        <i class="fas fa-shopping-basket"></i>
                        <span>Sản phẩm trong giỏ hàng</span>
                    </div>
                    <div class="section-badge">
                        <?php echo WC()->cart->get_cart_contents_count(); ?> sản phẩm
                    </div>
                </div>

                <div class="cart-items-container">
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>
                            <div class="cart-item-card" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                <div class="cart-item-image">
                                    <?php
                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                    if ( ! $product_permalink ) {
                                        echo $thumbnail; // PHPCS: XSS ok.
                                    } else {
                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                    }
                                    ?>
                                </div>
                                
                                <div class="cart-item-details">
                                    <div class="cart-item-info">
                                        <h4 class="cart-item-name">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }

                                            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                            // Backorder notification.
                                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                            }
                                            ?>
                                        </h4>
                                        
                                        <div class="cart-item-price-single">
                                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
                                            <span class="price-label">/ sản phẩm</span>
                                        </div>
                                    </div>

                                    <div class="cart-item-actions">
                                        <div class="quantity-controls">
                                            <label for="quantity_<?php echo esc_attr( $cart_item_key ); ?>" class="screen-reader-text">Số lượng</label>
                                            <div class="quantity-input-wrapper">
                                                <button type="button" class="qty-decrease" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <?php
                                                if ( $_product->is_sold_individually() ) {
                                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                                } else {
                                                    $product_quantity = woocommerce_quantity_input(
                                                        array(
                                                            'input_name'   => "cart[{$cart_item_key}][qty]",
                                                            'input_value'  => $cart_item['quantity'],
                                                            'max_value'    => $_product->get_max_purchase_quantity(),
                                                            'min_value'    => '0',
                                                            'product_name' => $_product->get_name(),
                                                        ),
                                                        $_product,
                                                        false
                                                    );
                                                }
                                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                                ?>
                                                <button type="button" class="qty-increase" data-cart-key="<?php echo esc_attr( $cart_item_key ); ?>">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="cart-item-total">
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
                                        </div>

                                        <div class="cart-item-remove">
                                            <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove-item" aria-label="%s" data-product_id="%s" data-product_sku="%s" title="Xóa sản phẩm"><i class="fas fa-trash"></i></a>',
                                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                    esc_html__( 'Remove this item', 'woocommerce' ),
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() )
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                </div>

                <div class="cart-actions-bottom">                    
                    <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="btn-continue-shopping-inline">
                        <i class="fas fa-arrow-left"></i>
                        Tiếp tục mua sắm
                    </a>

                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>
            </div>

            <!-- Cart Summary Section - Enhanced UX/UI -->
            <div class="cart-summary-section">
                <div class="cart-summary-card">
                    <!-- Summary Header -->
                    <div class="summary-header">
                        <div class="section-title">
                            <i class="fas fa-receipt"></i>
                            <span>Chi tiết đơn hàng</span>
                        </div>
                        <div class="section-badge">
                            <?php echo WC()->cart->get_cart_contents_count(); ?> sản phẩm
                        </div>
                    </div>

                    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

                    <!-- Cart Totals -->
                    <div class="cart-totals-container">
                        <div class="cart-totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
                            <?php do_action( 'woocommerce_before_cart_contents_total' ); ?>

                            <div class="summary-row subtotal-row">
                                <div class="row-content">
                                    <span class="label">
                                        <i class="fas fa-shopping-basket"></i>
                                        Tạm tính
                                    </span>
                                    <span class="value"><?php wc_cart_totals_subtotal_html(); ?></span>
                                </div>
                            </div>

                            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                                <div class="summary-row coupon-row">
                                    <div class="row-content">
                                        <span class="label">
                                            <i class="fas fa-tag"></i>
                                            <?php wc_cart_totals_coupon_label( $coupon ); ?>
                                            <a href="<?php echo esc_url( add_query_arg( 'remove_coupon', urlencode( $code ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ); ?>" class="remove-coupon" title="Xóa mã giảm giá">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </span>
                                        <span class="value discount-value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if ( WC()->cart->needs_shipping() ) : ?>
                                <div class="summary-row shipping-row">
                                    <div class="row-content">
                                        <span class="label">
                                            <i class="fas fa-truck"></i>
                                            Phí vận chuyển
                                        </span>
                                        <span class="value shipping-value">
                                            <span class="calculated-at-checkout">Tính ở trang thanh toán</span>
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                <div class="summary-row fee-row">
                                    <div class="row-content">
                                        <span class="label">
                                            <i class="fas fa-plus-circle"></i>
                                            <?php echo esc_html( $fee->name ); ?>
                                        </span>
                                        <span class="value"><?php wc_cart_totals_fee_html( $fee ); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php
                        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
                            $taxable_address = WC()->customer->get_taxable_address();
                            $estimated_text  = '';

                            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                                /* translators: %s location. */
                                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
                            }

                            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                    ?>
                                    <div class="summary-row tax-row">
                                        <div class="row-content">
                                            <span class="label">
                                                <i class="fas fa-percentage"></i>
                                                <?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            </span>
                                            <span class="value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="summary-row tax-row">
                                    <div class="row-content">
                                        <span class="label">
                                            <i class="fas fa-percentage"></i>
                                            <?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </span>
                                        <span class="value"><?php wc_cart_totals_taxes_total_html(); ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>

                            <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

                            <!-- Total Row - Prominent -->
                            <div class="summary-row total-row">
                                <div class="row-content">
                                    <span class="label">
                                        <i class="fas fa-calculator"></i>
                                        <?php esc_html_e( 'Tổng cộng', 'woocommerce' ); ?>
                                    </span>
                                    <span class="value total-value"><?php wc_cart_totals_order_total_html(); ?></span>
                                </div>
                            </div>

                            <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
                        </div>
                    </div>

                    <!-- Coupon Section - Enhanced -->
                    <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon-section">
                            <div class="coupon-header">
                                <i class="fas fa-percentage"></i>
                                <span>Mã giảm giá</span>
                            </div>
                            <div class="coupon-form">
                                <div class="input-group">
                                    <input type="text" name="coupon_code" class="coupon-input" id="coupon_code" value="" placeholder="Nhập mã giảm giá..." />
                                    <button type="submit" class="btn-apply-coupon" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
                                        <i class="fas fa-check"></i>
                                        Áp dụng
                                    </button>
                                </div>
                            </div>
                            <!-- Coupon message container -->
                            <div class="coupon-messages-container"></div>
                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                    <?php } ?>

                    <!-- Enhanced Checkout Section -->
                    <div class="checkout-section">
                        <div class="security-badges">
                            <div class="security-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Thanh toán bảo mật</span>
                            </div>
                            <div class="security-item">
                                <i class="fas fa-lock"></i>
                                <span>Mã hóa SSL</span>
                            </div>
                        </div>
                        
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button-enhanced">
                            <div class="button-content">
                                <div class="button-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="button-text">
                                    <span class="main-text"><?php esc_html_e( 'Tiến hành thanh toán', 'woocommerce' ); ?></span>
                                    <span class="sub-text">Bảo mật & Nhanh chóng</span>
                                </div>
                                <div class="button-arrow">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php do_action( 'woocommerce_after_cart_totals' ); ?>
                </div>
            </div>
        </div>

        <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
