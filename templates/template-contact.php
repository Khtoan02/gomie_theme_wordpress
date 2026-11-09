<?php
/**
 * Template Name: Contact
 * Description: Template for Contact page
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="container">
                <?php gomie_breadcrumbs(); ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>
        </div>
        
        <?php while (have_posts()) : the_post(); ?>
            
            <!-- Contact Info Section -->
            <section class="contact-info section">
                <div class="container">
                    <div class="contact-grid grid grid-3">
                        <!-- Address -->
                        <div class="contact-item glass-card animate-fadeIn">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3><?php esc_html_e('Địa chỉ', 'gomie-theme'); ?></h3>
                            <p><?php echo gomie_get_option('company_address', '123 Đường ABC, Quận XYZ, TP.HCM'); ?></p>
                        </div>
                        
                        <!-- Phone -->
                        <div class="contact-item glass-card animate-fadeIn">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h3><?php esc_html_e('Điện thoại', 'gomie-theme'); ?></h3>
                            <?php
                            $phone = gomie_get_option('phone_number', '0335 059 889');
                            $hotline = gomie_get_option('hotline', '1900 1234');
                            ?>
                            <p>
                                <a href="tel:<?php echo gomie_format_phone($phone); ?>"><?php echo esc_html($phone); ?></a><br>
                                <?php if ($hotline) : ?>
                                    Hotline: <a href="tel:<?php echo gomie_format_phone($hotline); ?>"><?php echo esc_html($hotline); ?></a>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <!-- Email -->
                        <div class="contact-item glass-card animate-fadeIn">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3><?php esc_html_e('Email', 'gomie-theme'); ?></h3>
                            <?php
                            $email = gomie_get_option('email_address', 'info@gomie.vn');
                            $support_email = gomie_get_option('support_email');
                            ?>
                            <p>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><br>
                                <?php if ($support_email) : ?>
                                    Support: <a href="mailto:<?php echo esc_attr($support_email); ?>"><?php echo esc_html($support_email); ?></a>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Contact Form & Map Section -->
            <section class="contact-main section">
                <div class="container">
                    <div class="contact-wrapper">
                        <!-- Contact Form -->
                        <div class="contact-form-wrapper glass-card">
                            <h2><?php esc_html_e('Gửi tin nhắn cho chúng tôi', 'gomie-theme'); ?></h2>
                            <p><?php esc_html_e('Vui lòng điền thông tin bên dưới, chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.', 'gomie-theme'); ?></p>
                            
                            <form class="contact-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                                <input type="hidden" name="action" value="gomie_contact_form">
                                <?php wp_nonce_field('gomie_contact_nonce', 'contact_nonce'); ?>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name"><?php esc_html_e('Họ và tên *', 'gomie-theme'); ?></label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone"><?php esc_html_e('Số điện thoại *', 'gomie-theme'); ?></label>
                                        <input type="tel" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email"><?php esc_html_e('Email *', 'gomie-theme'); ?></label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="subject"><?php esc_html_e('Chủ đề', 'gomie-theme'); ?></label>
                                        <input type="text" id="subject" name="subject" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="message"><?php esc_html_e('Nội dung *', 'gomie-theme'); ?></label>
                                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="glass-button">
                                        <span class="button-text"><?php esc_html_e('Gửi tin nhắn', 'gomie-theme'); ?></span>
                                        <span class="button-loading"><i class="fas fa-spinner fa-spin"></i></span>
                                    </button>
                                </div>
                                
                                <div class="form-message"></div>
                            </form>
                        </div>
                        
                        <!-- Map -->
                        <div class="contact-map">
                            <?php
                            $map_embed = gomie_get_option('google_map_embed');
                            if ($map_embed) :
                                echo $map_embed;
                            else :
                                ?>
                                <div class="map-placeholder glass-card">
                                    <i class="fas fa-map-marked-alt"></i>
                                    <p><?php esc_html_e('Bản đồ sẽ được hiển thị ở đây', 'gomie-theme'); ?></p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Working Hours -->
            <section class="working-hours section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Giờ làm việc', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="hours-wrapper glass-card">
                        <div class="hours-grid">
                            <div class="hours-item">
                                <span class="day"><?php esc_html_e('Thứ 2 - Thứ 6', 'gomie-theme'); ?></span>
                                <span class="time"><?php echo gomie_get_option('weekday_hours', '8:00 - 17:30'); ?></span>
                            </div>
                            <div class="hours-item">
                                <span class="day"><?php esc_html_e('Thứ 7', 'gomie-theme'); ?></span>
                                <span class="time"><?php echo gomie_get_option('saturday_hours', '8:00 - 12:00'); ?></span>
                            </div>
                            <div class="hours-item">
                                <span class="day"><?php esc_html_e('Chủ nhật', 'gomie-theme'); ?></span>
                                <span class="time"><?php echo gomie_get_option('sunday_hours', 'Nghỉ'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <?php if (get_the_content()) : ?>
                <!-- Additional Content -->
                <section class="additional-content section">
                    <div class="container">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            
        <?php endwhile; ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<script>
(function($) {
    'use strict';
    
    // Handle contact form submission
    $('.contact-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
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

<?php
get_footer();