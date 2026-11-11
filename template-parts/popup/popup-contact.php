<?php
/**
 * Template part for Quote Request & Contact Popup
 * Gomie Ceramic Editorial V11 - High-end HoReCa & Project Quote Modal
 *
 * @package Gomie
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Scoped styles to ensure flawless presentation anywhere -->
<style id="gomie-quote-popup-styles">
#contact-popup.popup-overlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background: rgba(15, 23, 42, 0.72) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.28s ease, visibility 0.28s ease !important;
    z-index: 999999 !important;
    padding: 16px !important;
    box-sizing: border-box !important;
}

#contact-popup.popup-overlay.active {
    opacity: 1 !important;
    visibility: visible !important;
    pointer-events: auto !important;
}

body.popup-open {
    overflow: hidden !important;
}

/* Modal Content Card */
#contact-popup .quote-modal-content {
    background: #ffffff !important;
    width: 100% !important;
    max-width: 620px !important;
    max-height: calc(100vh - 32px) !important;
    display: flex !important;
    flex-direction: column !important;
    border-radius: 22px !important;
    border: 1px solid rgba(226, 114, 91, 0.25) !important;
    box-shadow: 0 25px 70px -10px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.9) inset !important;
    position: relative !important;
    overflow: hidden !important;
    transform: translateY(20px) scale(0.97) !important;
    transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.28s ease !important;
    margin: auto !important;
    box-sizing: border-box !important;
}

#contact-popup.active .quote-modal-content {
    transform: translateY(0) scale(1) !important;
}

/* Close button */
#contact-popup .quote-modal-close {
    position: absolute !important;
    top: 16px !important;
    right: 16px !important;
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
    background: #f1ede8 !important;
    color: #4a5568 !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 15px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    z-index: 25 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06) !important;
    outline: none !important;
}

#contact-popup .quote-modal-close:hover {
    background: #e2725b !important;
    color: #ffffff !important;
    transform: rotate(90deg) scale(1.05) !important;
}

/* Header */
#contact-popup .quote-modal-header {
    flex-shrink: 0 !important;
    background: linear-gradient(180deg, #fdfbf7 0%, #f7f1e7 100%) !important;
    padding: 22px 28px 18px 28px !important;
    border-bottom: 1px solid #efe6da !important;
    text-align: left !important;
    position: relative !important;
}

#contact-popup .quote-modal-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    background: rgba(226, 114, 91, 0.12) !important;
    color: #c45a45 !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    padding: 4px 11px !important;
    border-radius: 999px !important;
    margin-bottom: 8px !important;
}

#contact-popup .quote-modal-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 21px !important;
    font-weight: 700 !important;
    color: #1e2830 !important;
    margin: 0 0 4px 0 !important;
    line-height: 1.3 !important;
}

#contact-popup .quote-modal-desc {
    font-size: 13px !important;
    color: #64748b !important;
    margin: 0 !important;
    line-height: 1.45 !important;
    max-width: 500px !important;
}

#contact-popup .quote-modal-desc strong {
    color: #e2725b !important;
}

/* Body & Form - Scrollable */
#contact-popup .quote-modal-body {
    flex: 1 1 auto !important;
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch !important;
    padding: 20px 28px 24px 28px !important;
    background: #ffffff !important;
}

/* Custom scrollbar inside modal body */
#contact-popup .quote-modal-body {
    scrollbar-width: thin;
    scrollbar-color: rgba(226, 114, 91, 0.35) transparent;
}
#contact-popup .quote-modal-body::-webkit-scrollbar {
    width: 5px;
}
#contact-popup .quote-modal-body::-webkit-scrollbar-thumb {
    background: rgba(226, 114, 91, 0.35);
    border-radius: 999px;
}
#contact-popup .quote-modal-body::-webkit-scrollbar-thumb:hover {
    background: rgba(226, 114, 91, 0.7);
}
#contact-popup .quote-modal-body::-webkit-scrollbar-track {
    background: transparent;
}

#contact-popup .quote-form-grid {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 13px !important;
}

#contact-popup .quote-form-full {
    grid-column: span 2 !important;
}

#contact-popup .quote-form-group {
    display: flex !important;
    flex-direction: column !important;
    gap: 5px !important;
    text-align: left !important;
}

#contact-popup .quote-form-label {
    font-size: 12.5px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin: 0 !important;
}

#contact-popup .quote-form-label .required {
    color: #e2725b !important;
    font-weight: 700 !important;
}

#contact-popup .text-terracotta {
    color: #e2725b !important;
}

#contact-popup .quote-form-input,
#contact-popup .quote-form-select,
#contact-popup .quote-form-textarea {
    width: 100% !important;
    padding: 9px 13px !important;
    border: 1.5px solid #e2d9cf !important;
    border-radius: 11px !important;
    background: #ffffff !important;
    font-size: 13.5px !important;
    color: #1e293b !important;
    transition: all 0.2s ease !important;
    box-sizing: border-box !important;
    font-family: inherit !important;
}

#contact-popup .quote-form-input:focus,
#contact-popup .quote-form-select:focus,
#contact-popup .quote-form-textarea:focus {
    border-color: #e2725b !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(226, 114, 91, 0.16) !important;
    background: #ffffff !important;
}

#contact-popup .quote-form-input::placeholder,
#contact-popup .quote-form-textarea::placeholder {
    color: #94a3b8 !important;
    font-size: 13px !important;
}

/* Submit Button */
#contact-popup .quote-form-actions {
    margin-top: 16px !important;
}

#contact-popup .quote-submit-btn {
    width: 100% !important;
    height: 48px !important;
    background: linear-gradient(135deg, #e2725b 0%, #c45a45 100%) !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 13px !important;
    font-size: 14.5px !important;
    font-weight: 700 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 8px 22px rgba(226, 114, 91, 0.35) !important;
    transition: all 0.25s ease !important;
    outline: none !important;
}

#contact-popup .quote-submit-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 10px 26px rgba(226, 114, 91, 0.45) !important;
    background: linear-gradient(135deg, #ea7d67 0%, #ce5f49 100%) !important;
}

#contact-popup .quote-submit-btn:disabled {
    opacity: 0.75 !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* Message Feedback */
#contact-popup .quote-form-feedback {
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 9px;
    font-size: 13px;
    display: none;
    text-align: left;
}
#contact-popup .quote-form-feedback.error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    display: block;
}

/* Trust Badges */
#contact-popup .quote-trust-badges {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 8px !important;
    margin-top: 16px !important;
    padding-top: 14px !important;
    border-top: 1px dashed #e8e1d7 !important;
}

#contact-popup .quote-trust-item {
    display: flex !important;
    align-items: center !important;
    gap: 5px !important;
    font-size: 11.5px !important;
    color: #475569 !important;
    font-weight: 500 !important;
}

#contact-popup .quote-trust-item i {
    color: #10b981 !important;
    font-size: 12px !important;
}

/* Direct Hotline Note */
#contact-popup .quote-hotline-footer {
    text-align: center !important;
    margin-top: 12px !important;
    font-size: 12px !important;
    color: #64748b !important;
}

#contact-popup .quote-hotline-footer a {
    color: #e2725b !important;
    font-weight: 700 !important;
    text-decoration: underline !important;
}

/* Success View */
#contact-popup .quote-success-view {
    text-align: center !important;
    padding: 30px 16px !important;
}

#contact-popup .quote-success-icon {
    width: 68px !important;
    height: 68px !important;
    border-radius: 50% !important;
    background: rgba(16, 185, 129, 0.12) !important;
    color: #10b981 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 30px !important;
    margin-bottom: 16px !important;
    box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.06) !important;
}

#contact-popup .quote-success-title {
    font-family: 'Playfair Display', Georgia, serif !important;
    font-size: 21px !important;
    font-weight: 700 !important;
    color: #1e2830 !important;
    margin-bottom: 8px !important;
}

#contact-popup .quote-success-desc {
    font-size: 13.5px !important;
    color: #475569 !important;
    line-height: 1.55 !important;
    max-width: 440px !important;
    margin: 0 auto 20px auto !important;
}

#contact-popup .quote-success-actions {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 12px !important;
    flex-wrap: wrap !important;
}

#contact-popup .btn-success-call {
    display: inline-flex !important;
    align-items: center !important;
    padding: 11px 22px !important;
    background: #e2725b !important;
    color: #ffffff !important;
    border-radius: 11px !important;
    font-weight: 600 !important;
    font-size: 13.5px !important;
    text-decoration: none !important;
    box-shadow: 0 4px 14px rgba(226, 114, 91, 0.3) !important;
    transition: all 0.2s ease !important;
}

#contact-popup .btn-success-call:hover {
    background: #c45a45 !important;
    color: #ffffff !important;
    transform: translateY(-1px) !important;
}

#contact-popup .btn-success-close {
    padding: 11px 22px !important;
    background: #f1f5f9 !important;
    color: #334155 !important;
    border: none !important;
    border-radius: 11px !important;
    font-weight: 600 !important;
    font-size: 13.5px !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
}

#contact-popup .btn-success-close:hover {
    background: #e2e8f0 !important;
}

/* Mobile responsive */
@media (max-width: 600px) {
    #contact-popup.popup-overlay {
        padding: 10px !important;
    }
    #contact-popup .quote-modal-header {
        padding: 18px 20px 14px 20px !important;
    }
    #contact-popup .quote-modal-title {
        font-size: 19px !important;
    }
    #contact-popup .quote-modal-body {
        padding: 16px 20px 20px 20px !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    #contact-popup .quote-modal-body::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    #contact-popup .quote-form-grid {
        grid-template-columns: 1fr !important;
        gap: 10px !important;
    }
    #contact-popup .quote-form-full {
        grid-column: span 1 !important;
    }
    #contact-popup .quote-trust-badges {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 6px !important;
    }
}
</style>

<div id="contact-popup" class="popup-overlay" role="dialog" aria-modal="true" aria-labelledby="quoteModalTitle">
    <div class="popup-content quote-modal-content">
        <!-- Close button -->
        <button type="button" class="popup-close quote-modal-close" aria-label="<?php esc_attr_e('Đóng cửa sổ', 'gomie-theme'); ?>">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Header (Fixed at top) -->
        <div class="quote-modal-header">
            <div class="quote-modal-badge">
                <i class="fas fa-certificate text-terracotta"></i>
                <span>GOMIE CERAMIC · DỰ ÁN &amp; HORECA</span>
            </div>
            <h3 id="quoteModalTitle" class="quote-modal-title">
                <?php esc_html_e('Yêu Cầu Báo Giá & Tư Vấn Giải Pháp', 'gomie-theme'); ?>
            </h3>
            <p class="quote-modal-desc">
                <?php esc_html_e('Chính sách chiết khấu trực tiếp tới ', 'gomie-theme'); ?>
                <strong><?php esc_html_e('35% từ xưởng Bát Tràng', 'gomie-theme'); ?></strong>. 
                <?php esc_html_e('Chuyên viên gửi bảng dự toán & catalogue trong 15 phút.', 'gomie-theme'); ?>
            </p>
        </div>
        
        <!-- Body (Scrollable) -->
        <div class="quote-modal-body">
            <!-- Form view -->
            <form class="quote-popup-form" id="gomieQuoteForm" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                <input type="hidden" name="action" value="gomie_contact_form">
                <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>
                
                <div class="quote-form-grid">
                    <!-- Row 1: Họ tên + Số điện thoại -->
                    <div class="quote-form-group">
                        <label for="contact-name" class="quote-form-label">
                            <i class="far fa-user text-terracotta"></i>
                            <?php esc_html_e('Họ và tên', 'gomie-theme'); ?> <span class="required">*</span>
                        </label>
                        <input type="text" id="contact-name" name="name" class="quote-form-input" placeholder="Ví dụ: Nguyễn Văn A" required>
                    </div>
                    
                    <div class="quote-form-group">
                        <label for="contact-phone" class="quote-form-label">
                            <i class="fas fa-phone-alt text-terracotta"></i>
                            <?php esc_html_e('Số điện thoại / Zalo', 'gomie-theme'); ?> <span class="required">*</span>
                        </label>
                        <input type="tel" id="contact-phone" name="phone" class="quote-form-input" placeholder="Ví dụ: 0912 345 678" required>
                    </div>
                    
                    <!-- Row 2: Email + Tên công ty / Đơn vị -->
                    <div class="quote-form-group">
                        <label for="contact-email" class="quote-form-label">
                            <i class="far fa-envelope text-terracotta"></i>
                            <?php esc_html_e('Email liên hệ', 'gomie-theme'); ?>
                        </label>
                        <input type="email" id="contact-email" name="email" class="quote-form-input" placeholder="email@congty.com">
                    </div>
                    
                    <div class="quote-form-group">
                        <label for="contact-company" class="quote-form-label">
                            <i class="far fa-building text-terracotta"></i>
                            <?php esc_html_e('Nhà hàng / Khách sạn / Công ty', 'gomie-theme'); ?>
                        </label>
                        <input type="text" id="contact-company" name="company" class="quote-form-input" placeholder="Ví dụ: Khách sạn Mường Thanh, Chuỗi BBQ...">
                    </div>
                    
                    <!-- Row 3: Nhu cầu tư vấn + Số lượng ước tính -->
                    <div class="quote-form-group">
                        <label for="contact-interest" class="quote-form-label">
                            <i class="fas fa-layer-group text-terracotta"></i>
                            <?php esc_html_e('Nhu cầu tư vấn', 'gomie-theme'); ?>
                        </label>
                        <select id="contact-interest" name="interest_type" class="quote-form-select">
                            <option value="Set bàn ăn Nhà hàng / Khách sạn (HoReCa)"><?php esc_html_e('Set bàn ăn Nhà hàng / Khách sạn (HoReCa)', 'gomie-theme'); ?></option>
                            <option value="Quà tặng Doanh nghiệp / Đại hội in logo"><?php esc_html_e('Quà tặng Doanh nghiệp / Đại hội in logo', 'gomie-theme'); ?></option>
                            <option value="Bộ ấm chén & Ly sứ độc bản"><?php esc_html_e('Bộ ấm chén & Ly sứ độc bản', 'gomie-theme'); ?></option>
                            <option value="Chế tác màu men hỏa biến theo yêu cầu"><?php esc_html_e('Chế tác màu men hỏa biến theo yêu cầu', 'gomie-theme'); ?></option>
                            <option value="Bộ bát đĩa gia đình cao cấp"><?php esc_html_e('Bộ bát đĩa gia đình cao cấp', 'gomie-theme'); ?></option>
                            <option value="Khác"><?php esc_html_e('Nhu cầu khác', 'gomie-theme'); ?></option>
                        </select>
                    </div>
                    
                    <div class="quote-form-group">
                        <label for="contact-quantity" class="quote-form-label">
                            <i class="fas fa-boxes text-terracotta"></i>
                            <?php esc_html_e('Số lượng ước tính', 'gomie-theme'); ?>
                        </label>
                        <select id="contact-quantity" name="quantity_range" class="quote-form-select">
                            <option value="Dưới 50 bộ (Dưới 10 triệu)"><?php esc_html_e('Dưới 50 bộ (Dưới 10 triệu)', 'gomie-theme'); ?></option>
                            <option value="50 - 200 bộ (10 - 50 triệu)" selected><?php esc_html_e('50 - 200 bộ (10 - 50 triệu)', 'gomie-theme'); ?></option>
                            <option value="200 - 500 bộ (50 - 100 triệu)"><?php esc_html_e('200 - 500 bộ (50 - 100 triệu)', 'gomie-theme'); ?></option>
                            <option value="Trên 500 bộ (Dự án lớn > 100 triệu)"><?php esc_html_e('Trên 500 bộ (Dự án lớn > 100 triệu)', 'gomie-theme'); ?></option>
                            <option value="Cần tư vấn thêm về số lượng"><?php esc_html_e('Cần tư vấn thêm về số lượng', 'gomie-theme'); ?></option>
                        </select>
                    </div>
                    
                    <!-- Row 4: Sản phẩm quan tâm cụ thể -->
                    <div class="quote-form-group quote-form-full">
                        <label for="contact-product" class="quote-form-label">
                            <i class="fas fa-tags text-terracotta"></i>
                            <?php esc_html_e('Dòng sản phẩm / Màu men quan tâm', 'gomie-theme'); ?>
                        </label>
                        <select id="contact-product" name="product" class="quote-form-select">
                            <option value=""><?php esc_html_e('-- Chọn sản phẩm hoặc màu men (không bắt buộc) --', 'gomie-theme'); ?></option>
                            <optgroup label="<?php esc_attr_e('Hệ sắc men hỏa biến đặc trưng', 'gomie-theme'); ?>">
                                <option value="Men Xanh Thiên Thanh">Men Xanh Thiên Thanh</option>
                                <option value="Men Ngọc Trai">Men Ngọc Trai</option>
                                <option value="Men Xanh Sóng Biển">Men Xanh Sóng Biển</option>
                                <option value="Men Hỏa Biến Độc Bản">Men Hỏa Biến Độc Bản</option>
                                <option value="Men Cẩm Quỳ">Men Cẩm Quỳ</option>
                                <option value="Men Rêu Đá">Men Rêu Đá</option>
                            </optgroup>
                            <optgroup label="<?php esc_attr_e('Tác phẩm gốm sứ tiêu biểu', 'gomie-theme'); ?>">
                                <?php
                                $featured_products = get_posts(array(
                                    'post_type' => 'product',
                                    'posts_per_page' => 20,
                                    'orderby' => 'menu_order title',
                                    'order' => 'ASC',
                                ));
                                foreach ($featured_products as $p) {
                                    echo '<option value="' . esc_attr($p->post_title) . '">' . esc_html($p->post_title) . '</option>';
                                }
                                ?>
                            </optgroup>
                        </select>
                    </div>
                    
                    <!-- Row 5: Ghi chú chi tiết -->
                    <div class="quote-form-group quote-form-full">
                        <label for="contact-message" class="quote-form-label">
                            <i class="far fa-comment-dots text-terracotta"></i>
                            <?php esc_html_e('Yêu cầu chi tiết & Ngân sách dự kiến', 'gomie-theme'); ?>
                        </label>
                        <textarea id="contact-message" name="message" class="quote-form-textarea" rows="2" placeholder="<?php esc_attr_e('Ghi chú về: yêu cầu in logo thương hiệu, đóng hộp quà tặng xi lụa, thời gian cần nhận hàng, địa điểm bàn giao...', 'gomie-theme'); ?>"></textarea>
                    </div>
                </div>
                
                <!-- Feedback error -->
                <div class="quote-form-feedback"></div>
                
                <!-- Submit Button -->
                <div class="quote-form-actions">
                    <button type="submit" class="quote-submit-btn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane me-2"></i> <?php esc_html_e('Gửi Yêu Cầu Báo Giá Nhanh', 'gomie-theme'); ?>
                        </span>
                        <span class="btn-spinner d-none">
                            <i class="fas fa-circle-notch fa-spin me-2"></i> <?php esc_html_e('Đang gửi yêu cầu...', 'gomie-theme'); ?>
                        </span>
                    </button>
                </div>
                
                <!-- Trust Badges -->
                <div class="quote-trust-badges">
                    <div class="quote-trust-item">
                        <i class="fas fa-check-circle"></i>
                        <span><?php esc_html_e('Chiết khấu xưởng đến 35%', 'gomie-theme'); ?></span>
                    </div>
                    <div class="quote-trust-item">
                        <i class="fas fa-check-circle"></i>
                        <span><?php esc_html_e('Miễn phí in logo & mẫu thử', 'gomie-theme'); ?></span>
                    </div>
                    <div class="quote-trust-item">
                        <i class="fas fa-check-circle"></i>
                        <span><?php esc_html_e('Bảo hiểm 100% vận chuyển', 'gomie-theme'); ?></span>
                    </div>
                </div>
                
                <!-- Direct Hotline Note -->
                <div class="quote-hotline-footer">
                    <?php esc_html_e('Cần báo giá gấp trong 5 phút? Gọi ngay:', 'gomie-theme'); ?> 
                    <a href="tel:0945741296" class="hotline-link">0945 74 1296</a> (Hotline/Zalo 24/7)
                </div>
            </form>
            
            <!-- Success Screen (Hidden by default) -->
            <div class="quote-success-view d-none">
                <div class="quote-success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h4 class="quote-success-title"><?php esc_html_e('Tiếp Nhận Yêu Cầu Thành Công!', 'gomie-theme'); ?></h4>
                <p class="quote-success-desc">
                    <?php esc_html_e('Cảm ơn quý khách! Đội ngũ tư vấn dự án Gomie Ceramic đã nhận được thông tin và sẽ gửi bảng dự toán chi tiết kèm mẫu catalog qua Điện thoại / Zalo trong vòng ', 'gomie-theme'); ?>
                    <strong><?php esc_html_e('15 - 30 phút', 'gomie-theme'); ?></strong>.
                </p>
                <div class="quote-success-actions">
                    <a href="tel:0945741296" class="btn-success-call">
                        <i class="fas fa-phone-alt me-2"></i> <?php esc_html_e('Gọi ngay: 0945 74 1296', 'gomie-theme'); ?>
                    </a>
                    <button type="button" class="btn-success-close">
                        <?php esc_html_e('Đóng cửa sổ', 'gomie-theme'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function($) {
    'use strict';
    
    $(document).ready(function() {
        var popup = $('#contact-popup');
        var form = popup.find('.quote-popup-form');
        var successView = popup.find('.quote-success-view');
        var feedbackDiv = popup.find('.quote-form-feedback');
        var submitBtn = popup.find('.quote-submit-btn');
        var btnText = submitBtn.find('.btn-text');
        var btnSpinner = submitBtn.find('.btn-spinner');
        
        // Open modal
        $(document).on('click', '.popup-trigger, [href="#contact-popup"], .btn-header-quote', function(e) {
            e.preventDefault();
            
            // If product was passed via data attributes
            var productName = $(this).data('product') || $(this).data('product-title');
            if (productName) {
                var select = $('#contact-product');
                if (select.find('option[value="' + productName + '"]').length > 0) {
                    select.val(productName);
                } else {
                    select.append(new Option(productName, productName, true, true));
                }
            }
            
            // Reset state
            form.removeClass('d-none');
            successView.addClass('d-none');
            feedbackDiv.removeClass('error').hide().empty();
            
            popup.addClass('active');
            $('body').addClass('popup-open');
            
            // Focus on first input
            setTimeout(function() {
                $('#contact-name').focus();
            }, 300);
        });
        
        // Close function
        function closeQuoteModal() {
            popup.removeClass('active');
            $('body').removeClass('popup-open');
        }
        
        // Close button click
        popup.find('.quote-modal-close, .btn-success-close').on('click', function(e) {
            e.preventDefault();
            closeQuoteModal();
        });
        
        // Close on background overlay click
        popup.on('click', function(e) {
            if (e.target === this) {
                closeQuoteModal();
            }
        });
        
        // Close on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && popup.hasClass('active')) {
                closeQuoteModal();
            }
        });
        
        // Handle form submission via AJAX
        form.on('submit', function(e) {
            e.preventDefault();
            
            var name = $('#contact-name').val().trim();
            var phone = $('#contact-phone').val().trim();
            
            if (!name || !phone) {
                feedbackDiv.addClass('error').text('Vui lòng điền đầy đủ Họ tên và Số điện thoại.').show();
                return;
            }
            
            submitBtn.prop('disabled', true);
            btnText.addClass('d-none');
            btnSpinner.removeClass('d-none');
            feedbackDiv.removeClass('error').hide().empty();
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        form.addClass('d-none');
                        successView.removeClass('d-none');
                        form[0].reset();
                        
                        // Auto close after 8s
                        setTimeout(function() {
                            if (popup.hasClass('active')) {
                                closeQuoteModal();
                            }
                        }, 8000);
                    } else {
                        var msg = (response.data && response.data.message) ? response.data.message : (response.data || 'Có lỗi xảy ra, vui lòng thử lại.');
                        feedbackDiv.addClass('error').text(msg).show();
                    }
                },
                error: function() {
                    feedbackDiv.addClass('error').text('Không thể kết nối đến máy chủ. Vui lòng liên hệ Hotline 0945 74 1296 để được hỗ trợ nhanh nhất.').show();
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    btnText.removeClass('d-none');
                    btnSpinner.addClass('d-none');
                }
            });
        });
    });
})(jQuery);
</script>
