<?php
/**
 * Template part for displaying single post content
 *
 * @package Gomie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>
    <header class="entry-header">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
        
        <div class="entry-meta">
            <span class="posted-on">
                <i class="far fa-calendar"></i>
                <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo get_the_date(); ?>
                </time>
            </span>
            
            <span class="byline">
                <i class="far fa-user"></i>
                <span class="author vcard">
                    <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php echo get_the_author(); ?>
                    </a>
                </span>
            </span>
            
            <?php if (get_comments_number() > 0) : ?>
                <span class="comments-link">
                    <i class="far fa-comments"></i>
                    <?php comments_popup_link(
                        esc_html__('No comments', 'gomie-theme'),
                        esc_html__('1 comment', 'gomie-theme'),
                        esc_html__('% comments', 'gomie-theme')
                    ); ?>
                </span>
            <?php endif; ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
    
    <div class="entry-content">
        <?php
        the_content();
        
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'gomie-theme'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->
    
    <footer class="entry-footer">
        <?php
        $categories_list = get_the_category_list(esc_html__(', ', 'gomie-theme'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'gomie-theme') . '</span>', $categories_list);
        }
        
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'gomie-theme'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'gomie-theme') . '</span>', $tags_list);
        }
        
        if (get_edit_post_link()) {
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
        }
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->