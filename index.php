<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php if (!is_front_page()) : ?>
            <!-- Page Header -->
            <div class="page-header">
                <div class="container">
                    <?php gomie_breadcrumbs(); ?>
                    
                    <h1 class="page-title">
                        <?php
                        if (is_home() && !is_front_page()) {
                            single_post_title();
                        } elseif (is_archive()) {
                            the_archive_title();
                        } elseif (is_search()) {
                            printf(esc_html__('Kết quả tìm kiếm cho: %s', 'gomie-theme'), '<span>' . get_search_query() . '</span>');
                        } elseif (is_404()) {
                            esc_html_e('Oops! Không tìm thấy trang.', 'gomie-theme');
                        }
                        ?>
                    </h1>
                    
                    <?php if (is_archive()) : ?>
                        <div class="archive-description">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="container">
            <div class="content-wrapper">
                <div class="primary-content">
                    <?php
                    if (have_posts()) :
                        
                        echo '<div class="posts-grid grid grid-3">';
                        
                        /* Start the Loop */
                        while (have_posts()) :
                            the_post();
                            
                            /*
                             * Include the Post-Type-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                             */
                            get_template_part('template-parts/content', get_post_type());
                            
                        endwhile;
                        
                        echo '</div><!-- .posts-grid -->';
                        
                        // Pagination
                        gomie_pagination();
                        
                    else :
                        
                        get_template_part('template-parts/content', 'none');
                        
                    endif;
                    ?>
                </div><!-- .primary-content -->
                
                <?php if (gomie_has_sidebar()) : ?>
                    <aside class="sidebar-content">
                        <?php get_sidebar(); ?>
                    </aside>
                <?php endif; ?>
            </div><!-- .content-wrapper -->
        </div><!-- .container -->
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();