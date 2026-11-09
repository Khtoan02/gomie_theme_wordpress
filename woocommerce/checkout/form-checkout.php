<?php
/**
 * Checkout Form - Gomie Ceramic Modern Editorial Design
 * Shopify/Apple-grade UX/UI with Clean 2-Column Architecture
 *
 * @package Gomie
 * @version 12.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

$current_user = wp_get_current_user();
?>

<div class="gomie-checkout-v12-wrapper">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <div class="row g-4 g-xl-5">
            
            <!-- Cột Trái: Thông tin nhận hàng & Yêu cầu đặc biệt (col-lg-7) -->
            <div class="col-lg-7">
                
                <!-- Card 1: Thông tin giao hàng -->
                <div class="gomie-checkout-card mb-4">
                    <div class="card-step-header d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                        <span class="step-circle">1</span>
                        <div>
                            <h3 class="step-title m-0 fw-bold fs-5 text-dark">Thông tin nhận hàng</h3>
                            <p class="step-sub text-muted m-0 small">Shipper sẽ gọi điện xác nhận trước khi giao hàng tận nơi</p>
                        </div>
                    </div>
                    
                    <div class="card-step-body">
                        <?php if (is_user_logged_in()) : ?>
                            <div class="checkout-user-welcome-alert mb-4 p-3 rounded-3 d-flex align-items-center gap-3">
                                <div class="welcome-icon-box">
                                    <i class="fa-solid fa-circle-check text-success fs-4"></i>
                                </div>
                                <div class="welcome-text-box">
                                    <div class="fw-semibold text-dark">
                                        Xin chào <strong><?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?></strong>!
                                    </div>
                                    <div class="text-muted small">
                                        Hệ thống đã tự động điền thông tin từ lần mua trước. Mọi cập nhật sẽ tự động lưu lại cho các đơn hàng sau.
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="checkout-guest-login-notice mb-4 p-3 rounded-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 text-muted small">
                                    <i class="fa-regular fa-user text-primary fs-5"></i>
                                    <span>Đã có tài khoản tại Gomie?</span>
                                </div>
                                <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="btn-guest-login-link small fw-semibold text-primary text-decoration-none">
                                    Đăng nhập để điền nhanh <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($checkout->get_checkout_fields()) : ?>
                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                            <div class="checkout-billing-fields">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Card 2: Ghi chú đơn hàng & Yêu cầu đóng gói -->
                <div class="gomie-checkout-card mb-4">
                    <div class="card-step-header d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                        <span class="step-circle step-circle-secondary">2</span>
                        <div>
                            <h3 class="step-title m-0 fw-bold fs-5 text-dark">Ghi chú &amp; Đóng gói đặc biệt</h3>
                            <p class="step-sub text-muted m-0 small">Dặn dò thời gian giao hàng hoặc yêu cầu bọc quà tặng</p>
                        </div>
                    </div>

                    <div class="card-step-body">
                        <div class="order-notes-wrap">
                            <label for="order_comments" class="form-label fw-semibold text-secondary d-flex align-items-center gap-2 mb-2">
                                <i class="fa-regular fa-comment-dots text-primary"></i> Lời nhắn cho người đóng gói &amp; Shipper:
                            </label>
                            <textarea name="order_comments" class="form-control gomie-textarea-custom" id="order_comments" placeholder="Ví dụ: Giao trong giờ hành chính, gọi trước 15 phút, bọc lót chống sốc nhiều lớp vì là quà tặng tân gia..." rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Cam kết bảo vệ quyền lợi khách hàng Gomie Ceramic -->
                <div class="gomie-guarantee-card p-4 rounded-4 mb-4">
                    <h5 class="fw-bold fs-6 text-dark d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-award text-primary fs-5"></i>
                        <span>Đặc quyền an tâm khi mua gốm tại Gomie</span>
                    </h5>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="guarantee-mini-item">
                                <i class="fa-solid fa-box-open text-primary mb-2 fs-5"></i>
                                <div class="fw-semibold text-dark small">Đồng kiểm 100%</div>
                                <div class="text-muted" style="font-size: 0.78rem;">Được mở hộp kiểm tra tận mắt trước khi thanh toán</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="guarantee-mini-item">
                                <i class="fa-solid fa-shield-virus text-primary mb-2 fs-5"></i>
                                <div class="fw-semibold text-dark small">Bảo hiểm nứt vỡ</div>
                                <div class="text-muted" style="font-size: 0.78rem;">Gomie đổi mới 100% miễn phí nếu kiện hàng gặp sự cố bể vỡ</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="guarantee-mini-item">
                                <i class="fa-solid fa-fire-burner text-primary mb-2 fs-5"></i>
                                <div class="fw-semibold text-dark small">Men nung 1.300°C</div>
                                <div class="text-muted" style="font-size: 0.78rem;">Khử sạch hoàn toàn chì &amp; kim loại nặng, an toàn sức khỏe</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Cột Phải: Tóm tắt đơn hàng + Phương thức thanh toán + Nút Hoàn tất (col-lg-5 Sticky) -->
            <div class="col-lg-5">
                <div class="gomie-checkout-sidebar-sticky">
                    
                    <div class="gomie-order-summary-card p-4 rounded-4 bg-white shadow-sm">
                        
                        <div class="summary-card-header d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                            <h4 class="m-0 fw-bold fs-5 text-dark d-flex align-items-center gap-2">
                                <i class="fa-solid fa-bag-shopping text-primary"></i>
                                <span>Đơn hàng của bạn</span>
                            </h4>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                                <?php echo WC()->cart->get_cart_contents_count(); ?> sản phẩm
                            </span>
                        </div>

                        <div class="summary-card-body">
                            <?php do_action('woocommerce_checkout_before_order_review'); ?>

                            <!-- Nơi WooCommerce render review-order.php VÀ payment.php -->
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>

                            <?php do_action('woocommerce_checkout_after_order_review'); ?>
                        </div>

                        <!-- Hotline hỗ trợ khách hàng tức thì -->
                        <div class="summary-hotline-box mt-4 p-3 rounded-3 text-center">
                            <span class="d-block text-muted small mb-1">Cần hỗ trợ tư vấn gấp về sản phẩm?</span>
                            <a href="tel:0335059889" class="fw-bold text-decoration-none hotline-link">
                                <i class="fa-solid fa-phone me-1"></i> 0335 059 889
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </form>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
