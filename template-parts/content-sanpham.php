<?php
/**
 * Template part for displaying products
 *
 * @package Gomie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('product-card glass-card'); ?>>
    <div class="product-image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('product-thumb'); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/no-image.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
        </a>
        
        <?php
        // Product badges
        $is_new = get_post_meta(get_the_ID(), '_is_new', true);
        $is_featured = get_post_meta(get_the_ID(), '_featured', true);
        
        if ($is_new || $is_featured) :
            ?>
            <div class="product-badges">
                <?php if ($is_new) : ?>
                    <span class="badge badge-new"><?php esc_html_e('Mới', 'gomie-theme'); ?></span>
                <?php endif; ?>
                <?php if ($is_featured) : ?>
                    <span class="badge badge-featured"><?php esc_html_e('Nổi bật', 'gomie-theme'); ?></span>
                <?php endif; ?>
            </div>
            <?php
        endif;
        ?>
        
        <div class="product-overlay">
            <a href="<?php the_permalink(); ?>" class="quick-view">
                <i class="fas fa-eye"></i>
                <?php esc_html_e('Xem chi tiết', 'gomie-theme'); ?>
            </a>
        </div>
    </div>
    
    <div class="product-info">
        <?php
        // Product categories
        $categories = get_the_terms(get_the_ID(), 'danh-muc-san-pham');
        if ($categories && !is_wp_error($categories)) :
            ?>
            <div class="product-category">
                <?php
                foreach ($categories as $category) :
                    echo '<a href="' . esc_url(get_term_link($category)) . '">' . esc_html($category->name) . '</a>';
                endforeach;
                ?>
            </div>
            <?php
        endif;
        ?>
        
        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <?php
        // Product code
        $product_code = get_post_meta(get_the_ID(), '_product_code', true);
        if ($product_code) :
            ?>
            <div class="product-code">
                <?php esc_html_e('Mã SP:', 'gomie-theme'); ?> <?php echo esc_html($product_code); ?>
            </div>
            <?php
        endif;
        ?>
        
        <div class="product-excerpt">
            <?php echo gomie_get_excerpt(15); ?>
        </div>
        
        <div class="product-actions">
            <a href="<?php the_permalink(); ?>" class="btn-view-product">
                <?php esc_html_e('Xem chi tiết', 'gomie-theme'); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>