<?php
/**
 * The template for displaying all pages
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
        
        <div class="container">
            <div class="content-wrapper">
                <div class="primary-content">
                    <?php
                    while (have_posts()) :
                        the_post();
                        
                        get_template_part('template-parts/content', 'page');
                        

                        
                    endwhile; // End of the loop.
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