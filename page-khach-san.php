<?php
/**
 * Template Name: Khách Hàng Khách Sạn & Resort - Gomie Ceramic
 * Description: Giải pháp gốm sứ tiện nghi & nghệ thuật cho Khách sạn 4-5 sao, Resort, Spa & Boutique Hotel
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
                    <li class="breadcrumb-item active" aria-current="page">Khách sạn & Resort</li>
                </ol>
            </nav>

            <div class="b2b-badge-wrap mb-3">
                <span class="b2b-pill-badge">
                    <i class="fa-solid fa-hotel me-1"></i> GOMIE HOSPITALITY · KHÁCH SẠN, RESORT & SPA NGHỈ DƯỠNG
                </span>
            </div>

            <h1 class="b2b-hero-title">
                Kiến Tạo Điểm Chạm Văn Hóa <br><span class="highlight-orange">Cho Khách Sạn & Khu Nghỉ Dưỡng</span>
            </h1>

            <p class="b2b-hero-desc mx-auto">
                Từ bộ đồ dùng phòng tắm amenities, khay đựng xà phòng, cốc súc miệng gốm mộc đến bộ ấm chén trà đạo trong phòng Suite và bình hoa đại sảnh. Gomie mang linh hồn di sản Bát Tràng nâng tầm đẳng cấp không gian nghỉ dưỡng của bạn.
            </p>

            <!-- Trust Pills -->
            <div class="b2b-trust-bar d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-star text-warning"></i>
                    <span>Tiêu chuẩn khách sạn 4 - 5 sao</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-droplet-slash text-info"></i>
                    <span>Cốt gốm không thấm nước ẩm mốc</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-fingerprint text-primary"></i>
                    <span>Khắc logo nhũ vàng chìm vĩnh cửu</span>
                </div>
                <div class="b2b-trust-item">
                    <i class="fa-solid fa-cubes-stacked text-success"></i>
                    <span>Lưu trữ khuôn & men bù hàng 3 năm</span>
                </div>
            </div>

            <div class="hero-cta-btn-group mt-4 d-flex justify-content-center gap-3">
                <a href="#b2bHotelForm" class="btn-b2b-primary">
                    <i class="fa-solid fa-file-pen me-2"></i> Nhận Báo Giá Dự Án Khách Sạn
                </a>
                <a href="tel:0335059889" class="btn-b2b-outline">
                    <i class="fa-solid fa-phone me-2"></i> Hotline Tư Vấn: 0335 059 889
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="container py-5">
        
        <!-- Featured Hotel Visual Showcase -->
        <div class="restaurant-intro-card p-4 p-md-5 rounded-4 shadow-sm mb-5 bg-white">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="sub-label-b2b">TRẢI NGHIỆM KHÁCH HÀNG TINH TẾ</span>
                    <h2 class="b2b-section-title fw-bold text-dark mt-2 mb-3">
                        Gốm Mộc Bát Tràng – Điểm Nhấn Bản Sắc Khác Biệt
                    </h2>
                    <p class="text-muted leading-relaxed mb-3">
                        Tại sao các khu nghỉ dưỡng hàng đầu tại Phú Quốc, Hội An, Sapa và Đà Nẵng dần thay thế đồ nhựa dùng một lần bằng gốm sứ thủ công? Bởi một chiếc bình xịt dầu gội bằng gốm vuốt tay tráng men hỏa biến hay chiếc khay đựng khăn bằng đất nung mộc mạc lập tức truyền tải thông điệp về <strong>bền vững, thân thiện môi trường và chiều sâu văn hóa bản địa</strong>.
                    </p>
                    <p class="text-muted leading-relaxed mb-4">
                        Gomie Ceramic sở hữu kỹ nghệ chế tác tinh xảo, đáp ứng các tiêu chuẩn khắt khe nhất của các đơn vị vận hành quốc tế (Marriott, Accor, IHG) về độ bền, độ bám men và độ an toàn sức khỏe.
                    </p>

                    <div class="b2b-checklist d-grid gap-2">
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>Độ bền cơ học vượt trội:</strong> Nung ở 1.300°C giúp xương gốm đanh chắc, chống trầy xước và nứt vỡ trong môi trường phòng tắm có độ ẩm cao.</span>
                        </div>
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>Đồng bộ ngôn ngữ kiến trúc:</strong> Dễ dàng phối màu theo phong cách Indochine (Đông Dương), Eco-Resort, Wabi-Sabi hoặc Modern Luxury.</span>
                        </div>
                        <div class="check-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check text-success"></i>
                            <span><strong>Cam kết lưu khuôn 36 tháng:</strong> Khi khách sạn cần thay thế hoặc mở rộng giai đoạn 2, các lô gốm bổ sung vẫn đồng nhất 100% kích thước và màu men.</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="b2b-photo-frame position-relative rounded-4 overflow-hidden shadow">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/stories/gomie-story-resort-horeca.jpg'); ?>" 
                             alt="Không gian phòng khách sạn nghỉ dưỡng cao cấp cùng gốm Gomie Ceramic" 
                             class="img-fluid w-100 object-fit-cover" 
                             style="min-height: 380px;" />
                        <div class="photo-overlay-tag">
                            <span class="badge bg-dark text-white p-2 px-3 rounded-pill">
                                <i class="fa-solid fa-hotel text-warning me-1"></i> Không Gian Khách Sạn & Resort HoReCa
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Key Spaces in Hotels -->
        <div class="hotel-spaces mb-5">
            <div class="text-center mb-5">
                <span class="sub-label-b2b">DANH MỤC TIỆN NGHI THEO KHÔNG GIAN</span>
                <h2 class="fw-bold text-dark mt-1">4 Không Gian Ứng Dụng Trong Khách Sạn & Resort</h2>
            </div>

            <div class="row g-4">
                <!-- Space 1 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <i class="fa-solid fa-bath fa-3x text-primary"></i>
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">PHÒNG TẮM & AMENITIES</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bộ Phụ Kiện Phòng Tắm</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Bộ bình xịt sữa tắm/dầu gội gốm sứ vòi inox cao cấp, cốc súc miệng, khay xà phòng và hộp đựng bông tăm in logo resort đồng bộ.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Chống bám cặn xà phòng</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Đáy có chân đệm chống trượt</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Vòi xịt áp lực êm ái</li>
                        </ul>
                    </div>
                </div>

                <!-- Space 2 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <i class="fa-solid fa-mug-saucer fa-3x text-warning"></i>
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">PHÒNG SUITE & MINI-BAR</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bộ Trà Đạo & Cà Phê</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Set ấm chén tử sa / men hỏa biến, phin cà phê sứ giữ nhiệt Bát Tràng và ly uống nước dưỡng sinh chào đón khách VIP.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Giữ hương vị trà trọn vẹn</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Cầm cách nhiệt thoải mái</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Khay gốm lót chống ố mặt bàn</li>
                        </ul>
                    </div>
                </div>

                <!-- Space 3 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <i class="fa-solid fa-spa fa-3x text-success"></i>
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">KHU SPA & TRỊ LIỆU</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Gốm Thư Giãn & Trầm Hương</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Chậu ngâm chân gốm thô vuốt tay giữ nhiệt lâu, đĩa đốt trầm hoa sen, đèn xông tinh dầu nến/điện tạo không gian an tĩnh tuyệt đối.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Khử độc tố khi ngâm thảo dược</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Chịu tinh dầu đậm đặc</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Dáng gốm thiền định mộc mạc</li>
                        </ul>
                    </div>
                </div>

                <!-- Space 4 -->
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="concept-card h-100 p-4 rounded-4 bg-white shadow-sm border">
                        <div class="concept-img-wrap mb-3 rounded-3 text-center p-3">
                            <i class="fa-solid fa-bell-concierge fa-3x text-danger"></i>
                        </div>
                        <span class="concept-badge mb-2 d-inline-block">TIỀN SẢNH & BUFFET</span>
                        <h3 class="concept-title fw-bold text-dark mb-2">Bình Decor & Khay Buffet</h3>
                        <p class="concept-desc text-muted small mb-3">
                            Bình hoa gốm men rạn cổ khổ lớn đón tiếp tại quầy Concierge, đĩa chữ nhật nông lòng phục vụ tiệc buffet sáng phong cách 5 sao.
                        </p>
                        <ul class="concept-features list-unstyled small text-muted mb-0">
                            <li><i class="fa-solid fa-check text-success me-2"></i>Kích thước tùy biến theo sảnh</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Men kết tinh ánh vàng vương giả</li>
                            <li><i class="fa-solid fa-check text-success me-2"></i>Tạo góc check-in ấn tượng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hotel Collaboration Form -->
        <div class="b2b-form-card p-4 p-md-5 rounded-4 shadow-sm" id="b2bHotelForm">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 text-white">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fa-solid fa-handshake me-1"></i> ĐỐI TÁC KHÁCH SẠN & RESORT
                    </span>
                    <h2 class="fw-bold text-white mb-3">Yêu Cầu Mẫu Thử Phòng Khách Sạn (Mockup Room)</h2>
                    <p class="text-white-50 leading-relaxed mb-4">
                        Gomie hỗ trợ sản xuất và gửi trọn bộ mẫu amenities / bộ trà thực tế in logo thử nghiệm để Ban Giám đốc và Bộ phận Mua hàng (Procurement) đánh giá chất lượng trực tiếp.
                    </p>

                    <div class="contact-direct-info d-grid gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-b2b"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <small class="text-white-50 d-block">Hotline Giám Đốc Dự Án Hospitality</small>
                                <strong class="text-white fs-5">0335 059 889</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle-b2b"><i class="fa-solid fa-envelope"></i></div>
                            <div>
                                <small class="text-white-50 d-block">Email Phòng Dự Án HoReCa</small>
                                <strong class="text-white">hospitality@gomie.vn</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="form-white-box p-4 p-md-5 rounded-4 bg-white shadow">
                        <h3 class="fw-bold text-dark mb-2">Đăng Ký Tư Vấn Dự Án Khách Sạn</h3>
                        <p class="text-muted small mb-4">Vui lòng cung cấp số lượng phòng dự kiến để Gomie áp dụng chính sách chiết khấu tốt nhất.</p>

                        <form id="hotelLeadForm" onsubmit="handleB2BSubmit(event, 'Khách Sạn & Resort')">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Tên Khách sạn / Resort <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Ví dụ: Anantara Mũi Né Resort" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Người phụ trách mua hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Họ và tên / Chức vụ" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Số điện thoại / Zalo <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" placeholder="09xx xxx xxx" required />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label small fw-bold">Quy mô phòng nghỉ</label>
                                    <select class="form-select">
                                        <option value="under-30">Dưới 30 phòng (Boutique Hotel, Villa)</option>
                                        <option value="30-100" selected>30 - 100 phòng (Khách sạn 3-4 sao)</option>
                                        <option value="100-300">100 - 300 phòng (Resort lớn)</option>
                                        <option value="over-300">Trên 300 phòng (Tổ hợp nghỉ dưỡng)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Hạng mục cần cung cấp</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hItem1" value="Amenities phòng tắm">
                                            <label class="form-check-label small" for="hItem1">Amenities phòng tắm</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hItem2" value="Set ấm chén phòng Suite">
                                            <label class="form-check-label small" for="hItem2">Set ấm chén phòng Suite</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hItem3" value="Đồ dùng Spa & Thư giãn">
                                            <label class="form-check-label small" for="hItem3">Đồ dùng Spa & Thư giãn</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hItem4" value="Bình hoa decor sảnh">
                                            <label class="form-check-label small" for="hItem4">Bình hoa decor sảnh</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Ghi chú & Thời gian nhận phòng mẫu</label>
                                    <textarea class="form-control" rows="3" placeholder="Nhập yêu cầu về phong cách kiến trúc, logo in ấn, hoặc ngày dự kiến cần mẫu đối chứng..."></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-submit-b2b w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i> Gửi Yêu Cầu Dự Án & Nhận Mockup Mẫu
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
/* Reusing shared styles from page-nha-hang.php with custom touches */
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
.b2b-hero-section {
    padding: 3.5rem 1rem 2.5rem;
    border-bottom: 1px solid rgba(224, 89, 42, 0.12);
}
.b2b-breadcrumb .breadcrumb { background: transparent; font-size: 0.88rem; }
.b2b-breadcrumb a { color: #8c827a; text-decoration: none; }
.b2b-breadcrumb a:hover { color: #e0592a; }
.b2b-breadcrumb .active { color: #e0592a; font-weight: 600; }
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
.b2b-hero-title .highlight-orange { color: #e0592a; }
.b2b-hero-desc { max-width: 780px; font-size: 1.05rem; line-height: 1.8; color: #5c554e; }
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
.btn-b2b-outline:hover { background: #1a1f2c; color: #ffffff !important; }
.restaurant-intro-card { border: 1px solid rgba(224, 89, 42, 0.15); }
.sub-label-b2b { font-size: 0.76rem; font-weight: 700; color: #e0592a; letter-spacing: 1.5px; display: inline-block; text-transform: uppercase; }
.b2b-section-title { font-size: clamp(1.5rem, 2.5vw, 2.2rem); line-height: 1.3; }
.photo-overlay-tag { position: absolute; bottom: 1rem; left: 1rem; }
.concept-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border-color: rgba(224, 89, 42, 0.12) !important; }
.concept-card:hover { transform: translateY(-6px); box-shadow: 0 16px 36px rgba(224, 89, 42, 0.12) !important; border-color: rgba(224, 89, 42, 0.3) !important; }
.concept-img-wrap { background: radial-gradient(circle, rgba(254, 245, 238, 0.9) 0%, rgba(255, 255, 255, 0.3) 75%); }
.concept-badge { font-size: 0.72rem; font-weight: 700; color: #b3471e; background: rgba(224, 89, 42, 0.08); padding: 0.25rem 0.65rem; border-radius: 999px; }
.concept-title { font-size: 1.15rem; }
.b2b-form-card { background: linear-gradient(135deg, #1a1f2c 0%, #2b3346 100%); border: 2px solid #e0592a; }
.icon-circle-b2b { width: 42px; height: 42px; border-radius: 50%; background: rgba(224, 89, 42, 0.2); color: #e0592a; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.form-white-box { border-radius: 20px; }
.btn-submit-b2b { background: #e0592a; color: #ffffff; border: none; border-radius: 999px; padding: 0.85rem 1.5rem; font-size: 1rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 18px rgba(224, 89, 42, 0.35); transition: all 0.25s ease; }
.btn-submit-b2b:hover { background: #c4471b; transform: translateY(-2px); box-shadow: 0 10px 24px rgba(224, 89, 42, 0.45); }
</style>

<script>
function handleB2BSubmit(e, type) {
    e.preventDefault();
    alert('Cảm ơn Quý khách! Gomie Ceramic đã tiếp nhận yêu cầu dự án ' + type + '. Trưởng ban dự án HoReCa sẽ liên hệ lại qua Số điện thoại/Zalo trong vòng 2 giờ.');
    e.target.reset();
}
</script>

<?php get_footer(); ?>
