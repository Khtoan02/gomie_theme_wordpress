<?php
/**
 * The template for displaying archive pages
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Archive Header -->
        <div class="archive-header">
            <div class="container">
                <?php gomie_breadcrumbs(); ?>
                
                <h1 class="archive-title">
                    <?php echo gomie_get_archive_title(); ?>
                </h1>
                
                <?php
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </div>
        </div>
        
        <div class="container">
            <div class="content-wrapper">
                <div class="primary-content">
                    <?php if (have_posts()) : ?>
                        
                        <div class="archive-grid grid grid-3">
                            <?php
                            /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                
                                /*
                                 * Include the Post-Type-specific template for the content.
                                 */
                                get_template_part('template-parts/content', get_post_type());
                                
                            endwhile;
                            ?>
                        </div><!-- .archive-grid -->
                        
                        <?php
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