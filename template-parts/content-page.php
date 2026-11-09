<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Gomie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail() && !is_front_page()) : ?>
        <div class="page-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </div>
    <?php endif; ?>
    
    <div class="page-content">
        <?php
        the_content();
        
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'gomie-theme'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .page-content -->
    
    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'gomie-theme'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->