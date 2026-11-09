<?php
/**
 * The template for displaying category archive pages
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area gomie-sharing-page-canvas">
    <main id="main" class="site-main">
        
        <!-- Category Header -->
        <div class="category-header">
            <div class="container">
                <?php gomie_breadcrumbs(); ?>
                
                <h1 class="category-title">
                    <?php single_cat_title(); ?>
                </h1>
                
                <?php
                $category_description = category_description();
                if (!empty($category_description)) :
                    ?>
                    <div class="category-description">
                        <?php echo $category_description; ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
        
        <div class="container">
            <div class="content-wrapper">
                <div class="primary-content">
                    <?php if (have_posts()) : ?>
                        
                        <div class="posts-grid grid grid-3">
                            <?php
                            /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                
                                get_template_part('template-parts/content', get_post_type());
                                
                            endwhile;
                            ?>
                        </div><!-- .posts-grid -->
                        
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