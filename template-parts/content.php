<?php
/**
 * Template part for displaying posts (Editorial Card Style)
 *
 * @package Gomie
 */

$p_id = get_the_ID();
$thumb_src = function_exists('gomie_get_post_thumbnail_src') ? gomie_get_post_thumbnail_src($p_id, 'medium_large') : (has_post_thumbnail() ? get_the_post_thumbnail_url($p_id, 'medium_large') : '');
$reading_time = function_exists('gomie_get_reading_time') ? gomie_get_reading_time($p_id) : '3 phút đọc';
$post_cats = get_the_category();
$p_cat_name = !empty($post_cats) ? $post_cats[0]->name : 'Gốm sứ';
$p_cat_link = !empty($post_cats) ? get_category_link($post_cats[0]->term_id) : '#';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gomie-post-card'); ?>>
    <div class="card-thumb-wrap">
        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
            <img src="<?php echo esc_url($thumb_src); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
        </a>
        <a href="<?php echo esc_url($p_cat_link); ?>" class="card-category-badge">
            <?php echo esc_html($p_cat_name); ?>
        </a>
    </div>
    
    <div class="card-body-content">
        <div class="card-meta">
            <span><i class="fa-regular fa-calendar-days"></i> <?php echo get_the_date('d/m/Y'); ?></span>
            <span><i class="fa-regular fa-clock"></i> <?php echo esc_html($reading_time); ?></span>
        </div>
        
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="card-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 24, '...'); ?>
        </div>
        
        <div class="card-action-row">
            <span class="card-author-mini">
                <i class="fa-solid fa-pen-nib me-1 text-muted"></i> Gomie Ceramic
            </span>
            <a href="<?php the_permalink(); ?>" class="card-read-link">
                <span>Đọc tiếp</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>
