<?php
/**
 * Template Name: Liên Hệ - Gomie Ceramic
 * Description: Trang liên hệ, trải nghiệm showroom và tư vấn gốm sứ Bát Tràng chuẩn Quiet Luxury Editorial V11
 *
 * @package Gomie
 * @version 2.2.0
 */

defined('ABSPATH') || exit;

get_header();

$theme_uri = get_template_directory_uri();
$hotline = function_exists('gomie_get_option') ? gomie_get_option('phone_number', '(+84) 335 059 889') : '(+84) 335 059 889';
$email = function_exists('gomie_get_option') ? gomie_get_option('email_address', 'support@gomie.vn') : 'support@gomie.vn';
$cskh_email = 'cskh@gomie.vn';
$zalo_url = function_exists('gomie_get_option') ? gomie_get_option('zalo_url', 'https://zalo.me/0335059889') : 'https://zalo.me/0335059889';
?>

<div class="gomie-contact-page-canvas">
    
    <!-- 1. Hero & Breadcrumbs Section (Quiet Luxury Editorial V11) -->
    <section class="contact-hero-section text-center">
        <div class="container">
            <!-- Breadcrumbs Trong Suốt Đồng Bộ Toàn Site -->
            <nav class="contact-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Liên hệ &amp; Tư vấn</li>
                </ol>
            </nav>

            <!-- Kicker Badge -->
            <div class="contact-badge-wrap mb-3">
                <span class="contact-pill-badge">
                    <i class="fa-solid fa-feather-pointed me-2"></i> GOMIE CERAMIC · KẾT NỐI &amp; TƯ VẤN
                </span>
            </div>

            <!-- Main Title -->
            <h1 class="contact-hero-title">
                Lắng Nghe &amp; Đồng Hành Cùng <br><span class="highlight-orange">Mọi Không Gian</span>
            </h1>

            <!-- Hero Subtitle -->
            <p class="contact-hero-desc mx-auto">
                Dù bạn tìm kiếm bộ gốm sứ mộc mạc cho bữa cơm gia đình hay giải pháp bàn tiệc độc bản cho chuỗi nhà hàng, resort cao cấp — Gomie luôn sẵn sàng lắng nghe và chế tác riêng theo mong muốn của bạn.
            </p>

            <!-- Trust Pills -->
            <div class="contact-trust-bar d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="contact-trust-item">
                    <i class="fa-solid fa-location-dot text-orange"></i>
                    <span>2 Showroom Hà Nội &amp; TP.HCM</span>
                </div>
                <div class="contact-trust-item">
                    <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                    <span>Phản hồi tư vấn trong 30 phút</span>
                </div>
                <div class="contact-trust-item">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                    <span>Bảo hiểm 100% bể vỡ giao hàng</span>
                </div>
                <div class="contact-trust-item">
                    <i class="fa-solid fa-wand-magic-sparkles text-warning"></i>
                    <span>Chế tác độc bản theo yêu cầu</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Direct Contact Channels (3 Glassmorphism Cards) -->
    <section class="contact-channels-section py-4 py-lg-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <!-- Channel 1: Hà Nội -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-channel-card h-100 p-4">
                        <div class="channel-icon-circle icon-orange mb-3">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h3 class="channel-title fw-bold text-dark fs-5 mb-2">Showroom &amp; Xưởng Hà Nội</h3>
                        <p class="channel-desc text-muted small mb-3">Trải nghiệm cốt đất Bát Tràng và chiêm ngưỡng các bộ sưu tập men hỏa biến nung 1.300°C thực tế.</p>
                        <div class="channel-divider mb-3"></div>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-map-pin text-orange mt-1"></i>
                                <span><strong>Xưởng sản xuất:</strong> Làng gốm cổ Bát Tràng, Gia Lâm, Hà Nội</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-building text-orange mt-1"></i>
                                <span><strong>Văn phòng:</strong> 41b, Ngõ 106 Hoàng Quốc Việt, Cầu Giấy, Hà Nội</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-phone text-orange mt-1"></i>
                                <span><strong>Hotline:</strong> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>" class="text-decoration-none text-dark fw-bold"><?php echo esc_html($hotline); ?></a></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Channel 2: TP. Hồ Chí Minh -->
                <div class="col-lg-4 col-md-6">
                    <div class="contact-channel-card h-100 p-4">
                        <div class="channel-icon-circle icon-blue mb-3">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <h3 class="channel-title fw-bold text-dark fs-5 mb-2">Showroom TP. Hồ Chí Minh</h3>
                        <p class="channel-desc text-muted small mb-3">Trung tâm phân phối &amp; trưng bày mẫu gốm sứ cao cấp phục vụ đối tác và khách hàng khu vực miền Nam.</p>
                        <div class="channel-divider mb-3"></div>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-map-pin text-primary mt-1"></i>
                                <span><strong>Địa chỉ:</strong> Tòa nhà Phúc Tấn Nguyên, 400 Nguyễn Thị Thập, P. Tân Hưng, Quận 7, TP. HCM</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-clock text-primary mt-1"></i>
                                <span><strong>Giờ mở cửa:</strong> 08:30 – 21:00 (Hàng ngày)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-phone text-primary mt-1"></i>
                                <span><strong>Hotline:</strong> <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>" class="text-decoration-none text-dark fw-bold"><?php echo esc_html($hotline); ?></a></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Channel 3: Hỗ Trợ Dự Án & B2B -->
                <div class="col-lg-4 col-md-12">
                    <div class="contact-channel-card h-100 p-4">
                        <div class="channel-icon-circle icon-green mb-3">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="channel-title fw-bold text-dark fs-5 mb-2">Tư Vấn B2B &amp; Khách Hàng</h3>
                        <p class="channel-desc text-muted small mb-3">Kênh hỗ trợ chuyên sâu cho đối tác nhà hàng, khách sạn, quà tặng doanh nghiệp &amp; chăm sóc khách hàng.</p>
                        <div class="channel-divider mb-3"></div>
                        <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-envelope text-success mt-1"></i>
                                <span><strong>Email CSKH:</strong> <a href="mailto:<?php echo esc_attr($cskh_email); ?>" class="text-decoration-none text-dark"><?php echo esc_html($cskh_email); ?></a></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-envelope-open-text text-success mt-1"></i>
                                <span><strong>Dự án B2B:</strong> <a href="mailto:<?php echo esc_attr($email); ?>" class="text-decoration-none text-dark"><?php echo esc_html($email); ?></a></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <i class="fa-solid fa-comment-dots text-success mt-1"></i>
                                <span><strong>Zalo tư vấn:</strong> <a href="<?php echo esc_url($zalo_url); ?>" target="_blank" rel="noopener" class="text-decoration-none text-dark fw-bold">Gomie Ceramic Bát Tràng</a></span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Form Section & Brand Commitments -->
    <section class="contact-form-section pb-5">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start">
                
                <!-- Left: Premium Contact Form Card -->
                <div class="col-lg-7">
                    <div class="contact-form-box p-4 p-md-5">
                        <div class="form-header mb-4">
                            <span class="sub-label-orange mb-2">GỬI TIN NHẮN TRỰC TIẾP</span>
                            <h2 class="form-title fw-bold text-dark mb-2">Chúng Tôi Có Thể Hỗ Trợ Gì Cho Bạn?</h2>
                            <p class="text-muted small mb-0">Điền thông tin bên dưới, chuyên viên Gomie sẽ liên hệ lại tư vấn và gửi báo giá trong vòng 30 phút làm việc.</p>
                        </div>

                        <form id="gomieDirectContactForm" class="gomie-contact-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                            <input type="hidden" name="action" value="gomie_contact_form">
                            <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_name" class="form-label small fw-bold text-dark">Họ và tên *</label>
                                    <input type="text" class="form-control custom-input" id="contact_name" name="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label small fw-bold text-dark">Số điện thoại / Zalo *</label>
                                    <input type="tel" class="form-control custom-input" id="contact_phone" name="phone" placeholder="Ví dụ: 0912 345 678" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label small fw-bold text-dark">Địa chỉ Email</label>
                                    <input type="email" class="form-control custom-input" id="contact_email" name="email" placeholder="example@gmail.com">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact_type" class="form-label small fw-bold text-dark">Nhu cầu tư vấn</label>
                                    <select class="form-select custom-input" id="contact_type" name="interest_type">
                                        <option value="ca-nhan">Gốm sứ gia đình &amp; Bàn ăn</option>
                                        <option value="nha-hang">Giải pháp Nhà hàng &amp; Quán Cafe</option>
                                        <option value="khach-san">Giải pháp Khách sạn &amp; Resort</option>
                                        <option value="qua-tang">Quà tặng doanh nghiệp (In logo)</option>
                                        <option value="khac">Yêu cầu chế tác theo thiết kế riêng</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="contact_message" class="form-label small fw-bold text-dark">Chi tiết yêu cầu *</label>
                                    <textarea class="form-control custom-input" id="contact_message" name="message" rows="4" placeholder="Vui lòng chia sẻ số lượng dự kiến, loại sản phẩm hoặc mong muốn chế tác của bạn..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-submit-contact w-100 py-3">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Tư Vấn Ngay
                                    </button>
                                </div>
                            </div>
                            <div class="contact-feedback-msg mt-3" style="display:none;"></div>
                        </form>
                    </div>
                </div>

                <!-- Right: Cam Kết Từ Nghệ Nhân -->
                <div class="col-lg-5">
                    <div class="contact-pledge-wrapper ps-lg-2">
                        <span class="sub-label-orange mb-2">CAM KẾT TỪ NGHỆ NHÂN</span>
                        <h2 class="form-title fw-bold text-dark mb-4">An Tâm Tuyệt Đối Khi Đồng Hành Cùng Gomie</h2>

                        <div class="pledge-list d-flex flex-column gap-3 mb-4">
                            
                            <div class="pledge-card d-flex gap-3 align-items-start p-3 rounded-4">
                                <div class="pledge-icon-circle icon-orange flex-shrink-0">
                                    <i class="fa-solid fa-fire"></i>
                                </div>
                                <div>
                                    <h4 class="pledge-title fw-bold text-dark fs-6 mb-1">Nung Khử 1.300°C Khử Hoàn Toàn Chì</h4>
                                    <p class="text-muted small mb-0">Loại bỏ 100% độc tố chì và cadmium theo tiêu chuẩn an toàn thực phẩm QUATEST 1, bảo vệ sức khỏe trọn vẹn gia đình và thực khách.</p>
                                </div>
                            </div>

                            <div class="pledge-card d-flex gap-3 align-items-start p-3 rounded-4">
                                <div class="pledge-icon-circle icon-blue flex-shrink-0">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <h4 class="pledge-title fw-bold text-dark fs-6 mb-1">Bảo Hiểm Vận Chuyển Vỡ Hỏng 100%</h4>
                                    <p class="text-muted small mb-0">Bất kỳ sự cố nứt vỡ nào trong quá trình vận chuyển đều được Gomie gửi bù sản phẩm mới nguyên vẹn ngay lập tức, không tốn thêm chi phí.</p>
                                </div>
                            </div>

                            <div class="pledge-card d-flex gap-3 align-items-start p-3 rounded-4">
                                <div class="pledge-icon-circle icon-green flex-shrink-0">
                                    <i class="fa-solid fa-stamp"></i>
                                </div>
                                <div>
                                    <h4 class="pledge-title fw-bold text-dark fs-6 mb-1">In Ấn Khắc Logo &amp; Hộp Quà Theo Yêu Cầu</h4>
                                    <p class="text-muted small mb-0">Hỗ trợ thiết kế và nung chìm logo thương hiệu bền màu vĩnh cửu cùng men sứ cho các dự án quà tặng và không gian ẩm thực.</p>
                                </div>
                            </div>

                            <div class="pledge-card d-flex gap-3 align-items-start p-3 rounded-4">
                                <div class="pledge-icon-circle icon-purple flex-shrink-0">
                                    <i class="fa-solid fa-hand-holding-heart"></i>
                                </div>
                                <div>
                                    <h4 class="pledge-title fw-bold text-dark fs-6 mb-1">100% Vuốt Nặn &amp; Chế Tác Thủ Công</h4>
                                    <p class="text-muted small mb-0">Mỗi tác phẩm gốm là một bản thể độc nhất mang trọn dấu ấn bàn tay nghệ nhân Bát Tràng và lớp men hỏa biến tinh xảo.</p>
                                </div>
                            </div>

                        </div>

                        <!-- Quick Hotline Banner -->
                        <div class="hotline-quick-call p-3 rounded-4 text-center">
                            <span class="text-muted small d-block mb-1">Cần tư vấn báo giá ngay lập tức? Gọi hotline hỗ trợ 24/7:</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $hotline)); ?>" class="quick-hotline-link text-decoration-none">
                                <i class="fa-solid fa-phone-volume me-2"></i> <?php echo esc_html($hotline); ?>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<style>
/* Base Canvas Editorial V11 */
.gomie-contact-page-canvas {
    background-color: #fffdf9;
    background-image: url('<?php echo esc_url($theme_uri . "/assets/images/glazes/Background-1.png"); ?>');
    background-position: top center;
    background-size: 100% auto;
    background-repeat: no-repeat;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #2b2b2b;
}

/* Hero Section */
.contact-hero-section {
    padding: 3.5rem 1rem 2.2rem;
}
.contact-breadcrumb .breadcrumb {
    background: transparent;
    font-size: 0.88rem;
}
.contact-breadcrumb a {
    color: #8c827a;
    text-decoration: none;
    transition: color 0.2s ease;
}
.contact-breadcrumb a:hover {
    color: #e0592a;
}
.contact-breadcrumb .active {
    color: #e0592a;
    font-weight: 600;
}

.contact-pill-badge {
    display: inline-block;
    padding: 0.4rem 1.25rem;
    background: rgba(224, 89, 42, 0.08);
    color: #b3471e;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    border-radius: 999px;
    border: 1px solid rgba(224, 89, 42, 0.25);
}

.contact-hero-title {
    font-size: clamp(2rem, 3.8vw, 3.2rem);
    font-weight: 800;
    color: #1a1f2c;
    letter-spacing: -0.5px;
    line-height: 1.25;
    margin-bottom: 1.2rem;
}
.contact-hero-title .highlight-orange {
    color: #e0592a;
}
.contact-hero-desc {
    max-width: 760px;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #5c554e;
}

/* Trust Bar */
.contact-trust-bar .contact-trust-item {
    background: #ffffff;
    padding: 0.55rem 1.15rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #3b3530;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid rgba(224, 89, 42, 0.15);
    box-shadow: 0 2px 10px rgba(45, 30, 15, 0.04);
}

/* Channel Cards Glassmorphism */
.contact-channel-card {
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 20px;
    border: 1px solid rgba(224, 89, 42, 0.12);
    box-shadow: 0 8px 24px rgba(45, 30, 15, 0.04);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.contact-channel-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(224, 89, 42, 0.09);
    border-color: rgba(224, 89, 42, 0.3);
}

.channel-icon-circle {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.icon-orange {
    background: rgba(224, 89, 42, 0.1);
    color: #e0592a;
}
.icon-blue {
    background: rgba(14, 165, 233, 0.1);
    color: #0284c7;
}
.icon-green {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}
.icon-purple {
    background: rgba(147, 51, 234, 0.1);
    color: #9333ea;
}

.channel-divider {
    height: 1px;
    background: rgba(224, 89, 42, 0.08);
}

/* Contact Form Card */
.contact-form-box {
    background: #ffffff;
    border-radius: 24px;
    border: 1px solid rgba(224, 89, 42, 0.15);
    box-shadow: 0 12px 40px rgba(45, 30, 15, 0.06);
}

.sub-label-orange {
    font-size: 0.76rem;
    font-weight: 700;
    color: #e0592a;
    letter-spacing: 1.5px;
    display: inline-block;
    text-transform: uppercase;
}

.form-title {
    font-size: clamp(1.4rem, 2.2vw, 1.85rem);
    letter-spacing: -0.3px;
}

.custom-input {
    border: 1.5px solid #ebdcd0;
    border-radius: 12px;
    padding: 0.72rem 1rem;
    font-size: 0.95rem;
    color: #2b2b2b;
    background-color: #faf7f4;
    transition: all 0.2s ease;
}
.custom-input:focus {
    background-color: #ffffff;
    border-color: #e0592a;
    box-shadow: 0 0 0 4px rgba(224, 89, 42, 0.12);
    outline: none;
}

.btn-submit-contact {
    background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%);
    color: #ffffff;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    border-radius: 999px;
    box-shadow: 0 8px 24px rgba(224, 89, 42, 0.28);
    transition: all 0.3s ease;
}
.btn-submit-contact:hover {
    background: linear-gradient(135deg, #e0592a 0%, #c44317 100%);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(224, 89, 42, 0.36);
}

/* Pledge Card */
.pledge-card {
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid rgba(224, 89, 42, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.pledge-card:hover {
    transform: translateX(4px);
    background: #ffffff;
    box-shadow: 0 6px 18px rgba(45, 30, 15, 0.04);
}
.pledge-icon-circle {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
}

/* Hotline Quick Call */
.hotline-quick-call {
    background: #fff6ee;
    border: 1.5px dashed rgba(224, 89, 42, 0.4);
}
.quick-hotline-link {
    color: #e0592a;
    font-weight: 800;
    font-size: 1.3rem;
    transition: color 0.2s ease;
}
.quick-hotline-link:hover {
    color: #c44317;
}

/* Mobile Responsiveness */
@media (max-width: 767.98px) {
    .contact-hero-section {
        padding: 2.2rem 1rem 1.8rem;
    }
    .contact-form-box {
        padding: 1.5rem 1.25rem;
        border-radius: 18px;
    }
    .contact-channel-card {
        padding: 1.25rem;
        border-radius: 16px;
    }
    .contact-hero-title {
        font-size: 1.65rem;
    }
    .contact-trust-bar .contact-trust-item {
        font-size: 0.78rem;
        padding: 0.45rem 0.9rem;
    }
}
</style>

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
                feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu đã được gửi thành công. Chuyên viên Gomie sẽ liên hệ lại ngay trong vòng 30 phút.';
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
