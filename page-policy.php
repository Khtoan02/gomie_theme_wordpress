<?php
/**
 * Template Name: Chính Sách Bảo Mật & Điều Khoản Gomie
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
            <span class="current">Chính Sách Bảo Mật</span>
        </div>
    </div>

    <!-- 2. Hero Section -->
    <section class="gomie-policy-hero">
        <div class="container">
            <span class="badge-pill">
                <i class="fa-solid fa-shield-halved"></i> GOMIE CERAMIC · MINH BẠCH &amp; PHÁP LÝ
            </span>
            <h1 class="policy-title">
                Chính Sách Bảo Mật &amp; <span class="highlight">Bảo Vệ Dữ Liệu</span>
            </h1>
            <div class="policy-updated-date">
                <i class="fa-regular fa-clock"></i> Cập nhật lần cuối: Ngày 01 Tháng 11 Năm 2026 · Áp dụng toàn hệ thống
            </div>

            <!-- Trust Badges -->
            <div class="policy-trust-badges">
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-lock"></i> Chuẩn Nghị định 13/2023/NĐ-CP
                </div>
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-key"></i> Mã hóa SSL 256-bit An Toàn
                </div>
                <div class="policy-trust-badge">
                    <i class="fa-solid fa-hand-holding-hand"></i> Không Chia Sẻ Dữ Liệu Thứ Ba
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
                            <i class="fa-solid fa-list-check"></i> Mục Lục Điều Khoản
                        </div>
                        <ul class="policy-toc-nav">
                            <li><a href="#muc-dich-thu-thap"><span class="toc-num">01</span> Mục đích thu thập dữ liệu</a></li>
                            <li><a href="#pham-vi-thu-thap"><span class="toc-num">02</span> Phạm vi thông tin thu thập</a></li>
                            <li><a href="#pham-vi-su-dung"><span class="toc-num">03</span> Phạm vi sử dụng thông tin</a></li>
                            <li><a href="#thoi-gian-luu-tru"><span class="toc-num">04</span> Thời gian lưu trữ dữ liệu</a></li>
                            <li><a href="#ben-thu-ba"><span class="toc-num">05</span> Tiếp cận của bên thứ ba</a></li>
                            <li><a href="#an-toan-thong-tin"><span class="toc-num">06</span> Biện pháp bảo mật &amp; an toàn</a></li>
                            <li><a href="#quyen-khach-hang"><span class="toc-num">07</span> Quyền hạn của khách hàng</a></li>
                            <li><a href="#tiep-nhan-khieu-nai"><span class="toc-num">08</span> Cơ chế khiếu nại &amp; hỗ trợ</a></li>
                        </ul>
                    </div>

                    <!-- Quick Support Card -->
                    <div class="policy-quick-help-card">
                        <h5>Cần Hỗ Trợ Pháp Lý?</h5>
                        <p>Đội ngũ chuyên viên của Gomie sẵn sàng giải đáp mọi thắc mắc về quyền riêng tư và dữ liệu cá nhân của bạn.</p>
                        <a href="tel:0335059889" class="policy-quick-help-btn">
                            <i class="fa-solid fa-phone"></i> Hotline: 0335 059 889
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area (Right) -->
            <main class="policy-article-card">
                
                <!-- Intro Notice Box -->
                <div class="policy-callout callout-terracotta">
                    <i class="fa-solid fa-circle-info"></i>
                    <div>
                        <h6>Lời Cam Kết Từ Gomie Ceramic</h6>
                        <p>
                            Gomie hiểu rằng sự riêng tư và an toàn thông tin cá nhân là nền tảng của mọi mối quan hệ tri kỷ. Chúng tôi cam kết bảo vệ dữ liệu của quý khách hàng theo các tiêu chuẩn khắt khe nhất của pháp luật Việt Nam (Nghị định 13/2023/NĐ-CP và Nghị định 52/2013/NĐ-CP).
                        </p>
                    </div>
                </div>

                <!-- Section 1 -->
                <section id="muc-dich-thu-thap" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">01</span>
                        <h2 class="policy-section-title">Mục Đích Thu Thập Dữ Liệu Cá Nhân</h2>
                    </div>
                    <p>
                        Gomie Ceramic chỉ thu thập thông tin cá nhân trong phạm vi cần thiết nhằm phục vụ các mục đích chính đáng sau:
                    </p>
                    <ul>
                        <li><strong>Xử lý đơn hàng:</strong> Xác nhận đơn hàng, lên đơn xuất kho xưởng gốm Bát Tràng và điều phối vận chuyển sản phẩm đến đúng địa chỉ khách hàng yêu cầu.</li>
                        <li><strong>Dịch vụ bảo hành &amp; đổi trả:</strong> Theo dõi lịch sử mua sắm để hỗ trợ bảo hành màu men, bù vỡ sản phẩm do vận chuyển nhanh chóng mà không cần khách hàng lưu giữ hóa đơn giấy tờ phức tạp.</li>
                        <li><strong>Tư vấn dự án B2B:</strong> Tiếp nhận thông tin từ các đối tác nhà hàng, khách sạn, doanh nghiệp để lập hồ sơ báo giá, thiết kế ma-két mockup 3D và gửi mẫu đối chứng.</li>
                        <li><strong>Xuất hóa đơn tài chính:</strong> Phát hành hóa đơn điện tử GTGT (VAT) hợp pháp theo quy định của Tổng cục Thuế.</li>
                        <li><strong>Chăm sóc khách hàng:</strong> Gửi thông báo về tiến độ đơn hàng, cẩm nang bảo quản gốm sứ và các chương trình ưu đãi đặc quyền dành riêng cho khách hàng thân thiết.</li>
                    </ul>
                </section>

                <!-- Section 2 -->
                <section id="pham-vi-thu-thap" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">02</span>
                        <h2 class="policy-section-title">Phạm Vi Thông Tin Thu Thập</h2>
                    </div>
                    <p>
                        Tùy thuộc vào phương thức tương tác trên website và đơn hàng, các thông tin Gomie thu thập bao gồm:
                    </p>
                    <ul>
                        <li><strong>Thông tin định danh cơ bản:</strong> Họ và tên, số điện thoại liên lạc, địa chỉ email, địa chỉ giao nhận hàng hóa.</li>
                        <li><strong>Thông tin doanh nghiệp (Dành cho khách hàng B2B):</strong> Tên công ty/nhà hàng/khách sạn, Mã số thuế, địa chỉ trụ sở đăng ký kinh doanh, người đại diện nhận hàng.</li>
                        <li><strong>Thông tin giao dịch:</strong> Chi tiết sản phẩm đặt mua, số lượng, giá trị giao dịch, phương thức thanh toán đã lựa chọn và lịch sử khiếu nại (nếu có).</li>
                        <li><strong>Thông tin kỹ thuật số:</strong> Địa chỉ IP, loại trình duyệt, thời gian truy cập thông qua hệ thống cookie ẩn danh nhằm tối ưu hóa tốc độ tải trang và trải nghiệm người dùng.</li>
                    </ul>
                </section>

                <!-- Section 3 -->
                <section id="pham-vi-su-dung" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">03</span>
                        <h2 class="policy-section-title">Phạm Vi Sử Dụng Thông Tin</h2>
                    </div>
                    <p>
                        Thông tin thu thập được chỉ sử dụng trong phạm vi nội bộ của Gomie Ceramic và phục vụ trực tiếp cho lợi ích của quý khách hàng:
                    </p>
                    <div class="policy-callout callout-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <div>
                            <h6>Nguyên Tắc Bất Di Bất Dịch</h6>
                            <p>Gomie tuyệt đối <strong>KHÔNG</strong> bán, chia sẻ, cho thuê hoặc chuyển giao dữ liệu cá nhân của quý khách cho bất kỳ bên thứ ba nào vì mục đích quảng cáo hoặc tiếp thị thương mại khi chưa có sự đồng thuận rõ ràng.</p>
                        </div>
                    </div>
                    <p>
                        Thông tin chỉ được chia sẻ trong trường hợp bất khả kháng theo yêu cầu bằng văn bản của cơ quan pháp luật có thẩm quyền của Nhà nước Việt Nam.
                    </p>
                </section>

                <!-- Section 4 -->
                <section id="thoi-gian-luu-tru" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">04</span>
                        <h2 class="policy-section-title">Thời Gian Lưu Trữ Thông Tin</h2>
                    </div>
                    <p>
                        Dữ liệu cá nhân của khách hàng sẽ được lưu trữ an toàn trong suốt thời gian hệ thống vận hành và duy trì tài khoản. 
                    </p>
                    <p>
                        Đối với hồ sơ chứng từ kế toán và hóa đơn điện tử, thời gian lưu trữ tối thiểu là 10 năm theo quy định của Luật Kế toán Việt Nam. Trong mọi trường hợp khác, dữ liệu sẽ được xóa bỏ vĩnh viễn khi có yêu cầu bằng văn bản hoặc email từ chính chủ thể dữ liệu.
                    </p>
                </section>

                <!-- Section 5 -->
                <section id="ben-thu-ba" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">05</span>
                        <h2 class="policy-section-title">Các Đơn Vị Được Tiếp Cận Dữ Liệu</h2>
                    </div>
                    <p>
                        Để đảm bảo sản phẩm gốm sứ được trao đến tay khách hàng nguyên vẹn và an toàn, chỉ các đối tác cung cấp dịch vụ được ủy quyền sau mới có thể tiếp cận một phần thông tin cần thiết:
                    </p>
                    <div class="policy-table-responsive">
                        <table class="policy-table">
                            <thead>
                                <tr>
                                    <th>Đối tượng tiếp nhận</th>
                                    <th>Phạm vi thông tin</th>
                                    <th>Mục đích sử dụng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Đơn vị vận chuyển</strong><br><small class="text-muted">(Viettel Post, GHTK, xe tải chuyên dụng)</small></td>
                                    <td>Tên người nhận, số điện thoại, địa chỉ nhận hàng</td>
                                    <td>Giao hàng tận tay, đồng kiểm gốm sứ chống bể vỡ</td>
                                </tr>
                                <tr>
                                    <td><strong>Cổng thanh toán điện tử</strong><br><small class="text-muted">(Napas, ngân hàng đối tác)</small></td>
                                    <td>Mã đơn hàng, số tiền thanh toán</td>
                                    <td>Xác thực giao dịch chuyển khoản trực tiếp an toàn</td>
                                </tr>
                                <tr>
                                    <td><strong>Cơ quan Thuế / Nhà nước</strong></td>
                                    <td>Hóa đơn điện tử, thông tin xuất hóa đơn VAT</td>
                                    <td>Thực hiện nghĩa vụ thuế theo quy định pháp luật</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Section 6 -->
                <section id="an-toan-thong-tin" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">06</span>
                        <h2 class="policy-section-title">Biện Pháp An Toàn &amp; Bảo Mật Kỹ Thuật</h2>
                    </div>
                    <p>
                        Gomie triển khai các biện pháp bảo vệ toàn diện cả về mặt công nghệ lẫn quy trình quản lý:
                    </p>
                    <ul>
                        <li><strong>Mã hóa kết nối SSL/TLS:</strong> Mọi dữ liệu truyền tải giữa máy tính người dùng và hệ thống máy chủ Gomie đều được mã hóa theo tiêu chuẩn 256-bit cao cấp nhất.</li>
                        <li><strong>Tường lửa đa lớp (WAF):</strong> Hệ thống giám sát 24/7 ngăn chặn các cuộc tấn công DDoS, tiêm mã độc hoặc truy cập trái phép.</li>
                        <li><strong>Phân quyền truy cập nội bộ:</strong> Chỉ nhân sự được phân công trực tiếp chịu trách nhiệm đơn hàng mới có quyền truy xuất thông tin khách hàng, có ghi nhận nhật ký (access log).</li>
                    </ul>
                </section>

                <!-- Section 7 -->
                <section id="quyen-khach-hang" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">07</span>
                        <h2 class="policy-section-title">Quyền Hạn Của Khách Hàng Đối Với Dữ Liệu</h2>
                    </div>
                    <p>
                        Căn cứ theo Điều 9 Nghị định 13/2023/NĐ-CP, quý khách hàng có toàn quyền thực thi các quyền sau bất cứ lúc nào:
                    </p>
                    <ol>
                        <li><strong>Quyền được biết &amp; truy cập:</strong> Yêu cầu Gomie cung cấp bản sao thông tin cá nhân của mình đang được lưu trữ.</li>
                        <li><strong>Quyền đính chính:</strong> Yêu cầu cập nhật hoặc sửa đổi các thông tin chưa chính xác.</li>
                        <li><strong>Quyền xóa dữ liệu:</strong> Yêu cầu xóa vĩnh viễn dữ liệu tài khoản và thông tin liên lạc khỏi cơ sở dữ liệu.</li>
                        <li><strong>Quyền rút lại sự đồng ý:</strong> Từ chối nhận các thông báo khuyến mãi, tiếp thị hoặc bản tin cẩm nang.</li>
                    </ol>
                </section>

                <!-- Section 8 -->
                <section id="tiep-nhan-khieu-nai" class="policy-section">
                    <div class="policy-section-header">
                        <span class="policy-section-num">08</span>
                        <h2 class="policy-section-title">Cơ Chế Tiếp Nhận &amp; Giải Quyết Khiếu Nại</h2>
                    </div>
                    <p>
                        Nếu nghi ngờ dữ liệu cá nhân bị sử dụng sai mục đích hoặc vi phạm các điều khoản cam kết, quý khách vui lòng liên hệ ngay với Bộ phận Bảo vệ dữ liệu của Gomie qua các kênh tiếp nhận sau:
                    </p>
                    <div class="policy-callout callout-success">
                        <i class="fa-solid fa-headset"></i>
                        <div>
                            <h6>Đầu Mối Tiếp Nhận Khiếu Nại Dữ Liệu</h6>
                            <p>
                                <strong>Người phụ trách:</strong> Ban Pháp chế &amp; Bảo mật Thông tin · Công ty TNHH Gốm Sứ Gomie Việt Nam<br>
                                <strong>Hotline trực tiếp:</strong> 0335 059 889 (8h00 - 21h00 các ngày trong tuần)<br>
                                <strong>Email chuyên trách:</strong> <a href="mailto:cskh@gomie.vn">cskh@gomie.vn</a><br>
                                <strong>Thời hạn xử lý:</strong> Phản hồi bằng văn bản và giải quyết dứt điểm trong vòng <strong>48 giờ làm việc</strong> kể từ khi tiếp nhận.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Policy Footer Signature -->
                <div class="policy-signature-block">
                    <div class="policy-company-info">
                        <strong>CÔNG TY TNHH GỐM SỨ GOMIE VIỆT NAM</strong>
                        <span>GPĐKKD số 0110702160 do Sở KHĐT TP. Hà Nội cấp ngày 03/05/2024</span><br>
                        <span>Trụ sở: Số 31 ngách 17 hẻm 18 ngõ 236 Khương Đình, P. Khương Đình, TP. Hà Nội</span>
                    </div>
                    <div class="policy-seal-badge">
                        <i class="fa-solid fa-stamp"></i>
                        <span>ĐÃ ĐĂNG KÝ BỘ CÔNG THƯƠNG<br><small>Minh bạch &amp; Tuân thủ pháp luật</small></span>
                    </div>
                </div>

            </main>

        </div><!-- .policy-layout-grid -->
    </div><!-- .container -->

</div><!-- .gomie-policy-canvas -->

<?php
get_footer();
