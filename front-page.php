<?php
/**
 * Front Page - GOMIE CERAMIC
 * Redesigned homepage with modern-classic Vietnamese Bat Trang aesthetic
 * Uses Bootstrap 5, WooCommerce, and theme color variables
 *
 * @package Gomie
 */

// Security
if (!defined('ABSPATH')) {
    exit;
}

get_header();

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
        $image = gomie_get_product_image_url($product_id, 'full');
        $price_html = $product->get_price_html();
        $stats = gomie_get_product_stats($product_id);
        
        // Format numbers
        $views_formatted = number_format($stats['views']);
        $sales_formatted = number_format($stats['sales']);
        
        $theme_dir_uri = get_template_directory_uri();
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

// Helper: Render product grid by term (product_cat)
if (!function_exists('gomie_render_category_grid')) {
    function gomie_render_category_grid($term, $limit = 8) {
        if (!class_exists('WooCommerce') || empty($term)) return;

        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                )
            )
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
            echo '<div class="gomie-product-grid">';
            while ($query->have_posts()) : $query->the_post();
                $product = wc_get_product(get_the_ID());
                gomie_render_product_card($product);
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else:
            echo '<div class="text-center text-muted py-4">' . esc_html__('Chưa có sản phẩm trong danh mục này.', 'gomie') . '</div>';
        endif;
    }
}

// Helper: Fetch product_cat by slug or name
if (!function_exists('gomie_get_product_category')) {
    function gomie_get_product_category($slug, $name_fallback = '') {
        $term = get_term_by('slug', $slug, 'product_cat');
        if (!$term && !empty($name_fallback)) {
            $term = get_term_by('name', $name_fallback, 'product_cat');
        }
        return $term ?: null;
    }
}
?>

<style>
  /* ===== MODERN HOMEPAGE STYLES ===== */
  :root { 
    scroll-behavior: smooth; 
    --section-spacing: 3.5rem 0;
    --container-max-width: 1400px;
    --border-radius-sm: 12px;
    --border-radius-md: 16px;
    --border-radius-lg: 20px;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
    --shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
  }

  /* ===== HERO SECTION (EDITORIAL CRAFT UX/UI) ===== */
  .gomie-hero {
    position: relative; 
    isolation: isolate;
    display: block !important;
    min-height: auto !important;
    background: linear-gradient(155deg, #fdfbf8 0%, #f8efe6 52%, #f4e6d8 100%) !important;
    overflow: hidden;
    padding: 3.5rem 0 3.75rem !important;
  }

  /* ===== GOMIE CERAMIC | EDITORIAL V11 UNIFIED VISUAL SYSTEM (MATCHING PAGE-MAU-MEN) ===== */
  .gomie-v11, .gomie-v11 * { box-sizing: border-box; }
  .gomie-v11 {
    --orange: #f47a20;
    --orange-deep: #e86b14;
    --blue: #168fd2;
    --blue-deep: #0873b6;
    --ink: #252c32;
    --muted: #667078;
    --warm: #fcfaf7;
    --line: #e9edf0;
    font-family: inherit;
    color: var(--ink);
    background-color: #fffdf9 !important;
    background-image: url('<?php echo esc_url(get_template_directory_uri() . "/assets/images/glazes/Background-1.png"); ?>') !important;
    background-position: top center !important;
    background-size: 100% auto !important;
    background-repeat: no-repeat !important;
    overflow: hidden;
    position: relative;
  }

  .gomie-v11 a { text-decoration: none !important; }

  .gomie-v11 section,
  .gomie-v11 #story,
  .gomie-v11 #featured,
  .gomie-v11 #gomie-blog,
  .gomie-v11 #partners,
  .gomie-v11 #faq {
    background: transparent !important;
    border: none !important;
  }

  .gomie-v11 .wrap {
    max-width: 1400px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  /* V11 Editorial Intro + HEART Values Unified Section */
  .gomie-v11 .intro {
    padding-top: clamp(55px, 6.5vw, 88px) !important;
    padding-bottom: clamp(45px, 5vw, 72px) !important;
  }

  .gomie-v11 .intro-inner {
    display: grid;
    grid-template-columns: .92fr 1.08fr;
    align-items: end;
    gap: clamp(40px, 6vw, 96px);
    margin-bottom: clamp(40px, 4.8vw, 60px);
  }

  .gomie-v11 .kicker {
    font-size: 12px !important;
    color: var(--orange-deep) !important;
    font-weight: 800 !important;
    letter-spacing: .16em !important;
    text-transform: uppercase !important;
    margin: 0 0 16px !important;
    line-height: 1.4 !important;
  }

  .gomie-v11 .intro h2 {
    font-size: clamp(32px, 3.8vw, 50px) !important;
    font-weight: 740 !important;
    line-height: 1.18 !important;
    letter-spacing: -.045em !important;
    color: var(--ink) !important;
    margin: 0 !important;
  }

  .gomie-v11 .intro h2 em {
    font-style: normal;
    color: var(--orange);
  }

  .gomie-v11 .intro h2:after {
    content: "";
    display: block;
    width: 56px;
    height: 3px;
    margin-top: 20px;
    background: var(--orange);
    border-radius: 3px;
  }

  .gomie-v11 .intro-copy {
    padding-bottom: 4px;
  }

  .gomie-v11 .intro-copy p {
    font-size: 16px !important;
    line-height: 1.92 !important;
    color: #546068 !important;
    margin: 0 0 14px !important;
    text-align: left;
  }

  .gomie-v11 .intro-copy strong {
    color: #293239;
  }

  .gomie-v11 .intro-copy p:last-child {
    margin-bottom: 0 !important;
  }

  /* V11 Catalog Section & Section Header with 56px Orange Bar */
  .gomie-v11 .catalog {
    padding-top: clamp(25px, 3vw, 45px) !important;
    padding-bottom: clamp(55px, 6.5vw, 90px) !important;
  }

  .gomie-v11 .catalog-head {
    margin: 0 0 38px;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 30px;
  }

  .gomie-v11 .catalog-head h2 {
    font-size: clamp(32px, 3.8vw, 50px) !important;
    font-weight: 740 !important;
    line-height: 1.2 !important;
    letter-spacing: -.045em !important;
    color: var(--ink) !important;
    margin: 0 !important;
  }

  .gomie-v11 .catalog-head h2 em {
    font-style: normal;
    color: var(--orange);
  }

  .gomie-v11 .catalog-head h2:after {
    content: "";
    display: block;
    width: 56px;
    height: 3px;
    margin-top: 20px;
    background: var(--orange);
    border-radius: 3px;
  }

  .gomie-v11 .catalog-aside {
    max-width: 310px;
    color: #667078;
    font-size: 14px;
    line-height: 1.7;
    text-align: right;
    margin: 0;
  }

  .gomie-v11 .v11-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    font-size: 13.5px;
    font-weight: 750;
    color: var(--blue) !important;
    transition: color .25s, transform .25s;
  }

  .gomie-v11 .v11-link:hover {
    color: var(--blue-deep) !important;
    transform: translateX(3px);
  }

  /* V11 Glaze Collection Grid styles are encapsulated inside template-parts/glaze-collection-grid.php */

  /* V11 Editorial Knowledge & Ceramic Story Grid with Photography */
  .gomie-v11 .knowledge {
    padding: clamp(50px, 6vw, 80px) 0 0 !important;
  }

  .gomie-v11 .knowledge-lead {
    display: grid;
    grid-template-columns: .92fr 1.08fr;
    gap: clamp(32px, 6vw, 96px);
    align-items: end;
    padding-bottom: clamp(40px, 4.8vw, 60px);
  }

  .gomie-v11 .knowledge h2 {
    font-size: clamp(32px, 3.8vw, 50px) !important;
    font-weight: 740 !important;
    line-height: 1.18 !important;
    letter-spacing: -.045em !important;
    margin: 0 !important;
    color: #252c32 !important;
  }

  .gomie-v11 .knowledge h2 em {
    font-style: normal;
    color: var(--orange);
  }

  .gomie-v11 .knowledge h2:after {
    content: "";
    display: block;
    width: 56px;
    height: 3px;
    margin-top: 20px;
    background: var(--orange);
    border-radius: 3px;
  }

  .gomie-v11 .knowledge p {
    font-size: 15.5px !important;
    line-height: 1.92 !important;
    color: #546068 !important;
    margin: 0 0 16px !important;
  }

  .gomie-v11 .knowledge .lead-copy {
    font-size: 16px !important;
    line-height: 1.92 !important;
    color: #546068 !important;
    margin: 0 !important;
  }

  .gomie-v11 .editorial-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: clamp(24px, 2.5vw, 36px);
    margin-bottom: 50px;
    align-items: stretch;
  }

  .gomie-v11 .editorial-tile {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    background: rgba(255, 255, 255, .90);
    backdrop-filter: blur(18px) saturate(180%);
    -webkit-backdrop-filter: blur(18px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, .95);
    box-shadow: 0 14px 36px rgba(45, 30, 15, .06), inset 0 1px 1px rgba(255, 255, 255, .95);
    position: relative;
    min-width: 0;
    border-radius: 24px;
    overflow: hidden;
    padding: 0 !important;
    transition: transform .38s cubic-bezier(.2,.8,.2,1), box-shadow .38s cubic-bezier(.2,.8,.2,1), border-color .35s ease, background .35s ease;
  }

  .gomie-v11 .editorial-tile:hover {
    transform: translateY(-6px);
    background: #ffffff;
    box-shadow: 0 24px 50px rgba(45, 30, 15, .12), inset 0 1px 2px rgba(255, 255, 255, 1);
    border-color: rgba(244, 122, 32, .45);
  }

  .gomie-v11 .editorial-tile-media {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #f2eee8;
  }

  .gomie-v11 .editorial-tile-media img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    transform: scale(1);
    transition: transform .6s cubic-bezier(.2,.8,.2,1);
    will-change: transform;
  }

  .gomie-v11 .editorial-tile:hover .editorial-tile-media img {
    transform: scale(1.06);
  }

  .gomie-v11 .editorial-tile-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-start;
    padding: clamp(24px, 2.8vw, 32px);
  }

  .gomie-v11 .editorial-tile .tile-tag {
    font-size: 11px !important;
    color: var(--orange-deep) !important;
    letter-spacing: .12em !important;
    text-transform: uppercase !important;
    font-weight: 800 !important;
    margin: 0 0 12px !important;
  }

  .gomie-v11 .editorial-tile:nth-child(even) .tile-tag { color: var(--blue-deep) !important; }

  .gomie-v11 .editorial-tile h3 {
    font-size: clamp(19.5px, 1.85vw, 23px) !important;
    font-weight: 750 !important;
    line-height: 1.34 !important;
    letter-spacing: -.022em !important;
    color: #222c33 !important;
    margin: 0 0 12px !important;
  }

  .gomie-v11 .editorial-tile h3 a {
    color: inherit !important;
    transition: color .25s ease;
  }

  .gomie-v11 .editorial-tile:hover h3 a {
    color: var(--blue) !important;
  }

  .gomie-v11 .editorial-tile p {
    font-size: 14px !important;
    line-height: 1.78 !important;
    color: #5c6870 !important;
    margin: 0 0 18px !important;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
  }

  .gomie-v11 .editorial-tile .tile-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: auto;
    font-size: 13px;
    font-weight: 750;
    letter-spacing: .02em;
    text-transform: uppercase;
    color: var(--blue) !important;
    transition: color .25s ease, transform .25s ease;
  }

  .gomie-v11 .editorial-tile:hover .tile-link {
    color: var(--orange-deep) !important;
    transform: translateX(4px);
  }

  @media (max-width: 900px) {
    .gomie-v11 .editorial-grid {
      grid-template-columns: 1fr;
    }
    .gomie-v11 .editorial-tile-media {
      height: 220px;
    }
  }

  /* V11 Product Card Harmonization */
  .gomie-v11 .gomie-product-card.apple-style {
    background: rgba(255, 255, 255, .86) !important;
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, .94) !important;
    border-radius: 22px !important;
    box-shadow: 0 12px 32px rgba(45, 30, 15, .06), inset 0 1px 1px rgba(255, 255, 255, .9) !important;
    transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s cubic-bezier(.2,.8,.2,1), border-color .35s ease !important;
  }

  .gomie-v11 .gomie-product-card.apple-style:hover {
    transform: translateY(-4px) !important;
    background: rgba(255, 255, 255, .96) !important;
    box-shadow: 0 22px 46px rgba(45, 30, 15, .12) !important;
    border-color: rgba(244, 122, 32, .45) !important;
  }

  /* V11 Partners Grid */
  .gomie-v11 .partners-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 20px;
    align-items: center;
  }

  .gomie-v11 .partner-item {
    background: rgba(255, 255, 255, .82);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-radius: 18px;
    padding: 1.45rem 1.25rem;
    box-shadow: 0 10px 28px rgba(45, 30, 15, .05);
    border: 1px solid rgba(255, 255, 255, .92);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .3s ease;
  }

  .gomie-v11 .partner-item:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, .95);
    box-shadow: 0 16px 36px rgba(45, 30, 15, .09);
    border-color: rgba(244, 122, 32, .4);
  }

  .gomie-v11 .partner-item img {
    height: 30px;
    max-width: 120px;
    width: auto;
    object-fit: contain;
    filter: grayscale(100%) opacity(0.72);
    transition: filter .3s ease;
  }

  .gomie-v11 .partner-item:hover img {
    filter: grayscale(0%) opacity(1);
  }

  /* V11 FAQ Section (Semantic Details & 2-Column Layout) */
  .gomie-v11 .faq {
    padding: clamp(50px, 6vw, 85px) 0 !important;
  }

  .gomie-v11 .faq-layout {
    display: grid;
    grid-template-columns: .78fr 1.22fr;
    gap: clamp(32px, 7vw, 105px);
    align-items: start;
  }

  .gomie-v11 .faq h2 {
    font-size: clamp(31px, 4vw, 46px) !important;
    font-weight: 740 !important;
    line-height: 1.2 !important;
    letter-spacing: -.03em !important;
    color: #252c32 !important;
    margin: 0 !important;
  }

  .gomie-v11 .faq-intro {
    font-size: 14px !important;
    color: #657078 !important;
    line-height: 1.85 !important;
    max-width: 350px;
    margin: 19px 0 0 !important;
  }

  .gomie-v11 .faq-list {
    border-top: 1px solid #dfe4e8;
  }

  .gomie-v11 .faq details {
    border-bottom: 1px solid #dfe4e8;
    padding: 0;
  }

  .gomie-v11 .faq summary {
    cursor: pointer;
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    font-weight: 650;
    color: #293741;
    line-height: 1.6;
    font-size: 16px;
    padding: 24px 2px;
  }

  .gomie-v11 .faq summary::-webkit-details-marker { display: none; }
  .gomie-v11 .faq summary::marker { display: none; }

  .gomie-v11 .faq summary:after {
    content: '+';
    font-size: 24px;
    line-height: 1;
    color: var(--blue);
    font-weight: 400;
    flex: none;
  }

  .gomie-v11 .faq details[open] summary:after {
    content: '−';
  }

  .gomie-v11 .faq details p {
    margin: -2px 38px 26px 2px !important;
    font-size: 14px !important;
    line-height: 1.9 !important;
    color: #5c6870 !important;
  }

  /* V11 Final CTA */
  .gomie-v11 .final-cta {
    padding: 60px 0 82px !important;
    text-align: center;
  }

  .gomie-v11 .final-cta h2 {
    font-size: clamp(26px, 3.4vw, 43px) !important;
    font-weight: 740 !important;
    line-height: 1.25 !important;
    letter-spacing: -.03em !important;
    color: #27343b !important;
    margin: 0 0 24px !important;
  }

  .gomie-v11 .final-cta a {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 32px;
    border-radius: 99px;
    background: var(--blue);
    color: white !important;
    font-size: 14px;
    font-weight: 750;
    transition: background .25s, transform .25s;
  }

  .gomie-v11 .final-cta a:hover {
    background: var(--blue-deep);
    transform: translateY(-2px);
  }

  @media (max-width: 1024px) {
    .gomie-v11 .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
    .gomie-v11 .partners-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
  }

  @media (max-width: 800px) {
    .gomie-v11 .intro-inner,
    .gomie-v11 .knowledge-lead,
    .gomie-v11 .faq-layout { grid-template-columns: 1fr; gap: 25px; }
    .gomie-v11 .editorial-grid { grid-template-columns: 1fr; }
    .gomie-v11 .catalog-head { align-items: flex-start; flex-direction: column; gap: 12px; }
    .gomie-v11 .catalog-aside { text-align: left; max-width: none; }
    .gomie-v11 .faq-intro { max-width: none; }
  }

  @media (max-width: 620px) {
    .gomie-v11 .grid { grid-template-columns: 1fr; gap: 22px; }
    .gomie-v11 .partners-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }

  /* ===== HERO SECTION: 2-ROW CENTERED EDITORIAL LAYOUT ===== */
  .gomie-hero {
    position: relative; 
    isolation: isolate;
    display: block !important;
    min-height: auto !important;
    background: linear-gradient(180deg, #fdfbf8 0%, #f8efe6 55%, #f5e6d7 100%) !important;
    overflow: hidden;
    padding: 3.75rem 0 4.5rem !important;
  }

  .gomie-hero .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }
  
  .gomie-hero .bg-media {
    position: absolute; 
    inset: 0; 
    z-index: -1; 
    opacity: 0.08;
    background-image: url('https://dntt.mediacdn.vn/197608888129458176/2022/9/13/lang-gom-bat-trang-1-1663057376452874393877.jpg');
    background-size: cover; 
    background-position: center;
    filter: saturate(0.85) contrast(1.05);
  }
  
  .gomie-hero .decor-orb {
    position: absolute; 
    border-radius: 50%; 
    filter: blur(70px); 
    opacity: 0.2;
    pointer-events: none;
    background: linear-gradient(135deg, #e67e22, #f39c12);
  }
  
  .gomie-hero .decor-orb.orb-1 { 
    width: 380px; 
    height: 380px; 
    top: -100px; 
    right: -60px; 
  }
  
  .gomie-hero .decor-orb.orb-2 { 
    width: 300px; 
    height: 300px; 
    bottom: -60px; 
    left: -60px; 
    background: linear-gradient(135deg, #f47a20, #f0b62b);
  }

  /* Row 1: Centered Hero Content */
  .gomie-hero .hero-top-row {
    max-width: 880px;
    margin: 0 auto;
    text-align: center;
  }

  .gomie-hero .hero-content {
    padding: 0 !important;
    gap: 0 !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .gomie-eyebrow { 
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    letter-spacing: 0.12em !important; 
    text-transform: uppercase !important; 
    color: #c25100 !important; 
    font-weight: 700 !important; 
    font-size: 0.78rem !important;
    background: rgba(244, 122, 32, 0.12) !important;
    border: 1px solid rgba(244, 122, 32, 0.28) !important;
    padding: 0.5rem 1.15rem !important;
    border-radius: 99px !important;
    margin-bottom: 1.35rem !important;
    box-shadow: 0 2px 10px rgba(244, 122, 32, 0.08) !important;
  }

  .gomie-eyebrow i {
    color: #e86b14 !important;
    font-size: 0.82rem !important;
  }
  
  .gomie-display { 
    color: #1e293b !important; 
    font-weight: 850 !important; 
    line-height: 1.22 !important; 
    font-size: clamp(1.65rem, 3.6vw, 3.25rem) !important;
    letter-spacing: -0.028em !important;
    margin-bottom: 1.25rem !important;
    text-align: center;
    word-break: keep-all;
    overflow-wrap: break-word;
  }

  .gomie-display .gomie-display-accent {
    display: block;
    margin-top: 0.2rem;
    background: linear-gradient(135deg, #e86b14 0%, #c2410c 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  
  .gomie-lead { 
    color: #475569 !important; 
    max-width: 720px !important; 
    margin: 0 auto 2rem !important;
    font-size: 1.1rem !important;
    line-height: 1.75 !important;
    font-weight: 450 !important;
    text-align: center;
  }
  
  .btn-gomie {
    background: linear-gradient(135deg, #f47a20 0%, #d95d08 100%) !important; 
    color: #ffffff !important; 
    border: none !important; 
    padding: 0.92rem 2rem !important; 
    border-radius: 99px !important; 
    font-weight: 700 !important;
    font-size: 0.96rem !important;
    box-shadow: 0 8px 22px rgba(244, 122, 32, 0.32) !important; 
    transition: all 0.28s cubic-bezier(0.2, 0.8, 0.2, 1) !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.55rem !important;
  }
  
  .btn-gomie:hover { 
    background: linear-gradient(135deg, #d95d08 0%, #b84a02 100%) !important; 
    transform: translateY(-2px) !important; 
    box-shadow: 0 12px 26px rgba(244, 122, 32, 0.42) !important; 
    color: #ffffff !important; 
  }
  
  .link-soft { 
    background: rgba(255, 255, 255, 0.94) !important;
    color: #1e293b !important; 
    border: 1.5px solid rgba(30, 41, 59, 0.12) !important;
    padding: 0.9rem 1.8rem !important;
    border-radius: 99px !important;
    font-weight: 650 !important; 
    text-decoration: none !important; 
    font-size: 0.95rem !important;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05) !important;
    transition: all 0.25s ease !important;
    justify-content: center !important;
  }

  .link-soft i {
    color: #f47a20 !important;
    font-size: 1.08rem !important;
  }
  
  .link-soft:hover { 
    background: #ffffff !important;
    color: #f47a20 !important; 
    border-color: rgba(244, 122, 32, 0.4) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(244, 122, 32, 0.12) !important;
    text-decoration: none !important; 
  }

  /* Centered Craft Trust Highlights Strip */
  .hero-trust-strip {
    display: inline-flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 12px 28px;
    margin-top: 1.85rem;
    padding: 0.75rem 1.75rem;
    background: rgba(255, 255, 255, 0.72);
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 99px;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 16px rgba(140, 80, 30, 0.06);
  }

  .hero-trust-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.86rem;
    font-weight: 650;
    color: #334155;
  }

  .hero-trust-item .trust-dot {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(244, 122, 32, 0.14);
    color: #d95d08;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    flex-shrink: 0;
  }

  /* Row 2: Full-Container Borderless Cinematic Video */
  .hero-video-row {
    max-width: 100%;
    margin: 2.5rem auto 0;
    width: 100%;
  }

  .hero-video-frame {
    background: transparent !important;
    padding: 0 !important;
    border-radius: 24px !important;
    border: none !important;
    box-shadow: 0 26px 60px rgba(45, 30, 15, 0.16) !important;
  }

  .custom-video-container {
    aspect-ratio: 16/9;
    background: #1e293b;
    border-radius: 24px !important;
    border: none !important;
    overflow: hidden;
    box-shadow: none !important;
    position: relative;
  }
  
  .custom-video-container::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(230,126,34,0.08) 50%, transparent 70%);
    z-index: 1;
    pointer-events: none;
  }

  /* ===== SECTION 3: GOMIE SPIRIT (HERITAGE STORY) ===== */
  .gomie-spirit-section {
    padding: 4.5rem 0;
    background: #fcfaf7;
  }

  .gomie-spirit-section .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  .gomie-spirit { 
    background: linear-gradient(135deg, #fff5eb 0%, #fde8d4 100%); 
    border-radius: 28px; 
    padding: 3.5rem !important;
    box-shadow: 0 18px 45px rgba(140, 80, 30, 0.07);
    border: 1px solid rgba(244, 122, 32, 0.16);
    position: relative;
    overflow: hidden;
  }
  
  .spirit-badge { 
    display: inline-flex; 
    gap: 0.5rem; 
    align-items: center; 
    background: #ffffff; 
    border-radius: 99px; 
    padding: 0.5rem 1.1rem; 
    font-weight: 700; 
    color: #d95d08; 
    box-shadow: 0 4px 12px rgba(244, 122, 32, 0.1);
    font-size: 0.78rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
  }

  .spirit-title {
    font-size: clamp(1.75rem, 2.6vw, 2.35rem);
    font-weight: 850;
    color: #1e293b;
    line-height: 1.22;
    letter-spacing: -0.025em;
    margin-bottom: 1.15rem;
  }

  .spirit-copy {
    color: #475569;
    font-size: 1.02rem;
    line-height: 1.75;
    margin-bottom: 1rem;
  }

  .spirit-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin: 1.75rem 0 2rem;
    padding: 1.25rem 0;
    border-top: 1px solid rgba(217, 93, 8, 0.15);
    border-bottom: 1px solid rgba(217, 93, 8, 0.15);
  }

  .spirit-metric-num {
    font-size: 1.55rem;
    font-weight: 850;
    color: #d95d08;
    line-height: 1.1;
    margin-bottom: 4px;
  }

  .spirit-metric-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
  }

  .spirit-gallery-card {
    background: #ffffff;
    padding: 10px;
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(45, 30, 15, 0.08);
    height: 100%;
  }

  /* ===== SECTIONS 4-8: EDITORIAL CATEGORY SECTIONS ===== */
  .gomie-cat-band {
    padding: 4rem 0;
    background: #ffffff;
    border-bottom: 1px solid #f3eee8;
  }

  .gomie-cat-band:nth-of-type(even) {
    background: #faf7f3;
  }

  .gomie-cat-band .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  .cat-header-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 2.25rem;
  }

  .cat-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #e86b14;
    margin-bottom: 0.5rem;
  }

  .cat-main-title {
    font-size: clamp(1.65rem, 2.4vw, 2.2rem);
    font-weight: 850;
    color: #1e293b;
    letter-spacing: -0.02em;
    margin: 0;
    line-height: 1.2;
  }

  .cat-main-sub {
    color: #556270;
    font-size: 0.98rem;
    margin: 0.5rem 0 0;
    max-width: 640px;
    line-height: 1.6;
  }

  .cat-cta .badge-cat { 
    background: #fdf8f3; 
    border: 1px solid rgba(244, 122, 32, 0.22); 
    padding: 0.55rem 1rem; 
    border-radius: 99px; 
    font-weight: 700; 
    color: #c25100; 
    font-size: 0.84rem;
  }

  .btn-cat-viewall {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.55rem 1.25rem;
    border-radius: 99px;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    color: #1e293b !important;
    font-weight: 700;
    font-size: 0.86rem;
    text-decoration: none !important;
    transition: all 0.25s ease;
  }

  .btn-cat-viewall:hover {
    background: #f47a20;
    color: #ffffff !important;
    border-color: #f47a20;
    transform: translateY(-2px);
  }

  /* ===== SECTION 9: BLOG JOURNAL SECTION ===== */
  .gomie-blog-section {
    padding: 4.5rem 0;
    background: #ffffff;
  }

  .gomie-blog-section .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  .post-card { 
    background: #ffffff; 
    border-radius: 20px; 
    overflow: hidden; 
    box-shadow: 0 10px 30px rgba(45, 30, 15, 0.06); 
    transition: all 0.32s cubic-bezier(0.2, 0.8, 0.2, 1); 
    border: 1px solid #f0ebe4;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .post-card:hover { 
    transform: translateY(-6px); 
    box-shadow: 0 20px 44px rgba(45, 30, 15, 0.12); 
    border-color: rgba(244, 122, 32, 0.35);
  }
  
  .post-thumb { 
    aspect-ratio: 16/10; 
    background: #f8f5f0; 
    overflow: hidden;
    position: relative;
  }
  
  .post-thumb img {
    transition: transform 0.45s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  
  .post-card:hover .post-thumb img {
    transform: scale(1.06);
  }

  .post-card-body {
    padding: 22px 24px 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .post-date-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    font-weight: 650;
    color: #e86b14;
    margin-bottom: 10px;
  }

  .post-card-title {
    font-size: 1.15rem;
    font-weight: 750;
    line-height: 1.4;
    margin-bottom: 10px;
  }

  .post-card-title a {
    color: #1e293b !important;
    text-decoration: none !important;
    transition: color 0.2s ease;
  }

  .post-card:hover .post-card-title a {
    color: #f47a20 !important;
  }

  .post-card-excerpt {
    font-size: 0.9rem;
    line-height: 1.68;
    color: #556270;
    margin-bottom: 16px;
    flex: 1;
  }

  .post-read-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #168fd2 !important;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    text-decoration: none !important;
  }

  /* ===== SECTION 10: PARTNERS SECTION ===== */
  .gomie-partners-section {
    padding: 3.5rem 0;
    background: #faf7f3;
    border-top: 1px solid #f0ebe4;
    border-bottom: 1px solid #f0ebe4;
  }

  .gomie-partners-section .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  .partners-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 20px;
    align-items: center;
  }
  
  .partner-item { 
    background: #ffffff; 
    border-radius: 16px; 
    padding: 1.35rem 1.25rem; 
    box-shadow: 0 4px 16px rgba(45, 30, 15, 0.04); 
    border: 1px solid #efeae2;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }
  
  .partner-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(45, 30, 15, 0.08);
    border-color: rgba(244, 122, 32, 0.3);
  }
  
  .partner-item img { 
    height: 30px; 
    max-width: 120px;
    width: auto; 
    object-fit: contain;
    filter: grayscale(100%) opacity(0.75);
    transition: filter 0.3s ease;
  }
  
  .partner-item:hover img {
    filter: grayscale(0%) opacity(1);
  }

  /* ===== SECTION 11: FAQ & B2B CONSULTATION ===== */
  .gomie-faq-section {
    padding: 4.5rem 0 5rem;
    background: #ffffff;
  }

  .gomie-faq-section .container {
    max-width: 1400px !important;
    padding-left: 24px !important;
    padding-right: 24px !important;
  }

  .faq-support-card {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    color: #ffffff;
    border-radius: 24px;
    padding: 2.25rem;
    margin-top: 1.75rem;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
  }

  .faq-support-card h3 {
    color: #ffffff !important;
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 0.65rem;
  }

  .faq-support-card p {
    color: #cbd5e1;
    font-size: 0.92rem;
    line-height: 1.65;
    margin-bottom: 1.35rem;
  }

  .faq .accordion-item { 
    border: 1px solid #ede8e0 !important; 
    margin-bottom: 14px; 
    border-radius: 16px !important; 
    overflow: hidden; 
    box-shadow: 0 4px 16px rgba(45, 30, 15, 0.04) !important; 
  }

  .faq .accordion-button { 
    font-weight: 750; 
    color: #1e293b; 
    background: #ffffff;
    border: none;
    padding: 1.2rem 1.4rem;
    font-size: 1rem;
    box-shadow: none !important;
  }
  
  .faq .accordion-button:not(.collapsed) { 
    background: #fff7ed; 
    color: #d95d08; 
  }
  
  .faq .accordion-body { 
    background: #ffffff; 
    padding: 0.25rem 1.4rem 1.35rem; 
    color: #475569; 
    line-height: 1.72;
    font-size: 0.95rem;
  }

  /* ===== RESPONSIVE DESIGN ===== */
  @media (max-width: 991.98px) {
    .partners-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .gomie-spirit {
      padding: 2.25rem !important;
    }
  }

  @media (max-width: 768px) {
    .gomie-hero {
      padding: 2.25rem 0 3rem !important;
    }
    .hero-trust-strip {
      border-radius: 20px;
      padding: 0.85rem 1.1rem;
      gap: 10px 18px;
    }
    .spirit-metrics {
      grid-template-columns: 1fr;
      gap: 12px;
    }
    .partners-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }
</style>

<main id="primary" class="site-main">
  <!-- Section 1: Hero (2 Rows: Top Centered Content + Bottom Cinematic Video) -->
  <section class="gomie-hero">
    <div class="bg-media" aria-hidden="true"></div>
    <span class="decor-orb orb-1"></span>
    <span class="decor-orb orb-2"></span>
    <div class="container">
      
      <!-- Hàng 1: Tiêu đề, Mô tả & Nút hành động -->
      <div class="hero-top-row">
        <div class="hero-content">
          <h1 class="gomie-display">
            Tinh hoa gốm sứ Bát Tràng
            <span class="gomie-display-accent">Cổ điển, Hiện đại &amp; Tối giản</span>
          </h1>
          <p class="gomie-lead">Kết tinh kỹ nghệ Việt hơn 500 năm với trải nghiệm chuẩn quốc tế. Bộ sưu tập gốm sứ GOMIE dành cho cuộc sống đương đại: tinh tế cho bàn tiệc, ấm chén &amp; cà phê, decor không gian và giải pháp chuyên biệt cho nhà hàng – khách sạn.</p>
          <div class="hero-actions d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
            <a href="#featured" class="btn btn-gomie">
              <i class="fa-solid fa-palette"></i>
              <span>Khám phá sắc men &amp; sản phẩm</span>
            </a>
            <a href="#story" class="link-soft d-inline-flex align-items-center gap-2">
              <i class="fa-solid fa-circle-play"></i> 
              <span>Về tinh thần GOMIE</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Hàng 2: Khung Video Nghệ Nhân Bát Tràng (Cinematic Editorial Poster & Player) -->
      <div class="hero-video-row">
        <div class="hero-media">
          <div class="hero-video-frame">
            <div class="custom-video-container position-relative overflow-hidden rounded-4 shadow-lg">
              <!-- Cinematic Video Cover / Poster -->
              <div class="hero-video-poster position-absolute top-0 start-0 w-100 h-100" style="background: url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-hoa-bien-1300c.jpg'); ?>') center/cover no-repeat; z-index: 2; transition: opacity 0.4s ease;">
                <div class="video-poster-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-4" style="background: linear-gradient(180deg, rgba(20, 15, 10, 0.25) 0%, rgba(20, 15, 10, 0.7) 100%);">
                  <button type="button" class="hero-play-btn rounded-circle d-flex align-items-center justify-content-center border-0 shadow-lg mb-3" aria-label="Xem video nghệ nhân Bát Tràng" style="width: 76px; height: 76px; background: linear-gradient(135deg, #f47a20 0%, #e0592a 100%); color: #ffffff; font-size: 1.6rem; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <i class="fa-solid fa-play" style="margin-left: 4px;"></i>
                  </button>
                  <span class="badge px-3 py-1 rounded-pill mb-2 fw-semibold text-uppercase" style="background: rgba(255,255,255,0.22); backdrop-filter: blur(8px); color: #fff; letter-spacing: 0.05em; font-size: 0.75rem;">
                    <i class="fa-solid fa-fire-flame-curved me-1 text-warning"></i> Thước Phim Tư Liệu Bát Tràng
                  </span>
                  <h3 class="fw-bold text-white fs-4 mb-1">Vũ Điệu Bàn Xoay &amp; Ngọn Lửa 1.300°C</h3>
                  <p class="text-white-50 small mb-0" style="max-width: 500px;">Hành trình tạo tác từng kiệt tác gốm sứ thủ công bởi nghệ nhân làng nghề Bát Tràng</p>
                </div>
              </div>
              <!-- Embedded iframe wrapper -->
              <div id="heroVideoEmbedWrapper" class="video-player-embed-target position-absolute top-0 start-0 w-100 h-100" style="display:none; z-index: 3;"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== UNIFIED EDITORIAL V11 CANVAS (ĐỒNG NHẤT VISUAL TRANG MÀU MEN) ===== -->
  <div class="gomie-v11">

    <!-- Section 2: Tinh thần Chế tác & Hệ Giá trị Cốt lõi H - E - A - R - T (Hợp nhất tinh gọn & giàu chất thơ) -->
    <section id="story" class="intro" aria-labelledby="gomie-home-story">
      <div class="wrap">
        <div class="intro-inner">
          <div>
            <p class="kicker">DI SẢN BÁT TRÀNG · HEART OF CRAFTSMANSHIP</p>
            <h2 id="gomie-home-story">Hồn đất ngàn năm,<br />nhịp đập từ <em>trái tim.</em></h2>
          </div>
          <div class="intro-copy">
            <p>Khởi nguồn từ mạch đất lành Bát Tràng hơn năm thế kỷ, <strong>Gomie Ceramic</strong> gửi trọn tâm tình người nghệ nhân vào vũ điệu của bàn xoay và ngọn lửa 1.300°C. Năm chữ cái <strong style="white-space: nowrap;">H – E – A – R – T</strong> chính là nhịp đập nuôi dưỡng từng dáng gốm thanh tao, từng lớp men biến thiên sâu lắng — để mỗi tác phẩm khi chạm tay người thưởng lãm đều mang theo hơi ấm của nghệ thuật sống đương đại.</p>
          </div>
        </div>

        <!-- GOMIE HEART Core Values Infographic -->
        <div class="heart-values-section">
          <div class="heart-values-container">
            <div class="heart-grid">

              <!-- 1. H - HANDMADE -->
              <div class="heart-card">
                <div class="heart-top-box">
                  <h3 class="heart-letter" style="color: #F0B62B;">H</h3>
                  <h4 class="heart-en-title" style="color: #F0B62B;">HANDMADE</h4>
                </div>
                <div class="heart-bottom-box">
                  <p class="heart-vi-sub">Thủ công</p>
                  <div class="heart-badge-box">
                    <svg viewBox="20 26 160 170" class="badge-svg">
                      <defs>
                        <linearGradient id="body-h" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#F4BE37" />
                          <stop offset="78%" stop-color="#F0B62B" />
                          <stop offset="100%" stop-color="#DF9E14" />
                        </linearGradient>
                        <linearGradient id="curl-h" x1="0%" y1="10%" x2="90%" y2="90%">
                          <stop offset="0%" stop-color="#875E00" />
                          <stop offset="40%" stop-color="#B58209" />
                          <stop offset="80%" stop-color="#DC9F15" />
                          <stop offset="100%" stop-color="#E6AC20" />
                        </linearGradient>
                      </defs>
                      <path d="M 134,142 Q 156,144 176,140 L 176,160 C 176,178 162,190 144,190 L 134,190 Z" fill="url(#curl-h)" />
                      <path d="M 24,84 A 56,56 0 0,1 136,84 L 136,162 C 136,178 142,190 154,190 L 52,190 C 34,190 24,178 24,160 Z" fill="url(#body-h)" />
                      <g stroke="#FFFFFF" stroke-width="3.3" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M 80,109 C 62,96 63,70 90,56 C 99,79 97,99 80,109 Z" />
                        <path d="M 80,115 C 79,98 83,83 90,71" />
                        <path d="M 62,155 C 62,146 57,141 51,135 C 43,128 40,120 40,108 L 40,94 C 40,88 47,88 47,94 L 47,114" />
                        <path d="M 47,99 C 47,94 53,94 53,100 L 53,115" />
                        <path d="M 74,155 C 74,141 72,133 65,125 L 55,114 C 51,110 46,115 50,120 L 61,132" />
                        <path d="M 98,155 C 98,146 103,141 109,135 C 117,128 120,120 120,108 L 120,94 C 120,88 113,88 113,94 L 113,114" />
                        <path d="M 113,99 C 113,94 107,94 107,100 L 107,115" />
                        <path d="M 86,155 C 86,141 88,133 95,125 L 105,114 C 109,110 114,115 110,120 L 99,132" />
                      </g>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- 2. E - EVERYBODY -->
              <div class="heart-card">
                <div class="heart-top-box">
                  <h3 class="heart-letter" style="color: #EF8423;">E</h3>
                  <h4 class="heart-en-title" style="color: #EF8423;">EVERYBODY</h4>
                </div>
                <div class="heart-bottom-box">
                  <p class="heart-vi-sub">Mọi người</p>
                  <div class="heart-badge-box">
                    <svg viewBox="20 26 160 170" class="badge-svg">
                      <defs>
                        <linearGradient id="body-e" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#F59233" />
                          <stop offset="78%" stop-color="#EF8423" />
                          <stop offset="100%" stop-color="#DC7012" />
                        </linearGradient>
                        <linearGradient id="curl-e" x1="0%" y1="10%" x2="90%" y2="90%">
                          <stop offset="0%" stop-color="#8A3F00" />
                          <stop offset="40%" stop-color="#B85908" />
                          <stop offset="80%" stop-color="#DC7014" />
                          <stop offset="100%" stop-color="#E67B1E" />
                        </linearGradient>
                      </defs>
                      <path d="M 134,142 Q 156,144 176,140 L 176,160 C 176,178 162,190 144,190 L 134,190 Z" fill="url(#curl-e)" />
                      <path d="M 24,84 A 56,56 0 0,1 136,84 L 136,162 C 136,178 142,190 154,190 L 52,190 C 34,190 24,178 24,160 Z" fill="url(#body-e)" />
                      <g stroke="#FFFFFF" stroke-width="3.1" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M 44,124 C 36,138 52,155 80,155 C 108,155 124,138 116,124" stroke-dasharray="2.5, 6.5" />
                        <circle cx="80" cy="70" r="6" />
                        <path d="M 65,61 L 73,77 L 87,77 L 95,61" />
                        <path d="M 73,77 L 71,94 M 87,77 L 89,94" />
                        <path d="M 52,78 Q 58,66 65,61" />
                        <path d="M 108,78 Q 102,66 95,61" />
                        <circle cx="55" cy="84" r="6" fill="#EF8423" />
                        <path d="M 40,92 L 52,104 L 59,138 L 65,137 L 61,115" />
                        <path d="M 40,92 L 45,86 L 56,96 L 68,85" />
                        <circle cx="105" cy="84" r="6" fill="#EF8423" />
                        <path d="M 120,92 L 108,104 L 101,138 L 95,137 L 99,115" />
                        <path d="M 120,92 L 115,86 L 104,96 L 92,85" />
                        <circle cx="80" cy="96" r="6.5" fill="#EF8423" />
                        <path d="M 60,92 L 73,107 L 73,142 L 79,142 L 80,122 L 81,142 L 87,142 L 87,107 L 100,92" fill="#EF8423" />
                        <path d="M 60,92 L 65,87 L 75,99 L 85,99 L 95,87 L 100,92" />
                      </g>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- 3. A - ART -->
              <div class="heart-card">
                <div class="heart-top-box">
                  <h3 class="heart-letter" style="color: #EB5626;">A</h3>
                  <h4 class="heart-en-title" style="color: #EB5626;">ART</h4>
                </div>
                <div class="heart-bottom-box">
                  <p class="heart-vi-sub">Nghệ Thuật</p>
                  <div class="heart-badge-box">
                    <svg viewBox="20 26 160 170" class="badge-svg">
                      <defs>
                        <linearGradient id="body-a" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#F26335" />
                          <stop offset="78%" stop-color="#EB5626" />
                          <stop offset="100%" stop-color="#D64315" />
                        </linearGradient>
                        <linearGradient id="curl-a" x1="0%" y1="10%" x2="90%" y2="90%">
                          <stop offset="0%" stop-color="#822000" />
                          <stop offset="40%" stop-color="#B0330B" />
                          <stop offset="80%" stop-color="#D64518" />
                          <stop offset="100%" stop-color="#E04E20" />
                        </linearGradient>
                      </defs>
                      <path d="M 134,142 Q 156,144 176,140 L 176,160 C 176,178 162,190 144,190 L 134,190 Z" fill="url(#curl-a)" />
                      <path d="M 24,84 A 56,56 0 0,1 136,84 L 136,162 C 136,178 142,190 154,190 L 52,190 C 34,190 24,178 24,160 Z" fill="url(#body-a)" />
                      <g stroke="#FFFFFF" stroke-width="2.9" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M 97,104 C 102,92 94,76 74,74 C 50,72 34,91 35,115 C 36,139 58,153 82,149 C 98,146 108,135 103,126 C 99,119 93,115 97,104 Z" />
                        <circle cx="71" cy="86" r="5.5" />
                        <circle cx="53" cy="95" r="5.5" />
                        <circle cx="47" cy="114" r="5.5" />
                        <circle cx="57" cy="131" r="5.5" />
                        <path d="M 91,115 L 122,80 C 125,77 129,81 126,85 L 98,122 Z" fill="#EB5626" />
                        <path d="M 91,115 C 83,118 81,126 78,132 C 76,136 72,137 69,137 C 76,142 89,140 95,131 C 97,128 98,125 98,122 Z" fill="#EB5626" />
                      </g>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- 4. R - RESOURCEFUL -->
              <div class="heart-card">
                <div class="heart-top-box">
                  <h3 class="heart-letter" style="color: #EE2D24;">R</h3>
                  <h4 class="heart-en-title" style="color: #EE2D24;">RESOURCEFUL</h4>
                </div>
                <div class="heart-bottom-box">
                  <p class="heart-vi-sub">Sáng tạo</p>
                  <div class="heart-badge-box">
                    <svg viewBox="20 26 160 170" class="badge-svg">
                      <defs>
                        <linearGradient id="body-r" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#F53B32" />
                          <stop offset="78%" stop-color="#EE2D24" />
                          <stop offset="100%" stop-color="#D61E16" />
                        </linearGradient>
                        <linearGradient id="curl-r" x1="0%" y1="10%" x2="90%" y2="90%">
                          <stop offset="0%" stop-color="#800702" />
                          <stop offset="40%" stop-color="#B0120B" />
                          <stop offset="80%" stop-color="#D61F17" />
                          <stop offset="100%" stop-color="#E0261E" />
                        </linearGradient>
                      </defs>
                      <path d="M 134,142 Q 156,144 176,140 L 176,160 C 176,178 162,190 144,190 L 134,190 Z" fill="url(#curl-r)" />
                      <path d="M 24,84 A 56,56 0 0,1 136,84 L 136,162 C 136,178 142,190 154,190 L 52,190 C 34,190 24,178 24,160 Z" fill="url(#body-r)" />
                      <g stroke="#FFFFFF" stroke-width="2.7" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="80" y1="53" x2="80" y2="59" />
                        <line x1="51" y1="65" x2="55" y2="69" />
                        <line x1="39" y1="96" x2="45" y2="96" />
                        <line x1="109" y1="65" x2="105" y2="69" />
                        <line x1="121" y1="96" x2="115" y2="96" />
                        <path d="M 67,131 C 65,121 51,113 51,96 C 51,79 64,67 80,67 C 96,67 109,79 109,96 C 109,113 95,121 93,131 Z" />
                        <path d="M 61,110 C 63,99 67,99 69,107 C 71,114 75,114 77,101 C 79,90 83,90 85,100 C 87,108 91,107 95,94 L 101,80" stroke-width="3" />
                        <path d="M 94,81 L 102,79 L 104,87" stroke-width="2.8" />
                        <rect x="67" y="131" width="26" height="5.5" rx="2.7" />
                        <rect x="69" y="136.5" width="22" height="5.5" rx="2.7" />
                        <rect x="72" y="142" width="16" height="5" rx="2.5" />
                        <path d="M 76,147 C 76,151 84,151 84,147" />
                      </g>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- 5. T - TEAM WORK -->
              <div class="heart-card">
                <div class="heart-top-box">
                  <h3 class="heart-letter" style="color: #E72653;">T</h3>
                  <h4 class="heart-en-title" style="color: #E72653;">TEAM WORK</h4>
                </div>
                <div class="heart-bottom-box">
                  <p class="heart-vi-sub">Đồng đội</p>
                  <div class="heart-badge-box">
                    <svg viewBox="20 26 160 170" class="badge-svg">
                      <defs>
                        <linearGradient id="body-t" x1="0%" y1="0%" x2="0%" y2="100%">
                          <stop offset="0%" stop-color="#F03561" />
                          <stop offset="78%" stop-color="#E72653" />
                          <stop offset="100%" stop-color="#CF1742" />
                        </linearGradient>
                        <linearGradient id="curl-t" x1="0%" y1="10%" x2="90%" y2="90%">
                          <stop offset="0%" stop-color="#7D0522" />
                          <stop offset="40%" stop-color="#AD0F35" />
                          <stop offset="80%" stop-color="#D11B46" />
                          <stop offset="100%" stop-color="#DC224E" />
                        </linearGradient>
                      </defs>
                      <path d="M 134,142 Q 156,144 176,140 L 176,160 C 176,178 162,190 144,190 L 134,190 Z" fill="url(#curl-t)" />
                      <path d="M 24,84 A 56,56 0 0,1 136,84 L 136,162 C 136,178 142,190 154,190 L 52,190 C 34,190 24,178 24,160 Z" fill="url(#body-t)" />
                      <g stroke="#FFFFFF" stroke-width="2.7" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="67" cy="67" r="5" />
                        <path d="M 57,85 C 57,76 77,76 77,85 Z" />
                        <path d="M 64,77 L 67,82 L 70,77" stroke-width="2" />
                        <circle cx="93" cy="67" r="5" />
                        <path d="M 83,85 C 83,76 103,76 103,85 Z" />
                        <path d="M 90,77 L 93,82 L 96,77" stroke-width="2" />
                        <line x1="54" y1="85" x2="106" y2="85" />
                        <line x1="65" y1="91" x2="95" y2="91" />
                        <path d="M 44,106 L 60,89 L 71,100 L 55,117 Z" />
                        <circle cx="55" cy="109" r="1" fill="#FFFFFF" stroke="none" />
                        <path d="M 116,106 L 100,89 L 89,100 L 105,117 Z" />
                        <circle cx="105" cy="109" r="1" fill="#FFFFFF" stroke="none" />
                        <path d="M 71,100 L 79,93 C 82,91 86,94 83,98 L 74,107 C 71,110 75,115 79,112 L 90,101" />
                        <path d="M 90,101 L 103,115 C 106,118 102,123 98,120 L 87,109" />
                        <path d="M 98,120 C 101,123 97,128 93,125 L 82,114" />
                        <path d="M 93,125 C 96,128 92,133 88,130 L 77,119" />
                        <path d="M 88,130 C 90,133 86,138 82,135 L 74,127" />
                        <rect x="56" y="114" width="11" height="6" rx="3" transform="rotate(-45 61.5 117)" fill="#E72653" />
                        <rect x="61" y="119" width="11" height="6" rx="3" transform="rotate(-45 66.5 122)" fill="#E72653" />
                        <rect x="66" y="124" width="11" height="6" rx="3" transform="rotate(-45 71.5 127)" fill="#E72653" />
                        <rect x="71" y="129" width="10" height="5.5" rx="2.7" transform="rotate(-45 76 131.7)" fill="#E72653" />
                      </g>
                    </svg>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 3: Nghệ thuật Sắc Men (Component dùng chung với Trang Màu Men) -->
    <section id="featured" class="catalog" aria-labelledby="gomie-home-glazes">
      <div class="wrap">
        <header class="catalog-head">
          <div>
            <p class="kicker">GOMIE CERAMIC · BỘ SƯU TẬP MÀU MEN</p>
            <h2 id="gomie-home-glazes">Mỗi sắc men, một dấu ấn.</h2>
          </div>
          <div class="catalog-aside">
            <div>Khám phá sắc men đồng điệu với cảm xúc và không gian sống của bạn.</div>
            <a class="v11-link" href="<?php echo esc_url(home_url('/mau-men/')); ?>">Khám phá chuyên trang Màu Men →</a>
          </div>
        </header>

        <?php get_template_part('template-parts/glaze-collection-grid'); ?>
      </div>
    </section>

    <?php
      // Danh mục sản phẩm chủ đạo
      $gomie_categories = array(
        'an-uong'               => 'Đồ ăn & Bàn tiệc',
        'bo-am-chen'            => 'Ấm Chén & Cà Phê',
        'trang-tri'             => 'Đồ Trang Trí & Decor',
        'bat-an'                => 'Giải Pháp Nhà Hàng & Khách Sạn',
        'qua-tang-doanh-nghiep' => 'Quà Tặng Doanh Nghiệp & In Logo',
      );
      $cat_counter = 0;
    ?>

    <!-- Sections 4-8: Category Collections (Đồng nhất Header & Card Visual V11) -->
    <?php if (class_exists('WooCommerce')) : ?>
      <?php foreach ($gomie_categories as $slug => $label) :
        $term = gomie_get_product_category($slug, $label);
        if (!$term || (int) $term->count <= 0) continue;
        $cat_counter++;
      ?>
        <section id="cat-<?php echo esc_attr($slug); ?>" class="catalog">
          <div class="wrap">
            <header class="catalog-head">
              <div>
                <p class="kicker">GOMIE CERAMIC · BỘ SƯU TẬP <?php echo sprintf('%02d', $cat_counter); ?></p>
                <h2><?php echo esc_html($label); ?>.</h2>
              </div>
              <div class="catalog-aside">
                <?php if (!empty($term->description)) : ?>
                  <div><?php echo esc_html(wp_trim_words(strip_tags($term->description), 22, '...')); ?></div>
                <?php else : ?>
                  <div>Tuyển chọn <?php echo esc_html($term->count); ?> tác phẩm gốm sứ thủ công Bát Tràng.</div>
                <?php endif; ?>
                <a class="v11-link" href="<?php echo esc_url(get_term_link($term)); ?>">Xem toàn bộ <?php echo esc_html($term->count); ?> tác phẩm →</a>
              </div>
            </header>
            <?php gomie_render_category_grid($term, 8); ?>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>

    <!-- Section 9: Cẩm nang & Góc nhìn Gốm sứ (Đồng nhất Editorial Knowledge Tile Grid V11) -->
    <section id="gomie-blog" class="knowledge" aria-labelledby="gomie-home-knowledge">
      <div class="wrap">
        <div class="knowledge-lead">
          <div>
            <p class="kicker">GOMIE CERAMIC · GÓC NHÌN &amp; CẢM HỨNG</p>
            <h2 id="gomie-home-knowledge">Nghệ thuật sống cùng <em>gốm thủ công.</em></h2>
          </div>
          <div>
            <p class="lead-copy">Mỗi chiếc bát, đĩa hay tách trà không chỉ là vật dụng thường nhật, mà là khúc giao hòa của đất lành, sắc men và ánh sáng. Cùng <strong>Gomie Ceramic</strong> lắng nghe những câu chuyện từ bàn xoay Bát Tràng và cảm hứng bài trí bàn tiệc đương đại.</p>
          </div>
        </div>

        <div class="editorial-grid">
          <?php
            $blog = new WP_Query(array(
              'post_type'      => 'post',
              'post_status'    => 'publish',
              'posts_per_page' => 4,
            ));
            $fallback_images = array(
              'gomie-story-ban-tiec.jpg',
              'gomie-story-hoa-bien-1300c.jpg',
              'gomie-story-gian-bep-viet.jpg',
              'gomie-story-resort-horeca.jpg',
            );
            $img_counter = 0;
            if ($blog->have_posts()) :
              while ($blog->have_posts()) : $blog->the_post();
                $custom_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
                $tile_tag   = !empty($custom_tag) ? $custom_tag : (get_the_date() . ' · CẨM NANG GOMIE');
                $custom_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
                if (empty($custom_img) && isset($fallback_images[$img_counter])) {
                  $custom_img = $fallback_images[$img_counter];
                }
                $img_counter++;
                $img_url = !empty($custom_img) ? esc_url(get_template_directory_uri() . '/assets/images/stories/' . $custom_img) : '';
              ?>
                <article class="editorial-tile">
                  <?php if (!empty($img_url)) : ?>
                    <a href="<?php the_permalink(); ?>" class="editorial-tile-media" aria-label="<?php the_title_attribute(); ?>">
                      <img src="<?php echo $img_url; ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async" />
                    </a>
                  <?php endif; ?>
                  <div class="editorial-tile-body">
                    <p class="tile-tag"><?php echo esc_html($tile_tag); ?></p>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo esc_html(get_the_excerpt()); ?></p>
                    <a href="<?php the_permalink(); ?>" class="tile-link">Khám phá bài viết →</a>
                  </div>
                </article>
              <?php endwhile;
              wp_reset_postdata();
            else : ?>
              <article class="editorial-tile">
                <p class="tile-tag">Hiểu về chất liệu</p>
                <h3>Màu men gốm sứ là gì?</h3>
                <p>Men gốm là lớp phủ được nung trên bề mặt sản phẩm gốm sứ ở nhiệt độ 1.300°C. Thành phần men, kỹ thuật tráng men và điều kiện nung tạo nên độ bóng và chiều sâu độc bản cho từng tác phẩm.</p>
              </article>
              <article class="editorial-tile">
                <p class="tile-tag">Gợi ý lựa chọn</p>
                <h3>Chọn màu men cho từng phong cách bàn ăn</h3>
                <p>Với bàn ăn tối giản, những sắc men sáng và nhẹ như Ngọc Trai hoặc Hồng Tuyết tạo cảm giác thông thoáng. Nếu yêu vẻ ấm cúng, Cánh Gián, Nâu Tuyết hay Gấm Vàng trở thành điểm tựa thị giác gần gũi.</p>
              </article>
            <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Section 10: Đối tác đồng hành -->
    <section id="partners" class="catalog" aria-labelledby="gomie-home-partners">
      <div class="wrap">
        <header class="catalog-head">
          <div>
            <p class="kicker">GOMIE CERAMIC · ĐỐI TÁC CHIẾN LƯỢC</p>
            <h2 id="gomie-home-partners">Tin cậy bởi chuỗi F&amp;B &amp; Khách sạn.</h2>
          </div>
          <p class="catalog-aside">Cung ứng gốm sứ tiêu chuẩn HoReCa &amp; Quà tặng chế tác độc bản cho doanh nghiệp.</p>
        </header>

        <div class="partners-grid">
          <div class="partner-item" aria-label="Lotte Hotels & Resorts">
            <span style="font-weight: 850; font-size: 16px; letter-spacing: 0.14em; color: #3a4650;">LOTTE HOTELS</span>
          </div>
          <div class="partner-item" aria-label="Marriott International">
            <span style="font-weight: 850; font-size: 16px; letter-spacing: 0.14em; color: #3a4650;">MARRIOTT</span>
          </div>
          <div class="partner-item" aria-label="Hyatt Regency">
            <span style="font-weight: 850; font-size: 16px; letter-spacing: 0.16em; color: #3a4650;">HYATT REGENCY</span>
          </div>
          <div class="partner-item" aria-label="Golden Gate Restaurant Group">
            <span style="font-weight: 850; font-size: 15px; letter-spacing: 0.12em; color: #3a4650;">GOLDEN GATE</span>
          </div>
          <div class="partner-item" aria-label="InterContinental">
            <span style="font-weight: 850; font-size: 13.5px; letter-spacing: 0.11em; color: #3a4650;">INTERCONTINENTAL</span>
          </div>
          <div class="partner-item" aria-label="Vinpearl Resort & Spa">
            <span style="font-weight: 850; font-size: 16px; letter-spacing: 0.14em; color: #3a4650;">VINPEARL</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 11: Giải đáp cùng GOMIE (Đồng nhất 100% FAQ Semantic Details V11) -->
    <section id="faq" class="faq" aria-labelledby="gomie-home-faq">
      <div class="wrap faq-layout">
        <div>
          <p class="kicker">GIẢI ĐÁP CÙNG GOMIE</p>
          <h2 id="gomie-home-faq">Những điều bạn có thể muốn biết.</h2>
          <p class="faq-intro">Một vài lưu ý nhỏ về tiêu chuẩn nung 1.300°C, đặt chế tác riêng, in logo doanh nghiệp và chính sách vận chuyển bảo hiểm toàn quốc.</p>
        </div>
        <div class="faq-list">
          <details open>
            <summary>Chính sách vận chuyển &amp; đóng gói an toàn chống vỡ như thế nào?</summary>
            <p>Chúng tôi đóng gói theo tiêu chuẩn xuất khẩu chống sốc nhiều lớp, cam kết bảo hiểm 100% rơi vỡ trong quá trình vận chuyển (đổi mới miễn phí ngay khi nhận hàng) trên toàn quốc và quốc tế.</p>
          </details>
          <details>
            <summary>GOMIE có nhận đặt làm theo yêu cầu (in logo, phối màu men, kích thước riêng)?</summary>
            <p>Có. Xưởng sản xuất GOMIE tại Bát Tràng hỗ trợ thiết kế dáng gốm, phối màu men độc bản và in nung logo bền vĩnh cửu ở nhiệt độ cao cho doanh nghiệp, nhà hàng và resort với MOQ linh hoạt.</p>
          </details>
          <details>
            <summary>Sản phẩm gốm sứ GOMIE có dùng được trong máy rửa bát và lò vi sóng không?</summary>
            <p>Được nung ở nhiệt độ 1.300°C giúp kết khối xương đất đanh chắc và khử sạch chì, kim loại nặng — các dòng bát đĩa GOMIE hoàn toàn an toàn trong lò vi sóng và máy rửa chén công nghiệp.</p>
          </details>
          <details>
            <summary>Vì sao màu men trên ảnh có thể khác đôi chút so với sản phẩm thực tế?</summary>
            <p>Ánh sáng khi chụp, thiết bị hiển thị và tính chất biến thiên tự nhiên của dòng men thủ công Bát Tràng làm mỗi tác phẩm đều có sắc thái độc bản. Khi cần phối đồng bộ nhiều món, đội ngũ GOMIE luôn sẵn sàng gửi ảnh/video thực tế để bạn lựa chọn.</p>
          </details>
          <details>
            <summary>Chính sách chiết khấu cho Nhà hàng – Khách sạn &amp; Quà tặng doanh nghiệp?</summary>
            <p>Chúng tôi có bảng giá sỉ từ xưởng và gói gửi mẫu thử trực tiếp cho các dự án F&amp;B, khách sạn, resort và đơn hàng quà tặng số lượng lớn. Vui lòng nhấn "Báo giá" trên thanh đầu trang hoặc gọi 0335 059 889 để được tư vấn 1-1.</p>
          </details>
        </div>
      </div>
    </section>

    <!-- Section 12: Final CTA (Đồng nhất Final CTA Trang Màu Men V11) -->
    <section class="final-cta" aria-labelledby="gomie-home-end">
      <div class="wrap">
        <p class="kicker">GOMIE CERAMIC</p>
        <h2 id="gomie-home-end">Một sắc men hợp ý, một bàn ăn thêm cảm hứng.</h2>
        <a href="<?php echo gomie_shop_url(); ?>">Khám phá toàn bộ sản phẩm →</a>
      </div>
    </section>

  </div><!-- /.gomie-v11 -->
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var poster = document.querySelector('.hero-video-poster');
  var playBtn = document.querySelector('.hero-play-btn');
  var wrapper = document.getElementById('heroVideoEmbedWrapper');
  
  if (poster && wrapper) {
    var startVideo = function(e) {
      if (e) e.preventDefault();
      poster.style.opacity = '0';
      poster.style.pointerEvents = 'none';
      wrapper.style.display = 'block';
      wrapper.innerHTML = '<iframe width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/XWlJn5T81CU?autoplay=1&rel=0&modestbranding=1" title="Gomie Ceramic - Di sản Bát Tràng" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:18px;"></iframe>';
    };
    
    if (playBtn) playBtn.addEventListener('click', startVideo);
    poster.addEventListener('click', startVideo);
  }
});
</script>

<?php get_footer(); ?>