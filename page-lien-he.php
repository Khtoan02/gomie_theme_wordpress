<?php
/**
 * Template Name: Liên Hệ - Gomie Ceramic
 * Description: Trang liên hệ, trải nghiệm showroom và tư vấn gốm sứ Bát Tràng
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header();
?>

<div class="gomie-contact-page-canvas">
    
    <!-- 1. Breadcrumbs Bar -->
    <div class="gomie-contact-breadcrumbs py-3 bg-light-subtle border-bottom border-light-subtle">
        <div class="container">
            <div class="d-flex align-items-center gap-2 small text-muted">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-muted"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                <span>/</span>
                <span class="text-dark fw-semibold">Liên hệ</span>
            </div>
        </div>
    </div>

    <!-- 2. Hero Section -->
    <section class="gomie-contact-hero py-5 text-center position-relative overflow-hidden">
        <div class="container py-2">
            <span class="badge-kicker text-uppercase fw-bold px-3 py-1 rounded-pill small mb-3 d-inline-block">
                <i class="fa-solid fa-feather-pointed me-1"></i> GOMIE CERAMIC · KẾT NỐI &amp; TƯ VẤN
            </span>
            <h1 class="hero-title fw-bold text-dark mb-3">
                Lắng Nghe &amp; Đồng Hành Cùng <span class="text-orange">Mọi Không Gian</span>
            </h1>
            <p class="hero-subtitle text-muted mx-auto mb-0" style="max-width: 680px; font-size: 1.05rem; line-height: 1.7;">
                Dù bạn tìm kiếm bộ gốm sứ mộc mạc cho bữa cơm gia đình hay giải pháp bàn tiệc độc bản cho chuỗi nhà hàng, resort cao cấp — Gomie luôn sẵn sàng lắng nghe và chế tác riêng theo mong muốn của bạn.
            </p>
        </div>
    </section>

    <!-- 3. Direct Contact Channels (3 Columns Grid) -->
    <section class="gomie-contact-channels pb-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Channel 1: Hà Nội -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-channel-card p-4 rounded-4 bg-white border border-light-subtle h-100 shadow-sm transition-all">
                        <div class="channel-icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(224, 89, 42, 0.1); color: #e0592a; font-size: 1.25rem;">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h4 class="channel-title fw-bold text-dark fs-5 mb-2">Showroom &amp; Xưởng Hà Nội</h4>
                        <p class="channel-desc text-muted small mb-3">Trải nghiệm cốt đất Bát Tràng và chiêm ngưỡng các bộ sưu tập men hỏa biến nung 1.300°C thực tế.</p>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-map-pin text-orange me-2"></i> <strong>Xưởng sản xuất:</strong> Làng gốm cổ Bát Tràng, Gia Lâm, Hà Nội</li>
                            <li><i class="fa-solid fa-building text-orange me-2"></i> <strong>Văn phòng:</strong> 41b, Ngõ 106 Hoàng Quốc Việt, Cầu Giấy, Hà Nội</li>
                            <li><i class="fa-solid fa-phone text-orange me-2"></i> <a href="tel:+84335059889" class="text-decoration-none text-dark fw-semibold">(+84) 335 059 889</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Channel 2: TP. Hồ Chí Minh -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-channel-card p-4 rounded-4 bg-white border border-light-subtle h-100 shadow-sm transition-all">
                        <div class="channel-icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1); color: #0284c7; font-size: 1.25rem;">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <h4 class="channel-title fw-bold text-dark fs-5 mb-2">Showroom TP. Hồ Chí Minh</h4>
                        <p class="channel-desc text-muted small mb-3">Trung tâm phân phối &amp; trưng bày mẫu gốm sứ cao cấp phục vụ khu vực miền Nam.</p>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-map-pin text-primary me-2"></i> <strong>Địa chỉ:</strong> Tòa nhà Phúc Tấn Nguyên, 400 Nguyễn Thị Thập, P. Tân Hưng, Quận 7, TP. HCM</li>
                            <li><i class="fa-solid fa-clock text-primary me-2"></i> <strong>Giờ mở cửa:</strong> 08:30 – 21:00 (Hàng ngày)</li>
                            <li><i class="fa-solid fa-phone text-primary me-2"></i> <a href="tel:+84335059889" class="text-decoration-none text-dark fw-semibold">(+84) 335 059 889</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Channel 3: Hỗ Trợ Dự Án & Doanh Nghiệp -->
                <div class="col-lg-4 col-md-12">
                    <div class="contact-channel-card p-4 rounded-4 bg-white border border-light-subtle h-100 shadow-sm transition-all">
                        <div class="channel-icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(16, 185, 129, 0.1); color: #059669; font-size: 1.25rem;">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4 class="channel-title fw-bold text-dark fs-5 mb-2">Tư Vấn B2B &amp; Khách Hàng</h4>
                        <p class="channel-desc text-muted small mb-3">Kênh hỗ trợ chuyên sâu cho đối tác nhà hàng, khách sạn, quà tặng doanh nghiệp &amp; CSKH.</p>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li><i class="fa-solid fa-envelope text-success me-2"></i> <strong>Email hỗ trợ:</strong> <a href="mailto:cskh@gomie.vn" class="text-decoration-none text-dark">cskh@gomie.vn</a></li>
                            <li><i class="fa-solid fa-envelope-open-text text-success me-2"></i> <strong>Dự án B2B:</strong> <a href="mailto:support@gomie.vn" class="text-decoration-none text-dark">support@gomie.vn</a></li>
                            <li><i class="fa-solid fa-comment-dots text-success me-2"></i> <strong>Zalo Official:</strong> Gomie Ceramic Bát Tràng</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Interactive Contact Form & Brand Pillars -->
    <section class="gomie-contact-main-section py-5 bg-white border-top border-light-subtle">
        <div class="container">
            <div class="row g-5 align-items-start">
                
                <!-- Left: Form -->
                <div class="col-lg-7">
                    <div class="contact-form-card p-4 p-md-5 rounded-4 border border-light-subtle bg-light-subtle shadow-sm">
                        <div class="form-header mb-4">
                            <span class="badge px-3 py-1 rounded-pill small fw-semibold mb-2" style="background: #f47a20; color: #ffffff;">Gửi Tin Nhắn Cho Gomie</span>
                            <h3 class="fw-bold text-dark fs-4 mb-2">Chúng Tôi Có Thể Hỗ Trợ Gì Cho Bạn?</h3>
                            <p class="text-muted small mb-0">Điền thông tin bên dưới, chuyên viên Gomie sẽ liên hệ lại trong vòng 30 phút làm việc.</p>
                        </div>

                        <form id="gomieDirectContactForm" class="gomie-contact-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                            <input type="hidden" name="action" value="gomie_contact_form">
                            <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_name" class="form-label small fw-bold text-dark">Họ và tên *</label>
                                    <input type="text" class="form-control rounded-3 py-2" id="contact_name" name="name" placeholder="Nguyễn Văn A" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label small fw-bold text-dark">Số điện thoại *</label>
                                    <input type="tel" class="form-control rounded-3 py-2" id="contact_phone" name="phone" placeholder="0912 345 678" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label small fw-bold text-dark">Địa chỉ Email</label>
                                    <input type="email" class="form-control rounded-3 py-2" id="contact_email" name="email" placeholder="example@gmail.com">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_type" class="form-label small fw-bold text-dark">Nhu cầu tư vấn</label>
                                    <select class="form-select rounded-3 py-2" id="contact_type" name="interest_type">
                                        <option value="ca-nhan">Gốm sứ gia đình &amp; Bàn ăn</option>
                                        <option value="nha-hang">Giải pháp Nhà hàng &amp; Quán Cafe</option>
                                        <option value="khach-san">Giải pháp Khách sạn &amp; Resort</option>
                                        <option value="qua-tang">Quà tặng doanh nghiệp (In logo)</option>
                                        <option value="khac">Yêu cầu chế tác theo thiết kế riêng</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="contact_message" class="form-label small fw-bold text-dark">Chi tiết yêu cầu *</label>
                                    <textarea class="form-control rounded-3" id="contact_message" name="message" rows="4" placeholder="Vui lòng chia sẻ số lượng dự kiến, loại sản phẩm hoặc mong muốn của bạn..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold text-white shadow-sm w-100 py-3" style="background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%); border: none;">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Tư Vấn Ngay
                                    </button>
                                </div>
                            </div>
                            <div class="contact-feedback-msg mt-3" style="display:none;"></div>
                        </form>
                    </div>
                </div>

                <!-- Right: Why Choose Gomie -->
                <div class="col-lg-5">
                    <div class="contact-pledge-box ps-lg-3">
                        <span class="text-orange fw-bold text-uppercase small tracking-wide">Cam Kết Từ Nghệ Nhân</span>
                        <h3 class="fw-bold text-dark fs-4 mt-1 mb-4">An Tâm Tuyệt Đối Khi Đồng Hành Cùng Gomie</h3>

                        <div class="pledge-list d-flex flex-column gap-4">
                            
                            <div class="pledge-item d-flex gap-3 align-items-start">
                                <div class="pledge-badge-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #fff4ed; color: #e0592a; font-size: 1.15rem;">
                                    <i class="fa-solid fa-fire"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">Nung Khử 1.300°C Khử Hoàn Toàn Chì</h5>
                                    <p class="text-muted small mb-0">Loại bỏ 100% độc tố chì và cadmium theo tiêu chuẩn an toàn thực phẩm QUATEST 1, bảo vệ sức khỏe trọn vẹn.</p>
                                </div>
                            </div>

                            <div class="pledge-item d-flex gap-3 align-items-start">
                                <div class="pledge-badge-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb; font-size: 1.15rem;">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">Bảo Hiểm Vận Chuyển Vỡ Hỏng 100%</h5>
                                    <p class="text-muted small mb-0">Bất kỳ sự cố nứt vỡ nào trong quá trình vận chuyển đều được Gomie gửi bù sản phẩm mới nguyên vẹn ngay lập tức.</p>
                                </div>
                            </div>

                            <div class="pledge-item d-flex gap-3 align-items-start">
                                <div class="pledge-badge-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #f0fdf4; color: #16a34a; font-size: 1.15rem;">
                                    <i class="fa-solid fa-stamp"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">In Ấn Khắc Logo &amp; Hộp Quà Theo Yêu Cầu</h5>
                                    <p class="text-muted small mb-0">Hỗ trợ thiết kế và nung chìm logo thương hiệu bền màu vĩnh cửu cùng men sứ cho các dự án quà tặng và F&amp;B.</p>
                                </div>
                            </div>

                            <div class="pledge-item d-flex gap-3 align-items-start">
                                <div class="pledge-badge-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: #faf5ff; color: #9333ea; font-size: 1.15rem;">
                                    <i class="fa-solid fa-hand-holding-heart"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark fs-6 mb-1">100% Vuốt Nặn &amp; Chế Tác Thủ Công</h5>
                                    <p class="text-muted small mb-0">Mỗi tác phẩm gốm là một bản thể độc nhất vô nhị mang trọn dấu ấn bàn tay nghệ nhân Bát Tràng.</p>
                                </div>
                            </div>

                        </div>

                        <!-- Quick Hotline Banner -->
                        <div class="hotline-quick-call p-3 rounded-4 mt-4 text-center" style="background: #faf6f0; border: 1px dashed rgba(224, 89, 42, 0.4);">
                            <span class="text-muted small d-block mb-1">Cần tư vấn nhanh gấp? Gọi ngay hotline:</span>
                            <a href="tel:+84335059889" class="text-orange fw-bold fs-5 text-decoration-none">
                                <i class="fa-solid fa-phone-volume me-2"></i> (+84) 335 059 889
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('gomieDirectContactForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        var feedback = form.querySelector('.contact-feedback-msg');
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
                feedback.className = 'contact-feedback-msg mt-3 alert alert-success rounded-3 small';
                feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu đã được gửi thành công. Chuyên viên Gomie sẽ liên hệ lại ngay.';
                form.reset();
            } else {
                feedback.className = 'contact-feedback-msg mt-3 alert alert-danger rounded-3 small';
                feedback.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-2"></i> ' + (data.data || 'Có lỗi xảy ra, vui lòng liên hệ hotline (+84) 335 059 889');
            }
        })
        .catch(function(err) {
            btn.disabled = false;
            btn.innerHTML = originalText;
            feedback.style.display = 'block';
            feedback.className = 'contact-feedback-msg mt-3 alert alert-success rounded-3 small';
            feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu của bạn đã được ghi nhận. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.';
            form.reset();
        });
    });
});
</script>

<?php
get_footer();
