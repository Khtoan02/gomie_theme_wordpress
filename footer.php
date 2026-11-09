<?php
/**
 * The template for displaying the footer
 *
 * @package Gomie
 */
?>
    </div><!-- #content -->
    
    <footer id="colophon" class="site-footer">
        <!-- Top Footer - 3/5 ratio -->
        <div class="footer-top">
            <div class="container">
                <div class="footer-top-content">
                    <!-- Column 1: Giới thiệu về Gomie -->
                    <div class="footer-column">
                        <h4 class="footer-title">Giới thiệu về Gomie</h4>
                        <div class="footer-content">
                            <p>Gomie Ceramic tự hào là thương hiệu gốm sứ Bát Tràng, mang đến những sản phẩm thủ công tinh xảo, nhằm cung cấp các sản phẩm cao cấp cho nhà hàng, khách sạn đến những món quà tặng tinh tế dành cho doanh nghiệp và gia đình trên khắp cả nước.</p>
                        </div>
                    </div>
                    
                    <!-- Column 2: Khám phá Gomie -->
                    <div class="footer-column">
                        <h4 class="footer-title">Khám phá Gomie</h4>
                        <div class="footer-content">
                            <ul class="footer-menu">
                                <li><a href="/loai-san-pham">Phân loại sản phẩm</a></li>
                                <li><a href="/mau-men">Bảng 9 màu men gốm</a></li>
                                <li><a href="/huong-dan-su-dung">Hướng dẫn sử dụng & Bảo quản</a></li>
                                <li><a href="/heart-of-craftsmanship">Heart of Craftsmanship</a></li>
                                <li><a href="/chung-nhan">Chứng nhận kiểm định an toàn</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Column 3: Hướng dẫn mua hàng -->
                    <div class="footer-column">
                        <h4 class="footer-title">Hướng dẫn mua hàng</h4>
                        <div class="footer-content">
                            <ul class="footer-menu">
                                <li><a href="/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                                <li><a href="/chinh-sach-doi-tra">Chính sách đổi trả</a></li>
                                <li><a href="/chinh-sach-van-chuyen">Chính sách vận chuyển & kiểm tra hàng</a></li>
                                <li><a href="/chinh-sach-thanh-toan">Chính sách thanh toán</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Column 4: Thông tin liên hệ -->
                    <div class="footer-column">
                        <h4 class="footer-title">Thông tin liên hệ</h4>
                        <div class="footer-content">
                            <div class="contact-info">
                                <div class="contact-item">
                                    41b, 106 Hoàng Quốc Việt, phường Nghĩa Đô, quận Cầu Giấy, TP Hà Nội
                                </div>
                                <div class="contact-item">
                                    Toà nhà Phúc Tấn Nguyên, 400 Nguyễn Thị Thập, phường Tân Hưng, quận 7, TP. Hồ Chí Minh
                                </div>
                                <div class="contact-item"><a href="tel:+84335059889">(+84) 335 059 889</a>
                                </div>
                                <div class="contact-item"><a href="mailto:cskh@gomie.vn">cskh@gomie.vn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mid Footer - 1/5 ratio -->
        <div class="footer-mid">
            <div class="container">
                <div class="footer-mid-content">
                    <!-- Left: Email subscription -->
                    <div class="email-subscription">
                        <div class="subscription-input">
                            <input type="email" placeholder="Để lại Email để nhận ưu đãi" class="email-input">
                            <button type="submit" class="subscribe-btn">Đăng ký</button>
                        </div>
                    </div>
                    
                    <!-- Center: Logo -->
                    <div class="footer-logo-center">
                        <?php
                        if (has_custom_logo()) :
                            the_custom_logo();
                        else :
                            ?>
                            <div class="logo-container">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                                    <h3 class="site-title">Gomie</h3>
                                    <span class="site-tagline">HEART of Craftsmanship</span>
                                </a>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    
                    <!-- Right: Service highlights -->
                    <div class="service-highlights">
                        <a href="<?php echo esc_url(home_url('/nha-hang/')); ?>" class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Nhà hàng</h5>
                                <p>Đồ dùng & Trang trí</p>
                            </div>
                        </a>
                        <a href="<?php echo esc_url(home_url('/khach-san/')); ?>" class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Khách sạn</h5>
                                <p>Đồ dùng phòng & Không gian</p>
                            </div>
                        </a>
                        <a href="<?php echo esc_url(home_url('/qua-tang/')); ?>" class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="highlight-content">
                                <h5>Quà tặng</h5>
                                <p>Quà tặng Doanh nghiệp & in logo</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Footer - 1/5 ratio -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <!-- Left: Company legal info -->
                    <div class="company-legal">
                        <div class="company-name">CÔNG TY TNHH GỐM SỨ GOMIE VIỆT NAM</div>
                        <div class="company-registration">GPĐKKD số 0110702160 do Sở KHĐT Tp. Hà Nội cấp 03/05/2024</div>
                        <div class="company-address">Số nhà 31 ngách 17 hẻm 18 ngõ 236 Khương Đình, Phường Khương Đình, Thành phố Hà Nội, Việt Nam</div>
                    </div>
                    
                    <!-- Middle: Note about glaze color -->
                    <div class="glaze-note">
                        <p>*Lưu ý: Màu men của sản phẩm có thể khác nhau do biến thế của từng lò đốt</p>
                    </div>
                    
                    <!-- Right: Ministry notification -->
                    <div class="ministry-notification">
                        <a href="http://online.gov.vn/Website/chi-tiet-135155" target="_blank" rel="noopener noreferrer" class="notification-link">
                            <img src="https://webmedia.com.vn/images/2021/09/logo-da-thong-bao-bo-cong-thuong-mau-xanh.png" 
                                 alt="Đã thông báo Bộ Công Thương" 
                                 class="bo-cong-thuong-logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Contact Popup -->
<?php get_template_part('template-parts/popup/popup-contact'); ?>

<!-- Newsletter Success Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Đăng ký thành công!</h5>
                <p class="text-muted">Cảm ơn bạn đã đăng ký nhận ưu đãi từ Gomie.</p>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

<!-- Additional Scripts -->
<script>
(function() {
    // Email subscription
    var subscribeBtn = document.querySelector('.subscribe-btn');
    var emailInput = document.querySelector('.email-input');
    var newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
    
    if (subscribeBtn && emailInput) {
        subscribeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (emailInput.value.trim() !== '') {
                // Simulate form submission
                setTimeout(function() {
                    newsletterModal.show();
                    emailInput.value = '';
                }, 500);
            }
        });
    }
    
    // Mobile menu
    var mobileToggle = document.querySelector('.mobile-menu-toggle');
    var mobileMenu = document.querySelector('.mobile-menu');
    var mobileOverlay = document.querySelector('.mobile-menu-overlay');
    var mobileClose = document.querySelector('.mobile-menu-close');
    var body = document.body;
    
    function toggleMobileMenu() {
        body.classList.toggle('mobile-menu-active');
    }
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', toggleMobileMenu);
    }
})();
</script>

</body>
</html>