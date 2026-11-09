<?php
/**
 * Template Name: Khách Hàng Nhà Hàng - Gomie Ceramic
 * Description: Giải pháp gốm sứ Bát Tràng cao cấp cho Nhà hàng, Quán ăn & Chuỗi Ẩm thực (HoReCa)
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header();

$theme_uri = get_template_directory_uri();
?>

<div class="gomie-b2b-page-canvas">
    
    <!-- Hero Section -->
    <section class="b2b-hero-section text-center py-5">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="b2b-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Sản phẩm</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nhà hàng & F&B</li>
                </ol>
            </nav>

            <div class="b2b-badge-wrap mb-3">
                <span class="b2b-pill-badge">
                    <i class="fa-solid fa-utensils me-1"></i> GOMIE HORECA · ĐỒNG HÀNH CÙNG NHÀ HÀNG & ẨM THỰC
                </span>
            </div>

            <h1 class="b2b-hero-title">
                Giải Pháp Bát Đĩa Gốm Sứ Thủ Công <br><span class="highlight-orange">Cho Nhà Hàng & Bàn Tiệc Đương Đại</span>
            </h1>

            <p class="b2b-hero-desc mx-auto">
                Gomie Ceramic đồng hành cùng các chủ nhà hàng, bếp trưởng và chuỗi ẩm thực fine-dining: Cung cấp bát, đĩa, thố canh nung <strong>1.300°C khử chì tuyệt đối</strong>, chống mẻ vành, chịu máy rửa bát công nghiệp và chế tác sắc men độc quyền theo nhận diện thương hiệu.
            </p>

            <!-- Trust Pills -->
            <div class="b2b-trust-bar d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                    <span>Nung 1.300°C chống mẻ vành</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-spray-can-sparkles text-primary"></i>
                    <span>Chịu máy rửa bát công nghiệp</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-paint-roller text-warning"></i>
                    <span>Pha chế men độc quyền theo món</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-truck-fast text-danger"></i>
                    <span>Cung ứng ổn định, bảo hiểm vỡ 100%</span>
                </div>
            </div>

            <div class="hero-cta-btn-group mt-4 d-flex justify-content-center gap-3">
                <a href="#b2bContactForm" class="btn-b2b-primary">
                    <i class="fa-solid fa-file-pen me-2"></i> Nhận Báo Giá Dự Án Nhà Hàng
                </a>
                <a href="tel:0335059889" class="btn-b2b-outline">
                    <i class="fa-solid fa-phone me-2"></i> Hotline Tư Vấn: 0335 059 889
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="container py-5">
        
        <!-- Featured Restaurant Visual Showcase -->
        <div class="restaurant-intro-card p-4 p-md-5 rounded-4 shadow-sm mb-5 bg-white">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="sub-label-b2b">TÔN VINH NGHỆ THUẬT PLATING</span>
                    <h2 class="b2b-section-title fw-bold text-dark mt-2 mb-3">
                        Mỗi Món Ăn Là Một Tác Phẩm, Mỗi Chiếc Đĩa Là Một Tấm Toan
                    </h2>
                    <p class="text-muted leading-relaxed mb-3">
                        Trong ẩm thực cao cấp, thực khách thưởng thức bằng mắt trước khi chạm tới vị giác. Một chiếc đĩa gốm Bát Tràng men hỏa biến gợn sóng hay đĩa nâu cánh gián mộc mạc không chỉ làm nền, mà còn trực tiếp nâng tầm màu sắc của miếng thịt nướng, lát cá tươi hay bát canh chua thanh mát.
                    </p>
                    <p class="text-muted leading-relaxed mb-4">
                        Gomie hợp tác chặt chẽ cùng các Bếp trưởng để tính toán độ sâu lòng, độ dốc vành đĩa, bề mặt tráng men chống trơn trượt sốt và độ giữ nhiệt giúp món ăn luôn nóng hổi khi đến bàn tiệc.
                    </p>

                    <div class="b2b-checklist d-grid gap-2">
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>Kiểm định an toàn thực phẩm QUATEST 1:</strong> 0% chì và cadmi, tuyệt đối an toàn khi tiếp xúc dầu mỡ sôi và đồ chua.</span>
                        </div>
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>In logo đáy đĩa / thành bát:</strong> Nung chìm ở 1.200°C, không bong tróc sau hàng nghìn chu kỳ rửa.</span>
                        </div>
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>Chính sách bổ sung linh hoạt:</strong> Bù vỡ, bổ sung số lượng nhỏ định kỳ mà không lo lệch màu men.</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="b2b-photo-frame position-relative rounded-4 overflow-hidden shadow">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/stories/gomie-story-ban-tiec.jpg'); ?>" 
                             alt="Bàn tiệc nhà hàng sử dụng gốm Gomie Ceramic" 
                             class="img-fluid w-100 object-fit-cover" 
                             style="min-height: 380px;" />
                        <div class="photo-overlay-tag">
                            <span class="badge bg-dark text-white p-2 px-3 rounded-pill">
                                <i class="fa-solid fa-star text-warning me-1"></i> Bàn Tiệc Fine-Dining Gomie Bát Tràng
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Concept Sets for Restaurants -->
        <div class="restaurant-concepts mb-5">
            <div class="text-center mb-5">
                <span class="sub-label-b2b">BỘ SƯU TẬP THEO PHONG CÁCH ẨM THỰC</span>
                <h2 class="fw-bold text-dark mt-1">3 Dòng Men Đặc Tuyển Cho Nhà Hàng</h2>
                <p class="text-muted mx-auto" style="max-width: 650px;">
                    Dù nhà hàng của bạn theo đuổi ẩm thực truyền thống Việt Nam, hải sản hiện đại hay tiệc Chay thanh tịnh, Gomie đều có bộ sưu tập đồng điệu.
                </p>
            </div>

            <div class="row g-4">
                <!-- Concept 1 -->
                <div class="col-12 col-md-4">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-xanh-song-bien.png'); ?>" alt="Men Xanh Hỏa Biến" class="img-fluid" style="max-height: 180px;" />
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">HẢI SẢN & FINE-DINING</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bộ Đồ Ăn Men Xanh Hỏa Biến</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Sắc xanh đại dương chuyển màu ảo diệu dưới ánh đèn bàn tiệc. Lý tưởng cho các nhà hàng hải sản cao cấp, sashimi Nhật Bản và ẩm thực fusion.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Đĩa phẳng viền cao bày Sashimi</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Tô lượn sóng đựng súp & lẩu</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Chén chấm hoa văn giọt nước</li>
                        </ul>
                    </div>
                </div>

                <!-- Concept 2 -->
                <div class="col-12 col-md-4">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-canh-gian.png'); ?>" alt="Men Cánh Gián" class="img-fluid" style="max-height: 180px;" />
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">ẨM THỰC VIỆT & MÓN NƯỚNG</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bộ Đồ Ăn Men Cánh Gián Trầm Ấm</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Sắc nâu hổ phách mộc mạc gợi nhắc không gian cơm nhà xưa ấm cúng. Rất được ưa chuộng tại các nhà hàng cơm niêu, món nướng than hoa và ẩm thực Bắc Bộ.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Bát chiết yêu giữ cơm nóng lâu</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Đĩa lá chuối, đĩa tròn viền hoa</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Niêu gốm đanh chịu lửa trực tiếp</li>
                        </ul>
                    </div>
                </div>

                <!-- Concept 3 -->
                <div class="col-12 col-md-4">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <img src="<?php echo esc_url($theme_uri . '/assets/images/glazes/Gomie-men-reu.png'); ?>" alt="Men Rêu" class="img-fluid" style="max-height: 180px;" />
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">ẨM THỰC CHAY & THIỀN ZEN</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bộ Đồ Ăn Men Rêu Thiền Định</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Tông xanh rêu mộc trầm tĩnh mang lại cảm giác an yên tuyệt đối. Thích hợp cho nhà hàng chay cao cấp, quán trà đạo và không gian ẩm thực chữa lành.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Bát ăn dáng chuông thanh thoát</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Khay gốm chữ nhật bày món cuốn</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Ấm trà kèm chén tống đồng bộ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4-Step Collaboration Process -->
        <div class="b2b-process-card p-4 p-md-5 rounded-4 bg-white shadow-sm mb-5">
            <div class="text-center mb-5">
                <span class="sub-label-b2b">QUY TRÌNH HỢP TÁC B2B CHUYÊN NGHIỆP</span>
                <h2 class="fw-bold text-dark mt-1">Từ Ý Tưởng Concept Đến Bàn Ăn Thực Tế</h2>
            </div>

            <div class="row g-4 text-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="step-box">
                        <div class="step-circle mb-3">1</div>
                        <h4 class="step-name fw-bold">Khảo Sát Concept</h4>
                        <p class="step-text text-muted small">Lắng nghe thực đơn, phong cách thiết kế không gian và ngân sách dự toán của nhà hàng.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="step-box">
                        <div class="step-circle mb-3">2</div>
                        <h4 class="step-name fw-bold">Làm Mẫu & Thử Nghiệm</h4>
                        <p class="step-text text-muted small">Chế tác mẫu thực tế, in logo thử và gửi trực tiếp đến nhà hàng để Bếp trưởng test món.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="step-box">
                        <div class="step-circle mb-3">3</div>
                        <h4 class="step-name fw-bold">Sản Xuất Đồng Bộ</h4>
                        <p class="step-text text-muted small">Nung mẻ lớn 1.300°C tại Bát Tràng, kiểm tra âm thanh từng chiếc trước khi đóng thùng.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="step-box">
                        <div class="step-circle mb-3">4</div>
                        <h4 class="step-name fw-bold">Giao Hàng & Bảo Trì</h4>
                        <p class="step-text text-muted small">Giao hàng tận nơi toàn quốc, bảo hiểm rơi vỡ 100%, lưu trữ công thức men để bù hàng trọn đời.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- B2B Contact Form for Restaurants -->
        <div class="b2b-form-card p-4 p-md-5 rounded-4 shadow-sm" id="b2bContactForm">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 text-white">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fa-solid fa-handshake me-1"></i> ĐỒNG HÀNH CÙNG DOANH NGHIỆP F&B
                    </span>
                    <h2 class="fw-bold text-white mb-3">Đăng Ký Tư Vấn & Nhận Bộ Mẫu Thử</h2>
                    <p class="text-white-50 leading-relaxed mb-4">
                        Gomie sẵn sàng cử chuyên viên mang mẫu bát đĩa thực tế đến trực tiếp nhà hàng của bạn để đối chiếu màu men với ánh sáng và món ăn thực tế.
                    </p>

                    <div class="contact-direct-info d-grid gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-b2b"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <small class="text-white-50 d-block">Hotline B2B / Zalo Dự Án</small>
                                <strong class="text-white fs-5">0335 059 889</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-b2b"><i class="fa-solid fa-envelope"></i></div>
                            <div>
                                <small class="text-white-50 d-block">Email Tiếp Nhận Dự Án</small>
                                <strong class="text-white">b2b@gomie.vn</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-b2b"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <small class="text-white-50 d-block">Showroom & Xưởng Sản Xuất</small>
                                <strong class="text-white">Làng gốm Bát Tràng, Gia Lâm, Hà Nội</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="form-white-box p-4 p-md-5 rounded-4 bg-white shadow">
                        <h3 class="fw-bold text-dark mb-2">Gửi Yêu Cầu Báo Giá Cho Nhà Hàng</h3>
                        <p class="text-muted small mb-4">Điền thông tin bên dưới, Gomie sẽ phản hồi và gửi bảng chào giá trong vòng 2 giờ làm việc.</p>

                        <form id="restaurantLeadForm" onsubmit="handleB2BSubmit(event, 'Nhà Hàng')">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Tên nhà hàng / Chuỗi F&B <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ví dụ: Nhà hàng Sen Tây Hồ" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Người đại diện liên hệ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Họ và tên" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Số điện thoại / Zalo <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" placeholder="09xx xxx xxx" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Quy mô nhà hàng</label>
                                    <select class="form-select">
                                        <option value="under-20">Dưới 20 bàn (Quán nhỏ, Cafe)</option>
                                        <option value="20-50" selected>20 - 50 bàn (Nhà hàng vừa)</option>
                                        <option value="50-100">50 - 100 bàn (Nhà hàng lớn)</option>
                                        <option value="chain">Chuỗi nhiều chi nhánh</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Dòng màu men quan tâm</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="glazeCheck1" value="Hỏa Biến">
                                            <label class="form-check-label small" for="glazeCheck1">Men Hỏa Biến</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="glazeCheck2" value="Cánh Gián">
                                            <label class="form-check-label small" for="glazeCheck2">Men Cánh Gián</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="glazeCheck3" value="Men Rêu">
                                            <label class="form-check-label small" for="glazeCheck3">Men Rêu</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="glazeCheck4" value="In logo độc quyền">
                                            <label class="form-check-label small" for="glazeCheck4">In logo độc quyền</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Yêu cầu cụ thể / Concept mong muốn</label>
                                    <textarea class="form-control" rows="3" placeholder="Ví dụ: Cần 50 bộ đồ ăn tiệc nướng, cần in logo ở lòng bát, dự kiến khai trương tháng sau..."></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-submit-b2b w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Báo Giá & Nhận Mẫu Thử
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* ==========================================================================
   GOMIE B2B RESTAURANT PAGE STYLES
   ========================================================================== */
.gomie-b2b-page-canvas {
    background: #fbf8f3 url('<?php echo esc_url($theme_uri . "/assets/images/glazes/Background-1.png"); ?>') repeat;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #2b2b2b;
}

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

.b2b-trust-bar .b2b-trust-item {
    background: #ffffff;
    padding: 0.55rem 1.1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #3b3530;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid rgba(224, 89, 42, 0.12);
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.btn-b2b-primary {
    background: #e0592a;
    color: #ffffff !important;
    padding: 0.8rem 2rem;
    border-radius: 999px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(224, 89, 42, 0.35);
    transition: all 0.25s ease;
}
.btn-b2b-primary:hover {
    background: #c4471b;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(224, 89, 42, 0.45);
}
.btn-b2b-outline {
    background: #ffffff;
    color: #1a1f2c !important;
    padding: 0.8rem 1.8rem;
    border-radius: 999px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid rgba(0,0,0,0.15);
    transition: all 0.2s;
}
.btn-b2b-outline:hover {
    background: #1a1f2c;
    color: #ffffff !important;
}

/* Restaurant Intro Card */
.restaurant-intro-card {
    border: 1px solid rgba(224, 89, 42, 0.15);
}
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
.photo-overlay-tag {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
}

/* Concepts */
.concept-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-color: rgba(224, 89, 42, 0.12) !important;
}
.concept-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(224, 89, 42, 0.12) !important;
    border-color: rgba(224, 89, 42, 0.3) !important;
}
.concept-img-wrap {
    background: radial-gradient(circle, rgba(254, 245, 238, 0.9) 0%, rgba(255, 255, 255, 0.3) 75%);
}
.concept-badge {
    font-size: 0.72rem;
    font-weight: 700;
    color: #b3471e;
    background: rgba(224, 89, 42, 0.08);
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
}
.concept-title {
    font-size: 1.15rem;
}
.concept-features li {
    margin-bottom: 0.35rem;
}

/* Step Process */
.b2b-process-card {
    border: 1px solid rgba(224, 89, 42, 0.12);
}
.step-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #e0592a;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* B2B Form */
.b2b-form-card {
    background: linear-gradient(135deg, #1a1f2c 0%, #2b3346 100%);
    border: 2px solid #e0592a;
}
.icon-circle-b2b {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(224, 89, 42, 0.2);
    color: #e0592a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.form-white-box {
    border-radius: 20px;
}
.btn-submit-b2b {
    background: #e0592a;
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding: 0.85rem 1.5rem;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(224, 89, 42, 0.35);
    transition: all 0.25s ease;
}
.btn-submit-b2b:hover {
    background: #c4471b;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(224, 89, 42, 0.45);
}
</style>

<script>
function handleB2BSubmit(e, type) {
    e.preventDefault();
    alert('Cảm ơn Quý khách! Gomie Ceramic đã tiếp nhận yêu cầu dự án ' + type + '. Chuyên viên phụ trách HoReCa sẽ liên hệ lại qua Số điện thoại/Zalo trong vòng 2 giờ.');
    e.target.reset();
}
</script>

<?php get_footer(); ?>
