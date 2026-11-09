<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <section class="error-404 not-found">
            <div class="container">
                <div class="error-content text-center">
                    <div class="error-icon animate-fadeIn">
                        <span class="error-number">404</span>
                    </div>
                    
                    <h1 class="error-title animate-fadeIn">
                        <?php esc_html_e('Oops! Không tìm thấy trang', 'gomie-theme'); ?>
                    </h1>
                    
                    <p class="error-message animate-fadeIn">
                        <?php esc_html_e('Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.', 'gomie-theme'); ?>
                    </p>
                    
                    <div class="error-actions animate-fadeIn">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="glass-button">
                            <i class="fas fa-home"></i>
                            <?php esc_html_e('Về trang chủ', 'gomie-theme'); ?>
                        </a>
                        <button onclick="history.back()" class="glass-button secondary">
                            <i class="fas fa-arrow-left"></i>
                            <?php esc_html_e('Quay lại', 'gomie-theme'); ?>
                        </button>
                    </div>
                    
                    <div class="error-search animate-fadeIn">
                        <h3><?php esc_html_e('Hoặc thử tìm kiếm:', 'gomie-theme'); ?></h3>
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="error-suggestions animate-fadeIn">
                        <h3><?php esc_html_e('Các trang hữu ích:', 'gomie-theme'); ?></h3>
                        <div class="suggestions-grid grid grid-4">
                            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="suggestion-card glass-card">
                                <i class="fas fa-lightbulb"></i>
                                <span><?php esc_html_e('Sản phẩm', 'gomie-theme'); ?></span>
                            </a>
                            <a href="<?php echo esc_url(home_url('/giai-phap')); ?>" class="suggestion-card glass-card">
                                <i class="fas fa-cogs"></i>
                                <span><?php esc_html_e('Nhà hàng', 'gomie-theme'); ?></span>
                            </a>
                            <a href="<?php echo esc_url(home_url('/du-an')); ?>" class="suggestion-card glass-card">
                                <i class="fas fa-project-diagram"></i>
                                <span><?php esc_html_e('Khách sạn', 'gomie-theme'); ?></span>
                            </a>
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="suggestion-card glass-card">
                                <i class="fas fa-phone"></i>
                                <span><?php esc_html_e('Liên hệ', 'gomie-theme'); ?></span>
                            </a>
                        </div>
                    </div>
                </div><!-- .error-content -->
            </div><!-- .container -->
        </section><!-- .error-404 -->
        
    </main><!-- #main -->
</div><!-- #primary -->

<style>
.error-404 {
    padding: 100px 0;
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.error-icon {
    margin-bottom: 30px;
}

.error-number {
    font-size: 150px;
    font-weight: 700;
    color: var(--color-primary);
    line-height: 1;
    display: inline-block;
    background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.error-title {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.error-message {
    font-size: 1.25rem;
    color: #666;
    margin-bottom: 40px;
}

.error-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 60px;
}

.error-search {
    max-width: 500px;
    margin: 0 auto 60px;
}

.error-search h3 {
    margin-bottom: 20px;
}

.suggestions-grid {
    max-width: 600px;
    margin: 0 auto;
}

.suggestion-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 30px 20px;
    text-align: center;
    transition: all var(--transition-normal);
}

.suggestion-card i {
    font-size: 2rem;
    color: var(--color-primary);
}

.suggestion-card:hover {
    transform: translateY(-5px);
}

@media (max-width: 768px) {
    .error-number {
        font-size: 100px;
    }
    
    .error-title {
        font-size: 1.75rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .suggestions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php
get_footer();