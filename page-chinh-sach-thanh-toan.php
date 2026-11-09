<?php
/**
 * Template Name: Chính Sách Thanh Toán & Hóa Đơn Gomie
 * Template Post Type: page
 *
 * @package Gomie
 */

get_header();
?>

<div class="gomie-policy-canvas">
    
    <!-- 1. Breadcrumbs Bar -->
    <div class="gomie-policy-breadcrumbs">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house-chimney me-1"></i> Trang chủ</a>
            <span class="separator">/</span>
            <span class="current">Chính Sách Thanh Toán</span>
        </div>
    </div>

    <!-- 2. Hero Section -->
    <section class="gomie-policy-hero">
        <div class="container">
            <span class="badge-pill">
                <i class="fa-solid fa-credit-card"></i> GIAO DỊCH MINH BẠCH &amp; AN TOÀN
            </span>
            <h1 class="policy-title">
                Chính Sách Thanh Toán &amp; <span class="highlight">Hóa Đơn Tài Chính</span>
            </h1>
            <div class="policy-updated-date">
                <i class="fa-regular fa-clock"></i> Cập nhật lần cuối: Ngày 01 Tháng 11 Năm 2026 · Hỗ trợ xuất VAT điện tử toàn diện
            </div>

            <!-- Trust Badges -->
            <div class="policy-trust-badges">
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-money-bill-wave"></i> Thanh Toán Tiền Mặt Khi Nhận Hàng (COD)
                </div>
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-qrcode"></i> Chuyển Khoản QR Code 24/7 Nhanh Chóng
                </div>
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Xuất Hóa Đơn Điện Tử VAT Đầy Đủ
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Policy Content Layout (2 Columns) -->
    <div class="container">
        <div class="policy-layout-grid">
            
            <!-- Sticky TOC Sidebar (Left) -->
            <aside class="policy-sidebar">
                <div class="policy-sidebar-sticky">
                    <div class="policy-toc-card">
                        <div class="policy-toc-title">
                            <i class="fa-solid fa-list-check"></i> Mục Lục Thanh Toán
                        </div>
                        <ul class="policy-toc-nav">
                            <li><a href="#phuong-thuc-ban-le"><span class="toc-num">01</span> Phương thức thanh toán bán lẻ</a></li>
                            <li><a href="#huong-dan-chuyen-khoan"><span class="toc-num">02</span> Thông tin tài khoản ngân hàng</a></li>
                            <li><a href="#thanh-toan-du-an-b2b"><span class="toc-num">03</span> Quy trình thanh toán dự án B2B</a></li>
                            <li><a href="#xuat-hoa-don-vat"><span class="toc-num">04</span> Quy định xuất hóa đơn VAT điện tử</a></li>
                            <li><a href="#an-toan-giao-dich"><span class="toc-num">05</span> Cam kết bảo mật thanh toán</a></li>
                        </ul>
                    </div>

                    <!-- Quick Support Card -->
                    <div class="policy-quick-help-card">
                        <h5>Cần Xuất Hóa Đơn VAT?</h5>
                        <p>Vui lòng gửi thông tin Mã số thuế, Tên đơn vị và Email qua Zalo kế toán hoặc Hotline để nhận hóa đơn trong ngày.</p>
                        <a href="tel:0335059889" class="policy-quick-help-btn">
                            <i class="fa-solid fa-phone"></i> Kế Toán: 0335 059 889
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area (Right) -->
            <main class="policy-article-card">
                
                <!-- Notice Callout -->
                <div class="policy-callout callout-terracotta">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <h6>Tiện Lợi · Linh Hoạt · Pháp Lý Rõ Ràng</h6>
                        <p>
                            Gomie Ceramic cung cấp các giải pháp thanh toán linh hoạt, tiện lợi nhất cho cả người tiêu dùng cá nhân lẫn các tổ chức, tập đoàn doanh nghiệp và chuỗi nhà hàng khách sạn trên cả nước.
                        </p>
                    </div>
                </div>

                <!-- Section 1 -->
                <section id="phuong-thuc-ban-le" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">01</span>
                        <h2 class="policy-section-title">Các Phương Thức Thanh Toán Dành Cho Khách Hàng Cá Nhân</h2>
                    </div>
                    <p>Khi mua sắm trực tuyến trên hệ thống Gomie Ceramic, quý khách có thể lựa chọn các hình thức thanh toán sau:</p>
                    
                    <div class="policy-timeline-grid">
                        <div class="policy-timeline-step">
                            <span class="step-badge"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                            <h6>1. Thanh Toán COD</h6>
                            <p>Thanh toán bằng tiền mặt trực tiếp cho nhân viên giao hàng sau khi mở hộp đồng kiểm gốm sứ nguyên vẹn.</p>
                        </div>
                        <div class="policy-timeline-step">
                            <span class="step-badge"><i class="fa-solid fa-building-columns"></i></span>
                            <h6>2. Chuyển Khoản 24/7</h6>
                            <p>Quét mã QR Code hiển thị tại trang hoàn tất đơn hàng hoặc chuyển khoản qua Internet Banking Napas 24/7.</p>
                        </div>
                        <div class="policy-timeline-step">
                            <span class="step-badge"><i class="fa-regular fa-credit-card"></i></span>
                            <h6>3. Thẻ &amp; Ví Điện Tử</h6>
                            <p>Thanh toán trực tuyến bằng thẻ ATM nội địa, thẻ quốc tế Visa / MasterCard thông qua cổng bảo mật tiêu chuẩn.</p>
                        </div>
                    </div>
                </section>

                <!-- Section 2 -->
                <section id="huong-dan-chuyen-khoan" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">02</span>
                        <h2 class="policy-section-title">Thông Tin Tài Khoản Ngân Hàng Chính Thức</h2>
                    </div>
                    <p>
                        Nhằm đảm bảo an toàn tuyệt đối, tránh các trường hợp giả mạo thông tin, quý khách chỉ thực hiện chuyển khoản đến tài khoản chính thức của Gomie sau đây:
                    </p>
                    
                    <div class="policy-table-responsive">
                        <table class="policy-table">
                            <thead>
                                <tr>
                                    <th>Thông tin</th>
                                    <th>Chi tiết tài khoản doanh nghiệp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Đơn vị thụ hưởng</strong></td>
                                    <td><strong class="text-danger">CÔNG TY TNHH GỐM SỨ GOMIE VIỆT NAM</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Ngân hàng</strong></td>
                                    <td>Ngân hàng TMCP Quân Đội (MB Bank) - Chi nhánh Hà Nội</td>
                                </tr>
                                <tr>
                                    <td><strong>Số tài khoản</strong></td>
                                    <td><code style="font-size: 1.15rem; font-weight: 700; color: #e0592a;">0335059889</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Nội dung chuyển khoản</strong></td>
                                    <td><code>[Mã đơn hàng] - [Số điện thoại đặt hàng]</code> (Ví dụ: <em>DH5860 - 0912345678</em>)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="policy-callout callout-warning">
                        <i class="fa-solid fa-bell"></i>
                        <div>
                            <h6>Lưu Ý Quan Trọng Khi Chuyển Khoản</h6>
                            <p>Hệ thống tự động kích hoạt xử lý đơn hàng ngay khi nhận được biến động số dư khớp đúng cú pháp. Trường hợp quý khách quên ghi mã đơn hàng, vui lòng gọi ngay Hotline <strong>0335 059 889</strong> để được kế toán đối soát xác nhận thủ công.</p>
                        </div>
                    </div>
                </section>

                <!-- Section 3 -->
                <section id="thanh-toan-du-an-b2b" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">03</span>
                        <h2 class="policy-section-title">Quy Trình Thanh Toán Đơn Hàng Dự Án B2B &amp; Hợp Đồng</h2>
                    </div>
                    <p>
                        Đối với các đơn hàng cung cấp gốm sứ cho Nhà hàng, Khách sạn, Resort và Quà tặng doanh nghiệp có ký kết hợp đồng kinh tế, tiến độ thanh toán được thực hiện theo 2 giai đoạn tiêu chuẩn:
                    </p>
                    <ul>
                        <li><strong>Đợt 1 (Tạm ứng sản xuất):</strong> Quý đối tác tạm ứng <strong>40% - 50%</strong> giá trị hợp đồng ngay sau khi hai bên ký kết hợp đồng kinh tế và phê duyệt mẫu thử thực tế để xưởng gom đất sét và lên lò nung $1.300^\circ\text{C}$.</li>
                        <li><strong>Đợt 2 (Tất toán hợp đồng):</strong> Quý đối tác thanh toán nốt <strong>50% - 60%</strong> giá trị còn lại trong vòng <strong>05 đến 07 ngày làm việc</strong> sau khi Gomie hoàn tất việc giao hàng tại chân công trình, hai bên ký biên bản nghiệm thu số lượng &amp; chất lượng, kèm theo hóa đơn điện tử GTGT hợp lệ.</li>
                    </ul>
                </section>

                <!-- Section 4 -->
                <section id="xuat-hoa-don-vat" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">04</span>
                        <h2 class="policy-section-title">Quy Định Xuất Hóa Đơn Giá Trị Gia Tăng (VAT)</h2>
                    </div>
                    <p>
                        Gomie Ceramic hỗ trợ phát hành hóa đơn điện tử hợp pháp theo đúng quy định tại Nghị định 123/2020/NĐ-CP và Thông tư 78/2021/TT-BTC của Bộ Tài chính:
                    </p>
                    <ul>
                        <li><strong>Giá niêm yết:</strong> Toàn bộ giá bán sản phẩm trên website và bảng báo giá dự án đều có thể xuất hóa đơn VAT theo đúng phân loại thuế suất hiện hành.</li>
                        <li><strong>Thời hạn yêu cầu xuất hóa đơn:</strong> Quý khách hàng vui lòng cung cấp thông tin xuất hóa đơn trong ngày hoặc tối đa trong vòng <strong>24 giờ</strong> sau khi đặt hàng thành công.</li>
                        <li><strong>Hình thức gửi hóa đơn:</strong> Hóa đơn điện tử có chữ ký số hợp lệ của Công ty TNHH Gốm Sứ Gomie Việt Nam sẽ được hệ thống tự động gửi trực tiếp về địa chỉ Email quý khách đã đăng ký.</li>
                    </ul>
                </section>

                <!-- Section 5 -->
                <section id="an-toan-giao-dich" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">05</span>
                        <h2 class="policy-section-title">Cam Kết An Toàn &amp; Bảo Mật Giao Dịch</h2>
                    </div>
                    <p>
                        Gomie áp dụng tiêu chuẩn bảo mật dữ liệu thẻ thanh toán quốc tế:
                    </p>
                    <ul>
                        <li>Gomie hoàn toàn <strong>KHÔNG LƯU TRỮ</strong> bất kỳ thông tin nhạy cảm nào liên quan đến thẻ ngân hàng (số thẻ, mã CVV/CVC, mật khẩu OTP) của khách hàng trên hệ thống máy chủ của mình.</li>
                        <li>Toàn bộ quá trình xử lý giao dịch thanh toán thẻ đều được điều hướng trực tiếp qua cổng thanh toán được cấp phép bởi Ngân hàng Nhà nước Việt Nam với chứng chỉ bảo mật SSL 256-bit.</li>
                    </ul>
                </section>

                <!-- Policy Footer Signature -->
                <div class="policy-signature-block">
                    <div class="policy-company-info">
                        <strong>CÔNG TY TNHH GỐM SỨ GOMIE VIỆT NAM</strong>
                        <span>Phòng Kế Toán &amp; Quản Trị Tài Chính Doanh Nghiệp</span><br>
                        <span>Mã số thuế: 0110702160 · Hotline tài chính: 0335 059 889</span>
                    </div>
                    <div class="policy-seal-badge">
                        <i class="fa-solid fa-file-shield"></i>
                        <span>GIAO DỊCH MINH BẠCH<br><small>Hóa đơn điện tử đầy đủ</small></span>
                    </div>
                </div>

            </main>

        </div><!-- .policy-layout-grid -->
    </div><!-- .container -->

</div><!-- .gomie-policy-canvas -->

<?php
get_footer();
