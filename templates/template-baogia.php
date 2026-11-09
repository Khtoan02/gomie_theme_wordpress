<?php
/**
 * Template Name: Request Quote
 * Description: Template for Request Quote page
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
            
            <!-- Quote Process -->
            <section class="quote-process section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Quy trình báo giá', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="process-steps">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4><?php esc_html_e('Gửi yêu cầu', 'gomie-theme'); ?></h4>
                                <p><?php esc_html_e('Điền thông tin vào form bên dưới', 'gomie-theme'); ?></p>
                            </div>
                        </div>
                        
                        <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
                        
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4><?php esc_html_e('Tư vấn miễn phí', 'gomie-theme'); ?></h4>
                                <p><?php esc_html_e('Chuyên gia tư vấn giải pháp phù hợp', 'gomie-theme'); ?></p>
                            </div>
                        </div>
                        
                        <div class="step-arrow"><i class="fas fa-chevron-right"></i></div>
                        
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4><?php esc_html_e('Nhận báo giá', 'gomie-theme'); ?></h4>
                                <p><?php esc_html_e('Báo giá chi tiết trong 24h', 'gomie-theme'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Quote Form -->
            <section class="quote-form-section section">
                <div class="container">
                    <div class="quote-form-wrapper glass-card">
                        <h2 class="form-title"><?php esc_html_e('Form yêu cầu báo giá', 'gomie-theme'); ?></h2>
                        
                        <form class="quote-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                            <input type="hidden" name="action" value="gomie_quote_form">
                            <?php wp_nonce_field('gomie_quote_nonce', 'quote_nonce'); ?>
                            
                            <!-- Personal Information -->
                            <div class="form-section">
                                <h3><?php esc_html_e('Thông tin liên hệ', 'gomie-theme'); ?></h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fullname"><?php esc_html_e('Họ và tên *', 'gomie-theme'); ?></label>
                                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="company"><?php esc_html_e('Công ty', 'gomie-theme'); ?></label>
                                        <input type="text" id="company" name="company" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="phone"><?php esc_html_e('Số điện thoại *', 'gomie-theme'); ?></label>
                                        <input type="tel" id="phone" name="phone" class="form-control" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email"><?php esc_html_e('Email *', 'gomie-theme'); ?></label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="address"><?php esc_html_e('Địa chỉ', 'gomie-theme'); ?></label>
                                    <input type="text" id="address" name="address" class="form-control">
                                </div>
                            </div>
                            
                            <!-- Project Information -->
                            <div class="form-section">
                                <h3><?php esc_html_e('Thông tin dự án', 'gomie-theme'); ?></h3>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="project_type"><?php esc_html_e('Loại công trình *', 'gomie-theme'); ?></label>
                                        <select id="project_type" name="project_type" class="form-control" required>
                                            <option value=""><?php esc_html_e('Chọn loại công trình', 'gomie-theme'); ?></option>
                                            <option value="residential"><?php esc_html_e('Nhà ở', 'gomie-theme'); ?></option>
                                            <option value="commercial"><?php esc_html_e('Thương mại', 'gomie-theme'); ?></option>
                                            <option value="industrial"><?php esc_html_e('Công nghiệp', 'gomie-theme'); ?></option>
                                            <option value="outdoor"><?php esc_html_e('Ngoài trời', 'gomie-theme'); ?></option>
                                            <option value="other"><?php esc_html_e('Khác', 'gomie-theme'); ?></option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="area"><?php esc_html_e('Diện tích (m2)', 'gomie-theme'); ?></label>
                                        <input type="number" id="area" name="area" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label><?php esc_html_e('Sản phẩm quan tâm', 'gomie-theme'); ?></label>
                                    <div class="checkbox-group">
                                        <?php
                                        $product_categories = get_terms(array(
                                            'taxonomy' => (taxonomy_exists('product_cat') ? 'product_cat' : 'category'),
                                            'hide_empty' => false,
                                        ));
                                        
                                        foreach ($product_categories as $category) :
                                            ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="products[]" value="<?php echo esc_attr($category->term_id); ?>">
                                                <span><?php echo esc_html($category->name); ?></span>
                                            </label>
                                            <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="budget"><?php esc_html_e('Ngân sách dự kiến', 'gomie-theme'); ?></label>
                                    <select id="budget" name="budget" class="form-control">
                                        <option value=""><?php esc_html_e('Chọn ngân sách', 'gomie-theme'); ?></option>
                                        <option value="under-10m"><?php esc_html_e('Dưới 10 triệu', 'gomie-theme'); ?></option>
                                        <option value="10-50m"><?php esc_html_e('10 - 50 triệu', 'gomie-theme'); ?></option>
                                        <option value="50-100m"><?php esc_html_e('50 - 100 triệu', 'gomie-theme'); ?></option>
                                        <option value="100-500m"><?php esc_html_e('100 - 500 triệu', 'gomie-theme'); ?></option>
                                        <option value="over-500m"><?php esc_html_e('Trên 500 triệu', 'gomie-theme'); ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="timeline"><?php esc_html_e('Thời gian dự kiến', 'gomie-theme'); ?></label>
                                    <input type="text" id="timeline" name="timeline" class="form-control" placeholder="<?php esc_attr_e('Ví dụ: Trong vòng 3 tháng', 'gomie-theme'); ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label for="requirements"><?php esc_html_e('Yêu cầu chi tiết', 'gomie-theme'); ?></label>
                                    <textarea id="requirements" name="requirements" class="form-control" rows="5" placeholder="<?php esc_attr_e('Mô tả chi tiết yêu cầu của bạn...', 'gomie-theme'); ?>"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="glass-button">
                                    <span class="button-text"><?php esc_html_e('Gửi yêu cầu báo giá', 'gomie-theme'); ?></span>
                                    <span class="button-loading"><i class="fas fa-spinner fa-spin"></i></span>
                                </button>
                            </div>
                            
                            <div class="form-message"></div>
                        </form>
                    </div>
                </div>
            </section>
            
            <!-- Why Choose Us -->
            <section class="why-quote section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Tại sao chọn Gomie Ceramic?', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="features-grid grid grid-3">
                        <div class="feature-card glass-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h3><?php esc_html_e('Báo giá minh bạch', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Giá cả cạnh tranh, không phát sinh chi phí', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="feature-card glass-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h3><?php esc_html_e('Tư vấn chuyên nghiệp', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Đội ngũ nghệ nhân và chuyên viên giàu kinh nghiệm', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="feature-card glass-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3><?php esc_html_e('Phản hồi nhanh chóng', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Báo giá trong vòng 24 giờ', 'gomie-theme'); ?></p>
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
    
    // Handle quote form submission
    $('.quote-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        var messageDiv = form.find('.form-message');
        
        // Validate form
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }
        
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
                    
                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: messageDiv.offset().top - 100
                    }, 500);
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