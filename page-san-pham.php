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
$glaze_counts = array();
$has_doc_ban = false;

foreach ($query_products as $p) {
    $wc_prod = wc_get_product($p->ID);
    if (!$wc_prod || !$wc_prod->is_visible()) {
        continue;
    }

    $pid = $wc_prod->get_id();
    $title = $wc_prod->get_name();
    $cat_slugs = wp_get_post_terms($pid, 'product_cat', array('fields' => 'slugs'));
    if (!is_array($cat_slugs)) $cat_slugs = array();

    // Skip non-ceramic legacy demo products on test environment
    $legacy_demo_prefixes = array('led', 'man-hinh', 'thiet-bi', 'thoi-trang', 'suc-khoe', 'sach-', 'khoa-hoc', 'am-thanh', 'anh-sang', 'robot', 'laptop', 'balo', 'giay', 'tai-nghe', 'sua-hat', 'vitamin', 'duoc-lieu', 'dinh-duong', 'cabin', 'bo-xu-ly', 'dien-thoai', 'dong-ho', 'ebook', 'gia-dung', 'may-loc', 'may-tinh');
    $is_legacy = false;
    foreach ($cat_slugs as $c_slug) {
        foreach ($legacy_demo_prefixes as $pref) {
            if (strpos($c_slug, $pref) !== false) {
                $is_legacy = true;
                break 2;
            }
        }
    }
    if ($is_legacy) {
        continue;
    }

    // Detect Glaze info dynamically from attributes (pa_*), custom meta, categories, or title
    $glaze_info = function_exists('gomie_get_product_glaze_info') 
        ? gomie_get_product_glaze_info($wc_prod) 
        : array('name' => 'Men Độc Bản', 'slug' => 'men-doc-ban', 'color' => '#e0592a');

    // Aggregate counts for filter chips
    $g_slug = $glaze_info['slug'];
    $glaze_counts[$g_slug] = ($glaze_counts[$g_slug] ?? 0) + 1;
    if ($g_slug === 'men-doc-ban') {
        $has_doc_ban = true;
    }

    $ceramic_products[] = array(
        'product'     => $wc_prod,
        'glaze_name'  => $glaze_info['name'],
        'glaze_slug'  => $glaze_info['slug'],
        'glaze_color' => $glaze_info['color'],
        'cat_slugs'   => $cat_slugs,
    );
}

// Hệ thống sắc men chuẩn từ WooCommerce attributes (pa_mau-sac)
$system_glazes = function_exists('gomie_get_active_glazes') ? gomie_get_active_glazes() : array();
if ($has_doc_ban) {
    $system_glazes[] = array(
        'id'        => 0,
        'name'      => 'Men Độc Bản',
        'slug'      => 'men-doc-ban',
        'color'     => '#e0592a',
        'img_url'   => '',
        'count'     => $glaze_counts['men-doc-ban'] ?? 0,
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
        $excluded_keywords = array('chua-phan-loai', 'uncategorized', 'led', 'cabin', 'man-hinh', 'am-thanh', 'anh-sang', 'dien-tu', 'ebook', 'khoa-hoc', 'thoi-trang', 'vitamin', 'may-tinh', 'laptop', 'dien-thoai', 'giay', 'robot', 'sach', 'may-loc', 'dinh-duong', 'sua-hat', 'suc-khoe', 'tai-nghe', 'dong-ho', 'duoc-lieu', 'xu-ly', 'chieu-sang', 'thiet-bi');
        foreach ($p_cats as $c) {
            $skip = false;
            foreach ($excluded_keywords as $ex) {
                if (strpos($c->slug, $ex) !== false) {
                    $skip = true;
                    break;
                }
            }
            if ($skip) continue;

            if (!isset($seen_cat_ids[$c->term_id])) {
                $seen_cat_ids[$c->term_id] = true;
                $active_categories[] = $c;
            }
        }
    }
}

// Phân tách danh mục thành 2 nhóm chuyên biệt theo đúng tư duy UX:
// 1. Nhóm Quà Tặng & Dự Án Doanh Nghiệp (Bộ quà tặng, Quà doanh nghiệp, Quà cá nhân, HoReCa...)
// 2. Nhóm Đồ Dùng Bàn Ăn & Gia Dụng (Bát ăn, Bát tô, Đĩa ăn, Ấm chén, Cốc ly, Khay gia vị, Thìa, Gác đũa...)
$tableware_categories = array();
$gift_categories = array();
$gift_slug_keywords = array('qua-tang', 'doanh-nghiep', 'ca-nhan', 'set-qua', 'du-an', 'khach-san', 'horeca');

foreach ($active_categories as $cat) {
    $c_slug = strtolower($cat->slug);
    $c_name = strtolower($cat->name);
    $is_gift = false;
    foreach ($gift_slug_keywords as $kw) {
        if (strpos($c_slug, $kw) !== false || strpos($c_name, $kw) !== false) {
            $is_gift = true;
            break;
        }
    }
    if ($is_gift) {
        $gift_categories[] = $cat;
    } else {
        $tableware_categories[] = $cat;
    }
}

// Helper gán icon tương ứng cho từng loại vật phẩm bàn ăn
if (!function_exists('gomie_get_cat_icon')) {
    function gomie_get_cat_icon($slug, $name) {
        $slug_lower = strtolower($slug . ' ' . $name);
        if (strpos($slug_lower, 'bat-an') !== false || strpos($slug_lower, 'bát ăn') !== false) {
            return 'fa-solid fa-bowl-rice';
        } elseif (strpos($slug_lower, 'bat-to') !== false || strpos($slug_lower, 'bát tô') !== false) {
            return 'fa-solid fa-bowl-food';
        } elseif (strpos($slug_lower, 'dia') !== false || strpos($slug_lower, 'đĩa') !== false) {
            return 'fa-solid fa-plate-wheat';
        } elseif (strpos($slug_lower, 'am-chen') !== false || strpos($slug_lower, 'ấm chén') !== false) {
            return 'fa-solid fa-mug-hot';
        } elseif (strpos($slug_lower, 'coc') !== false || strpos($slug_lower, 'cốc') !== false || strpos($slug_lower, 'ly') !== false) {
            return 'fa-solid fa-mug-saucer';
        } elseif (strpos($slug_lower, 'khay') !== false || strpos($slug_lower, 'gia-vi') !== false) {
            return 'fa-solid fa-cubes-stacked';
        } elseif (strpos($slug_lower, 'thia') !== false || strpos($slug_lower, 'thìa') !== false || strpos($slug_lower, 'muoi') !== false) {
            return 'fa-solid fa-spoon';
        } elseif (strpos($slug_lower, 'dua') !== false || strpos($slug_lower, 'đũa') !== false) {
            return 'fa-solid fa-grip-lines';
        } elseif (strpos($slug_lower, 'tra') !== false || strpos($slug_lower, 'hũ') !== false) {
            return 'fa-solid fa-jar';
        } elseif (strpos($slug_lower, 'am') !== false && strpos($slug_lower, 'ấm') !== false) {
            return 'fa-solid fa-faucet';
        }
        return 'fa-solid fa-utensils';
    }
}

$theme_uri = get_template_directory_uri();
?>

<!-- Critical Shop CSS: Injected before HTML to guarantee 0ms FOUC & zero black borders -->
<style id="gomie-shop-critical-css">
.gomie-shop-editorial-page {
    background-color: #fffdf9 !important;
    background-image: url('<?php echo esc_url(get_template_directory_uri() . "/assets/images/glazes/Background-1.png"); ?>') !important;
    background-position: top center !important;
    background-size: 100% auto !important;
    background-repeat: no-repeat !important;
}
.shop-breadcrumb .breadcrumb-item::after { display: none !important; content: none !important; }
.shop-breadcrumb .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; padding: 0 8px; color: #c4b5a5 !important; }

/* Filter Buttons Instant Reset: Kills raw browser button borders immediately */
.glaze-chip-widget, .cat-pill-widget, .gift-pill-widget {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 0.52rem 0.85rem !important;
    border-radius: 999px !important;
    border: 1px solid #e5ded6 !important;
    background: #ffffff !important;
    font-size: 0.84rem !important;
    font-weight: 600 !important;
    color: #4b443d !important;
    cursor: pointer !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
    outline: none !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    font-family: inherit !important;
    transition: all 0.2s ease !important;
}
.glaze-chip-widget:hover, .cat-pill-widget:hover, .gift-pill-widget:hover {
    border-color: #d1c5b8 !important;
    background: #fdfbf8 !important;
}
.glaze-chip-widget.active, .cat-pill-widget.active {
    background: #1a2233 !important;
    color: #ffffff !important;
    border-color: #1a2233 !important;
}
.glaze-dot-icon {
    width: 10px !important;
    height: 10px !important;
    border-radius: 50% !important;
    display: inline-block !important;
    flex-shrink: 0 !important;
}

/* Product Cards & Images Instant Geometry */
.gomie-product-item {
    display: flex;
    flex-direction: column;
}
.gomie-product-card.apple-style {
    background: #ffffff !important;
    border-radius: 20px !important;
    overflow: hidden !important;
    border: 1px solid #f2ede6 !important;
    box-shadow: 0 4px 18px rgba(35, 25, 15, 0.04) !important;
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
}
.gomie-product-card.apple-style .product-image-wrapper {
    position: relative !important;
    width: 100% !important;
    aspect-ratio: 1 / 1 !important;
    overflow: hidden !important;
    background: #ffffff !important;
    border-bottom: 1px solid #f6f3ee !important;
    display: block !important;
}
.gomie-product-card.apple-style .product-image-link {
    display: flex !important;
    width: 100% !important;
    height: 100% !important;
}
.gomie-product-card.apple-style .product-image-container {
    width: 100% !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: #ffffff !important;
}
.gomie-product-card.apple-style .product-image {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;
    padding: 10px !important;
    display: block !important;
    transition: transform 0.4s ease !important;
}
</style>

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
        <div class="shop-canvas-wrapper">
            <!-- WIDGET BỘ LỌC NẰM BÊN NGOÀI CONTAINER-WIDTH (LỀ TRÁI CỦA SẢN PHẨM) -->
            <aside class="shop-outside-sidebar" id="shopFilterSidebar">
                <div class="filter-widget-card rounded-4 shadow-sm bg-white" id="filterWidgetCard">
                    <div class="widget-header d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="widget-title fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sliders text-danger"></i>
                            <span>Bộ lọc sản phẩm</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-clear-filters text-muted small border-0 bg-transparent" title="Xóa tất cả lọc">
                                <i class="fa-solid fa-rotate-left me-1"></i>Đặt lại
                            </button>
                            <button type="button" class="btn-close-filter-mobile d-xl-none border-0 bg-transparent text-muted ms-1" id="btnCloseFilterMobile" aria-label="Đóng bộ lọc">
                                <i class="fa-solid fa-xmark fs-5"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Widget Block 1: Sắc Men Gốm Bát Tràng (Lưới 2 cột gọn nhẹ) -->
                    <div class="widget-filter-group mb-3">
                        <div class="filter-group-title fw-bold text-dark mb-2">
                            <span><i class="fa-solid fa-palette text-danger me-2"></i>Sắc men gốm</span>
                        </div>
                        <div class="glaze-filter-list" id="glazeFilter">
                            <button type="button" class="glaze-chip-widget glaze-all active mb-1" data-glaze="all">
                                <span class="chip-color chip-all"></span>
                                <span class="chip-title">Tất cả sắc men</span>
                            </button>
                            <div class="glaze-grid-items">
                                <?php if (!empty($system_glazes)) : ?>
                                    <?php foreach ($system_glazes as $glaze_item) : 
                                        $slug = $glaze_item['slug'];
                                        $short_name = trim(preg_replace('/^Men\s+(Xanh\s+)?/ui', '', $glaze_item['name']));
                                        if ($glaze_item['name'] === 'Men Xanh Ngọc') {
                                            $short_name = 'Xanh Ngọc';
                                        } elseif ($glaze_item['name'] === 'Men Xanh Sóng Biển') {
                                            $short_name = 'Sóng Biển';
                                        } elseif ($glaze_item['name'] === 'Men Xanh Thiên Thanh') {
                                            $short_name = 'Thiên Thanh';
                                        }
                                        $item_count = $glaze_counts[$slug] ?? 0;
                                    ?>
                                        <button type="button" class="glaze-chip-widget" data-glaze="<?php echo esc_attr($slug); ?>" title="<?php echo esc_attr($glaze_item['name']); ?><?php echo $item_count > 0 ? ' (' . $item_count . ' tác phẩm)' : ''; ?>">
                                            <?php if (!empty($glaze_item['img_url']) && strpos($glaze_item['img_url'], 'bo-mau-men-955x800.png') === false) : ?>
                                                <img src="<?php echo esc_url($glaze_item['img_url']); ?>" class="chip-img-avatar" alt="<?php echo esc_attr($glaze_item['name']); ?>" />
                                            <?php else : ?>
                                                <span class="chip-color" style="background-color: <?php echo esc_attr($glaze_item['color']); ?>;"></span>
                                            <?php endif; ?>
                                            <span class="chip-title"><?php echo esc_html($short_name); ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Widget Block 2: Danh Mục Tác Phẩm Bàn Ăn & Gia Dụng (Lưới 2 cột có Icon) -->
                    <div class="widget-filter-group mb-3 pt-3 border-top">
                        <div class="filter-group-title fw-bold text-dark mb-2">
                            <span><i class="fa-solid fa-utensils text-danger me-2"></i>Đồ dùng bàn ăn</span>
                        </div>
                        <div class="category-filter-list" id="categoryFilter">
                            <button type="button" class="cat-pill-widget cat-pill-all active mb-1" data-cat="all">
                                <i class="fa-solid fa-boxes-stacked me-1"></i>
                                <span class="cat-name">Tất cả đồ bàn ăn</span>
                            </button>
                            <div class="cat-grid-items">
                                <?php if (!empty($tableware_categories)) : ?>
                                    <?php foreach ($tableware_categories as $cat) : 
                                        $icon_class = gomie_get_cat_icon($cat->slug, $cat->name);
                                    ?>
                                        <button type="button" class="cat-pill-widget" data-cat="<?php echo esc_attr($cat->slug); ?>" title="<?php echo esc_attr($cat->name); ?>">
                                            <i class="<?php echo esc_attr($icon_class); ?> cat-icon"></i>
                                            <span class="cat-name"><?php echo esc_html($cat->name); ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($gift_categories)) : ?>
                    <!-- Widget Block 3: Bộ Quà Tặng & Dự Án Doanh Nghiệp (Phần riêng biệt) -->
                    <div class="widget-filter-group pt-3 border-top">
                        <div class="filter-group-title fw-bold text-dark mb-2 d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-gift text-danger me-2"></i>Quà tặng & Dự án</span>
                            <span class="badge bg-danger-subtle text-danger small px-2 py-0 rounded-pill" style="font-size: 10px;">HoReCa</span>
                        </div>
                        <div class="gift-grid-items">
                            <?php foreach ($gift_categories as $cat) : ?>
                                <button type="button" class="gift-pill-widget" data-cat="<?php echo esc_attr($cat->slug); ?>" title="<?php echo esc_attr($cat->name); ?>">
                                    <i class="fa-solid fa-award text-danger me-1"></i>
                                    <span class="gift-name"><?php echo esc_html($cat->name); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Mobile Apply Button -->
                    <div class="filter-mobile-footer d-xl-none mt-3 pt-3 border-top">
                        <button type="button" class="btn btn-danger w-100 rounded-pill py-2 fw-bold" id="btnApplyMobileFilter">
                            <span>Áp dụng bộ lọc</span> (<span id="toolbarFilterCountMobile"><?php echo count($ceramic_products); ?></span>)
                        </button>
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
            <?php 
            $card_idx = 0;
            foreach ($ceramic_products as $item) : 
                $is_above_fold = ($card_idx < 8);
                $card_idx++; 
                $product = $item['product'];
                $pid = $product->get_id();
                $title = $product->get_name();
                $permalink = get_permalink($pid);
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $price_num = $product->get_price();
                $price_html = $product->get_price_html();
                if (!empty($price_html)) {
                    // Ngăn ngắt dòng rời rạc giữa dấu gạch ngang và số tiền trong khoảng giá
                    $price_html = str_replace(
                        array(' &ndash; ', ' - '),
                        '<span class="price-range-sep">&nbsp;&ndash;&nbsp;</span>',
                        $price_html
                    );
                }
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
                     data-title="<?php echo esc_attr($display_title); ?>"
                     data-index="<?php echo $card_idx; ?>">
                    <div class="gomie-product-item h-100">
                        <div class="gomie-product-card apple-style">
                            <!-- Product Image Container -->
                            <div class="product-image-wrapper">
                                <a href="<?php echo esc_url($permalink); ?>" class="product-image-link" aria-label="<?php echo esc_attr($display_title); ?>">
                                    <div class="product-image-container">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($display_title); ?>" <?php echo $is_above_fold ? 'loading="eager" fetchpriority="high" decoding="sync"' : 'loading="lazy" decoding="async"'; ?> class="product-image" />
                                    </div>
                                </a>
                            </div>

                            <!-- Product Content -->
                            <div class="product-content">
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
                                    <a href="<?php echo esc_url($permalink); ?>" class="btn-card-detail">
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

<!-- Core shop styles and filter engine loaded via inc/enqueue.php (assets/js/shop-filter.js) -->

<?php get_footer(); ?>
