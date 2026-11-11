<?php
/**
 * Template Name: Báo Giá Dự Án - Gomie Ceramic
 * Description: Trang yêu cầu báo giá dự án nhà hàng, khách sạn & quà tặng doanh nghiệp chuẩn B2B Gomie
 *
 * @package Gomie
 * @version 2.2.0
 */

defined('ABSPATH') || exit;

get_header();

$theme_uri = get_template_directory_uri();
$hotline = gomie_get_option('phone_number', '0335 059 889');
$email = gomie_get_option('email_address', 'support@gomie.vn');
$zalo_url = gomie_get_option('zalo_url', 'https://zalo.me/0335059889');
?>

<div class="gomie-b2b-page-canvas">
    
    <!-- 1. Hero Section Đồng Bộ Chuẩn B2B Gomie -->
    <section class="b2b-hero-section text-center py-5">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav class="b2b-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Dự án &amp; B2B</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Báo giá dự án</li>
                </ol>
            </nav>

            <!-- Badge Kicker -->
            <div class="b2b-badge-wrap mb-3">
                <span class="b2b-pill-badge">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i> GOMIE B2B · YÊU CẦU BÁO GIÁ DỰ ÁN &amp; QUÀ TẶNG
                </span>
            </div>

            <!-- Main Title -->
            <h1 class="b2b-hero-title">
                Yêu Cầu Báo Giá <br><span class="highlight-orange">Dự Án Gốm Sứ Bát Tràng</span>
            </h1>

            <!-- Description -->
            <p class="b2b-hero-desc mx-auto">
                Gomie Ceramic cung ứng trực tiếp từ xưởng lò 1.300°C Bát Tràng — không qua trung gian. Chiết khấu dự án tối ưu <strong>15% – 35%</strong>, hỗ trợ in khắc logo nung bền vĩnh cửu và thiết kế hộp quà độc quyền theo nhận diện thương hiệu của bạn.
            </p>

            <!-- Trust Pills -->
            <div class="b2b-trust-bar d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-fire-burner text-orange"></i>
                    <span>Giá gốc từ xưởng lò 1.300°C</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-stamp text-primary"></i>
                    <span>In logo nung chìm không bong tróc</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-wand-magic-sparkles text-warning"></i>
                    <span>Miễn phí thiết kế Mockup 3D &amp; Hộp quà</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                    <span>Bảo hiểm bể vỡ 100% khi giao nhận</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Key Benefits: 4 Lợi Thế Cạnh Tranh Tuyệt Đối Của Xưởng Gomie -->
    <section class="quote-benefits-section py-5">
        <div class="container">
            <div class="text-center mb-4">
                <span class="sub-label-b2b">CAM KẾT CHẤT LƯỢNG &amp; NĂNG LỰC SẢN XUẤT</span>
                <h2 class="b2b-section-title fw-bold text-dark mt-1">Tại Sao Doanh Nghiệp Chọn Gomie Ceramic?</h2>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="benefit-icon-circle mb-3">
                            <i class="fa-solid fa-tags text-orange"></i>
                        </div>
                        <h3 class="benefit-title fw-bold text-dark fs-6 mb-2">Giá Gốc Từ Lò Nung</h3>
                        <p class="benefit-desc text-muted small mb-0">Tiết kiệm 15% – 35% ngân sách dự án nhờ hợp tác trực tiếp với xưởng lò Bát Tràng, hoàn toàn không qua trung gian thương mại.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="benefit-icon-circle mb-3">
                            <i class="fa-solid fa-stamp text-primary"></i>
                        </div>
                        <h3 class="benefit-title fw-bold text-dark fs-6 mb-2">In Logo Chuẩn Màu</h3>
                        <p class="benefit-desc text-muted small mb-0">Nung chìm công nghệ nhiệt độ cao 800°C – 1.300°C, logo chìm sâu dưới men, không phai màu, không bong tróc qua ngàn lần rửa sấy.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="benefit-icon-circle mb-3">
                            <i class="fa-solid fa-box-open text-warning"></i>
                        </div>
                        <h3 class="benefit-title fw-bold text-dark fs-6 mb-2">Thiết Kế Hộp Quà Riêng</h3>
                        <p class="benefit-desc text-muted small mb-0">Đóng gói hộp xi lót lụa cao cấp dập nổi nhũ vàng/bạc, túi giấy mỹ thuật đồng bộ tạo dấu ấn trang trọng đẳng cấp đối với đối tác &amp; khách hàng.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="benefit-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="benefit-icon-circle mb-3">
                            <i class="fa-solid fa-shield-halved text-success"></i>
                        </div>
                        <h3 class="benefit-title fw-bold text-dark fs-6 mb-2">Bảo Hiểm Vận Chuyển 100%</h3>
                        <p class="benefit-desc text-muted small mb-0">Cam kết 100% bù hàng mới ngay lập tức hoặc hoàn tiền nếu phát sinh nứt vỡ trong quá trình giao hàng trên toàn quốc, đảm bảo tiến độ sự kiện.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Quotation Form & Direct Contact Layout (7 : 5) -->
    <section class="quote-main-section py-5">
        <div class="container">
            <div class="row g-4 g-xl-5 align-items-start">
                
                <!-- CỘT TRÁI: BIỂU MẪU ĐĂNG KÝ BÁO GIÁ (7 CỘT) -->
                <div class="col-lg-7">
                    <div class="quote-form-card p-4 p-md-5 rounded-4 bg-white shadow-sm border">
                        
                        <div class="form-header mb-4">
                            <span class="b2b-pill-badge mb-2 d-inline-block" style="font-size: 0.72rem; padding: 0.3rem 0.9rem;">
                                <i class="fa-solid fa-pen-to-square me-1"></i> BIỂU MẪU TIẾP NHẬN DỰ ÁN
                            </span>
                            <h2 class="fw-bold text-dark fs-4 mb-2">Đăng Ký Nhận Dự Toán &amp; Catalogue Mẫu</h2>
                            <p class="text-muted small mb-0">Điền thông tin nhu cầu của bạn, chuyên viên B2B của Gomie sẽ gửi bảng dự toán ngân sách chi tiết và catalogue sau <strong>15–30 phút</strong>.</p>
                        </div>

                        <form id="gomieQuotePageForm" class="gomie-quote-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                            <input type="hidden" name="action" value="gomie_contact_form">
                            <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>

                            <div class="row g-3">
                                <!-- Họ tên -->
                                <div class="col-md-6">
                                    <label for="quote_name" class="form-label small fw-bold text-dark">Họ và tên người liên hệ <span class="text-danger">*</span></label>
                                    <div class="input-icon-wrap">
                                        <i class="fa-regular fa-user input-icon"></i>
                                        <input type="text" class="form-control rounded-3 py-2 ps-4" id="quote_name" name="name" placeholder="Nguyễn Văn A" required>
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="col-md-6">
                                    <label for="quote_phone" class="form-label small fw-bold text-dark">Số điện thoại / Zalo <span class="text-danger">*</span></label>
                                    <div class="input-icon-wrap">
                                        <i class="fa-solid fa-phone input-icon"></i>
                                        <input type="tel" class="form-control rounded-3 py-2 ps-4" id="quote_phone" name="phone" placeholder="0912 345 678" required>
                                    </div>
                                </div>

                                <!-- Đơn vị / Doanh nghiệp -->
                                <div class="col-md-6">
                                    <label for="quote_company" class="form-label small fw-bold text-dark">Tên đơn vị / Nhà hàng / Doanh nghiệp</label>
                                    <div class="input-icon-wrap">
                                        <i class="fa-regular fa-building input-icon"></i>
                                        <input type="text" class="form-control rounded-3 py-2 ps-4" id="quote_company" name="company" placeholder="Tên công ty hoặc thương hiệu">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="quote_email" class="form-label small fw-bold text-dark">Email nhận bảng dự toán</label>
                                    <div class="input-icon-wrap">
                                        <i class="fa-regular fa-envelope input-icon"></i>
                                        <input type="email" class="form-control rounded-3 py-2 ps-4" id="quote_email" name="email" placeholder="example@company.com">
                                    </div>
                                </div>

                                <!-- Lĩnh vực dự án -->
                                <div class="col-md-6">
                                    <label for="quote_type" class="form-label small fw-bold text-dark">Lĩnh vực dự án <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-3 py-2" id="quote_type" name="interest_type" required>
                                        <option value="nha-hang">Set Bát Đĩa Nhà Hàng &amp; Ẩm Thực (F&amp;B)</option>
                                        <option value="khach-san">Gốm Sứ Khách Sạn &amp; Resort Cao Cấp</option>
                                        <option value="qua-tang-doanh-nghiep">Bộ Quà Tặng Doanh Nghiệp &amp; Tri Ân VIP</option>
                                        <option value="am-chen-in-logo">Bộ Ấm Chén In Logo Thương Hiệu</option>
                                        <option value="coc-su-cafe">Cốc Sứ, Ly Sứ Chuỗi Cafe &amp; Văn Phòng</option>
                                        <option value="dat-san-xuat-rieng">Đặt Chế Tác Màu Men Riêng Theo Yêu Cầu</option>
                                    </select>
                                </div>

                                <!-- Số lượng dự kiến -->
                                <div class="col-md-6">
                                    <label for="quote_quantity" class="form-label small fw-bold text-dark">Số lượng dự kiến</label>
                                    <select class="form-select rounded-3 py-2" id="quote_quantity" name="quantity_range">
                                        <option value="20-50">20 – 50 bộ / sản phẩm</option>
                                        <option value="50-200">50 – 200 bộ / sản phẩm (Chiết khấu 15%)</option>
                                        <option value="200-500">200 – 500 bộ / sản phẩm (Chiết khấu 25%)</option>
                                        <option value="500+">Trên 500 bộ / sản phẩm (Chiết khấu tối đa 35%)</option>
                                    </select>
                                </div>

                                <!-- Mô tả yêu cầu -->
                                <div class="col-12">
                                    <label for="quote_notes" class="form-label small fw-bold text-dark">Mô tả thêm yêu cầu (Ngân sách, thời hạn bàn giao, in logo...)</label>
                                    <textarea class="form-control rounded-3" id="quote_notes" name="message" rows="3" placeholder="Ví dụ: Cần 100 bộ ấm chén men hỏa biến in logo giao trước ngày 20 tháng sau tại Hà Nội, ngân sách khoảng 350.000đ/bộ..."></textarea>
                                </div>

                                <!-- Submit CTA Button -->
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn-submit-b2b w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Báo Giá &amp; Nhận Tư Vấn Ngay
                                    </button>
                                    <div class="text-center mt-2">
                                        <span class="text-muted" style="font-size: 0.76rem;">
                                            <i class="fa-solid fa-lock me-1 text-success"></i> Cam kết bảo mật thông tin dự án 100% · Phản hồi trong 15–30 phút.
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="quote-feedback-msg mt-3" style="display:none;"></div>
                        </form>

                    </div>
                </div>

                <!-- CỘT PHẢI: KÊNH LIÊN HỆ DỰ ÁN TRỰC TIẾP & QUY TRÌNH (5 CỘT) -->
                <div class="col-lg-5">
                    
                    <!-- Card 1: Kênh Liên Hệ Nhanh Giám Đốc Dự Án -->
                    <div class="direct-contact-card p-4 rounded-4 bg-white shadow-sm border mb-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="avatar-ring position-relative">
                                <div class="avatar-initials">G</div>
                                <span class="online-dot" title="Đang trực tuyến"></span>
                            </div>
                            <div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small fw-semibold" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-circle text-success me-1" style="font-size: 6px;"></i> Phục vụ 24/7
                                </span>
                                <h3 class="fw-bold text-dark fs-5 mb-0 mt-1">Ban Quản Lý Dự Án B2B</h3>
                                <span class="text-muted small">Tư vấn trực tiếp từ xưởng Bát Tràng</span>
                            </div>
                        </div>

                        <div class="contact-links-list d-flex flex-column gap-2 mb-3">
                            <a href="tel:<?php echo gomie_format_phone($hotline); ?>" class="contact-action-btn phone-btn d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="action-icon-circle bg-orange-subtle text-orange">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Hotline Tư Vấn Nhanh</div>
                                        <div class="fw-bold text-dark fs-6"><?php echo esc_html($hotline); ?></div>
                                    </div>
                                </div>
                                <span class="btn-arrow text-orange"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>

                            <a href="<?php echo esc_url($zalo_url); ?>" target="_blank" rel="noopener noreferrer" class="contact-action-btn zalo-btn d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="action-icon-circle bg-primary-subtle text-primary">
                                        <i class="fa-solid fa-comment-dots"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Chat Zalo Báo Giá Ngay</div>
                                        <div class="fw-bold text-primary fs-6">Nhắn tin nhận catalogue PDF</div>
                                    </div>
                                </div>
                                <span class="btn-arrow text-primary"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>

                        <div class="studio-info-meta pt-3 border-top small text-muted">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa-solid fa-location-dot text-orange mt-1"></i>
                                <span><strong>Xưởng chế tác:</strong> Xóm 3, Làng cổ Bát Tràng, Gia Lâm, Hà Nội.</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-envelope text-orange"></i>
                                <span><strong>Email:</strong> <?php echo esc_html($email); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Quy Trình Hợp Tác B2B 4 Bước Tinh Gọn -->
                    <div class="workflow-card p-4 rounded-4 bg-white shadow-sm border">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="workflow-badge"><i class="fa-solid fa-timeline"></i></span>
                            <h3 class="fw-bold text-dark fs-6 mb-0">Quy Trình Triển Khai 4 Bước</h3>
                        </div>

                        <div class="workflow-steps">
                            <div class="wf-step-item d-flex gap-3 pb-3 position-relative">
                                <div class="wf-step-num">01</div>
                                <div class="wf-step-content">
                                    <h4 class="wf-step-title fw-bold text-dark fs-6 mb-1">Khảo sát &amp; Báo giá</h4>
                                    <p class="wf-step-desc text-muted small mb-0">Lắng nghe nhu cầu, định hướng dòng men và gửi dự toán trong 30 phút.</p>
                                </div>
                            </div>

                            <div class="wf-step-item d-flex gap-3 pb-3 position-relative">
                                <div class="wf-step-num">02</div>
                                <div class="wf-step-content">
                                    <h4 class="wf-step-title fw-bold text-dark fs-6 mb-1">Thiết kế 3D &amp; Nung mẫu thử</h4>
                                    <p class="wf-step-desc text-muted small mb-0">Lên market mockup in logo và nung mẫu thực tế gửi quý khách duyệt tận tay.</p>
                                </div>
                            </div>

                            <div class="wf-step-item d-flex gap-3 pb-3 position-relative">
                                <div class="wf-step-num">03</div>
                                <div class="wf-step-content">
                                    <h4 class="wf-step-title fw-bold text-dark fs-6 mb-1">Sản xuất lò 1.300°C</h4>
                                    <p class="wf-step-desc text-muted small mb-0">Đổ rót thủ công, nhúng men bí truyền và nung nhiệt cao khử hoàn toàn chì.</p>
                                </div>
                            </div>

                            <div class="wf-step-item d-flex gap-3 position-relative">
                                <div class="wf-step-num">04</div>
                                <div class="wf-step-content">
                                    <h4 class="wf-step-title fw-bold text-dark fs-6 mb-1">KCS, Hộp quà &amp; Bàn giao</h4>
                                    <p class="wf-step-desc text-muted small mb-0">Kiểm tra từng sản phẩm, đóng hộp xi lụa và giao hàng tận nơi bảo hiểm 100%.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- 4. Lĩnh Vực Chuyên Môn B2B (Showcase 3 Nhóm Giải Pháp) -->
    <section class="b2b-sectors-section py-5 bg-white border-top">
        <div class="container">
            <div class="text-center mb-5">
                <span class="sub-label-b2b">DANH MỤC GIẢI PHÁP CHUYÊN BIỆT</span>
                <h2 class="b2b-section-title fw-bold text-dark mt-1">Các Nhóm Dự Án Gomie Đang Cung Ứng</h2>
                <p class="text-muted mx-auto" style="max-width: 680px; font-size: 0.95rem;">Lựa chọn giải pháp phù hợp với định vị thương hiệu và không gian kiến trúc của doanh nghiệp bạn.</p>
            </div>

            <div class="row g-4">
                <!-- Giải pháp 1: Nhà hàng -->
                <div class="col-md-4">
                    <div class="sector-card h-100 rounded-4 overflow-hidden border shadow-sm bg-white d-flex flex-column">
                        <div class="sector-img-wrap position-relative">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/stories/gomie-story-ban-tiec.jpg'); ?>" alt="Gốm sứ Nhà hàng" class="w-100" style="height: 220px; object-fit: cover;">
                            <span class="sector-badge position-absolute top-0 end-0 m-3 badge rounded-pill" style="background: rgba(224, 89, 42, 0.95); font-size: 0.72rem;">
                                HORECA
                            </span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold text-dark fs-5 mb-2">Bát Đĩa Nhà Hàng &amp; Ẩm Thực</h3>
                            <p class="text-muted small mb-3 flex-grow-1">Bát, đĩa, thố canh nung 1.300°C chống mẻ vành, chịu máy rửa bát công nghiệp và giữ nhiệt thức ăn vượt trội.</p>
                            <a href="<?php echo esc_url(home_url('/nha-hang/')); ?>" class="btn btn-outline-dark btn-sm rounded-pill fw-semibold align-self-start px-3 py-2">
                                Xem giải pháp nhà hàng <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Giải pháp 2: Khách sạn -->
                <div class="col-md-4">
                    <div class="sector-card h-100 rounded-4 overflow-hidden border shadow-sm bg-white d-flex flex-column">
                        <div class="sector-img-wrap position-relative">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/stories/gomie-story-resort-horeca.jpg'); ?>" alt="Gốm sứ Khách sạn & Resort" class="w-100" style="height: 220px; object-fit: cover;">
                            <span class="sector-badge position-absolute top-0 end-0 m-3 badge rounded-pill" style="background: rgba(15, 23, 42, 0.9); font-size: 0.72rem;">
                                RESORT &amp; SPA
                            </span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold text-dark fs-5 mb-2">Gốm Sứ Khách Sạn &amp; Resort</h3>
                            <p class="text-muted small mb-3 flex-grow-1">Set amenities phòng ngủ, bộ bình hoa trang trí tiền sảnh và đồ decor gốm sứ chế tác độc bản theo concept kiến trúc.</p>
                            <a href="<?php echo esc_url(home_url('/khach-san/')); ?>" class="btn btn-outline-dark btn-sm rounded-pill fw-semibold align-self-start px-3 py-2">
                                Xem giải pháp khách sạn <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Giải pháp 3: Quà tặng doanh nghiệp -->
                <div class="col-md-4">
                    <div class="sector-card h-100 rounded-4 overflow-hidden border shadow-sm bg-white d-flex flex-column">
                        <div class="sector-img-wrap position-relative">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/stories/gomie-story-hoa-bien-1300c.jpg'); ?>" alt="Bộ Quà Tặng Doanh Nghiệp" class="w-100" style="height: 220px; object-fit: cover;">
                            <span class="sector-badge position-absolute top-0 end-0 m-3 badge rounded-pill" style="background: rgba(244, 122, 32, 0.95); font-size: 0.72rem;">
                                VIP GIFTS
                            </span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold text-dark fs-5 mb-2">Bộ Quà Tặng Doanh Nghiệp</h3>
                            <p class="text-muted small mb-3 flex-grow-1">Bộ ấm chén men hỏa biến, set ly cốc sứ in logo nhung lụa cao cấp, hộp quà ép kim nhũ vàng sang trọng.</p>
                            <a href="<?php echo esc_url(home_url('/qua-tang/')); ?>" class="btn btn-outline-dark btn-sm rounded-pill fw-semibold align-self-start px-3 py-2">
                                Xem quà tặng doanh nghiệp <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Inline Styles For B2B Quote Page -->
<style>
/* Base Canvas */
.gomie-b2b-page-canvas {
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
.b2b-hero-section {
    padding: 3.5rem 1rem 2.5rem;
    border-bottom: 1px solid rgba(224, 89, 42, 0.12);
}
.b2b-breadcrumb .breadcrumb {
    background: transparent;
    font-size: 0.88rem;
}
.b2b-breadcrumb a {
    color: #8c827a;
    text-decoration: none;
    transition: color 0.2s ease;
}
.b2b-breadcrumb a:hover {
    color: #e0592a;
}
.b2b-breadcrumb .active {
    color: #e0592a;
    font-weight: 600;
}

.b2b-pill-badge {
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

.b2b-hero-title {
    font-size: clamp(2rem, 3.8vw, 3.2rem);
    font-weight: 800;
    color: #1a1f2c;
    letter-spacing: -0.5px;
    line-height: 1.25;
    margin-bottom: 1.2rem;
}
.b2b-hero-title .highlight-orange {
    color: #e0592a;
}
.b2b-hero-desc {
    max-width: 780px;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #5c554e;
}

/* Trust Bar */
.b2b-trust-bar .b2b-trust-item {
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

/* Section Sub Labels & Titles */
.sub-label-b2b {
    font-size: 0.76rem;
    font-weight: 700;
    color: #e0592a;
    letter-spacing: 1.5px;
    display: inline-block;
    text-transform: uppercase;
}
.b2b-section-title {
    font-size: clamp(1.5rem, 2.5vw, 2.2rem);
    line-height: 1.3;
}

/* Benefit Cards */
.benefit-card {
    border-color: rgba(224, 89, 42, 0.12) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}
.benefit-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(224, 89, 42, 0.1) !important;
    border-color: rgba(224, 89, 42, 0.3) !important;
}
.benefit-icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: rgba(224, 89, 42, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

/* Form Styles */
.quote-form-card {
    border-color: rgba(224, 89, 42, 0.18) !important;
    box-shadow: 0 16px 40px rgba(45, 30, 15, 0.05) !important;
}
.input-icon-wrap {
    position: relative;
}
.input-icon-wrap .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
}
.input-icon-wrap .form-control {
    padding-left: 38px !important;
}
.gomie-quote-form .form-control,
.gomie-quote-form .form-select {
    border: 1px solid #e2e8f0;
    font-size: 0.92rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.gomie-quote-form .form-control:focus,
.gomie-quote-form .form-select:focus {
    border-color: #e0592a;
    box-shadow: 0 0 0 3px rgba(224, 89, 42, 0.15);
}

.btn-submit-b2b {
    background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%);
    color: #ffffff;
    border: none;
    padding: 0.85rem 2rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 1rem;
    box-shadow: 0 6px 20px rgba(224, 89, 42, 0.35);
    transition: all 0.25s ease;
    cursor: pointer;
}
.btn-submit-b2b:hover {
    background: linear-gradient(135deg, #e0592a 0%, #c4471b 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(224, 89, 42, 0.45);
    color: #ffffff;
}

/* Direct Contact Card */
.direct-contact-card {
    border-color: rgba(224, 89, 42, 0.15) !important;
}
.avatar-ring {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-weight: 800;
    font-size: 1.2rem;
    box-shadow: 0 4px 12px rgba(224, 89, 42, 0.3);
}
.online-dot {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: #10b981;
    border: 2px solid #ffffff;
}
.contact-action-btn {
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}
.contact-action-btn:hover {
    border-color: #e0592a;
    background: #fff9f5;
    transform: translateX(4px);
}
.action-icon-circle {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}
.bg-orange-subtle { background: rgba(224, 89, 42, 0.1); }
.text-orange { color: #e0592a !important; }

/* Workflow Steps */
.workflow-card {
    border-color: rgba(224, 89, 42, 0.15) !important;
}
.workflow-badge {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(224, 89, 42, 0.1);
    color: #e0592a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}
.wf-step-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 17px;
    top: 36px;
    bottom: 0;
    width: 2px;
    background: rgba(224, 89, 42, 0.15);
}
.wf-step-num {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fff0e6;
    color: #e0592a;
    font-weight: 800;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 2px solid #ffffff;
    box-shadow: 0 2px 6px rgba(224, 89, 42, 0.15);
}

/* Sectors Showcase */
.sector-card {
    border-color: rgba(224, 89, 42, 0.12) !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.sector-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(45, 30, 15, 0.08) !important;
}
</style>

<!-- Form Submission Script -->
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
                feedback.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Cảm ơn bạn! Yêu cầu báo giá đã được chuyển đến bộ phận dự án B2B. Chuyên viên Gomie sẽ gửi bảng dự toán cho bạn trong 15–30 phút.';
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
