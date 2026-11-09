<?php
/**
 * Template part for contact popup
 *
 * @package Gomie
 */
?>

<div id="contact-popup" class="popup-overlay">
    <div class="popup-content glass-card">
        <button class="popup-close" aria-label="<?php esc_attr_e('Đóng', 'gomie-theme'); ?>">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="popup-header">
            <h3><?php esc_html_e('Yêu cầu báo giá', 'gomie-theme'); ?></h3>
            <p><?php esc_html_e('Vui lòng điền thông tin để chúng tôi liên hệ tư vấn', 'gomie-theme'); ?></p>
        </div>
        
        <div class="popup-body">
            <form class="contact-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                <input type="hidden" name="action" value="gomie_contact_form">
                <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name"><?php esc_html_e('Họ và tên *', 'gomie-theme'); ?></label>
                        <input type="text" id="contact-name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-phone"><?php esc_html_e('Số điện thoại *', 'gomie-theme'); ?></label>
                        <input type="tel" id="contact-phone" name="phone" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="contact-email"><?php esc_html_e('Email', 'gomie-theme'); ?></label>
                    <input type="email" id="contact-email" name="email" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="contact-product"><?php esc_html_e('Sản phẩm quan tâm', 'gomie-theme'); ?></label>
                    <select id="contact-product" name="product" class="form-control">
                        <option value=""><?php esc_html_e('Chọn sản phẩm', 'gomie-theme'); ?></option>
                        <?php
                        $products = get_posts(array(
                            'post_type' => (post_type_exists('product') ? 'product' : 'post'),
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ));
                        
                        foreach ($products as $product) :
                            echo '<option value="' . esc_attr($product->ID) . '">' . esc_html($product->post_title) . '</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="contact-message"><?php esc_html_e('Nội dung yêu cầu', 'gomie-theme'); ?></label>
                    <textarea id="contact-message" name="message" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="glass-button submit-button">
                        <span class="button-text"><?php esc_html_e('Gửi yêu cầu', 'gomie-theme'); ?></span>
                        <span class="button-loading"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>
                
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

<script>
(function($) {
    'use strict';
    
    // Popup functionality
    var popup = $('#contact-popup');
    var popupTriggers = $('.popup-trigger, .header-cta, .contact-button');
    
    // Open popup
    popupTriggers.on('click', function(e) {
        e.preventDefault();
        popup.addClass('active');
        $('body').addClass('popup-open');
    });
    
    // Close popup
    popup.find('.popup-close').on('click', function() {
        popup.removeClass('active');
        $('body').removeClass('popup-open');
    });
    
    // Close on overlay click
    popup.on('click', function(e) {
        if (e.target === this) {
            popup.removeClass('active');
            $('body').removeClass('popup-open');
        }
    });
    
    // Handle form submission
    popup.find('.contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitButton = form.find('.submit-button');
        var messageDiv = form.find('.form-message');
        
        // Disable submit button
        submitButton.prop('disabled', true).addClass('loading');
        messageDiv.removeClass('success error').empty();
        
        // Submit form via AJAX
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    messageDiv.addClass('success').html(response.data.message);
                    form[0].reset();
                    
                    // Close popup after 3 seconds
                    setTimeout(function() {
                        popup.removeClass('active');
                        $('body').removeClass('popup-open');
                    }, 3000);
                } else {
                    messageDiv.addClass('error').html(response.data.message);
                }
            },
            error: function() {
                messageDiv.addClass('error').html('<?php esc_html_e('Có lỗi xảy ra. Vui lòng thử lại.', 'gomie-theme'); ?>');
            },
            complete: function() {
                submitButton.prop('disabled', false).removeClass('loading');
            }
        });
    });
    
})(jQuery);
</script>