<?php
/**
 * Template part for displaying posts
 *
 * @package Gomie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="blog-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('blog-thumb'); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="blog-content">
        <div class="blog-meta">
            <span class="blog-date">
                <i class="far fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            <span class="blog-category">
                <i class="far fa-folder"></i>
                <?php the_category(', '); ?>
            </span>
        </div>
        
        <h3 class="blog-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="blog-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php esc_html_e('Đọc thêm', 'gomie-theme'); ?>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</article>