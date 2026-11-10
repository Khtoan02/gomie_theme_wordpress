<?php
/**
 * Template Name: Báo Giá Dự Án - Gomie Ceramic
 * Description: Trang yêu cầu báo giá dự án nhà hàng, khách sạn & quà tặng doanh nghiệp
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header();
?>

<div class="gomie-quote-page-canvas">
    
    <!-- 1. Breadcrumbs Bar -->
    <div class="gomie-quote-breadcrumbs py-3 bg-light-subtle border-bottom border-light-subtle">
        <div class="container">
            <div class="d-flex align-items-center gap-2 small text-muted">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                <span>/</span>
                <span class="text-dark fw-semibold">Báo giá dự án</span>
            </div>
        </div>
    </div>

    <!-- 2. Hero Section -->
    <section class="gomie-quote-hero py-5 text-center position-relative overflow-hidden" style="background: linear-gradient(180deg, #fff9f5 0%, #ffffff 100%);">
        <div class="container py-3">
            <span class="badge-kicker text-uppercase fw-bold px-3 py-1 rounded-pill small mb-3 d-inline-block" style="background: #fff0e6; color: #e0592a;">
                <i class="fa-solid fa-file-invoice-dollar me-1"></i> GIẢI PHÁP B2B &amp; QUÀ TẶNG DOANH NGHIỆP
            </span>
            <h1 class="hero-title fw-bold text-dark mb-3">
                Yêu Cầu Báo Giá <span class="text-orange">Dự Án Gốm Sứ Bát Tràng</span>
            </h1>
            <p class="hero-subtitle text-muted mx-auto mb-0" style="max-width: 720px; font-size: 1.05rem; line-height: 1.7;">
                Gomie Ceramic cung ứng trực tiếp từ xưởng lò 1.300°C Bát Tràng — không qua trung gian. Chiết khấu tối ưu, hỗ trợ in khắc logo nung bền vĩnh cửu và thiết kế hộp quà độc quyền theo nhận diện thương hiệu của bạn.
            </p>
        </div>
    </section>

    <!-- 3. Key Benefits for B2B Clients -->
    <section class="gomie-quote-benefits pb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="benefit-box p-3 rounded-4 bg-white border border-light-subtle text-center h-100 shadow-sm">
                        <div class="benefit-icon mb-2 text-orange fs-3">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <h5 class="fw-bold text-dark fs-6 mb-1">Giá Gốc Từ Lò Nung</h5>
                        <p class="text-muted small mb-0">Tiết kiệm 15% – 35% ngân sách dự án nhờ làm việc trực tiếp với xưởng.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="benefit-box p-3 rounded-4 bg-white border border-light-subtle text-center h-100 shadow-sm">
                        <div class="benefit-icon mb-2 text-primary fs-3">
                            <i class="fa-solid fa-stamp"></i>
                        </div>
                        <h5 class="fw-bold text-dark fs-6 mb-1">In Logo Chuẩn Màu</h5>
                        <p class="text-muted small mb-0">Nung chìm công nghệ nhiệt cao 1.300°C, không bong tróc qua ngàn lần rửa.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="benefit-box p-3 rounded-4 bg-white border border-light-subtle text-center h-100 shadow-sm">
                        <div class="benefit-icon mb-2 text-success fs-3">
                            <i class="fa-solid fa-truck-shield"></i>
                        </div>
                        <h5 class="fw-bold text-dark fs-6 mb-1">Bảo Hiểm Vận Chuyển</h5>
                        <p class="text-muted small mb-0">Cam kết 100% đền bù hoặc đổi mới nếu phát sinh sứt mẻ khi giao hàng.</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="benefit-box p-3 rounded-4 bg-white border border-light-subtle text-center h-100 shadow-sm">
                        <div class="benefit-icon mb-2 text-warning fs-3">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h5 class="fw-bold text-dark fs-6 mb-1">Thiết Kế Hộp Quà Riêng</h5>
                        <p class="text-muted small mb-0">Hộp xi lót lụa cao cấp dập nhũ vàng tạo ấn tượng đẳng cấp cho đối tác.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Quotation Form Section -->
    <section class="gomie-quote-form-section py-5 bg-white border-top border-light-subtle">
        <div class="container" style="max-width: 860px;">
            <div class="quote-form-wrapper p-4 p-md-5 rounded-4 border border-light-subtle bg-light-subtle shadow-sm">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark fs-4 mb-2">Biểu Mẫu Nhận Báo Giá Chi Tiết</h3>
                    <p class="text-muted small mb-0">Gửi thông tin nhu cầu, chuyên viên dự án của Gomie sẽ gửi bảng dự toán &amp; catalogue mẫu sau 15–30 phút.</p>
                </div>

                <form id="gomieQuotePageForm" class="gomie-quote-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                    <input type="hidden" name="action" value="gomie_contact_form">
                    <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="quote_name" class="form-label small fw-bold text-dark">Họ và tên người liên hệ *</label>
                            <input type="text" class="form-control rounded-3 py-2" id="quote_name" name="name" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quote_phone" class="form-label small fw-bold text-dark">Số điện thoại / Zalo *</label>
                            <input type="tel" class="form-control rounded-3 py-2" id="quote_phone" name="phone" placeholder="0912 345 678" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quote_company" class="form-label small fw-bold text-dark">Tên đơn vị / Nhà hàng / Doanh nghiệp</label>
                            <input type="text" class="form-control rounded-3 py-2" id="quote_company" name="company" placeholder="Tên công ty hoặc thương hiệu">
                        </div>
                        <div class="col-md-6">
                            <label for="quote_email" class="form-label small fw-bold text-dark">Email nhận báo giá</label>
                            <input type="email" class="form-control rounded-3 py-2" id="quote_email" name="email" placeholder="example@company.com">
                        </div>
                        <div class="col-md-6">
                            <label for="quote_type" class="form-label small fw-bold text-dark">Lĩnh vực dự án *</label>
                            <select class="form-select rounded-3 py-2" id="quote_type" name="interest_type" required>
                                <option value="nha-hang">Set Bát Đĩa Nhà Hàng &amp; Quán Ăn</option>
                                <option value="khach-san">Gốm Sứ Khách Sạn &amp; Resort Cao Cấp</option>
                                <option value="qua-tang-doanh-nghiep">Bộ Quà Tặng Doanh Nghiệp &amp; Tri Ân</option>
                                <option value="am-chen-in-logo">Bộ Ấm Chén In Logo</option>
                                <option value="dat-san-xuat-rieng">Đặt Chế Tác Riêng Theo Yêu Cầu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="quote_quantity" class="form-label small fw-bold text-dark">Số lượng dự kiến</label>
                            <select class="form-select rounded-3 py-2" id="quote_quantity" name="quantity_range">
                                <option value="10-50">10 – 50 bộ / sản phẩm</option>
                                <option value="50-200">50 – 200 bộ / sản phẩm</option>
                                <option value="200-500">200 – 500 bộ / sản phẩm</option>
                                <option value="500+">Trên 500 bộ / sản phẩm</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="quote_notes" class="form-label small fw-bold text-dark">Mô tả thêm yêu cầu (Ngân sách, thời hạn giao hàng, in logo...)</label>
                            <textarea class="form-control rounded-3" id="quote_notes" name="message" rows="3" placeholder="Ví dụ: Cần 100 bộ ấm chén men hỏa biến in logo giao trước ngày 20 tháng sau tại Hà Nội..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold text-white shadow-sm w-100 py-3" style="background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%); border: none;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Nhận Bảng Báo Giá &amp; Tư Vấn Ngay
                            </button>
                        </div>
                    </div>
                    <div class="quote-feedback-msg mt-3" style="display:none;"></div>
                </form>

            </div>
        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('gomieQuotePageForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        var feedback = form.querySelector('.quote-feedback-msg');
        var originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Đang gửi yêu cầu...';
        
        var formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            feedback.style.display = 'block';
            if (data.success) {
                feedback.className = 'quote-feedback-msg mt-3 alert alert-success rounded-3 small';
                feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu báo giá đã được chuyển đến bộ phận dự án B2B. Chuyên viên Gomie sẽ gửi bảng dự toán cho bạn ngay.';
                form.reset();
            } else {
                feedback.className = 'quote-feedback-msg mt-3 alert alert-danger rounded-3 small';
                feedback.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i> ' + (data.data || 'Có lỗi xảy ra, vui lòng liên hệ hotline (+84) 335 059 889');
            }
        })
        .catch(function(err) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            feedback.style.display = 'block';
            feedback.className = 'quote-feedback-msg mt-3 alert alert-success rounded-3 small';
            feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu của bạn đã được ghi nhận. Chuyên viên dự án sẽ liên hệ lại với bạn sớm nhất.';
            form.reset();
        });
    });
});
</script>

<?php
get_footer();
