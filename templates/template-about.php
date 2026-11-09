<?php
/**
 * Template Name: About Us
 * Description: Template for About Us page
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
            
            <!-- About Content -->
            <section class="about-content section">
                <div class="container">
                    <div class="content-wrapper">
                        <div class="about-text">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Mission & Vision -->
            <section class="mission-vision section">
                <div class="container">
                    <div class="grid grid-2">
                        <div class="mission-box glass-card animate-fadeIn">
                            <div class="icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3><?php esc_html_e('Sứ mệnh', 'gomie-theme'); ?></h3>
                            <p><?php echo gomie_get_option('mission_text', 'Mang đến những sản phẩm gốm sứ Bát Tràng chất lượng cao, tinh xảo và an toàn cho sức khỏe gia đình Việt.'); ?></p>
                        </div>
                        
                        <div class="vision-box glass-card animate-fadeIn">
                            <div class="icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3><?php esc_html_e('Tầm nhìn', 'gomie-theme'); ?></h3>
                            <p><?php echo gomie_get_option('vision_text', 'Trở thành thương hiệu gốm sứ thủ công uy tín hàng đầu Việt Nam, gìn giữ và tôn vinh tinh hoa làng nghề truyền thống.'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Core Values -->
            <section class="core-values section">
                <div class="container">
                    <div class="section-title">
                        <h2><?php esc_html_e('Giá trị cốt lõi', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <div class="values-grid grid grid-4">
                        <div class="value-item glass-card animate-fadeIn">
                            <div class="value-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                            <h4><?php esc_html_e('Chất lượng', 'gomie-theme'); ?></h4>
                            <p><?php esc_html_e('Cam kết cung cấp sản phẩm chất lượng cao', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="value-item glass-card animate-fadeIn">
                            <div class="value-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h4><?php esc_html_e('Sáng tạo', 'gomie-theme'); ?></h4>
                            <p><?php esc_html_e('Không ngừng đổi mới và cải tiến', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="value-item glass-card animate-fadeIn">
                            <div class="value-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h4><?php esc_html_e('Uy tín', 'gomie-theme'); ?></h4>
                            <p><?php esc_html_e('Xây dựng niềm tin với khách hàng', 'gomie-theme'); ?></p>
                        </div>
                        
                        <div class="value-item glass-card animate-fadeIn">
                            <div class="value-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <h4><?php esc_html_e('Bền vững', 'gomie-theme'); ?></h4>
                            <p><?php esc_html_e('Phát triển bền vững và bảo vệ môi trường', 'gomie-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Team Section -->
            <section class="team-section section">
                <div class="container">
                    <div class="section-title">
                        <h2><?php esc_html_e('Đội ngũ của chúng tôi', 'gomie-theme'); ?></h2>
                    </div>
                    
                    <?php
                    // You can use ACF repeater field or custom query to display team members
                    ?>
                </div>
            </section>
            
            <!-- Achievements -->
            <section class="achievements section">
                <div class="container">
                    <div class="achievements-grid grid grid-4">
                        <div class="achievement-item text-center animate-fadeIn">
                            <div class="achievement-number" data-count="10">0</div>
                            <div class="achievement-label"><?php esc_html_e('Năm kinh nghiệm', 'gomie-theme'); ?></div>
                        </div>
                        
                        <div class="achievement-item text-center animate-fadeIn">
                            <div class="achievement-number" data-count="500">0</div>
                            <div class="achievement-label"><?php esc_html_e('Dự án hoàn thành', 'gomie-theme'); ?></div>
                        </div>
                        
                        <div class="achievement-item text-center animate-fadeIn">
                            <div class="achievement-number" data-count="1000">0</div>
                            <div class="achievement-label"><?php esc_html_e('Khách hàng hài lòng', 'gomie-theme'); ?></div>
                        </div>
                        
                        <div class="achievement-item text-center animate-fadeIn">
                            <div class="achievement-number" data-count="50">0</div>
                            <div class="achievement-label"><?php esc_html_e('Nhân viên', 'gomie-theme'); ?></div>
                        </div>
                    </div>
                </div>
            </section>
            
        <?php endwhile; ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();