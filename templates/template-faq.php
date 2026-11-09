<?php
/**
 * Template Name: FAQ
 * Description: Template for FAQ/Support page
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
            
            <!-- FAQ Categories -->
            <section class="faq-categories section">
                <div class="container">
                    <div class="categories-grid grid grid-4">
                        <button class="category-btn glass-card active" data-category="all">
                            <i class="fas fa-th"></i>
                            <span><?php esc_html_e('Tất cả', 'gomie-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="product">
                            <i class="fas fa-mug-hot"></i>
                            <span><?php esc_html_e('Sản phẩm', 'gomie-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="warranty">
                            <i class="fas fa-shield-alt"></i>
                            <span><?php esc_html_e('Đổi trả & Bảo hành', 'gomie-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="technical">
                            <i class="fas fa-truck"></i>
                            <span><?php esc_html_e('Đặt hàng & Giao nhận', 'gomie-theme'); ?></span>
                        </button>
                    </div>
                </div>
            </section>
            
            <!-- FAQ Content -->
            <section class="faq-content section">
                <div class="container">
                    <div class="faq-wrapper">
                        <!-- Search FAQ -->
                        <div class="faq-search glass-card">
                            <form class="search-form">
                                <input type="text" class="search-input" placeholder="<?php esc_attr_e('Tìm kiếm câu hỏi...', 'gomie-theme'); ?>">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- FAQ Items -->
                        <div class="faq-items">
                            <?php
                            // You can use ACF repeater field or custom post type for FAQs
                            // For demo purposes, we'll create static FAQs
                            $faqs = array(
                                array(
                                    'category' => 'product',
                                    'question' => 'Sản phẩm gốm sứ Gomie có an toàn trong lò vi sóng và máy rửa bát không?',
                                    'answer' => 'Tất cả sản phẩm gốm sứ Gomie đều được nung ở nhiệt độ cao trên 1280°C, khử sạch hoàn toàn chì và kim loại nặng, an toàn tuyệt đối cho sức khỏe và dùng được trong lò vi sóng, máy rửa bát.'
                                ),
                                array(
                                    'category' => 'product',
                                    'question' => 'Gốm sứ Gomie được sản xuất ở đâu?',
                                    'answer' => 'Toàn bộ sản phẩm của Gomie Ceramic được nghệ nhân chế tác thủ công tại làng nghề gốm sứ truyền thống Bát Tràng, Hà Nội với chất men độc đáo.'
                                ),
                                array(
                                    'category' => 'warranty',
                                    'question' => 'Chính sách bảo hành và đổi trả của Gomie Ceramic như thế nào?',
                                    'answer' => 'Gomie hỗ trợ đổi mới 1-1 trong vòng 7 ngày nếu sản phẩm có lỗi từ nhà sản xuất hoặc bị nứt vỡ trong quá trình vận chuyển.'
                                ),
                                array(
                                    'category' => 'warranty',
                                    'question' => 'Làm thế nào để yêu cầu đổi trả hàng bị sự cố vận chuyển?',
                                    'answer' => 'Quý khách chỉ cần quay video mở hộp hàng và liên hệ ngay với hotline hoặc fanpage Gomie Ceramic để được gửi sản phẩm mới thay thế nhanh chóng.'
                                ),
                                array(
                                    'category' => 'technical',
                                    'question' => 'Làm thế nào để đặt gốm sứ in logo cho nhà hàng, khách sạn hay quà tặng doanh nghiệp?',
                                    'answer' => 'Quý khách vui lòng gửi thông tin yêu cầu tại trang Báo Giá hoặc gọi trực tiếp Hotline, đội ngũ tư vấn Gomie sẽ hỗ trợ lên maket thiết kế và gửi báo giá ưu đãi nhất.'
                                ),
                                array(
                                    'category' => 'technical',
                                    'question' => 'Thời gian sản xuất đơn hàng đặt in logo theo yêu cầu là bao lâu?',
                                    'answer' => 'Thời gian sản xuất thường từ 7 đến 15 ngày làm việc tùy thuộc vào số lượng và độ phức tạp của mẫu men họa tiết.'
                                ),
                            );
                            
                            foreach ($faqs as $index => $faq) :
                                ?>
                                <div class="faq-item glass-card" data-category="<?php echo esc_attr($faq['category']); ?>">
                                    <div class="faq-question">
                                        <h3><?php echo esc_html($faq['question']); ?></h3>
                                        <button class="faq-toggle" aria-label="Toggle answer">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="faq-answer">
                                        <p><?php echo esc_html($faq['answer']); ?></p>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                        
                        <!-- No Results -->
                        <div class="no-results" style="display: none;">
                            <p><?php esc_html_e('Không tìm thấy câu hỏi phù hợp.', 'gomie-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Contact Support -->
            <section class="contact-support section">
                <div class="container">
                    <div class="support-box glass-card text-center">
                        <h2><?php esc_html_e('Cần hỗ trợ thêm?', 'gomie-theme'); ?></h2>
                        <p><?php esc_html_e('Nếu bạn không tìm thấy câu trả lời cho câu hỏi của mình, hãy liên hệ với chúng tôi.', 'gomie-theme'); ?></p>
                        
                        <div class="support-options">
                            <a href="tel:<?php echo gomie_format_phone(gomie_get_option('phone_number', '0123456789')); ?>" class="glass-button">
                                <i class="fas fa-phone"></i>
                                <?php esc_html_e('Gọi ngay', 'gomie-theme'); ?>
                            </a>
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="glass-button secondary">
                                <i class="fas fa-envelope"></i>
                                <?php esc_html_e('Gửi email', 'gomie-theme'); ?>
                            </a>
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
    
    // FAQ Toggle
    $('.faq-toggle').on('click', function() {
        var faqItem = $(this).closest('.faq-item');
        var answer = faqItem.find('.faq-answer');
        var icon = $(this).find('i');
        
        // Close other items
        $('.faq-item').not(faqItem).removeClass('active');
        $('.faq-answer').not(answer).slideUp();
        $('.faq-toggle i').not(icon).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        
        // Toggle current item
        faqItem.toggleClass('active');
        answer.slideToggle();
        icon.toggleClass('fa-chevron-down fa-chevron-up');
    });
    
    // Category Filter
    $('.category-btn').on('click', function() {
        var category = $(this).data('category');
        
        // Update active button
        $('.category-btn').removeClass('active');
        $(this).addClass('active');
        
        // Filter items
        if (category === 'all') {
            $('.faq-item').show();
        } else {
            $('.faq-item').hide();
            $('.faq-item[data-category="' + category + '"]').show();
        }
        
        // Check if no results
        checkNoResults();
    });
    
    // Search
    $('.search-input').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.faq-item').each(function() {
            var question = $(this).find('.faq-question h3').text().toLowerCase();
            var answer = $(this).find('.faq-answer p').text().toLowerCase();
            
            if (question.indexOf(searchTerm) > -1 || answer.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        checkNoResults();
    });
    
    // Check no results
    function checkNoResults() {
        if ($('.faq-item:visible').length === 0) {
            $('.no-results').show();
        } else {
            $('.no-results').hide();
        }
    }
    
})(jQuery);
</script>

<?php
get_footer();