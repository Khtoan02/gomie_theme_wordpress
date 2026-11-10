<?php
/**
 * Template Name: Partners
 * Description: Template for Partners/Brands page
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
            
            <!-- Page Content -->
            <?php if (get_the_content()) : ?>
                <section class="page-content section">
                    <div class="container">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            
            <!-- Partners Grid -->
            <section class="partners-grid-section section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Đối tác của chúng tôi', 'gomie-theme'); ?></h2>
                        <p><?php esc_html_e('Chúng tôi tự hào hợp tác với các thương hiệu hàng đầu', 'gomie-theme'); ?></p>
                    </div>
                    
                    <div class="partners-grid grid grid-4">
                        <?php
                        $partners = function_exists('gomie_get_partners') ? gomie_get_partners() : array();
                        if (!empty($partners)) :
                            foreach ($partners as $partner) :
                                $has_link = !empty($partner['url']);
                                ?>
                                <div class="partner-item glass-card">
                                    <?php if ($has_link) : ?>
                                        <a href="<?php echo esc_url($partner['url']); ?>" target="<?php echo esc_attr($partner['target']); ?>" rel="noopener noreferrer">
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($partner['logo_url'])) : ?>
                                        <img src="<?php echo esc_url($partner['logo_url']); ?>" alt="<?php echo esc_attr($partner['title']); ?>" loading="lazy">
                                    <?php else : ?>
                                        <div class="partner-name">
                                            <h4 style="font-weight: 850; font-size: 16px; letter-spacing: 0.12em; color: #3a4650; margin: 0;"><?php echo esc_html($partner['text']); ?></h4>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($has_link) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </section>
            
            <!-- Clients Section -->
            <section class="clients-section section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Khách hàng tiêu biểu', 'gomie-theme'); ?></h2>
                        <p><?php esc_html_e('Những khách hàng đã tin tưởng và sử dụng sản phẩm của chúng tôi', 'gomie-theme'); ?></p>
                    </div>
                    
                    <div class="clients-logos">
                        <div class="clients-slider">
                            <?php
                            // You can use ACF repeater field for client logos
                            // This is a placeholder for the slider
                            ?>
                            <div class="client-logo">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/client-placeholder.png'); ?>" alt="Client">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Testimonials -->
            <section class="testimonials-section section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Khách hàng nói gì về chúng tôi', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="testimonials-grid grid grid-3">
                        <?php
                        // You can use ACF repeater field or custom post type for testimonials
                        // For demo purposes, we'll create static testimonials
                        $testimonials = array(
                            array(
                                'name' => 'Nguyễn Văn A',
                                'position' => 'Giám đốc Công ty ABC',
                                'content' => 'Sản phẩm chất lượng cao, dịch vụ tốt. Chúng tôi rất hài lòng khi hợp tác với Gomie Ceramic.',
                                'rating' => 5
                            ),
                            array(
                                'name' => 'Trần Thị B',
                                'position' => 'Chủ đầu tư Dự án XYZ',
                                'content' => 'Đội ngũ chuyên nghiệp, tư vấn nhiệt tình. Giải pháp chiếu sáng đáp ứng đúng yêu cầu.',
                                'rating' => 5
                            ),
                            array(
                                'name' => 'Lê Văn C',
                                'position' => 'Kiến trúc sư',
                                'content' => 'Gomie Ceramic luôn cập nhật công nghệ mới, mang lại giải pháp tiết kiệm năng lượng hiệu quả.',
                                'rating' => 5
                            ),
                        );
                        
                        foreach ($testimonials as $testimonial) :
                            ?>
                            <div class="testimonial-card glass-card">
                                <div class="testimonial-content">
                                    <div class="quote-icon">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <p><?php echo esc_html($testimonial['content']); ?></p>
                                    
                                    <div class="testimonial-rating">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) :
                                            if ($i <= $testimonial['rating']) :
                                                echo '<i class="fas fa-star"></i>';
                                            else :
                                                echo '<i class="far fa-star"></i>';
                                            endif;
                                        endfor;
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="testimonial-author">
                                    <h4><?php echo esc_html($testimonial['name']); ?></h4>
                                    <p><?php echo esc_html($testimonial['position']); ?></p>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>
            
            <!-- Partnership Benefits -->
            <section class="partnership-benefits section">
                <div class="container">
                    <div class="section-title text-center">
                        <h2><?php esc_html_e('Lợi ích khi hợp tác', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="benefits-grid grid grid-3">
                        <div class="benefit-item text-center animate-fadeIn">
                            <div class="benefit-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <h3><?php esc_html_e('Chiết khấu hấp dẫn', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Chính sách giá ưu đãi cho đối tác lâu dài', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="benefit-item text-center animate-fadeIn">
                            <div class="benefit-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h3><?php esc_html_e('Hỗ trợ kỹ thuật', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Hỗ trợ kỹ thuật 24/7 từ đội ngũ chuyên gia', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="benefit-item text-center animate-fadeIn">
                            <div class="benefit-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <h3><?php esc_html_e('Chứng nhận đối tác', 'gomie-theme'); ?></h3>
                            <p><?php esc_html_e('Chứng nhận đối tác chính thức của Gomie Ceramic', 'gomie-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Become Partner CTA -->
            <section class="become-partner section">
                <div class="container">
                    <div class="cta-box glass-card text-center">
                        <h2><?php esc_html_e('Trở thành đối tác của Gomie Ceramic', 'gomie-theme'); ?></h2>
                        <p><?php esc_html_e('Hãy cùng chúng tôi mang đến giải pháp chiếu sáng tốt nhất cho khách hàng', 'gomie-theme'); ?></p>
                        
                        <div class="cta-buttons">
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="glass-button">
                                <?php esc_html_e('Đăng ký hợp tác', 'gomie-theme'); ?>
                            </a>
                            <a href="tel:<?php echo gomie_format_phone(gomie_get_option('phone_number', '0123456789')); ?>" class="glass-button secondary">
                                <i class="fas fa-phone"></i>
                                <?php esc_html_e('Gọi ngay', 'gomie-theme'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            
        <?php endwhile; ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();