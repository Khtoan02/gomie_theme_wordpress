<?php
/**
 * Template for displaying Restaurant Category Archive
 * Specifically for "nha-hang" (restaurant) product category
 *
 * @package Gomie
 * @since 1.0.0
 */

get_header();

// AJAX handler is now in functions.php

// Include product card functions from front-page.php
$theme_dir_uri = get_template_directory_uri();

// Helper: Safe shop URL
if (!function_exists('gomie_shop_url')) {
    function gomie_shop_url() {
        if (function_exists('wc_get_page_permalink')) {
            $url = wc_get_page_permalink('shop');
            if ($url) return esc_url($url);
        }
        return esc_url(home_url('/shop'));
    }
}

// Helper: Get product image URL safely
if (!function_exists('gomie_get_product_image_url')) {
    function gomie_get_product_image_url($product_id, $size = 'woocommerce_thumbnail') {
        if (function_exists('wp_get_attachment_image_src')) {
            $image_id = get_post_thumbnail_id($product_id);
            if ($image_id) {
                $image_src = wp_get_attachment_image_src($image_id, $size);
                if (!empty($image_src[0])) {
                    return esc_url($image_src[0]);
                }
            }
        }
        
        // Fallback to WooCommerce placeholder
        if (function_exists('wc_placeholder_img_src')) {
            return wc_placeholder_img_src($size);
        }
        
        // Custom GOMIE ceramic placeholder
        return get_template_directory_uri() . '/assets/images/gomie-ceramic-placeholder.svg';
    }
}

// Helper: Get product stats (views, sales, rating) - Enhanced with real data
if (!function_exists('gomie_get_product_stats')) {
    function gomie_get_product_stats($product_id) {
        // Base stats with minimum requirements - using product ID for consistent numbers
        $base_views = 3000 + (($product_id % 20) * 500);  // Base views: 3000-13000 based on product ID
        $base_sales = 300 + (($product_id % 15) * 100);   // Base sales: 300-1700 based on product ID
        $base_rating = 6;                                  // Always 6/6 stars
        
        // Initialize stats array
        $stats = array(
            'views' => $base_views,
            'sales' => $base_sales,
            'rating' => $base_rating,
            'promotions' => 1 + (($product_id % 5))        // 1-5 promotions based on product ID
        );
        
        // Try to get real data if available
        if (function_exists('wc_get_product')) {
            $product = wc_get_product($product_id);
            if ($product) {
                // Get real sales data
                $real_sales = get_post_meta($product_id, 'total_sales', true);
                if ($real_sales && is_numeric($real_sales)) {
                    $real_sales = intval($real_sales);
                    // Combine base sales with real sales, ensuring minimum 300
                    $stats['sales'] = max(300, $base_sales + $real_sales);
                }
                
                // Get real views data (if using view tracking plugin)
                $real_views = get_post_meta($product_id, 'post_views_count', true);
                if ($real_views && is_numeric($real_views)) {
                    $real_views = intval($real_views);
                    // Combine base views with real views, ensuring minimum 3000
                    $stats['views'] = max(3000, $base_views + $real_views);
                }
                
                // Get real rating if available (but maintain 6/6 as minimum)
                $real_rating = $product->get_average_rating();
                if ($real_rating > 0) {
                    // Always show 6/6 stars for GOMIE quality
                    $stats['rating'] = 6;
                }
            }
        }
        
        return $stats;
    }
}

// Helper: Render product card with enhanced design
if (!function_exists('gomie_render_product_card')) {
    function gomie_render_product_card($product) {
        if (!$product) return;
        
        $product_id = $product->get_id();
        $title = $product->get_name();
        $permalink = get_permalink($product_id);
        $image = gomie_get_product_image_url($product_id, 'woocommerce_thumbnail');
        $price_html = $product->get_price_html();
        $stats = gomie_get_product_stats($product_id);
        
        // Format numbers
        $views_formatted = number_format($stats['views']);
        $sales_formatted = number_format($stats['sales']);
        
        global $theme_dir_uri;
        ?>
        <div class="gomie-product-item">
            <div class="gomie-product-card apple-style">
                <!-- Product Image Container -->
                <div class="product-image-wrapper">
                    <a href="<?php echo esc_url($permalink); ?>" class="product-image-link" aria-label="<?php echo esc_attr($title); ?>">
                        <div class="product-image-container">
                            <?php if (has_post_thumbnail($product_id)) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" class="product-image" />
                            <?php else : ?>
                                <img src="<?php echo esc_url($theme_dir_uri . '/assets/images/gomie-ceramic-placeholder.svg'); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" class="product-image" />
                            <?php endif; ?>
                        </div>
                    </a>
                </div>

                <!-- Product Content -->
                <div class="product-content">
                    <!-- Product Category -->
                    <div class="product-category">
                        <?php
                        $categories = wc_get_product_category_list($product_id, ', ', '', '');
                        if ($categories) {
                            echo '<span class="category-label">' . wp_kses_post($categories) . '</span>';
                        } else {
                            echo '<span class="category-label">Danh mục sản phẩm</span>';
                        }
                        ?>
                    </div>
                    
                    <!-- Product Title -->
                    <h3 class="product-title">
                        <a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($title); ?>">
                            <?php echo esc_html($title); ?>
                        </a>
                    </h3>
                    
                    <!-- Product Stats Row -->
                    <div class="product-stats">
                        <div class="stat-item">
                            <i class="fa-solid fa-eye"></i>
                            <span class="stat-value"><?php echo esc_html($views_formatted); ?></span>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-shopping-bag"></i>
                            <span class="stat-value"><?php echo esc_html($sales_formatted); ?></span>
                        </div>
                        <div class="stat-item">
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="fa-solid fa-star <?php echo $i <= $stats['rating'] ? 'filled' : 'empty'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Price -->
                    <div class="product-price-section">
                        <?php if (!empty($price_html)) : ?>
                            <div class="product-price"><?php echo wp_kses_post($price_html); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Add to Cart Button -->
                    <div class="product-actions">
                        <button class="btn-add-to-cart-apple" type="button" data-product-id="<?php echo esc_attr($product_id); ?>" data-product-url="<?php echo esc_url($permalink); ?>">
                            <span class="button-text">Thêm vào giỏ</span>
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

// Add SEO meta tags for external images
add_action('wp_head', function() {
    echo '<meta name="robots" content="index, follow, noarchive, nosnippet" />' . "\n";
    echo '<meta name="referrer" content="no-referrer-when-downgrade" />' . "\n";
}, 1);

// Get current term
$term = get_queried_object();
$term_id = $term->term_id;
$term_name = $term->name;
$term_description = $term->description;

// Get theme directory URI for assets
$theme_uri = get_template_directory_uri();

// Get subcategories of restaurant category
$subcategories = get_terms(array(
    'taxonomy' => 'product_cat',
    'parent' => $term_id,
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));

// Get restaurant images from helper function with SEO optimization
$restaurant_images = gomie_get_restaurant_images();
$restaurant_images = gomie_add_nofollow_to_external_images($restaurant_images);

// Get category statistics
$category_stats = gomie_get_restaurant_category_stats($term_id);
?>

<!-- Restaurant Category Hero Section -->
<section class="restaurant-hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1920&h=800&fit=crop" alt="Restaurant Background" class="hero-bg-image">
    </div>
    
    <div class="container">
        <div class="hero-content">
            <!-- Breadcrumb -->
            <?php gomie_restaurant_breadcrumb(); ?>
            
            <!-- Category Title & Description -->
            <div class="hero-text">
                <div class="category-badge">
                    <i class="fas fa-bed"></i>
                    <span>Danh mục chuyên nghiệp</span>
                </div>
                
                <h1 class="category-title"><?php echo esc_html($term_name); ?></h1>
                
                <?php if (!empty($term_description)) : ?>
                    <div class="category-description">
                        <?php echo wp_kses_post($term_description); ?>
                    </div>
                <?php else : ?>
                    <div class="category-description">
                        <p>Khám phá bộ sưu tập gốm sứ cao cấp dành riêng cho nhà hàng. Từ chén bát tinh tế đến đĩa trang trí nghệ thuật, mang đến trải nghiệm ẩm thực đẳng cấp cho khách hàng của bạn.</p>
                    </div>
                <?php endif; ?>
                
                <!-- Category Stats -->
                <div class="category-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo number_format($category_stats['total_products']); ?></span>
                        <span class="stat-label">Sản phẩm</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $category_stats['subcategories']; ?></span>
                        <span class="stat-label">Danh mục con</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $category_stats['average_rating']; ?>★</span>
                        <span class="stat-label">Đánh giá</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Widget Sidebar -->
<aside class="floating-widget-sidebar" id="floatingWidgets">
    <div class="widget-toggle-btn" id="widgetToggle">
        <i class="fas fa-bars"></i>
        <span class="toggle-text">Menu</span>
    </div>
    
    <div class="widget-container">
                <!-- Category Navigation Widget -->
                <div class="sidebar-widget category-nav-widget">
                    <h3 class="widget-title">
                        <i class="fas fa-list"></i>
                        Danh mục nhà hàng
                    </h3>
                    
                    <ul class="category-nav-list">
                        <li class="nav-item <?php echo is_product_category('nha-hang') ? 'active' : ''; ?>">
                            <a href="<?php echo get_term_link($term); ?>" class="nav-link">
                                <i class="fas fa-utensils"></i>
                                <span>Tất cả sản phẩm</span>
                                <span class="product-count"><?php echo $term->count; ?></span>
                            </a>
                        </li>
                        
                        <?php if (!empty($subcategories)) : ?>
                            <?php foreach ($subcategories as $subcat) : ?>
                                <li class="nav-item">
                                    <a href="<?php echo get_term_link($subcat); ?>" class="nav-link">
                                        <i class="fas fa-chevron-right"></i>
                                        <span><?php echo esc_html($subcat->name); ?></span>
                                        <span class="product-count"><?php echo $subcat->count; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Featured Products Widget -->
                <div class="sidebar-widget featured-products-widget">
                    <h3 class="widget-title">
                        <i class="fas fa-star"></i>
                        Sản phẩm nổi bật
                    </h3>
                    
                    <div class="featured-products-list">
                        <?php
                        // Get featured products from this category
                        $featured_args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 3,
                            'meta_key' => '_featured',
                            'meta_value' => 'yes',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => $term_id,
                                )
                            )
                        );
                        
                        $featured_query = new WP_Query($featured_args);
                        
                        if ($featured_query->have_posts()) :
                            while ($featured_query->have_posts()) : $featured_query->the_post();
                                $product = wc_get_product(get_the_ID());
                                ?>
                                <div class="featured-product-item">
                                    <div class="product-thumbnail">
                                        <a href="<?php echo get_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('woocommerce_gallery_thumbnail'); ?>
                                            <?php else : ?>
                                                <img src="<?php echo $theme_uri; ?>/assets/images/gomie-ceramic-placeholder.svg" alt="<?php the_title(); ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h4 class="product-name">
                                            <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                        <div class="product-price">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
                
                <!-- Contact Widget -->
                <div class="sidebar-widget contact-widget">
                    <h3 class="widget-title">
                        <i class="fas fa-phone"></i>
                        Cần tư vấn?
                    </h3>
                    <div class="contact-info">
                        <p>Liên hệ ngay với chúng tôi để được tư vấn về sản phẩm phù hợp cho nhà hàng của bạn.</p>
                        <div class="contact-buttons">
                            <a href="tel:+84123456789" class="btn btn-primary btn-sm">
                                <i class="fas fa-phone"></i>
                                Gọi ngay
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal">
                                <i class="fas fa-envelope"></i>
                                Nhắn tin
                            </a>
                        </div>
                    </div>
                </div>
    </div>
</aside>

<div class="restaurant-category-content">
    <div class="container">
        <!-- Main Content -->
        <main class="category-main-content-full">
                
                <!-- Restaurant Images Masonry Grid -->
                <section class="restaurant-gallery-section">
                    <div class="section-header">
                        <h2 class="section-title">Hình ảnh không gian nhà hàng</h2>
                        <p class="section-subtitle">Khám phá cách sản phẩm Gomie tạo nên không gian ẩm thực đẳng cấp</p>
                    </div>
                    
                    <div class="masonry-gallery-grid row" id="restaurantMasonry">
                        <?php 
                        // Chia hình ảnh thành 3 cột cho layout masonry với pattern dọc-ngang xen kẽ
                        $total_images = count($restaurant_images);
                        $images_per_column = ceil($total_images / 3);
                        
                        for ($col = 0; $col < 3; $col++) : 
                            $start_index = $col * $images_per_column;
                            $column_images = array_slice($restaurant_images, $start_index, $images_per_column);
                        ?>
                            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0 masonry-column">
                                <?php foreach ($column_images as $index => $image) : 
                                    $global_index = $start_index + $index;
                                    $row_number = floor($global_index / 3);
                                    $col_position = $global_index % 3;
                                    
                                    // Xác định orientation theo pattern:
                                    // Hàng chẵn (0,2,4...): Dọc, Ngang, Dọc
                                    // Hàng lẻ (1,3,5...): Ngang, Dọc, Ngang
                                    $is_even_row = ($row_number % 2 == 0);
                                    if ($is_even_row) {
                                        $orientation = ($col_position == 1) ? 'horizontal' : 'vertical';
                                    } else {
                                        $orientation = ($col_position == 1) ? 'vertical' : 'horizontal';
                                    }
                                ?>
                                    <div class="gallery-item gallery-item-<?php echo $orientation; ?>" 
                                         data-aos="fade-up" 
                                         data-aos-delay="<?php echo $global_index * 100; ?>" 
                                         data-category="<?php echo $global_index % 3 == 0 ? 'dining' : ($global_index % 3 == 1 ? 'kitchen' : 'decor'); ?>">
                                        <div class="gallery-card">
                                            <div class="image-wrapper">
                                                <?php echo gomie_generate_image_tag($image); ?>
                                                <div class="image-gradient"></div>
                                            </div>
                                            
                                            <div class="card-overlay">
                                                <div class="overlay-top">
                                                    <span class="image-category">
                                                        <?php 
                                                        $categories = ['Không gian', 'Bếp', 'Trang trí'];
                                                        echo $categories[$global_index % 3]; 
                                                        ?>
                                                    </span>
                                                    <button class="favorite-btn" data-image-id="<?php echo $global_index; ?>">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </div>
                                                
                                                <div class="overlay-content">
                                                    <h4 class="image-title"><?php echo esc_html($image['title']); ?></h4>
                                                    <p class="image-description"><?php echo esc_html($image['description'] ?? ''); ?></p>
                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </section>
                
                <!-- Products Section -->
                <section class="restaurant-products-section">
                    <div class="section-header">
                        <h2 class="section-title">Sản phẩm cho nhà hàng</h2>
                        <p class="section-subtitle">Bộ sưu tập gốm sứ cao cấp được thiết kế đặc biệt cho không gian ẩm thực chuyên nghiệp</p>
                    </div>
                    
                    <!-- Product Filters -->
                    <div class="product-filters">
                        <div class="filter-tabs">
                            <button class="filter-tab active" data-filter="all">Tất cả</button>
                            <?php
                            // Get subcategories of the current restaurant category
                            $subcategories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'parent' => $term_id,
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ));
                            
                            if (!empty($subcategories) && !is_wp_error($subcategories)) :
                                foreach ($subcategories as $subcategory) :
                            ?>
                                <button class="filter-tab" data-filter="<?php echo esc_attr($subcategory->slug); ?>">
                                    <?php echo esc_html($subcategory->name); ?>
                                </button>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                        
                        <div class="filter-options">
                            <select class="form-select" id="sortProducts">
                                <option value="default">Mặc định</option>
                                <option value="price-asc">Giá thấp đến cao</option>
                                <option value="price-desc">Giá cao đến thấp</option>
                                <option value="popularity">Phổ biến nhất</option>
                                <option value="rating">Đánh giá cao</option>
                                <option value="date">Mới nhất</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="products-container">
                        <?php
                        // Get current page number for pagination
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        
                        // Simplified and improved products query
                        $products_args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => 12,
                            'paged' => $paged,
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        
                        // Add tax_query for category
                        $tax_query = array();
                        
                        // Main category filter
                        $tax_query[] = array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $term_id,
                            'include_children' => true
                        );
                        
                        // Optional: Add WooCommerce visibility filter if function exists
                        if (function_exists('wc_get_product_visibility_term_ids')) {
                            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                            if (isset($product_visibility_term_ids['exclude-from-catalog'])) {
                                $tax_query[] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'term_taxonomy_id',
                                    'terms'    => array($product_visibility_term_ids['exclude-from-catalog']),
                                    'operator' => 'NOT IN',
                                );
                            }
                        }
                        
                        if (!empty($tax_query)) {
                            if (count($tax_query) > 1) {
                                $tax_query['relation'] = 'AND';
                            }
                            $products_args['tax_query'] = $tax_query;
                        }
                        
                        // Debug query args
                        echo '<!-- DEBUG Query Args: ' . print_r($products_args, true) . ' -->';
                        
                        $products_query = new WP_Query($products_args);
                        
                        // Debug information
                        echo '<!-- DEBUG: Found ' . $products_query->found_posts . ' products in category ID: ' . $term_id . ' -->';
                        
                        if ($products_query->have_posts()) :
                            echo '<div class="gomie-product-grid" data-filter-container="all">';
                            
                            $product_count = 0;
                            while ($products_query->have_posts()) : $products_query->the_post();
                                $product = wc_get_product(get_the_ID());
                                
                                if ($product) {
                                    $product_count++;
                                    
                                    // Get product categories for filtering
                                    $product_cats = wp_get_post_terms(get_the_ID(), 'product_cat');
                                    $filter_classes = array('filter-item');
                                    
                                    if (!empty($product_cats)) {
                                        foreach ($product_cats as $cat) {
                                            $filter_classes[] = 'filter-' . $cat->slug;
                                        }
                                    }
                                    
                                    echo '<!-- Product: ' . get_the_title() . ' | Classes: ' . implode(' ', $filter_classes) . ' -->';
                                    echo '<div class="' . implode(' ', $filter_classes) . '">';
                                    gomie_render_product_card($product);
                                    echo '</div>';
                                }
                                
                            endwhile;
                            
                            echo '</div>';
                            echo '<!-- DEBUG: Rendered ' . $product_count . ' products -->';
                            
                            // Pagination
                            $total_pages = $products_query->max_num_pages;
                            if ($total_pages > 1) :
                                ?>
                                <div class="products-pagination">
                                    <?php
                                    echo paginate_links(array(
                                        'total' => $total_pages,
                                        'current' => $paged,
                                        'format' => '?paged=%#%',
                                        'prev_text' => '<i class="fas fa-chevron-left"></i> Trước',
                                        'next_text' => 'Tiếp <i class="fas fa-chevron-right"></i>',
                                        'type' => 'list',
                                        'end_size' => 2,
                                        'mid_size' => 1,
                                    ));
                                    ?>
                                </div>
                                <?php
                            endif;
                            
                            wp_reset_postdata();
                            
                        else :
                            // Try fallback query without category restriction to show any products
                            echo '<!-- DEBUG: No products found in category, trying fallback query -->';
                            
                            $fallback_args = array(
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'posts_per_page' => 12,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            
                            $fallback_query = new WP_Query($fallback_args);
                            echo '<!-- DEBUG: Fallback query found ' . $fallback_query->found_posts . ' products -->';
                            
                            if ($fallback_query->have_posts()) :
                                echo '<div class="alert alert-warning mb-4">Không tìm thấy sản phẩm trong danh mục "' . esc_html($term_name) . '". Hiển thị tất cả sản phẩm:</div>';
                                echo '<div class="gomie-product-grid" data-filter-container="all">';
                                
                                while ($fallback_query->have_posts()) : $fallback_query->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    
                                    if ($product) {
                                        echo '<div class="filter-item">';
                                        gomie_render_product_card($product);
                                        echo '</div>';
                                    }
                                endwhile;
                                
                                echo '</div>';
                                wp_reset_postdata();
                            else :
                                ?>
                                <div class="no-products-found">
                                    <div class="no-products-content">
                                        <i class="fas fa-search"></i>
                                        <h3>Chưa có sản phẩm nào</h3>
                                        <p>Hiện tại chưa có sản phẩm nào trong cửa hàng. Vui lòng quay lại sau.</p>
                                        <p><strong>Debug:</strong> Category ID: <?php echo $term_id; ?>, Term Name: <?php echo esc_html($term_name); ?></p>
                                        <?php
                                        // Show all available product categories for debugging
                                        $all_cats = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
                                        if (!empty($all_cats)) {
                                            echo '<p><strong>Available Categories:</strong><br>';
                                            foreach ($all_cats as $cat) {
                                                echo $cat->name . ' (ID: ' . $cat->term_id . ', Count: ' . $cat->count . ')<br>';
                                            }
                                            echo '</p>';
                                        }
                                        ?>
                                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-primary">
                                            <i class="fas fa-arrow-left"></i>
                                            Quay lại cửa hàng
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>
                    </div>
                </section>
                
                <!-- Call to Action -->
                <section class="restaurant-cta-section">
                    <div class="cta-card">
                        <div class="cta-content">
                            <div class="cta-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="cta-text">
                                <h3>Cần tư vấn cho dự án nhà hàng?</h3>
                                <p>Đội ngũ chuyên gia của Gomie sẵn sàng tư vấn và thiết kế bộ sản phẩm phù hợp với phong cách nhà hàng của bạn.</p>
                            </div>
                            <div class="cta-actions">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#consultModal">
                                    <i class="fas fa-comments"></i>
                                    Tư vấn miễn phí
                                </a>
                                <a href="tel:+84123456789" class="btn btn-outline-primary">
                                    <i class="fas fa-phone"></i>
                                    Hotline: 0123 456 789
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                
            </main>
    </div>
</div>

<!-- Enhanced Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="imageModalLabel">Hình ảnh chi tiết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-8">
                        <img src="" alt="" class="img-fluid w-100" id="modalImage" style="max-height: 70vh; object-fit: cover;">
                    </div>
                    <div class="col-md-4 p-4">
                        <div class="modal-image-info">
                            <h4 class="mb-3" id="modalImageTitle">Tiêu đề hình ảnh</h4>
                            <p class="text-muted mb-4" id="modalImageDescription">Mô tả hình ảnh sẽ được hiển thị ở đây</p>
                            
                            <div class="modal-actions d-flex gap-2">
                                <button class="btn btn-primary flex-fill" id="modalFavoriteBtn">
                                    <i class="far fa-heart"></i>
                                    Yêu thích
                                </button>
                                <button class="btn btn-outline-primary flex-fill" id="modalShareBtn">
                                    <i class="fas fa-share-alt"></i>
                                    Chia sẻ
                                </button>
                            </div>
                            
                            <div class="modal-navigation mt-4">
                                <button class="btn btn-outline-secondary me-2" id="modalPrevBtn">
                                    <i class="fas fa-chevron-left"></i>
                                    Trước
                                </button>
                                <button class="btn btn-outline-secondary" id="modalNextBtn">
                                    Tiếp
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles are loaded from restaurant-category.css -->

<!-- Product Filters JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product Filter Functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const sortSelect = document.getElementById('sortProducts');
    const productGrid = document.querySelector('.gomie-product-grid');
    const filterItems = document.querySelectorAll('.filter-item');
    
    // Ensure all items are visible initially
    filterItems.forEach((item) => {
        item.style.display = 'block';
        item.style.opacity = '1';
        item.style.visibility = 'visible';
        item.classList.remove('hidden');
    });
    
    // Ensure product grid is visible
    if (productGrid) {
        productGrid.style.display = 'grid';
        productGrid.style.visibility = 'visible';
    }
    
    // Store filter items globally for AJAX updates
    window.filterItems = filterItems;
    
    // Filter by category with AJAX pagination per tab
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filterValue = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Check if this filter has been loaded before
            if (!tabPages[filterValue]) {
                tabPages[filterValue] = 1;
            }
            
            // Load products for this tab (always start from page 1 when switching tabs)
            const currentPage = tabPages[filterValue] || 1;
            
            // If switching to a different tab, reset to page 1
            if (filterValue !== currentFilter) {
                tabPages[filterValue] = 1;
                loadProducts(1, filterValue);
            } else {
                // Same tab, just do client-side filtering (for current page products)
                let visibleCount = 0;
                const currentFilterItems = window.filterItems || filterItems;
                currentFilterItems.forEach(item => {
                    if (filterValue === 'all' || item.classList.contains(`filter-${filterValue}`)) {
                        item.classList.remove('hidden');
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });
                console.log(`Client-side filtering: Showing ${visibleCount} products for filter: ${filterValue}`);
            }
            
            currentFilter = filterValue;
        });
    });
    
    // AJAX Pagination Variables - Track page for each tab
    let tabPages = {
        'all': 1  // Default page for "all" tab
    };
    let currentFilter = 'all';
    let isLoading = false;
    
    // Initialize tab pages for each filter tab
    filterTabs.forEach(tab => {
        const tabFilter = tab.dataset.filter;
        if (tabFilter && !tabPages[tabFilter]) {
            tabPages[tabFilter] = 1;
        }
    });
    
    // AJAX Load Products Function
    function loadProducts(page, filter = 'all') {
        if (isLoading) return;
        
        isLoading = true;
        
        // Update page for current tab
        tabPages[filter] = page;
        currentFilter = filter;
        
        const productsContainer = document.querySelector('.products-container');
        const productGrid = document.querySelector('.gomie-product-grid');
        const paginationContainer = document.querySelector('.products-pagination');
        
        // Add loading state
        productsContainer.classList.add('loading');
        
        // Show loading in pagination
        if (paginationContainer) {
            paginationContainer.innerHTML = '<div class="pagination-loading"><div class="spinner"></div> Đang tải...</div>';
        }
        
        // Prepare AJAX data
        const formData = new FormData();
        formData.append('action', 'load_restaurant_products');
        formData.append('page', page);
        formData.append('filter', filter);
        formData.append('term_id', <?php echo json_encode($term_id); ?>);
        formData.append('nonce', '<?php echo wp_create_nonce("load_restaurant_products_nonce"); ?>');
        
        // Debug FormData
        console.log('Sending AJAX request with data:', {
            action: 'load_restaurant_products',
            page: page,
            filter: filter,
            term_id: <?php echo json_encode($term_id); ?>,
            nonce: '<?php echo wp_create_nonce("load_restaurant_products_nonce"); ?>'
        });
        
        // AJAX Request
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text().then(text => {
                console.log('Raw response:', text.substring(0, 500));
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    throw new Error('Invalid JSON response');
                }
            });
        })
        .then(data => {
            console.log('Parsed data:', data);
            if (data.success) {
                // Update products with fade effect
                if (productGrid) {
                    productGrid.style.opacity = '0';
                    
                    setTimeout(() => {
                        productGrid.innerHTML = data.data.products;
                        productGrid.style.opacity = '1';
                        
                        // Re-initialize filter items for client-side filtering
                        const newFilterItems = document.querySelectorAll('.filter-item');
                        newFilterItems.forEach((item) => {
                            item.style.display = 'block';
                            item.style.opacity = '1';
                            item.style.visibility = 'visible';
                            item.classList.remove('hidden');
                        });
                        
                        // Update filter items reference for future filtering
                        window.filterItems = newFilterItems;
                    }, 150);
                }
                
                // Update pagination
                if (paginationContainer) {
                    setTimeout(() => {
                        paginationContainer.innerHTML = data.data.pagination;
                    }, 150);
                }
                
                // Update URL without page reload
                const newUrl = new URL(window.location);
                
                // Set filter if not "all"
                if (filter !== 'all') {
                    newUrl.searchParams.set('filter', filter);
                } else {
                    newUrl.searchParams.delete('filter');
                }
                
                // Set page if > 1
                if (page > 1) {
                    newUrl.searchParams.set('paged', page);
                } else {
                    newUrl.searchParams.delete('paged');
                }
                
                window.history.pushState({page: page, filter: filter, tabPages: {...tabPages}}, '', newUrl);
                
                // Scroll to products section smoothly
                setTimeout(() => {
                    document.querySelector('.restaurant-products-section').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 200);
                
                console.log(`Loaded page ${page} successfully with ${data.data.found_posts} products`);
            } else {
                console.error('AJAX Error:', data.data);
                alert('Có lỗi xảy ra khi tải sản phẩm. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Network Error:', error);
            alert('Có lỗi mạng xảy ra. Vui lòng kiểm tra kết nối và thử lại.');
        })
        .finally(() => {
            // Remove loading state
            setTimeout(() => {
                productsContainer.classList.remove('loading');
                isLoading = false;
            }, 300);
        });
    }
    
    // Handle pagination clicks with event delegation
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('page-numbers') && 
            !e.target.classList.contains('dots') && 
            !e.target.classList.contains('current') &&
            !isLoading) {
            
            e.preventDefault();
            
            let targetPage = 1;
            const href = e.target.getAttribute('href');
            
            if (href) {
                const urlParams = new URLSearchParams(href.split('?')[1]);
                targetPage = parseInt(urlParams.get('paged')) || 1;
            } else if (e.target.textContent.trim() && !isNaN(e.target.textContent.trim())) {
                targetPage = parseInt(e.target.textContent.trim());
            }
            
            // Load products for current filter with target page
            loadProducts(targetPage, currentFilter);
        }
    });
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (e.state) {
            const page = e.state.page || 1;
            const filter = e.state.filter || 'all';
            
            // Restore tab pages if available
            if (e.state.tabPages) {
                tabPages = {...e.state.tabPages};
            }
            
            // Update active tab
            filterTabs.forEach(t => {
                if (t.dataset.filter === filter) {
                    t.classList.add('active');
                } else {
                    t.classList.remove('active');
                }
            });
            
            loadProducts(page, filter);
        }
    });
    
    // Set initial state
    const urlParams = new URLSearchParams(window.location.search);
    const initialFilter = urlParams.get('filter') || 'all';
    const initialPage = parseInt(urlParams.get('paged')) || 1;
    
    // Set initial tab page
    tabPages[initialFilter] = initialPage;
    currentFilter = initialFilter;
    
    window.history.replaceState({
        page: initialPage, 
        filter: initialFilter, 
        tabPages: {...tabPages}
    }, '', window.location);
    
    // Sort products
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const visibleItems = Array.from(filterItems).filter(item => !item.classList.contains('hidden'));
            
            // Sort logic would go here - for now just a placeholder
            console.log('Sorting by:', sortValue);
            
            // You can implement sorting by price, popularity, etc. here
            // This would require AJAX calls to reload products with new order
        });
    }
    
    // Add to cart functionality (placeholder)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-to-cart-apple')) {
            const button = e.target.closest('.btn-add-to-cart-apple');
            const productId = button.dataset.productId;
            
            // Add loading state
            button.style.opacity = '0.7';
            button.style.pointerEvents = 'none';
            
            // Placeholder for add to cart AJAX
            console.log('Adding product to cart:', productId);
            
            // Reset button after 2 seconds (replace with actual AJAX response)
            setTimeout(() => {
                button.style.opacity = '1';
                button.style.pointerEvents = 'auto';
                
                // Show success message
                const originalText = button.querySelector('.button-text').textContent;
                button.querySelector('.button-text').textContent = 'Đã thêm!';
                
                setTimeout(() => {
                    button.querySelector('.button-text').textContent = originalText;
                }, 1500);
            }, 2000);
        }
    });
});
</script>

<!-- Structured Data for SEO -->
<script type="application/ld+json">
<?php echo gomie_restaurant_category_structured_data($term); ?>
</script>

<?php get_footer(); ?>
