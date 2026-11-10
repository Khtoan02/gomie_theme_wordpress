<?php
/**
 * Template Name: Chứng Nhận & Minh Bạch - Gomie Ceramic
 * Description: Trang công bố chứng nhận kiểm định chất lượng QUATEST 1 và cam kết minh bạch an toàn thực phẩm
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header();

$theme_uri = get_template_directory_uri();
?>

<div class="gomie-cert-page-canvas">
    
    <!-- Hero Header -->
    <section class="cert-hero-section text-center py-5">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav class="cert-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chứng nhận & Minh bạch</li>
                </ol>
            </nav>

            <div class="cert-badge-wrapper mb-3">
                <span class="cert-pill-badge">
                    <i class="fa-solid fa-shield-halved me-1"></i> MINH BẠCH & AN TOÀN TUYỆT ĐỐI · GOMIE CERAMIC
                </span>
            </div>

            <h1 class="cert-hero-title">
                Chứng Nhận Kiểm Định <br><span class="highlight-orange">& Minh Bạch Chất Lượng</span>
            </h1>

            <p class="cert-hero-desc mx-auto">
                Mỗi sản phẩm gốm sứ Gomie khi đến tay bạn không chỉ mang vẻ đẹp nghệ thuật men hỏa biến độc bản, mà còn là lời cam kết đanh thép về sức khỏe: <strong>100% nung ở nhiệt độ 1.300°C</strong>, triệt tiêu kim loại nặng, đạt kết quả <strong>KPH (Không phát hiện Chì & Cadmi)</strong> tại cơ quan kiểm định độc lập QUATEST 1.
            </p>

            <!-- 4 Trust Badges -->
            <div class="cert-trust-bar d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="trust-badge-item">
                    <span class="trust-icon fire"><i class="fa-solid fa-fire-burner"></i></span>
                    <div class="trust-text">
                        <strong>Nung khử 1.300°C</strong>
                        <small class="d-block text-muted">Thấu cốt, trơ silicate</small>
                    </div>
                </div>

                <div class="trust-badge-item">
                    <span class="trust-icon cert"><i class="fa-solid fa-stamp"></i></span>
                    <div class="trust-text">
                        <strong>QUATEST 1 Kiểm Định</strong>
                        <small class="d-block text-muted">Trung tâm Kỹ thuật 1 - Bộ KH&CN</small>
                    </div>
                </div>

                <div class="trust-badge-item">
                    <span class="trust-icon safe"><i class="fa-solid fa-vial-circle-check"></i></span>
                    <div class="trust-text">
                        <strong>0% Chì & Cadmi (KPH)</strong>
                        <small class="d-block text-muted">Dưới ngưỡng phát hiện</small>
                    </div>
                </div>

                <div class="trust-badge-item">
                    <span class="trust-icon standard"><i class="fa-solid fa-medal"></i></span>
                    <div class="trust-text">
                        <strong>QCVN 12-4:2015/BYT</strong>
                        <small class="d-block text-muted">Chuẩn Bộ Y Tế ban hành</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Certificate Showcase -->
    <div class="container py-4 py-md-5">
        
        <!-- Official Banner Preview Card -->
        <div class="official-banner-card p-4 p-md-5 rounded-4 shadow-sm mb-5 bg-white">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="sub-pill-dark mb-2 d-inline-block">KẾT QUẢ THỬ NGHIỆM ĐỘC LẬP</span>
                    <h2 class="section-heading-dark fw-bold mb-3">
                        Hồ Sơ Thử Nghiệm Mẫu Gốm Sứ Tại QUATEST 1
                    </h2>
                    <p class="text-muted leading-relaxed">
                        Toàn bộ các dòng gốm sứ Gomie Ceramic (từ bộ bát đĩa men Sapphire, cốc sứ dưỡng sinh, đến đĩa tiệc men Cánh Gián) đều được gửi kiểm định định kỳ tại <strong>Trung tâm Kỹ thuật Tiêu chuẩn Đo lường Chất lượng 1 (QUATEST 1)</strong> thuộc Tổng cục Tiêu chuẩn Đo lường Chất lượng - Bộ Khoa học và Công nghệ.
                    </p>
                    
                    <ul class="cert-highlight-list list-unstyled my-4">
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <span><strong>Phương pháp thử:</strong> Ngâm chiết mẫu trong dung dịch axit acetic 4% ở nhiệt độ tiêu chuẩn nhằm mô phỏng điều kiện tiếp xúc thực phẩm chua/nóng khắc nghiệt nhất.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <span><strong>Hàm lượng thôi nhiễm Chì (Pb):</strong> <strong>KPH (Không phát hiện)</strong>, đạt mức an toàn tuyệt đối.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2 mb-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <span><strong>Hàm lượng thôi nhiễm Cadmi (Cd):</strong> <strong>KPH (Không phát hiện)</strong>, bảo vệ sức khỏe người dùng lâu dài.</span>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <span><strong>Được cấp phép & đóng dấu:</strong> Có dấu tròn đỏ chính thức của Giám đốc QUATEST 1 & Trưởng phòng Thử nghiệm Thực phẩm.</span>
                        </li>
                    </ul>

                    <div class="action-btn-row d-flex flex-wrap gap-2">
                        <button type="button" class="btn-cert-primary" onclick="openCertModal('<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-1-all-certificates.jpg'); ?>', 'Hồ Sơ Tổng Hợp Phiếu Kết Quả Thử Nghiệm QUATEST 1')">
                            <i class="fa-solid fa-magnifying-glass-plus me-1"></i> Phóng to toàn bộ chứng chỉ
                        </button>
                        <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-cert-outline">
                            <i class="fa-solid fa-bag-shopping me-1"></i> Xem các sản phẩm đã kiểm định
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="cert-img-frame cursor-pointer" onclick="openCertModal('<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-1-all-certificates.jpg'); ?>', 'Hồ Sơ Tổng Hợp Phiếu Kết Quả Thử Nghiệm QUATEST 1')">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-1-all-certificates.jpg'); ?>" 
                             alt="Chứng nhận kiểm định QUATEST 1 gốm sứ Gomie" 
                             class="img-fluid rounded-3 shadow" />
                        <div class="cert-frame-overlay">
                            <span class="overlay-pill"><i class="fa-solid fa-expand me-1"></i> Nhấp để xem ảnh phóng to</span>
                        </div>
                    </div>
                    <div class="cert-caption mt-2 text-muted small">
                        <i class="fa-solid fa-award text-warning me-1"></i> Ảnh scan gốc bộ chứng chỉ kiểm nghiệm QUATEST 1 của các sản phẩm Gomie Ceramic
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Specific Product Test Reports -->
        <div class="row g-4 mb-5">
            <div class="col-12 text-center mb-2">
                <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">Chi Tiết Từng Dòng Sản Phẩm</span>
                <h2 class="fw-bold text-dark mt-1">Kết Quả Kiểm Nghiệm Từng Mẫu Thực Tế</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    Dưới đây là thông số thử nghiệm cụ thể đối với 3 dòng sản phẩm đại diện tiếp xúc thực phẩm hàng ngày.
                </p>
            </div>

            <!-- Report Card 1 -->
            <div class="col-12 col-lg-4">
                <div class="report-card-v11 h-100 p-4 rounded-4 bg-white shadow-sm d-flex flex-column">
                    <div class="report-card-header d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div class="report-org">
                            <span class="badge-quatest">QUATEST 1</span>
                            <span class="report-type ms-2 text-muted small">Mẫu thử #01</span>
                        </div>
                        <span class="badge-status-pass"><i class="fa-solid fa-check"></i> ĐẠT CHUẨN</span>
                    </div>

                    <div class="report-sample-img text-center mb-3 cursor-pointer" onclick="openCertModal('<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-1.jpg'); ?>', 'Mẫu thử: Bát & Tô Men Xanh Hỏa Biến 1.300°C')">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-1.jpg'); ?>" alt="Phiếu kiểm nghiệm bát tô men hỏa biến" class="img-fluid rounded-3" />
                        <div class="img-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Xem phiếu gốc</div>
                    </div>

                    <h3 class="report-title fw-bold text-dark mb-2">
                        Bát Ăn Cơm & Tô Canh Men Hỏa Biến
                    </h3>
                    <p class="report-desc text-muted small mb-3">
                        Thử nghiệm đối với dòng bát tô men xanh hỏa biến sâu thẳm nung 1.300°C, thường xuyên đựng canh nóng và thức ăn chứa axit.
                    </p>

                    <!-- Results Table -->
                    <div class="test-table-wrap mb-4 mt-auto">
                        <table class="table table-sm test-table mb-0">
                            <thead>
                                <tr>
                                    <th>Chỉ tiêu kiểm nghiệm</th>
                                    <th>Giới hạn QCVN</th>
                                    <th>Kết quả Gomie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-danger me-1"></i> Hàm lượng Chì (Pb)</td>
                                    <td>2.0 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-warning me-1"></i> Hàm lượng Cadmi (Cd)</td>
                                    <td>0.5 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-temperature-arrow-up text-primary me-1"></i> Sốc nhiệt</td>
                                    <td>100°C</td>
                                    <td class="text-success fw-bold">Không rạn nứt</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="report-footer pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-calendar-check me-1"></i> Đã kiểm định</span>
                        <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-view-tested-prod">Xem sản phẩm <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Report Card 2 -->
            <div class="col-12 col-lg-4">
                <div class="report-card-v11 h-100 p-4 rounded-4 bg-white shadow-sm d-flex flex-column">
                    <div class="report-card-header d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div class="report-org">
                            <span class="badge-quatest">QUATEST 1</span>
                            <span class="report-type ms-2 text-muted small">Mẫu thử #02</span>
                        </div>
                        <span class="badge-status-pass"><i class="fa-solid fa-check"></i> ĐẠT CHUẨN</span>
                    </div>

                    <div class="report-sample-img text-center mb-3 cursor-pointer" onclick="openCertModal('<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-2.jpg'); ?>', 'Mẫu thử: Cốc Gốm Sứ Văn Phòng & Ly Trà')">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-2.jpg'); ?>" alt="Phiếu kiểm nghiệm cốc sứ Bát Tràng" class="img-fluid rounded-3" />
                        <div class="img-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Xem phiếu gốc</div>
                    </div>

                    <h3 class="report-title fw-bold text-dark mb-2">
                        Cốc Gốm & Ly Sứ Uống Nước
                    </h3>
                    <p class="report-desc text-muted small mb-3">
                        Thử nghiệm đối với ca cốc gốm Bát Tràng dùng pha trà, cà phê, nước chanh nóng và các loại đồ uống có tính axit tự nhiên.
                    </p>

                    <!-- Results Table -->
                    <div class="test-table-wrap mb-4 mt-auto">
                        <table class="table table-sm test-table mb-0">
                            <thead>
                                <tr>
                                    <th>Chỉ tiêu kiểm nghiệm</th>
                                    <th>Giới hạn QCVN</th>
                                    <th>Kết quả Gomie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-danger me-1"></i> Hàm lượng Chì (Pb)</td>
                                    <td>2.0 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-warning me-1"></i> Hàm lượng Cadmi (Cd)</td>
                                    <td>0.5 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-shield-virus text-info me-1"></i> Độ thôi men</td>
                                    <td>Tiêu chuẩn</td>
                                    <td class="text-success fw-bold">Không phai màu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="report-footer pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-calendar-check me-1"></i> Đã kiểm định</span>
                        <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-view-tested-prod">Xem sản phẩm <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Report Card 3 -->
            <div class="col-12 col-lg-4">
                <div class="report-card-v11 h-100 p-4 rounded-4 bg-white shadow-sm d-flex flex-column">
                    <div class="report-card-header d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div class="report-org">
                            <span class="badge-quatest">QUATEST 1</span>
                            <span class="report-type ms-2 text-muted small">Mẫu thử #03</span>
                        </div>
                        <span class="badge-status-pass"><i class="fa-solid fa-check"></i> ĐẠT CHUẨN</span>
                    </div>

                    <div class="report-sample-img text-center mb-3 cursor-pointer" onclick="openCertModal('<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-3.jpg'); ?>', 'Mẫu thử: Đĩa Tiệc Men Cánh Gián & Gấm Vàng')">
                        <img src="<?php echo esc_url($theme_uri . '/assets/images/certificates/quatest-pair-3.jpg'); ?>" alt="Phiếu kiểm nghiệm đĩa men cánh gián" class="img-fluid rounded-3" />
                        <div class="img-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Xem phiếu gốc</div>
                    </div>

                    <h3 class="report-title fw-bold text-dark mb-2">
                        Đĩa Bày Tiệc & Set Bàn Ăn Men Cánh Gián
                    </h3>
                    <p class="report-desc text-muted small mb-3">
                        Thử nghiệm đối với đĩa tiệc sâu lòng men Cánh Gián và Gấm Vàng chuyên dụng cho nhà hàng, khách sạn và các bữa tiệc sum họp.
                    </p>

                    <!-- Results Table -->
                    <div class="test-table-wrap mb-4 mt-auto">
                        <table class="table table-sm test-table mb-0">
                            <thead>
                                <tr>
                                    <th>Chỉ tiêu kiểm nghiệm</th>
                                    <th>Giới hạn QCVN</th>
                                    <th>Kết quả Gomie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-danger me-1"></i> Hàm lượng Chì (Pb)</td>
                                    <td>2.0 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-atom text-warning me-1"></i> Hàm lượng Cadmi (Cd)</td>
                                    <td>0.5 mg/L</td>
                                    <td class="text-success fw-bold">KPH (0.00)</td>
                                </tr>
                                <tr>
                                    <td><i class="fa-solid fa-microwave text-success me-1"></i> Máy rửa bát & Lò vi sóng</td>
                                    <td>Chịu lực</td>
                                    <td class="text-success fw-bold">Hoàn toàn an toàn</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="report-footer pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="fa-solid fa-calendar-check me-1"></i> Đã kiểm định</span>
                        <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-view-tested-prod">Xem sản phẩm <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparison Table: Gomie vs Low-fired cheap ceramics -->
        <div class="comparison-section-box p-4 p-md-5 rounded-4 bg-white shadow-sm mb-5">
            <div class="text-center mb-4">
                <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">Hiểu Rõ Để Lựa Chọn Đúng</span>
                <h2 class="fw-bold text-dark mt-1">Sự Khác Biệt Giữa Gomie Ceramic & Gốm Sứ Kém Chất Lượng</h2>
                <p class="text-muted mx-auto" style="max-width: 650px;">
                    Vì sao gốm sứ giá rẻ thường có màu sắc rất rực rỡ nhưng lại tiềm ẩn nguy cơ nhiễm độc kim loại nặng nguy hiểm?
                </p>
            </div>

            <div class="table-responsive">
                <table class="table comparison-table align-middle">
                    <thead>
                        <tr>
                            <th class="col-criteria">Tiêu chí so sánh</th>
                            <th class="col-gomie"><i class="fa-solid fa-crown text-warning me-1"></i> Gốm Sứ Gomie Bát Tràng</th>
                            <th class="col-cheap"><i class="fa-solid fa-triangle-exclamation text-danger me-1"></i> Gốm trôi nổi / Nhiệt độ thấp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="criteria-title">
                                <strong>Nhiệt độ nung lò</strong>
                                <small class="d-block text-muted">Quyết định độ đanh và giải phóng độc tố</small>
                            </td>
                            <td class="gomie-cell">
                                <span class="badge-good"><i class="fa-solid fa-check"></i> Đạt 1.300°C</span>
                                <p class="mb-0 small text-muted">Nung 2 lần liên tục 36 giờ, khử sạch hoàn toàn độc tố chì và cadmi trong đất.</p>
                            </td>
                            <td class="cheap-cell">
                                <span class="badge-bad"><i class="fa-solid fa-xmark"></i> Dưới 800°C – 1.000°C</span>
                                <p class="mb-0 small text-muted">Nung nhiệt thấp để tiết kiệm nhiên liệu, đất chưa chín thấu, dễ mủn.</p>
                            </td>
                        </tr>

                        <tr>
                            <td class="criteria-title">
                                <strong>Hàm lượng Chì (Pb) & Cadmi (Cd)</strong>
                                <small class="d-block text-muted">Đo lường an toàn thực phẩm</small>
                            </td>
                            <td class="gomie-cell">
                                <span class="badge-good"><i class="fa-solid fa-check"></i> KPH (Không phát hiện)</span>
                                <p class="mb-0 small text-muted">Được kiểm định độc lập bởi QUATEST 1 theo quy chuẩn QCVN 12-4:2015/BYT.</p>
                            </td>
                            <td class="cheap-cell">
                                <span class="badge-bad"><i class="fa-solid fa-xmark"></i> Hàm lượng chì rất cao</span>
                                <p class="mb-0 small text-muted">Pha chì oxit vào men để tạo độ bóng và màu rực rỡ ở nhiệt độ nung thấp.</p>
                            </td>
                        </tr>

                        <tr>
                            <td class="criteria-title">
                                <strong>Nguyên liệu men phủ</strong>
                                <small class="d-block text-muted">Nguồn gốc màu sắc bề mặt gốm</small>
                            </td>
                            <td class="gomie-cell">
                                <span class="badge-good"><i class="fa-solid fa-check"></i> Men khoáng tự nhiên</span>
                                <p class="mb-0 small text-muted">Phối chế từ tro trấu, đá vôi, thạch anh tự nhiên; biến thiên ngẫu sinh trong lửa lò.</p>
                            </td>
                            <td class="cheap-cell">
                                <span class="badge-bad"><i class="fa-solid fa-xmark"></i> Phẩm màu hóa học & decal</span>
                                <p class="mb-0 small text-muted">Sử dụng phẩm màu công nghiệp, dễ bong tróc và phai màu khi cọ rửa.</p>
                            </td>
                        </tr>

                        <tr>
                            <td class="criteria-title">
                                <strong>Sử dụng trong Lò vi sóng & Máy rửa bát</strong>
                                <small class="d-block text-muted">Tiện ích trong đời sống hiện đại</small>
                            </td>
                            <td class="gomie-cell">
                                <span class="badge-good"><i class="fa-solid fa-check"></i> Hoàn toàn an toàn</span>
                                <p class="mb-0 small text-muted">Cốt gốm đanh chắc không hút ẩm, không tích nhiệt cục bộ, chịu chênh lệch nhiệt cao.</p>
                            </td>
                            <td class="cheap-cell">
                                <span class="badge-bad"><i class="fa-solid fa-xmark"></i> Nguy cơ nứt vỡ & giải phóng khí độc</span>
                                <p class="mb-0 small text-muted">Xương gốm xốp ngậm nước dễ nổ trong lò vi sóng, men trôi vào thức ăn.</p>
                            </td>
                        </tr>

                        <tr>
                            <td class="criteria-title">
                                <strong>Độ bền & Âm vang</strong>
                                <small class="d-block text-muted">Nhận biết bằng mắt và tai</small>
                            </td>
                            <td class="gomie-cell">
                                <span class="badge-good"><i class="fa-solid fa-check"></i> Âm thanh vang đanh như chuông</span>
                                <p class="mb-0 small text-muted">Gõ nhẹ phát ra tiếng coong thanh thoát, cầm đầm tay, viền bát khó sứt mẻ.</p>
                            </td>
                            <td class="cheap-cell">
                                <span class="badge-bad"><i class="fa-solid fa-xmark"></i> Âm thanh đục, xỉn màu nhanh</span>
                                <p class="mb-0 small text-muted">Tiếng cộp cộp nặng nề, đáy xốp hút nước ố đen sau thời gian ngắn sử dụng.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5-Step Quality Assurance Process -->
        <div class="quality-process-box p-4 p-md-5 rounded-4 bg-white shadow-sm mb-5">
            <div class="text-center mb-5">
                <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">Quy Trình Kiểm Soát</span>
                <h2 class="fw-bold text-dark mt-1">Hành Trình Tạo Ra Gốm Sứ An Toàn Tuyệt Đối</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    5 bước nghiêm ngặt bảo chứng cho từng sản phẩm gốm Gomie xuất xưởng về bàn ăn gia đình bạn.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg">
                    <div class="process-step-item text-center">
                        <div class="step-num">01</div>
                        <h4 class="step-title">Tuyển Đất Nguyên Sinh</h4>
                        <p class="step-desc text-muted small">Đất sét phù sa sông Hồng kết hợp cao lanh dẻo mịn, lọc sạch sạn đá và tạp chất hữu cơ.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg">
                    <div class="process-step-item text-center">
                        <div class="step-num">02</div>
                        <h4 class="step-title">Vuốt Nặn Thủ Công</h4>
                        <p class="step-desc text-muted small">Nghệ nhân tạo dáng trên bàn xoay truyền thống, phơi sấy tự nhiên tránh biến dạng.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg">
                    <div class="process-step-item text-center">
                        <div class="step-num">03</div>
                        <h4 class="step-title">Phối Men Khoáng</h4>
                        <p class="step-desc text-muted small">Công thức men gia truyền từ khoáng đá, tro nếp và phù sa, hoàn toàn không phẩm màu độc hại.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg">
                    <div class="process-step-item text-center">
                        <div class="step-num">04</div>
                        <h4 class="step-title">Nung Lò 1.300°C</h4>
                        <p class="step-desc text-muted small">Lò nung nhiệt cao khử oxy 36 tiếng, biến đổi silicat thành kết cấu gốm đanh đặc vĩnh cửu.</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg">
                    <div class="process-step-item text-center">
                        <div class="step-num">05</div>
                        <h4 class="step-title">Kiểm Định QUATEST 1</h4>
                        <p class="step-desc text-muted small">Gửi mẫu kiểm tra ngẫu nhiên định kỳ tại cơ quan độc lập, cấp chứng chỉ công khai minh bạch.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 200% Commitment Guarantee Banner -->
        <div class="commitment-guarantee-banner p-4 p-md-5 rounded-4 shadow-sm text-center mb-5">
            <div class="guarantee-icon-wrap mx-auto mb-3">
                <i class="fa-solid fa-shield-heart fa-3x text-white"></i>
            </div>
            <span class="guarantee-eyebrow text-uppercase fw-bold letter-spacing-2">CAM KẾT MINH BẠCH VÀNG</span>
            <h2 class="guarantee-title text-white fw-bold my-3">
                Bồi Thường 200% Nếu Phát Hiện Thôi Nhiễm Chì Độc Hại
            </h2>
            <p class="guarantee-desc text-white-50 mx-auto mb-4" style="max-width: 680px;">
                Gomie Ceramic tự tin chịu trách nhiệm cao nhất trước sức khỏe khách hàng. Nếu bất kỳ cơ quan kiểm định được nhà nước cấp phép phát hiện sản phẩm Gomie vượt ngưỡng thôi nhiễm chì hoặc cadmi theo chuẩn Bộ Y Tế, chúng tôi cam kết hoàn tiền và bồi thường gấp đôi giá trị đơn hàng.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-guarantee-act">
                    <i class="fa-solid fa-basket-shopping me-2"></i> Khám phá Bộ Sưu Tập Gốm An Toàn
                </a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-guarantee-contact">
                    <i class="fa-solid fa-file-contract me-2"></i> Yêu cầu Hồ Sơ Kiểm Định Dự Án (HoReCa)
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="cert-faq-box p-4 p-md-5 rounded-4 bg-white shadow-sm">
            <div class="text-center mb-4">
                <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">Giải Đáp Thắc Mắc</span>
                <h2 class="fw-bold text-dark mt-1">Câu Hỏi Thường Gặp Về An Toàn Gốm Sứ</h2>
            </div>

            <div class="accordion accordion-flush mx-auto" id="certFaqAccordion" style="max-width: 850px;">
                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                    <h3 class="accordion-header" id="faqHeading1">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                            Làm thế nào để nhận biết gốm sứ bị nhiễm độc chì khi mua ngoài thị trường?
                        </button>
                    </h3>
                    <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#certFaqAccordion">
                        <div class="accordion-body text-muted leading-relaxed">
                            Có 3 dấu hiệu cơ bản: (1) <strong>Màu sắc & hoa văn:</strong> Gốm nhiều chì thường có màu sắc sặc sỡ in nổi cộm trên mặt men, dùng tay sờ thấy nhám ráp; (2) <strong>Âm thanh gõ:</strong> Gõ nhẹ vào sản phẩm, nếu tiếng cộp đục nặng nề là gốm nung non nhiệt, gốm chuẩn nung 1.300°C sẽ vang thanh coong coong như chuông đồng; (3) <strong>Thử nghiệm giấm:</strong> Ngâm giấm trắng 24 giờ, nếu nước giấm đổi màu hoặc bề mặt men bị xỉn thì sản phẩm đã thôi nhiễm hóa chất.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                    <h3 class="accordion-header" id="faqHeading2">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                            Gốm sứ Gomie có dùng được trong lò nướng, lò vi sóng và máy rửa bát không?
                        </button>
                    </h3>
                    <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#certFaqAccordion">
                        <div class="accordion-body text-muted leading-relaxed">
                            <strong>Hoàn toàn an toàn.</strong> Nhờ nung ở nhiệt độ cao 1.300°C, cốt gốm Gomie đã được thủy tinh hóa liên kết đặc quánh, không hút ẩm và chịu được sốc nhiệt đột ngột từ 0°C đến 150°C. Bạn có thể sử dụng thoải mái trong lò vi sóng, máy rửa bát gia đình lẫn máy rửa bát công nghiệp tại các nhà hàng, khách sạn.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border rounded-3 overflow-hidden">
                    <h3 class="accordion-header" id="faqHeading3">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                            Khách hàng dự án (nhà hàng, resort, quà tặng công ty) có được cấp phiếu kiểm định QUATEST 1 gốc không?
                        </button>
                    </h3>
                    <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#certFaqAccordion">
                        <div class="accordion-body text-muted leading-relaxed">
                            <strong>Có.</strong> Đối với các đơn hàng cung cấp cho nhà hàng, khách sạn hoặc hợp đồng quà tặng doanh nghiệp số lượng lớn, Gomie luôn bàn giao đầy đủ hồ sơ pháp lý gồm: Bản sao công chứng Kết quả thử nghiệm QUATEST 1, Giấy chứng nhận xuất xứ Bát Tràng (CO), và Hóa đơn VAT hợp lệ để phục vụ công tác thanh kiểm tra an toàn vệ sinh thực phẩm.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Lightbox for Full Certificate View -->
<div id="certLightboxModal" class="cert-modal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="cert-modal-backdrop" onclick="closeCertModal()"></div>
    <div class="cert-modal-container">
        <div class="cert-modal-header d-flex justify-content-between align-items-center">
            <h4 class="cert-modal-title mb-0" id="modalCertTitle">Phiếu Kết Quả Thử Nghiệm QUATEST 1</h4>
            <button type="button" class="btn-close-modal" onclick="closeCertModal()" aria-label="Đóng">&times;</button>
        </div>
        <div class="cert-modal-body text-center">
            <img id="modalCertImg" src="" alt="Chứng nhận kiểm định" class="img-fluid cert-modal-zoom-img" />
        </div>
        <div class="cert-modal-footer d-flex justify-content-between align-items-center">
            <span class="small text-muted"><i class="fa-solid fa-stamp text-danger me-1"></i> Trung tâm Kỹ thuật Tiêu chuẩn Đo lường Chất lượng 1</span>
            <a id="modalDownloadBtn" href="" target="_blank" download class="btn-modal-download">
                <i class="fa-solid fa-download me-1"></i> Mở ảnh gốc
            </a>
        </div>
    </div>
</div>

<style>
/* ==========================================================================
   GOMIE CERTIFICATE & TRANSPARENCY PAGE STYLES
   ========================================================================== */
.gomie-cert-page-canvas {
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
.cert-hero-section {
    padding: 3rem 1rem 2.5rem;
    border-bottom: 1px solid rgba(224, 89, 42, 0.12);
}
.cert-breadcrumb .breadcrumb {
    background: transparent;
    font-size: 0.88rem;
}
.cert-breadcrumb a {
    color: #8c827a;
    text-decoration: none;
}
.cert-breadcrumb a:hover {
    color: #e0592a;
}
.cert-breadcrumb .active {
    color: #e0592a;
    font-weight: 600;
}

.cert-pill-badge {
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

.cert-hero-title {
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800;
    color: #1a1f2c;
    letter-spacing: -0.5px;
    line-height: 1.25;
    margin-bottom: 1.2rem;
}
.cert-hero-title .highlight-orange {
    color: #e0592a;
}
.cert-hero-desc {
    max-width: 780px;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #5c554e;
}

/* Trust Bar */
.trust-badge-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #ffffff;
    padding: 0.65rem 1.2rem;
    border-radius: 14px;
    border: 1px solid rgba(224, 89, 42, 0.12);
    box-shadow: 0 4px 12px rgba(180, 140, 100, 0.06);
    text-align: left;
}
.trust-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.trust-icon.fire { background: rgba(224, 89, 42, 0.12); color: #e0592a; }
.trust-icon.cert { background: rgba(217, 119, 6, 0.12); color: #d97706; }
.trust-icon.safe { background: rgba(5, 150, 105, 0.12); color: #059669; }
.trust-icon.standard { background: rgba(37, 99, 235, 0.12); color: #2563eb; }

.trust-text strong {
    font-size: 0.9rem;
    color: #1a1f2c;
    display: block;
    line-height: 1.2;
}
.trust-text small {
    font-size: 0.75rem;
}

/* Official Banner Card */
.official-banner-card {
    border: 1px solid rgba(224, 89, 42, 0.15);
}
.sub-pill-dark {
    font-size: 0.75rem;
    font-weight: 700;
    color: #e0592a;
    letter-spacing: 1px;
}
.section-heading-dark {
    font-size: clamp(1.5rem, 2.5vw, 2.2rem);
    color: #1a1f2c;
    line-height: 1.3;
}
.cert-highlight-list li {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #4a453f;
}

.btn-cert-primary {
    background: #e0592a;
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding: 0.75rem 1.6rem;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(224, 89, 42, 0.35);
    transition: all 0.25s ease;
}
.btn-cert-primary:hover {
    background: #c4471b;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(224, 89, 42, 0.45);
}
.btn-cert-outline {
    background: transparent;
    color: #1a1f2c;
    border: 1px solid rgba(0,0,0,0.15);
    border-radius: 999px;
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-cert-outline:hover {
    background: #1a1f2c;
    color: #fff;
}

.cert-img-frame {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border: 3px solid #fbf8f3;
}
.cert-img-frame img {
    width: 100%;
    transition: transform 0.4s ease;
}
.cert-img-frame:hover img {
    transform: scale(1.03);
}
.cert-frame-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.4);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease;
}
.cert-img-frame:hover .cert-frame-overlay {
    opacity: 1;
}
.overlay-pill {
    background: #ffffff;
    color: #1a1f2c;
    padding: 0.5rem 1.2rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 700;
}

/* Report Cards */
.report-card-v11 {
    border: 1px solid rgba(224, 89, 42, 0.12);
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease;
}
.report-card-v11:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 36px rgba(224, 89, 42, 0.12);
    border-color: rgba(224, 89, 42, 0.3);
}
.badge-quatest {
    background: #1e3a8a;
    color: #fff;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 0.25rem 0.6rem;
    border-radius: 6px;
}
.badge-status-pass {
    background: rgba(5, 150, 105, 0.1);
    color: #059669;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
    border: 1px solid rgba(5, 150, 105, 0.25);
}

.report-sample-img {
    background: #fbf8f3;
    border-radius: 12px;
    padding: 0.75rem;
    position: relative;
    overflow: hidden;
}
.report-sample-img img {
    max-height: 160px;
    object-fit: contain;
}
.img-zoom-hint {
    font-size: 0.75rem;
    color: #e0592a;
    font-weight: 600;
    margin-top: 0.4rem;
}

.test-table {
    font-size: 0.85rem;
}
.test-table th {
    background: #fbf8f3;
    font-size: 0.75rem;
    color: #666;
    font-weight: 700;
    border: none;
    padding: 0.5rem;
}
.test-table td {
    padding: 0.5rem;
    border-color: rgba(0,0,0,0.05);
}

.btn-view-tested-prod {
    font-size: 0.85rem;
    color: #e0592a;
    text-decoration: none;
    font-weight: 700;
    transition: color 0.2s;
}
.btn-view-tested-prod:hover {
    color: #c4471b;
}

/* Comparison Table */
.comparison-section-box {
    border: 1px solid rgba(224, 89, 42, 0.12);
}
.comparison-table th {
    padding: 1.25rem 1rem;
    font-size: 1rem;
    border-bottom: 2px solid rgba(224, 89, 42, 0.2);
}
.comparison-table .col-criteria {
    width: 30%;
    color: #1a1f2c;
}
.comparison-table .col-gomie {
    width: 35%;
    background: rgba(224, 89, 42, 0.05);
    color: #b3471e;
    font-weight: 700;
    border-radius: 12px 12px 0 0;
}
.comparison-table .col-cheap {
    width: 35%;
    color: #dc2626;
    font-weight: 700;
}
.comparison-table td {
    padding: 1.1rem 1rem;
    border-color: rgba(0,0,0,0.06);
}
.comparison-table .gomie-cell {
    background: rgba(224, 89, 42, 0.02);
}
.badge-good {
    display: inline-block;
    background: #059669;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    margin-bottom: 0.4rem;
}
.badge-bad {
    display: inline-block;
    background: #dc2626;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 700;
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    margin-bottom: 0.4rem;
}

/* Process */
.quality-process-box {
    border: 1px solid rgba(224, 89, 42, 0.12);
}
.process-step-item {
    padding: 1.5rem 1rem;
    background: #fbf8f3;
    border-radius: 16px;
    height: 100%;
    border: 1px solid rgba(224, 89, 42, 0.1);
    transition: transform 0.25s ease;
}
.process-step-item:hover {
    transform: translateY(-4px);
    border-color: #e0592a;
}
.step-num {
    width: 44px;
    height: 44px;
    background: #e0592a;
    color: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.1rem;
    margin: 0 auto 1rem;
}
.step-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1f2c;
    margin-bottom: 0.5rem;
}

/* Guarantee Banner */
.commitment-guarantee-banner {
    background: linear-gradient(135deg, #1a1f2c 0%, #2b3346 100%);
    border: 2px solid #e0592a;
}
.guarantee-icon-wrap {
    width: 72px;
    height: 72px;
    background: rgba(224, 89, 42, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e0592a;
}
.guarantee-eyebrow {
    color: #e0592a;
    font-size: 0.85rem;
}
.guarantee-title {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
}
.btn-guarantee-act {
    background: #e0592a;
    color: #ffffff;
    padding: 0.8rem 2rem;
    border-radius: 999px;
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(224, 89, 42, 0.4);
    transition: all 0.25s;
}
.btn-guarantee-act:hover {
    background: #c4471b;
    color: #fff;
    transform: translateY(-2px);
}
.btn-guarantee-contact {
    background: transparent;
    color: #ffffff;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.8rem 1.8rem;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-guarantee-contact:hover {
    background: #ffffff;
    color: #1a1f2c;
}

/* Lightbox Modal */
.cert-modal {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.cert-modal.active {
    display: flex;
}
.cert-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(8px);
}
.cert-modal-container {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    max-width: 960px;
    width: 100%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    z-index: 2;
}
.cert-modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    background: #fbf8f3;
}
.cert-modal-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1f2c;
}
.btn-close-modal {
    background: transparent;
    border: none;
    font-size: 2rem;
    line-height: 1;
    color: #666;
    cursor: pointer;
}
.btn-close-modal:hover {
    color: #000;
}
.cert-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    background: #2b2b2b;
}
.cert-modal-zoom-img {
    max-height: 65vh;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}
.cert-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(0,0,0,0.1);
    background: #fbf8f3;
}
.btn-modal-download {
    background: #e0592a;
    color: #fff;
    padding: 0.4rem 1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
}
.btn-modal-download:hover {
    background: #c4471b;
    color: #fff;
}
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
function openCertModal(imgSrc, title) {
    const modal = document.getElementById('certLightboxModal');
    const modalImg = document.getElementById('modalCertImg');
    const modalTitle = document.getElementById('modalCertTitle');
    const downloadBtn = document.getElementById('modalDownloadBtn');
    
    if (modal && modalImg) {
        modalImg.src = imgSrc;
        if (modalTitle) modalTitle.textContent = title || 'Phiếu Kết Quả Thử Nghiệm QUATEST 1';
        if (downloadBtn) downloadBtn.href = imgSrc;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeCertModal() {
    const modal = document.getElementById('certLightboxModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCertModal();
    }
});
</script>

<?php get_footer(); ?>
