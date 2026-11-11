<?php
/**
 * The Template for displaying product archives, including the main shop page
 * Custom design for Gomie Ceramic theme with category sections
 *
 * @package Gomie
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Get all product categories
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => 0, // Only top-level categories
    'orderby' => 'name',
    'order' => 'ASC'
));

// Helper functions (reuse from existing templates)
if (!function_exists('gomie_get_product_image_url')) {
    function gomie_get_product_image_url($product_id, $size = 'full') {
        if (function_exists('wp_get_attachment_image_src')) {
            $image_id = get_post_thumbnail_id($product_id);
            if ($image_id) {
                $image_src = wp_get_attachment_image_src($image_id, $size);
                if (!empty($image_src[0])) {
                    return esc_url($image_src[0]);
                }
            }
        }
        
        if (function_exists('wc_placeholder_img_src')) {
            return wc_placeholder_img_src($size);
        }
        
        return get_template_directory_uri() . '/assets/images/gomie-ceramic-placeholder.svg';
    }
}

if (!function_exists('gomie_get_product_stats')) {
    function gomie_get_product_stats($product_id) {
        $base_views = 3000 + (($product_id % 20) * 500);
        $base_sales = 300 + (($product_id % 15) * 100);
        $base_rating = 6;
        
        return array(
            'views' => $base_views,
            'sales' => $base_sales,
            'rating' => $base_rating,
            'promotions' => 1 + (($product_id % 5))
        );
    }
}

if (!function_exists('gomie_render_product_card_shop')) {
    function gomie_render_product_card_shop($product) {
        if (!$product) return;
        
        $product_id = $product->get_id();
        $title = $product->get_name();
        $permalink = get_permalink($product_id);
        $image = gomie_get_product_image_url($product_id, 'full');
        $price_html = $product->get_price_html();
        $stats = gomie_get_product_stats($product_id);
        
        $views_formatted = number_format($stats['views']);
        $sales_formatted = number_format($stats['sales']);
        
        $theme_dir_uri = get_template_directory_uri();
        ?>
        <div class="gomie-product-item">
            <div class="gomie-product-card apple-style">
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

                <div class="product-content">
                    <h3 class="product-title">
                        <a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($title); ?>">
                            <?php echo esc_html($title); ?>
                        </a>
                    </h3>
                    
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
                    
                    <div class="product-price-section">
                        <?php if (!empty($price_html)) : ?>
                            <div class="product-price"><?php echo wp_kses_post($price_html); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-actions">
                        <a href="<?php echo esc_url($permalink); ?>" class="btn-card-detail" title="<?php echo esc_attr($title); ?>">
                            <span class="button-text">Chi tiết</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<!-- Shop Page Hero Section -->
<section class="shop-hero restaurant-hero">
    <div class="hero-background">
        <div class="hero-overlay"></div>
        <img src="https://gomie.vn/wp-content/uploads/2025/09/Cac-thanh-phan-bo-do-an-men-xanh-song-bien-nha-hang-1200x540.jpeg" 
             alt="Gốm sứ thủ công Gomie" 
             class="hero-bg-image"
             onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/images/gomie-ceramic-placeholder.svg'">
    </div>
    
    <div class="container">
        <div class="hero-content">
            <!-- Breadcrumb -->
            <div class="breadcrumb-nav">
                <ul class="breadcrumb">
                    <li><a href="<?php echo home_url(); ?>">Trang chủ</a></li>
                    <li class="current">Cửa hàng</li>
                </ul>
            </div>
            
            <!-- Hero Text -->
            <div class="category-badge">
                <i class="fas fa-store"></i>
                <span>Cửa hàng chính hãng</span>
            </div>
            
            <h1 class="category-title">Tinh hoa gốm sứ Bát Tràng</h1>
            
            <div class="category-description">
                <p>Khám phá bộ sưu tập gốm sứ cao cấp kết hợp tinh hoa nghề truyền thống <strong>700 năm làng Bát Tràng</strong> 
                với thiết kế hiện đại. Dành riêng cho <strong>nhà hàng, khách sạn và quà tặng</strong> - 
                mang văn hóa Việt Nam giới thiệu bạn bè năm châu.</p>
            </div>
            
            <!-- Category Stats -->
            <div class="category-stats">
                <div class="stat-item">
                    <span class="stat-number">
                        <?php 
                        $total_products = wp_count_posts('product');
                        echo number_format($total_products->publish ?? 200);
                        ?>+
                    </span>
                    <span class="stat-label">Sản phẩm thủ công</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">700</span>
                    <span class="stat-label">Năm truyền thống</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3</span>
                    <span class="stat-label">Danh mục chuyên biệt</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5.0★</span>
                    <span class="stat-label">Đánh giá khách hàng</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Sections -->
<div id="categories" class="shop-categories-wrapper">
    <div class="container">
        <?php if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
            <?php foreach ($product_categories as $index => $category) : 
                // Get products in this category for carousel
                $category_products = get_posts(array(
                    'post_type' => 'product',
                    'posts_per_page' => 12, // More products for carousel
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        )
                    )
                ));
                
                if (empty($category_products)) continue;
                
                // Alternate section background
                $section_class = ($index % 2 == 0) ? 'category-section-light' : 'category-section-dark';
                
                // Category icons
                $category_icons = array(
                    'nha-hang' => 'fas fa-utensils',
                    'khach-san' => 'fas fa-bed',
                    'qua-tang' => 'fas fa-gift'
                );
                
                $icon = isset($category_icons[$category->slug]) ? $category_icons[$category->slug] : 'fas fa-circle';
            ?>
                <section class="category-section <?php echo $section_class; ?>" data-aos="fade-up">
                    <div class="section-heading text-center">
                        <div class="gomie-eyebrow">
                            <i class="<?php echo $icon; ?>"></i>
                            <?php echo esc_html($category->name); ?>
                        </div>
                        
                        <h2 class="title"><?php echo esc_html($category->name); ?></h2>
                        <p class="sub">Khám phá bộ sưu tập <?php echo strtolower(esc_html($category->name)); ?> cao cấp</p>
                        
                        <div class="cat-cta">
                            <div class="badge-cat">
                                <i class="fas fa-box-open"></i>
                                <?php echo $category->count; ?> sản phẩm
                            </div>
                            <a href="<?php echo get_term_link($category); ?>" class="btn-gomie">
                                <span>Xem tất cả</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Products Carousel -->
                    <div class="category-products-carousel" data-aos="fade-up" data-aos-delay="200">
                        <div class="swiper category-swiper-<?php echo $category->slug; ?>">
                            <div class="swiper-wrapper">
                                <?php foreach ($category_products as $product_post) : 
                                    $product = wc_get_product($product_post->ID);
                                    if ($product) : ?>
                                        <div class="swiper-slide">
                                            <?php gomie_render_product_card_shop($product); ?>
                                        </div>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                            
                            <!-- Navigation buttons -->
                            <div class="swiper-button-next category-next-<?php echo $category->slug; ?>">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            <div class="swiper-button-prev category-prev-<?php echo $category->slug; ?>">
                                <i class="fas fa-chevron-left"></i>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="swiper-pagination category-pagination-<?php echo $category->slug; ?>"></div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <!-- Compact All Products Section -->
        <section id="all-products" class="category-section category-section-compact" data-aos="fade-up">
            <div class="section-heading text-center">
                <h2 class="title">Tất cả sản phẩm</h2>
                <p class="sub">Khám phá toàn bộ bộ sưu tập gốm sứ Gomie</p>
            </div>
            
            <div class="compact-products-grid">
                <?php
                // Show only 8 featured products for compact view
                $featured_products = get_posts(array(
                    'post_type' => 'product',
                    'posts_per_page' => 8,
                    'orderby' => 'rand',
                    'meta_query' => array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        )
                    )
                ));
                
                if (!empty($featured_products)) :
                    foreach ($featured_products as $product_post) :
                        $product = wc_get_product($product_post->ID);
                        if ($product) {
                            gomie_render_product_card_shop($product);
                        }
                    endforeach;
                endif;
                ?>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn-gomie btn-lg">
                    <span>Xem tất cả sản phẩm</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>
    </div>
</div>

<!-- Compact SEO Section -->
<section class="shop-seo-compact">
    <div class="container">
        <div class="seo-compact-wrapper text-center" data-aos="fade-up">
            <h2>Gốm sứ thủ công Gomie - Nghệ thuật Bát Tràng</h2>
            <p>
                <strong>Gomie</strong> chuyên sản xuất gốm sứ thủ công cao cấp cho 
                <strong>nhà hàng, khách sạn và quà tặng</strong> doanh nghiệp. 
                Sản phẩm được làm 100% thủ công từ đất sét Bát Tràng với chất lượng đảm bảo.
            </p>
            
            <div class="seo-features row">
                <div class="col-md-3 col-6">
                    <div class="feature-item">
                        <i class="fas fa-hand-paper"></i>
                        <span>Thủ công 100%</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Bát Tràng</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Chất lượng cao</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="feature-item">
                        <i class="fas fa-sync-alt"></i>
                        <span>Đổi trả linh hoạt</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="shop-cta-section">
    <div class="container">
        <div class="cta-final">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h3>Cần tư vấn sản phẩm phù hợp?</h3>
                    <p>Đội ngũ chuyên gia của Gomie sẵn sàng tư vấn và thiết kế bộ sản phẩm phù hợp với nhu cầu của bạn.</p>
                </div>
                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    <div class="cta-actions d-flex flex-column flex-sm-row gap-3">
                        <a href="tel:+84123456789" class="btn-gomie">
                            <i class="fas fa-phone"></i>
                            <span>Hotline: 0123 456 789</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Debug and Initialize Carousels -->
<script>
console.log('Shop page loaded, checking for Swiper...');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready, looking for carousels...');
    
    // Check if Swiper is loaded
    if (typeof Swiper === 'undefined') {
        console.log('Swiper not loaded, loading dynamically...');
        
        // Load Swiper CSS
        var swiperCSS = document.createElement('link');
        swiperCSS.rel = 'stylesheet';
        swiperCSS.href = 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css';
        document.head.appendChild(swiperCSS);
        
        // Load Swiper JS
        var swiperJS = document.createElement('script');
        swiperJS.src = 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js';
        swiperJS.onload = function() {
            console.log('Swiper loaded dynamically');
            initAllCarousels();
        };
        document.head.appendChild(swiperJS);
    } else {
        console.log('Swiper already loaded');
        initAllCarousels();
    }
    
    function initAllCarousels() {
        console.log('Initializing all carousels...');
        
        // Find all carousel containers
        document.querySelectorAll('.category-products-carousel .swiper').forEach(function(swiperEl) {
            var slideCount = swiperEl.querySelectorAll('.swiper-slide').length;
            console.log('Found carousel with', slideCount, 'slides');
            
            if (slideCount === 0) {
                console.log('No slides, skipping...');
                return;
            }
            
            // Get category slug from class
            var classes = swiperEl.className;
            var match = classes.match(/category-swiper-([a-z-]+)/);
            
            if (match && match[1]) {
                var slug = match[1];
                console.log('Initializing carousel for category:', slug);
                
                try {
                    var swiper = new Swiper(swiperEl, {
                        slidesPerView: 1,
                        spaceBetween: 20,
                        loop: slideCount > 3,
                        autoplay: slideCount > 1 ? {
                            delay: 5000,
                            disableOnInteraction: false,
                        } : false,
                        pagination: {
                            el: '.category-pagination-' + slug,
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.category-next-' + slug,
                            prevEl: '.category-prev-' + slug,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: Math.min(2, slideCount),
                                spaceBetween: 20,
                            },
                            768: {
                                slidesPerView: Math.min(3, slideCount),
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: Math.min(4, slideCount),
                                spaceBetween: 20,
                            },
                        },
                        on: {
                            init: function() {
                                console.log('✅ Swiper initialized successfully for:', slug);
                            },
                            slideChange: function() {
                                console.log('Slide changed for:', slug);
                            }
                        }
                    });
                    
                    console.log('Swiper instance:', swiper);
                } catch (error) {
                    console.error('❌ Error initializing Swiper for', slug, ':', error);
                    
                    // Fallback: Convert to grid
                    swiperEl.style.display = 'grid';
                    swiperEl.style.gridTemplateColumns = 'repeat(auto-fit, minmax(280px, 1fr))';
                    swiperEl.style.gap = '1rem';
                    swiperEl.querySelector('.swiper-wrapper').style.display = 'contents';
                }
            }
        });
    }
});
</script>

<?php
/**
 * Hook: woocommerce_sidebar.
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
?>
