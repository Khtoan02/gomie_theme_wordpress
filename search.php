<?php
/**
 * The template for displaying search results pages
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Search Header -->
        <div class="search-header">
            <div class="container">
                <?php gomie_breadcrumbs(); ?>
                
                <h1 class="search-title">
                    <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Kết quả tìm kiếm cho: %s', 'gomie-theme'), '<span>' . get_search_query() . '</span>');
                    ?>
                </h1>
                
                <div class="search-form-wrapper">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="content-wrapper">
                <div class="primary-content">
                    <?php if (have_posts()) : ?>
                        
                        <div class="search-info">
                            <?php
                            global $wp_query;
                            $results_count = $wp_query->found_posts;
                            /* translators: %d: number of search results */
                            printf(
                                esc_html(_n('Tìm thấy %d kết quả', 'Tìm thấy %d kết quả', $results_count, 'gomie-theme')),
                                $results_count
                            );
                            ?>
                        </div>
                        
                        <div class="search-results">
                            <?php
                            /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                ?>
                                <article class="search-result glass-card">
                                    <div class="result-content">
                                        <h2 class="result-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="result-meta">
                                            <span class="result-type">
                                                <?php
                                                $post_type_obj = get_post_type_object(get_post_type());
                                                echo esc_html($post_type_obj->labels->singular_name);
                                                ?>
                                            </span>
                                            <span class="result-date">
                                                <?php echo get_the_date(); ?>
                                            </span>
                                        </div>
                                        
                                        <div class="result-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php esc_html_e('Xem chi tiết', 'gomie-theme'); ?>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                    
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="result-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </article>
                                <?php
                            endwhile;
                            ?>
                        </div><!-- .search-results -->
                        
                        <?php
                        // Pagination
                        gomie_pagination();
                        
                    else :
                        ?>
                        <div class="no-results glass-card">
                            <h2><?php esc_html_e('Không tìm thấy kết quả nào', 'gomie-theme'); ?></h2>
                            <p><?php esc_html_e('Xin lỗi, không có kết quả nào phù hợp với từ khóa tìm kiếm của bạn. Vui lòng thử lại với từ khóa khác.', 'gomie-theme'); ?></p>
                            
                            <h3><?php esc_html_e('Gợi ý:', 'gomie-theme'); ?></h3>
                            <ul>
                                <li><?php esc_html_e('Kiểm tra lại chính tả của từ khóa', 'gomie-theme'); ?></li>
                                <li><?php esc_html_e('Sử dụng từ khóa tổng quát hơn', 'gomie-theme'); ?></li>
                                <li><?php esc_html_e('Thử tìm kiếm với ít từ khóa hơn', 'gomie-theme'); ?></li>
                            </ul>
                            
                            <div class="search-form-wrapper">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                        <?php
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