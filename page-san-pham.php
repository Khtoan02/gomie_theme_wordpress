<?php
/**
 * Template Name: Trang Sản Phẩm - Gomie Ceramic
 * Description: Danh mục sản phẩm gốm sứ Bát Tràng chuẩn Editorial V11
 *
 * @package Gomie
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

get_header();

// Fetch all published products
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC'
);
$query_products = get_posts($args);

$ceramic_products = array();
$detected_glazes = array();

foreach ($query_products as $p) {
    $wc_prod = wc_get_product($p->ID);
    if (!$wc_prod || !$wc_prod->is_visible()) {
        continue;
    }

    $pid = $wc_prod->get_id();
    $title = $wc_prod->get_name();
    $cat_slugs = wp_get_post_terms($pid, 'product_cat', array('fields' => 'slugs'));
    if (!is_array($cat_slugs)) $cat_slugs = array();

    // Skip LED demo products on local test environment
    $is_led = false;
    foreach ($cat_slugs as $c_slug) {
        if (strpos($c_slug, 'led') !== false || strpos($c_slug, 'man-hinh') !== false) {
            $is_led = true;
            break;
        }
    }
    if ($is_led && (stripos($title, 'LED') !== false || stripos($title, 'NovaStar') !== false)) {
        continue;
    }

    // Detect Glaze info dynamically from attributes (pa_*), custom meta, categories, or title
    $glaze_info = function_exists('gomie_get_product_glaze_info') 
        ? gomie_get_product_glaze_info($wc_prod) 
        : array('name' => 'Men Độc Bản', 'slug' => 'men-doc-ban', 'color' => '#e0592a');

    // Aggregate unique glazes for filter chips
    if (!isset($detected_glazes[$glaze_info['slug']])) {
        $detected_glazes[$glaze_info['slug']] = array(
            'name'  => $glaze_info['name'],
            'slug'  => $glaze_info['slug'],
            'color' => $glaze_info['color'],
            'count' => 0,
        );
    }
    $detected_glazes[$glaze_info['slug']]['count']++;

    $ceramic_products[] = array(
        'product'     => $wc_prod,
        'glaze_name'  => $glaze_info['name'],
        'glaze_slug'  => $glaze_info['slug'],
        'glaze_color' => $glaze_info['color'],
        'cat_slugs'   => $cat_slugs,
    );
}

// Fetch dynamic product categories and counts from active products
$active_categories = array();
$seen_cat_ids = array();
$cat_counts = array();

foreach ($ceramic_products as $item) {
    if (!empty($item['cat_slugs'])) {
        foreach ($item['cat_slugs'] as $cslug) {
            $cat_counts[$cslug] = ($cat_counts[$cslug] ?? 0) + 1;
        }
    }
    
    $p_cats = wp_get_post_terms($item['product']->get_id(), 'product_cat');
    if (!empty($p_cats) && !is_wp_error($p_cats)) {
        foreach ($p_cats as $c) {
            if (in_array($c->slug, array('chua-phan-loai', 'uncategorized', 'man-hinh-led', 'cabin-led', 'bo-xu-ly-hinh-anh', 'den-led-chieu-sang-thong-minh', 'man-hinh-led-ngoai-troi', 'man-hinh-led-trong-nha', 'ung-dung-man-hinh-led', 'he-thong-am-thanh', 'he-thong-anh-sang'))) {
                continue;
            }
            if (!isset($seen_cat_ids[$c->term_id])) {
                $seen_cat_ids[$c->term_id] = true;
                $active_categories[] = $c;
            }
        }
    }
}

$theme_uri = get_template_directory_uri();
?>

<div class="gomie-shop-editorial-page">
    <!-- Hero Canvas Header -->
    <section class="shop-hero-editorial text-center">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav class="shop-breadcrumb mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                </ol>
            </nav>

            <div class="shop-badge-wrapper mb-3">
                <span class="shop-pill-badge">
                    <i class="fa-solid fa-gem me-1"></i> BỘ SƯU TẬP GỐM SỨ BÁT TRÀNG THỦ CÔNG
                </span>
            </div>

            <h1 class="shop-hero-title">
                Kiệt Tác Sắc Men <span class="highlight-orange">Hỏa Biến 1.300°C</span>
            </h1>

            <p class="shop-hero-desc mx-auto">
                Từng dáng bát, đĩa, ấm chén Gomie mang trọn vẹn hồn cốt đất Bát Tràng hơn 500 năm. Nung hai lần ở nhiệt độ 1.300°C khử triệt để độc tố chì & cadmium, đảm bảo chuẩn thẩm mỹ mỹ nghệ và an toàn tuyệt đối cho bàn tiệc đương đại.
            </p>

            <!-- Value Highlights Bar -->
            <div class="shop-trust-pills d-flex flex-wrap justify-content-center gap-2 gap-md-3 mt-4">
                <div class="trust-pill-item">
                    <span class="pill-dot fire-dot"></span>
                    <strong>Nung khử chì 1.300°C</strong>
                </div>
                <div class="trust-pill-item">
                    <span class="pill-dot craft-dot"></span>
                    <strong>100% Vuốt nặn thủ công</strong>
                </div>
                <div class="trust-pill-item">
                    <span class="pill-dot safe-dot"></span>
                    <strong>An toàn lò vi sóng & máy rửa bát</strong>
                </div>
                <div class="trust-pill-item">
                    <span class="pill-dot protect-dot"></span>
                    <strong>Bảo hiểm vỡ hỏng 100% vận chuyển</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area: Sidebar Widget Outside Left + Products in Container-Width -->
    <div class="shop-body-section py-5">
        <div class="shop-canvas-wrapper d-flex justify-content-center align-items-start gap-4">
            <!-- WIDGET BỘ LỌC NẰM BÊN NGOÀI CONTAINER-WIDTH (LỀ TRÁI CỦA SẢN PHẨM) -->
            <aside class="shop-outside-sidebar" id="shopFilterSidebar">
                <div class="filter-widget-card p-3 p-xl-4 rounded-4 shadow-sm bg-white" id="filterWidgetCard">
                    <div class="widget-header d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="widget-title fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders text-danger"></i>
                            <span>Bộ lọc sản phẩm</span>
                        </div>
                        <button type="button" class="btn-clear-filters text-muted small border-0 bg-transparent" onclick="resetFilters()" title="Xóa tất cả lọc">
                            <i class="fa-solid fa-rotate-left me-1"></i>Đặt lại
                        </button>
                    </div>

                    <!-- Widget Block 1: Sắc Men Gốm Bát Tràng -->
                    <div class="widget-filter-group mb-4">
                        <div class="filter-group-title fw-bold text-dark mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-palette text-danger me-2"></i>Sắc men gốm</span>
                        </div>
                        <div class="glaze-filter-list d-flex flex-column gap-1" id="glazeFilter">
                            <button type="button" class="glaze-chip-widget active" data-glaze="all">
                                <span class="chip-color chip-all"></span>
                                <span class="chip-title">Tất cả sắc men</span>
                                <span class="chip-badge ms-auto"><?php echo count($ceramic_products); ?></span>
                            </button>
                            <?php if (!empty($detected_glazes)) : ?>
                                <?php foreach ($detected_glazes as $slug => $glaze_item) : ?>
                                    <button type="button" class="glaze-chip-widget" data-glaze="<?php echo esc_attr($slug); ?>">
                                        <span class="chip-color" style="background-color: <?php echo esc_attr($glaze_item['color']); ?>;"></span>
                                        <span class="chip-title"><?php echo esc_html($glaze_item['name']); ?></span>
                                        <span class="chip-badge ms-auto"><?php echo esc_html($glaze_item['count']); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Widget Block 2: Danh Mục Tác Phẩm -->
                    <div class="widget-filter-group mb-4 pt-3 border-top">
                        <div class="filter-group-title fw-bold text-dark mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-layer-group text-danger me-2"></i>Danh mục</span>
                        </div>
                        <div class="category-filter-list d-flex flex-column gap-1" id="categoryFilter">
                            <button type="button" class="cat-pill-widget active" data-cat="all">
                                <span class="cat-name">Tất cả danh mục</span>
                                <span class="cat-badge ms-auto"><?php echo count($ceramic_products); ?></span>
                            </button>
                            <?php if (!empty($active_categories)) : ?>
                                <?php foreach ($active_categories as $cat) : 
                                    $c_count = $cat_counts[$cat->slug] ?? $cat->count;
                                ?>
                                    <button type="button" class="cat-pill-widget" data-cat="<?php echo esc_attr($cat->slug); ?>">
                                        <span class="cat-name"><?php echo esc_html($cat->name); ?></span>
                                        <span class="cat-badge ms-auto"><?php echo esc_html($c_count); ?></span>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Widget Block 3: Khoảng Giá -->
                    <div class="widget-filter-group mb-4 pt-3 border-top">
                        <div class="filter-group-title fw-bold text-dark mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-tag text-danger me-2"></i>Khoảng giá</span>
                        </div>
                        <div class="price-filter-list d-flex flex-column gap-1" id="priceFilter">
                            <button type="button" class="price-chip-widget active" data-price-range="all">Tất cả mức giá</button>
                            <button type="button" class="price-chip-widget" data-price-range="under-100k">Dưới 100.000 đ</button>
                            <button type="button" class="price-chip-widget" data-price-range="100k-300k">100.000 đ - 300.000 đ</button>
                            <button type="button" class="price-chip-widget" data-price-range="300k-500k">300.000 đ - 500.000 đ</button>
                            <button type="button" class="price-chip-widget" data-price-range="above-500k">Trên 500.000 đ</button>
                        </div>
                    </div>

                    <!-- Widget Block 4: Cam kết Gomie -->
                    <div class="widget-craft-pledge p-3 rounded-3 mt-3">
                        <div class="pledge-item d-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-fire text-danger"></i>
                            <span class="small fw-semibold text-dark">Nung 1.300°C khử chì</span>
                        </div>
                        <div class="pledge-item d-flex align-items-center gap-2 mb-2">
                            <i class="fa-solid fa-shield-halved text-success"></i>
                            <span class="small fw-semibold text-dark">Bảo hiểm vỡ hỏng 100%</span>
                        </div>
                        <div class="pledge-item d-flex align-items-center gap-2">
                            <i class="fa-solid fa-hand-sparkles text-primary"></i>
                            <span class="small fw-semibold text-dark">100% vuốt nặn thủ công</span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- SẢN PHẨM NẰM TRỌN VẸN TRONG CONTAINER-WIDTH (FULL 4 CỘT) -->
            <div class="container shop-products-container">
                <!-- Shop Controls Toolbar -->
                <div class="shop-toolbar mb-4 p-3 rounded-4 shadow-sm bg-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="toolbar-left d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill d-xl-none" id="btnToggleMobileFilter">
                            <i class="fa-solid fa-sliders me-1"></i> <strong>Bộ lọc</strong>
                        </button>
                        <div class="products-counter text-muted small ms-1">
                            Hiển thị <strong class="text-dark" id="productCount"><?php echo count($ceramic_products); ?></strong> tác phẩm gốm sứ
                        </div>
                        <div id="activeFilterTags" class="active-filter-tags d-flex flex-wrap gap-1 ms-md-2">
                            <!-- Dynamic Active Filter Tags -->
                        </div>
                    </div>

                    <div class="toolbar-right d-flex align-items-center gap-2 ms-auto">
                        <label for="shopSort" class="text-nowrap small text-muted"><i class="fa-solid fa-arrow-down-short-wide me-1"></i>Sắp xếp:</label>
                        <select id="shopSort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3 py-1">
                            <option value="featured">Nổi bật nhất</option>
                            <option value="price-asc">Giá: Thấp đến Cao</option>
                            <option value="price-desc">Giá: Cao đến Thấp</option>
                            <option value="title-asc">Tên: A - Z</option>
                        </select>
                    </div>
                </div>

                <!-- Product Grid (Full container width: 4 columns on desktop!) -->
                <div class="row g-4 shop-product-grid" id="productGrid">
            <?php foreach ($ceramic_products as $item) : 
                $product = $item['product'];
                $pid = $product->get_id();
                $title = $product->get_name();
                $permalink = get_permalink($pid);
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $price_num = $product->get_price();
                $price_html = $product->get_price_html();
                $glaze_name = $item['glaze_name'];
                $glaze_slug = $item['glaze_slug'];
                $cat_data_attr = !empty($item['cat_slugs']) ? implode(' ', $item['cat_slugs']) : 'all';

                // Tự động gán tên tác phẩm nếu sản phẩm thiếu tên hoặc (no title)
                $cats = wp_get_post_terms($pid, 'product_cat', ['fields' => 'names']);
                $first_cat = (!empty($cats) && !is_wp_error($cats) && $cats[0] !== 'Uncategorized') ? $cats[0] : '';
                $cat_label = !empty($first_cat) ? $first_cat : (!empty($glaze_name) ? $glaze_name : 'Gốm Sứ');

                $display_title = trim($title);
                if (empty($display_title) || strcasecmp($display_title, '(no title)') === 0 || strcasecmp($display_title, 'no title') === 0) {
                    $glaze_display = (stripos($glaze_name, 'men') === 0) ? $glaze_name : 'Men ' . $glaze_name;
                    $display_title = $cat_label . ' ' . $glaze_display . ' Bát Tràng';
                }
                // Chuẩn hóa tên sản phẩm: loại bỏ lặp từ như "Men Men"
                $display_title = preg_replace('/\bMen\s+Men\b/ui', 'Men', $display_title);
                $display_title = preg_replace('/\s+/', ' ', $display_title);

                // Stats tương tác đồng bộ
                $stats = function_exists('gomie_get_product_stats') ? gomie_get_product_stats($pid) : array(
                    'views' => 3800,
                    'sales' => 450,
                    'rating' => 5
                );
                $views_formatted = number_format($stats['views']);
                $sales_formatted = number_format($stats['sales']);

                // Image with prioritized detection (Optimized large size first for instant load & 60fps scrolling)
                $img_url = '';
                if (has_post_thumbnail($pid)) {
                    $img_url = get_the_post_thumbnail_url($pid, 'large') ?: get_the_post_thumbnail_url($pid, 'full');
                } elseif ($product->get_image_id()) {
                    $img_url = wp_get_attachment_image_url($product->get_image_id(), 'large') ?: wp_get_attachment_image_url($product->get_image_id(), 'full');
                }
                
                if (empty($img_url)) {
                    if ($glaze_slug === 'sapphire') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-saphire.png';
                    elseif ($glaze_slug === 'canh-gian') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-canh-gian.png';
                    elseif ($glaze_slug === 'gam-vang') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-gam-vang.png';
                    elseif ($glaze_slug === 'hoa-bien') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-xanh-song-bien.png';
                    elseif ($glaze_slug === 'reu') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-reu.png';
                    elseif ($glaze_slug === 'ngoc-trai') $img_url = $theme_uri . '/assets/images/glazes/xanh-ngoc-tach-nen-955x800.png';
                    elseif ($glaze_slug === 'nau-tuyet') $img_url = $theme_uri . '/assets/images/glazes/Gomie-men-nau-tuyet.png';
                    else $img_url = $theme_uri . '/assets/images/glazes/bo-mau-men-955x800.png';
                }
            ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 product-card-col" 
                     data-glaze="<?php echo esc_attr($glaze_slug); ?>" 
                     data-cat="<?php echo esc_attr($cat_data_attr); ?>"
                     data-price="<?php echo esc_attr($price_num); ?>"
                     data-title="<?php echo esc_attr($display_title); ?>">
                    <div class="gomie-product-item h-100">
                        <div class="gomie-product-card apple-style">
                            <!-- Product Image Container -->
                            <div class="product-image-wrapper">
                                <a href="<?php echo esc_url($permalink); ?>" class="product-image-link" aria-label="<?php echo esc_attr($display_title); ?>">
                                    <div class="product-image-container">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($display_title); ?>" loading="lazy" decoding="async" class="product-image" />
                                    </div>
                                </a>
                            </div>

                            <!-- Product Content -->
                            <div class="product-content">
                                <!-- Product Category Badge -->
                                <div class="product-category">
                                    <span class="category-label"><?php echo esc_html($cat_label); ?></span>
                                </div>

                                <!-- Product Title -->
                                <h3 class="product-title">
                                    <a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($display_title); ?>">
                                        <?php echo esc_html($display_title); ?>
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
                                                <i class="fa-solid fa-star <?php echo $i <= ($stats['rating'] ?? 5) ? 'filled' : 'empty'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Row -->
                                <div class="product-price-section">
                                    <?php if (!empty($price_html)) : ?>
                                        <div class="product-price"><?php echo wp_kses_post($price_html); ?></div>
                                    <?php else : ?>
                                        <div class="product-price">Liên hệ</div>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Button -->
                                <div class="product-actions">
                                    <a href="<?php echo esc_url($permalink); ?>" class="btn-add-to-cart-apple">
                                        <span class="button-text">Chi tiết</span>
                                        <i class="fa-solid fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Empty state fallback if no filter matches -->
        <div id="noProductsAlert" class="text-center py-5 d-none">
            <div class="empty-icon-wrap mb-3">
                <i class="fa-solid fa-palette text-muted fa-3x"></i>
            </div>
            <h4 class="text-dark fw-bold">Không tìm thấy sản phẩm phù hợp</h4>
            <p class="text-muted">Vui lòng chọn bộ lọc khác hoặc đặt chế tác men riêng theo yêu cầu.</p>
            <button type="button" class="btn btn-outline-dark rounded-pill px-4" onclick="resetFilters()">Xem tất cả sản phẩm</button>
        </div>

        <!-- Load More Products Button for Ultra Smooth Scroll Experience -->
        <div class="shop-load-more-wrap text-center mt-5 mb-2 d-none" id="loadMoreWrap">
            <button type="button" class="btn-load-more-editorial" id="btnLoadMore">
                <i class="fa-solid fa-sparkles text-danger me-1"></i>
                <span>Xem thêm tác phẩm</span>
                <span class="load-more-badge" id="loadMoreBadge">+16</span>
            </button>
        </div>
            </div> <!-- /.container.shop-products-container -->
        </div> <!-- /.shop-canvas-wrapper -->
    </div> <!-- /.shop-body-section -->

    <!-- Editorial Commitment Banner -->
    <section class="shop-bottom-feature py-5">
        <div class="container">
            <div class="feature-banner-box p-4 p-md-5 rounded-4 shadow-sm">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="sub-label text-uppercase text-secondary fw-bold letter-spacing-1">
                            <i class="fa-solid fa-certificate text-danger me-1"></i> TIÊU CHUẨN GỐM SỨ GOMIE
                        </span>
                        <h2 class="banner-title text-dark fw-bold mt-2 mb-3">
                            Chế Tác Thủ Công Cho Nhà Hàng, Khách Sạn & Tư Gia
                        </h2>
                        <p class="banner-desc text-muted mb-4">
                            Gomie cung cấp dịch vụ sản xuất gốm sứ số lượng lớn cho chuỗi ẩm thực HoReCa, in logo khắc vàng quà tặng ngoại giao và thiết kế sắc men độc quyền theo nhận diện thương hiệu.
                        </p>
                        <div class="banner-cta-group d-flex flex-wrap gap-3">
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-banner-primary">
                                <i class="fa-solid fa-paper-plane me-2"></i> Nhận Báo Giá Dự Án
                            </a>
                            <a href="<?php echo esc_url(home_url('/cau-chuyen/')); ?>" class="btn-banner-secondary">
                                <i class="fa-solid fa-book-open me-2"></i> Xem Chuyện Làng Gốm
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center">
                        <div class="banner-stat-grid">
                            <div class="stat-card">
                                <span class="stat-big">1.300°C</span>
                                <span class="stat-txt">Nhiệt độ nung lò khử chì an toàn</span>
                            </div>
                            <div class="stat-card">
                                <span class="stat-big">100%</span>
                                <span class="stat-txt">Bảo hành rơi vỡ trên toàn quốc</span>
                            </div>
                            <div class="stat-card">
                                <span class="stat-big">500+</span>
                                <span class="stat-txt">Năm kế thừa di sản Bát Tràng</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- AJAX Toast Notification -->
<div id="cartToast" class="cart-toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-content d-flex align-items-center gap-3">
        <div class="toast-icon">
            <i class="fa-solid fa-check"></i>
        </div>
        <div class="toast-message flex-grow-1">
            <strong id="toastTitle">Đã thêm vào giỏ hàng!</strong>
            <div id="toastDesc" class="small text-muted">Sản phẩm đã sẵn sàng trong giỏ của bạn.</div>
        </div>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn-toast-view">Xem giỏ</a>
    </div>
</div>

<style>
.shop-breadcrumb .breadcrumb-item::after {
    display: none !important;
    content: none !important;
}
.shop-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "/" !important;
    padding: 0 8px;
    color: #c4b5a5 !important;
}
/* ==========================================================================
   GOMIE EDITORIAL SHOP STYLES
   ========================================================================== */
.gomie-shop-editorial-page {
    background: #fbf8f3 url('<?php echo esc_url($theme_uri . "/assets/images/glazes/Background-1.png"); ?>') repeat;
    min-height: 100vh;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #2b2b2b;
}

/* Hero Section */
.shop-hero-editorial {
    padding: 3rem 1rem 2.5rem;
    position: relative;
    border-bottom: 1px solid rgba(224, 89, 42, 0.12);
}

.shop-breadcrumb .breadcrumb {
    background: transparent;
    font-size: 0.88rem;
}
.shop-breadcrumb a {
    color: #8c827a;
    text-decoration: none;
    transition: color 0.2s;
}
.shop-breadcrumb a:hover {
    color: #e0592a;
}
.shop-breadcrumb .active {
    color: #e0592a;
    font-weight: 600;
}

.shop-pill-badge {
    display: inline-block;
    padding: 0.4rem 1.2rem;
    background: rgba(224, 89, 42, 0.08);
    color: #b3471e;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    border-radius: 999px;
    border: 1px solid rgba(224, 89, 42, 0.25);
}

.shop-hero-title {
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800;
    color: #1a1f2c;
    letter-spacing: -0.5px;
    line-height: 1.2;
    margin-bottom: 1rem;
}
.shop-hero-title .highlight-orange {
    color: #e0592a;
}

.shop-hero-desc {
    max-width: 780px;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #5c554e;
}

/* Trust Bar */
.shop-trust-pills .trust-pill-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #ffffff;
    padding: 0.45rem 1rem;
    border-radius: 999px;
    font-size: 0.85rem;
    color: #3b3530;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    border: 1px solid rgba(224, 89, 42, 0.12);
}
.pill-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}
.fire-dot { background: #e0592a; }
.craft-dot { background: #d97706; }
.safe-dot { background: #059669; }
.protect-dot { background: #2563eb; }

/* ==========================================================================
   GOMIE OUTSIDE SIDEBAR FILTER (NẰM BÊN TRÁI CONTAINER SẢN PHẨM)
   ========================================================================== */
.shop-body-section {
    position: relative;
    width: 100%;
    z-index: 1;
}

.shop-canvas-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 32px;
    max-width: 1680px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Sidebar nằm bên trái, ngoài container của sản phẩm */
.shop-outside-sidebar {
    width: 280px;
    flex-shrink: 0;
    position: sticky;
    top: 100px;
    z-index: 20;
    transition: all 0.3s ease;
}

.filter-widget-card {
    border: 1px solid rgba(224, 89, 42, 0.15);
    background: #ffffff;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
    border-radius: 20px;
    scrollbar-width: thin;
    scrollbar-color: rgba(224, 89, 42, 0.3) transparent;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
}
.filter-widget-card::-webkit-scrollbar {
    width: 4px;
}
.filter-widget-card::-webkit-scrollbar-thumb {
    background: rgba(224, 89, 42, 0.3);
    border-radius: 999px;
}

/* Container sản phẩm rộng rãi chứa đầy đủ 4 cột sản phẩm */
.shop-products-container {
    flex: 1;
    max-width: 1320px;
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Responsive cho màn hình nhỏ hơn 1200px */
@media (max-width: 1199.98px) {
    .shop-canvas-wrapper {
        display: block;
        padding: 0 16px;
    }
    .shop-outside-sidebar {
        display: none;
        width: 100%;
        position: static;
        margin-bottom: 24px;
    }
    .shop-outside-sidebar.show-mobile {
        display: block;
        animation: fadeInDown 0.3s ease;
    }
    .shop-products-container {
        max-width: 100%;
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.widget-title {
    font-size: 1.02rem;
    letter-spacing: -0.2px;
}
.btn-clear-filters {
    cursor: pointer;
    font-size: 0.8rem;
    transition: color 0.2s;
}
.btn-clear-filters:hover {
    color: #e0592a !important;
}

.filter-group-title {
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #2b2b2b !important;
}

/* Glaze Chips Widget */
.glaze-chip-widget {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    background: transparent;
    border: 1px solid transparent;
    padding: 0.42rem 0.75rem;
    border-radius: 10px;
    font-size: 0.88rem;
    color: #4a453f;
    text-align: left;
    width: 100%;
    cursor: pointer;
    transition: all 0.2s ease;
}
.glaze-chip-widget:hover {
    background: #fbf7f2;
    color: #e0592a;
    border-color: rgba(224, 89, 42, 0.15);
}
.glaze-chip-widget.active {
    background: #1a1f2c;
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(26, 31, 44, 0.18);
}
.glaze-chip-widget.active .chip-badge {
    background: rgba(255, 255, 255, 0.22);
    color: #ffffff;
}

.chip-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}
.chip-all { background: conic-gradient(#0b89e7, #78350f, #d97706, #059669, #475569); }
.chip-sapphire { background: #1e3a8a; }
.chip-canh-gian { background: #5c3a21; }
.chip-gam-vang { background: #d97706; }
.chip-hoa-bien { background: #0284c7; }
.chip-reu { background: #3f6212; }
.chip-ngoc-trai { background: #14b8a6; }
.chip-nau-tuyet { background: #78350f; }

.chip-badge, .cat-badge {
    font-size: 0.72rem;
    background: #f1ede8;
    color: #7a7065;
    padding: 2px 7px;
    border-radius: 999px;
    font-weight: 600;
}

/* Category Pills Widget */
.cat-pill-widget {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: transparent;
    border: 1px solid transparent;
    padding: 0.42rem 0.75rem;
    border-radius: 10px;
    font-size: 0.88rem;
    color: #4a453f;
    text-align: left;
    width: 100%;
    cursor: pointer;
    transition: all 0.2s ease;
}
.cat-pill-widget:hover {
    background: #fbf7f2;
    color: #e0592a;
    border-color: rgba(224, 89, 42, 0.15);
}
.cat-pill-widget.active {
    background: rgba(224, 89, 42, 0.08);
    color: #d9531e;
    font-weight: 700;
    border-color: rgba(224, 89, 42, 0.35);
}
.cat-pill-widget.active .cat-badge {
    background: #e0592a;
    color: #ffffff;
}

/* Price Range Widget */
.price-chip-widget {
    display: block;
    background: transparent;
    border: 1px solid transparent;
    padding: 0.42rem 0.75rem;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #4a453f;
    text-align: left;
    width: 100%;
    cursor: pointer;
    transition: all 0.2s ease;
}
.price-chip-widget:hover {
    background: #fbf7f2;
    color: #e0592a;
}
.price-chip-widget.active {
    background: #fbf0e9;
    color: #d9531e;
    font-weight: 700;
    border-left: 3px solid #e0592a;
    border-radius: 4px 8px 8px 4px;
}

/* Widget Craft Pledge */
.widget-craft-pledge {
    background: #fdfaf6;
    border: 1px dashed rgba(224, 89, 42, 0.25);
}
.pledge-item i {
    font-size: 0.95rem;
    width: 18px;
    text-align: center;
}

/* Shop Toolbar (Right Side) */
.shop-toolbar {
    border: 1px solid rgba(224, 89, 42, 0.14);
}
.active-filter-tags .active-tag {
    background: #f5ebe1;
    color: #b5491d;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.active-filter-tags .active-tag:hover {
    background: #edd2be;
    color: #8f320e;
}
.active-filter-tags .active-tag i {
    font-size: 0.7rem;
}



/* Smooth Viewport Rendering for Product Columns (Fluid 60fps/120fps Scroll) */
.product-card-col {
    content-visibility: auto;
    contain-intrinsic-size: 0 440px;
    transition: opacity 0.25s ease, transform 0.25s ease;
}
.product-card-col.d-none {
    display: none !important;
}

/* Gomie Apple-Style Product Card Component (Synchronized with Homepage & Editorial Brand) */
.gomie-product-item {
    margin: 0;
    padding: 0;
    height: 100%;
}

.gomie-product-card.apple-style {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(224, 89, 42, 0.08);
    overflow: hidden;
    transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    will-change: transform, box-shadow;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform: translateZ(0);
}

.gomie-product-card.apple-style:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(224, 89, 42, 0.12);
    border-color: rgba(224, 89, 42, 0.25);
}

/* Khối ảnh đồng nhất màu nền với card (Loại bỏ triệt để viền hộp/card-inside-card) */
.gomie-product-card.apple-style .product-image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #ffffff;
    border-bottom: 1px solid #f6f3ee;
}

.gomie-product-card.apple-style .product-image-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
}

.gomie-product-card.apple-style .product-image-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: #ffffff;
}

.gomie-product-card.apple-style .product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 16px;
    image-rendering: auto;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform: translateZ(0);
    transition: transform 0.3s ease;
}

/* Loại bỏ phóng to scale(1.06) gây vỡ hạt/mờ ảnh trên màn hình Retina khi hover */
.gomie-product-card.apple-style:hover .product-image {
    transform: none;
}

.gomie-product-card.apple-style .product-content {
    padding: 16px 18px 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: 8px;
    background: #ffffff;
}

.gomie-product-card.apple-style .product-category {
    margin: 0;
}

.gomie-product-card.apple-style .category-label {
    display: inline-block;
    background: #fff7ed;
    color: #c2410c;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid rgba(234, 88, 12, 0.16);
    width: fit-content;
}

.gomie-product-card.apple-style .product-title {
    margin: 0;
    font-size: 14.5px;
    font-weight: 700;
    line-height: 1.45;
    color: #1e293b;
    min-height: 42px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.gomie-product-card.apple-style .product-title a {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.2s ease;
}

.gomie-product-card.apple-style:hover .product-title a {
    color: #e0592a;
}

.gomie-product-card.apple-style .product-stats {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 2px 0;
    padding: 0;
    gap: 6px;
}

.gomie-product-card.apple-style .stat-item {
    display: flex;
    align-items: center;
    gap: 4px;
    flex: 1;
    justify-content: center;
    padding: 4px 6px;
    background: #f8fafc;
    border-radius: 6px;
    border: none;
}

.gomie-product-card.apple-style .stat-item i {
    font-size: 10px;
    color: #e0592a;
}

.gomie-product-card.apple-style .stat-value {
    font-size: 11px;
    font-weight: 700;
    color: #475569;
}

.gomie-product-card.apple-style .star-rating {
    display: flex;
    align-items: center;
    gap: 2px;
}

.gomie-product-card.apple-style .star-rating i {
    font-size: 9px;
    color: #f59e0b;
}

.gomie-product-card.apple-style .product-price-section {
    margin: 6px 0;
    text-align: center;
    margin-top: auto;
}

.gomie-product-card.apple-style .product-price {
    color: #e0592a;
    font-weight: 800;
    font-size: 22px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    line-height: 1.2;
}

.gomie-product-card.apple-style .product-price del {
    color: #94a3b8;
    font-size: 13px;
    font-weight: 400;
    text-decoration: line-through;
}

.gomie-product-card.apple-style .product-price ins {
    text-decoration: none;
    color: #e0592a;
}

.gomie-product-card.apple-style .product-actions {
    margin-top: 4px;
}

.gomie-product-card.apple-style .btn-add-to-cart-apple {
    width: 100%;
    background: #e0592a;
    color: #ffffff !important;
    border: none;
    border-radius: 12px;
    padding: 9px 16px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.25s ease;
}

.gomie-product-card.apple-style .btn-add-to-cart-apple:hover {
    background: #c4471b;
    box-shadow: 0 4px 12px rgba(224, 89, 42, 0.25);
    color: #ffffff !important;
}

/* Nút Xem Thêm Tác Phẩm */
.btn-load-more-editorial {
    background: #ffffff;
    color: #e0592a;
    border: 1.5px solid #e0592a;
    padding: 10px 28px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s ease;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(224, 89, 42, 0.08);
}
.btn-load-more-editorial:hover {
    background: #e0592a;
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(224, 89, 42, 0.25);
    transform: translateY(-2px);
}
.btn-load-more-editorial .load-more-badge {
    background: rgba(224, 89, 42, 0.1);
    color: #e0592a;
    border-radius: 999px;
    padding: 2px 8px;
    font-size: 12px;
    font-weight: 800;
    transition: all 0.2s ease;
}
.btn-load-more-editorial:hover .load-more-badge {
    background: #ffffff;
    color: #e0592a;
}

/* Bottom Feature */
.feature-banner-box {
    background: #ffffff;
    border: 1px solid rgba(224, 89, 42, 0.15);
}
.banner-title {
    font-size: clamp(1.4rem, 2.5vw, 2rem);
}
.btn-banner-primary {
    display: inline-flex;
    align-items: center;
    background: #e0592a;
    color: #fff;
    padding: 0.75rem 1.6rem;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.btn-banner-primary:hover {
    background: #c4471b;
    color: #fff;
}
.btn-banner-secondary {
    display: inline-flex;
    align-items: center;
    background: transparent;
    color: #1a1f2c;
    padding: 0.75rem 1.6rem;
    border-radius: 999px;
    border: 1px solid rgba(0,0,0,0.15);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-banner-secondary:hover {
    background: #1a1f2c;
    color: #fff;
}

.banner-stat-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}
.stat-card {
    background: #fbf8f3;
    padding: 1.25rem 1.5rem;
    border-radius: 14px;
    border-left: 4px solid #e0592a;
    text-align: left;
}
.stat-big {
    display: block;
    font-size: 1.6rem;
    font-weight: 800;
    color: #1a1f2c;
    line-height: 1.1;
}
.stat-txt {
    font-size: 0.85rem;
    color: #736b63;
}

/* Toast */
.cart-toast {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #1a1f2c;
    color: #ffffff;
    padding: 1rem 1.25rem;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    z-index: 99999;
    transform: translateY(150%);
    opacity: 0;
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), opacity 0.4s ease;
    max-width: 420px;
}
.cart-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.toast-icon {
    width: 32px;
    height: 32px;
    background: #10b981;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: #fff;
    flex-shrink: 0;
}
.btn-toast-view {
    background: #e0592a;
    color: #fff;
    padding: 0.4rem 0.9rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}
.btn-toast-view:hover {
    background: #c4471b;
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const glazeChips = document.querySelectorAll('#glazeFilter .glaze-chip-widget');
    const catPills = document.querySelectorAll('#categoryFilter .cat-pill-widget');
    const priceChips = document.querySelectorAll('#priceFilter .price-chip-widget');
    const sortSelect = document.getElementById('shopSort');
    const cards = Array.from(document.querySelectorAll('.product-card-col'));
    const grid = document.getElementById('productGrid');
    const countEl = document.getElementById('productCount');
    const emptyAlert = document.getElementById('noProductsAlert');
    const activeTagsContainer = document.getElementById('activeFilterTags');

    let currentGlaze = 'all';
    let currentCat = 'all';
    let currentPriceRange = 'all';

    function renderActiveTags() {
        if (!activeTagsContainer) return;
        activeTagsContainer.innerHTML = '';

        if (currentGlaze !== 'all') {
            const activeGlazeEl = document.querySelector('#glazeFilter .glaze-chip-widget.active');
            const name = activeGlazeEl ? (activeGlazeEl.querySelector('.chip-title')?.textContent.trim() || currentGlaze) : currentGlaze;
            const tag = document.createElement('span');
            tag.className = 'active-tag';
            tag.innerHTML = `${name} <i class="fa-solid fa-xmark"></i>`;
            tag.title = 'Bỏ lọc men';
            tag.addEventListener('click', () => {
                const allBtn = document.querySelector('#glazeFilter .glaze-chip-widget[data-glaze="all"]');
                if (allBtn) allBtn.click();
            });
            activeTagsContainer.appendChild(tag);
        }

        if (currentCat !== 'all') {
            const activeCatEl = document.querySelector('#categoryFilter .cat-pill-widget.active');
            const name = activeCatEl ? (activeCatEl.querySelector('.cat-name')?.textContent.trim() || currentCat) : currentCat;
            const tag = document.createElement('span');
            tag.className = 'active-tag';
            tag.innerHTML = `${name} <i class="fa-solid fa-xmark"></i>`;
            tag.title = 'Bỏ lọc danh mục';
            tag.addEventListener('click', () => {
                const allBtn = document.querySelector('#categoryFilter .cat-pill-widget[data-cat="all"]');
                if (allBtn) allBtn.click();
            });
            activeTagsContainer.appendChild(tag);
        }

        if (currentPriceRange !== 'all') {
            const activePriceEl = document.querySelector('#priceFilter .price-chip-widget.active');
            const name = activePriceEl ? activePriceEl.textContent.trim() : currentPriceRange;
            const tag = document.createElement('span');
            tag.className = 'active-tag';
            tag.innerHTML = `${name} <i class="fa-solid fa-xmark"></i>`;
            tag.title = 'Bỏ lọc giá';
            tag.addEventListener('click', () => {
                const allBtn = document.querySelector('#priceFilter .price-chip-widget[data-price-range="all"]');
                if (allBtn) allBtn.click();
            });
            activeTagsContainer.appendChild(tag);
        }
    }

    const pageSize = 16;
    let currentlyVisibleLimit = 16;
    const btnLoadMore = document.getElementById('btnLoadMore');
    const loadMoreWrap = document.getElementById('loadMoreWrap');
    const loadMoreBadge = document.getElementById('loadMoreBadge');

    function applyFilters() {
        let matchingCards = [];

        cards.forEach(card => {
            const cardGlaze = card.getAttribute('data-glaze');
            const rawCats = card.getAttribute('data-cat') || '';
            const cardCats = rawCats.split(/\s+/);
            const price = parseFloat(card.getAttribute('data-price') || 0);

            const glazeMatch = (currentGlaze === 'all' || cardGlaze === currentGlaze);
            const catMatch = (currentCat === 'all' || cardCats.includes(currentCat) || rawCats.includes(currentCat));

            let priceMatch = true;
            if (currentPriceRange === 'under-100k') {
                priceMatch = (price > 0 && price < 100000);
            } else if (currentPriceRange === '100k-300k') {
                priceMatch = (price >= 100000 && price <= 300000);
            } else if (currentPriceRange === '300k-500k') {
                priceMatch = (price >= 300000 && price <= 500000);
            } else if (currentPriceRange === 'above-500k') {
                priceMatch = (price > 500000);
            }

            if (glazeMatch && catMatch && priceMatch) {
                matchingCards.push(card);
            } else {
                card.classList.add('d-none');
            }
        });

        const totalMatches = matchingCards.length;
        if (countEl) countEl.textContent = totalMatches;
        const tbCount = document.getElementById('toolbarFilterCount');
        if (tbCount) tbCount.textContent = totalMatches;

        const isFiltered = (currentGlaze !== 'all' || currentCat !== 'all' || currentPriceRange !== 'all');
        const activeLimit = isFiltered ? Math.max(currentlyVisibleLimit, pageSize) : currentlyVisibleLimit;

        matchingCards.forEach((card, index) => {
            if (index < activeLimit) {
                card.classList.remove('d-none');
            } else {
                card.classList.add('d-none');
            }
        });

        if (loadMoreWrap && btnLoadMore) {
            const remaining = totalMatches - activeLimit;
            if (remaining > 0) {
                loadMoreWrap.classList.remove('d-none');
                if (loadMoreBadge) loadMoreBadge.textContent = '+' + (remaining > pageSize ? pageSize : remaining);
            } else {
                loadMoreWrap.classList.add('d-none');
            }
        }

        if (emptyAlert) {
            if (totalMatches === 0) emptyAlert.classList.remove('d-none');
            else emptyAlert.classList.add('d-none');
        }

        renderActiveTags();
    }

    if (btnLoadMore) {
        btnLoadMore.addEventListener('click', function() {
            currentlyVisibleLimit += pageSize;
            applyFilters();
        });
    }

    // Glaze chip clicks
    glazeChips.forEach(chip => {
        chip.addEventListener('click', function() {
            glazeChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentGlaze = this.getAttribute('data-glaze');
            applyFilters();
        });
    });

    // Category pill clicks
    catPills.forEach(pill => {
        pill.addEventListener('click', function() {
            catPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentCat = this.getAttribute('data-cat');
            applyFilters();
        });
    });

    // Price range clicks
    priceChips.forEach(chip => {
        chip.addEventListener('click', function() {
            priceChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentPriceRange = this.getAttribute('data-price-range');
            applyFilters();
        });
    });

    // Sort
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const val = this.value;
            cards.sort((a, b) => {
                if (val === 'price-asc') {
                    return parseFloat(a.dataset.price || 0) - parseFloat(b.dataset.price || 0);
                } else if (val === 'price-desc') {
                    return parseFloat(b.dataset.price || 0) - parseFloat(a.dataset.price || 0);
                } else if (val === 'title-asc') {
                    return (a.dataset.title || '').localeCompare(b.dataset.title || '');
                }
                return 0;
            });
            cards.forEach(c => grid.appendChild(c));
        });
    }

    // Mobile Filter Toggle Trigger
    const sidebarEl = document.getElementById('shopFilterSidebar');
    const btnToggleMobile = document.getElementById('btnToggleMobileFilter');

    if (btnToggleMobile && sidebarEl) {
        btnToggleMobile.addEventListener('click', function() {
            sidebarEl.classList.toggle('show-mobile');
            if (sidebarEl.classList.contains('show-mobile')) {
                sidebarEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    window.resetFilters = function() {
        glazeChips.forEach(c => c.classList.remove('active'));
        if (glazeChips[0]) glazeChips[0].classList.add('active');
        catPills.forEach(p => p.classList.remove('active'));
        if (catPills[0]) catPills[0].classList.add('active');
        priceChips.forEach(c => c.classList.remove('active'));
        if (priceChips[0]) priceChips[0].classList.add('active');
        currentGlaze = 'all';
        currentCat = 'all';
        currentPriceRange = 'all';
        currentlyVisibleLimit = pageSize;
        applyFilters();
    };

    // AJAX Add to Cart
    const addButtons = document.querySelectorAll('.btn-add-cart-v11');
    const toast = document.getElementById('cartToast');
    let toastTimer;

    addButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const pid = this.getAttribute('data-product-id');
            const originalHtml = this.innerHTML;
            this.classList.add('loading');
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...';

            const formData = new FormData();
            formData.append('product_id', pid);
            formData.append('quantity', 1);

            fetch('<?php echo esc_url(wc_get_cart_url()); ?>?add-to-cart=' + pid, {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(res => {
                this.classList.remove('loading');
                this.innerHTML = '<i class="fa-solid fa-check"></i> Đã thêm';
                
                // Show toast
                if (toast) {
                    toast.classList.add('show');
                    clearTimeout(toastTimer);
                    toastTimer = setTimeout(() => {
                        toast.classList.remove('show');
                    }, 4000);
                }

                setTimeout(() => {
                    this.innerHTML = originalHtml;
                }, 2000);

                // Update cart count in header if exists
                fetch('<?php echo esc_url(home_url("/?wc-ajax=get_refreshed_fragments")); ?>', {
                    method: 'POST'
                })
                .then(r => r.json())
                .then(data => {
                    if (data && data.fragments) {
                        for (const key in data.fragments) {
                            const el = document.querySelector(key);
                            if (el) el.outerHTML = data.fragments[key];
                        }
                    }
                }).catch(() => {});
            })
            .catch(err => {
                this.classList.remove('loading');
                this.innerHTML = originalHtml;
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại!');
            });
        });
    });
});
</script>

<?php get_footer(); ?>
