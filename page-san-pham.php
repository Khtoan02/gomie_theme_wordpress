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

// Fetch all ceramic products with glaze meta
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        array(
            'key'     => '_gomie_glaze_name',
            'compare' => 'EXISTS',
        )
    ),
    'orderby'        => 'ID',
    'order'          => 'ASC'
);
$query_products = get_posts($args);

$ceramic_products = array();
foreach ($query_products as $p) {
    $wc_prod = wc_get_product($p->ID);
    if ($wc_prod) {
        $ceramic_products[] = $wc_prod;
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

    <!-- Main Content Area -->
    <div class="container shop-body-container py-5">
        <!-- Interactive Controls Bar -->
        <div class="shop-filter-bar mb-4 p-3 p-md-4 rounded-4 shadow-sm bg-white">
            <div class="row g-3 align-items-center">
                <!-- Glaze Quick Filters -->
                <div class="col-12">
                    <div class="filter-group-header mb-2 d-flex align-items-center justify-content-between">
                        <span class="filter-label"><i class="fa-solid fa-palette me-2 text-danger"></i><strong>Lọc theo Sắc Men:</strong></span>
                        <span class="text-muted small">Hiển thị <span id="productCount"><?php echo count($ceramic_products); ?></span> tác phẩm</span>
                    </div>
                    <div class="glaze-filter-chips d-flex flex-wrap gap-2" id="glazeFilter">
                        <button type="button" class="glaze-chip active" data-glaze="all">
                            <span class="chip-color chip-all"></span> Tất cả sắc men
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="sapphire">
                            <span class="chip-color chip-sapphire"></span> Men Sapphire
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="canh-gian">
                            <span class="chip-color chip-canh-gian"></span> Men Cánh Gián
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="gam-vang">
                            <span class="chip-color chip-gam-vang"></span> Men Gấm Vàng
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="hoa-bien">
                            <span class="chip-color chip-hoa-bien"></span> Men Xanh Hỏa Biến
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="reu">
                            <span class="chip-color chip-reu"></span> Men Rêu
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="ngoc-trai">
                            <span class="chip-color chip-ngoc-trai"></span> Men Ngọc Trai
                        </button>
                        <button type="button" class="glaze-chip" data-glaze="nau-tuyet">
                            <span class="chip-color chip-nau-tuyet"></span> Men Nâu Tuyết
                        </button>
                    </div>
                </div>

                <!-- Category & Sort Filter Row -->
                <div class="col-12 mt-3 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <!-- Category Tabs -->
                    <div class="category-tabs d-flex flex-wrap gap-2" id="categoryFilter">
                        <button type="button" class="cat-pill active" data-cat="all">Tất cả sản phẩm</button>
                        <button type="button" class="cat-pill" data-cat="bat-an">Bát ăn cơm</button>
                        <button type="button" class="cat-pill" data-cat="bat-to">Bát tô canh</button>
                        <button type="button" class="cat-pill" data-cat="dia-an">Đĩa tiệc</button>
                        <button type="button" class="cat-pill" data-cat="bo-am-chen">Bộ ấm chén</button>
                        <button type="button" class="cat-pill" data-cat="bo-qua-tang">Bộ quà tặng</button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="sort-selector d-flex align-items-center gap-2">
                        <label for="shopSort" class="text-nowrap small text-muted"><i class="fa-solid fa-arrow-down-short-wide me-1"></i>Sắp xếp:</label>
                        <select id="shopSort" class="form-select form-select-sm border-0 bg-light rounded-pill px-3 py-1">
                            <option value="featured">Nổi bật nhất</option>
                            <option value="price-asc">Giá: Thấp đến Cao</option>
                            <option value="price-desc">Giá: Cao đến Thấp</option>
                            <option value="title-asc">Tên: A - Z</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-4 shop-product-grid" id="productGrid">
            <?php foreach ($ceramic_products as $product) : 
                $pid = $product->get_id();
                $title = $product->get_name();
                $permalink = get_permalink($pid);
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $price_num = $product->get_price();
                $price_html = $product->get_price_html();
                
                // Get glaze name
                $glaze_name = get_post_meta($pid, '_gomie_glaze_name', true);
                if (empty($glaze_name)) {
                    if (stripos($title, 'sapphire') !== false) $glaze_name = 'Men Sapphire';
                    elseif (stripos($title, 'cánh gián') !== false) $glaze_name = 'Men Cánh Gián';
                    elseif (stripos($title, 'gấm vàng') !== false) $glaze_name = 'Men Gấm Vàng';
                    elseif (stripos($title, 'hỏa biến') !== false) $glaze_name = 'Men Xanh Hỏa Biến';
                    elseif (stripos($title, 'rêu') !== false) $glaze_name = 'Men Rêu';
                    elseif (stripos($title, 'ngọc trai') !== false || stripos($title, 'bích ngọc') !== false) $glaze_name = 'Men Ngọc Trai';
                    elseif (stripos($title, 'nâu tuyết') !== false) $glaze_name = 'Men Nâu Tuyết';
                    else $glaze_name = 'Men Độc Bản';
                }

                // Glaze slug for filtering
                $glaze_slug = 'other';
                if (stripos($glaze_name, 'sapphire') !== false) $glaze_slug = 'sapphire';
                elseif (stripos($glaze_name, 'cánh gián') !== false) $glaze_slug = 'canh-gian';
                elseif (stripos($glaze_name, 'gấm vàng') !== false) $glaze_slug = 'gam-vang';
                elseif (stripos($glaze_name, 'hỏa biến') !== false) $glaze_slug = 'hoa-bien';
                elseif (stripos($glaze_name, 'rêu') !== false) $glaze_slug = 'reu';
                elseif (stripos($glaze_name, 'ngọc trai') !== false) $glaze_slug = 'ngoc-trai';
                elseif (stripos($glaze_name, 'nâu tuyết') !== false) $glaze_slug = 'nau-tuyet';

                // Categories
                $term_slugs = wp_get_post_terms($pid, 'product_cat', array('fields' => 'slugs'));
                $cat_data_attr = !empty($term_slugs) ? implode(' ', $term_slugs) : 'all';

                // Image
                $img_url = wp_get_attachment_image_url($product->get_image_id(), 'medium_large');
                if (empty($img_url)) {
                    // Fallback to glaze mockup
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
                     data-title="<?php echo esc_attr($title); ?>">
                    <div class="ceramic-card-v11">
                        <!-- Top Badges -->
                        <div class="card-badges">
                            <span class="badge-glaze">
                                <span class="badge-dot"></span> <?php echo esc_html($glaze_name); ?>
                            </span>
                            <span class="badge-temp">1.300°C</span>
                        </div>

                        <!-- Card Image -->
                        <a href="<?php echo esc_url($permalink); ?>" class="card-img-anchor">
                            <div class="card-img-wrap">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" class="product-clay-img" />
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="card-body-v11">
                            <div class="card-rating-row mb-1">
                                <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                                <span class="craft-note ms-2">Bát Tràng Thủ Công</span>
                            </div>

                            <h3 class="product-title-v11">
                                <a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($title); ?>">
                                    <?php echo esc_html($title); ?>
                                </a>
                            </h3>

                            <p class="product-desc-brief">
                                <?php echo esc_html(wp_strip_all_tags($product->get_short_description())); ?>
                            </p>

                            <!-- Price Row -->
                            <div class="price-row-v11 mb-3">
                                <?php if (!empty($price_html)) : ?>
                                    <div class="price-box"><?php echo wp_kses_post($price_html); ?></div>
                                <?php else : ?>
                                    <div class="price-contact">Liên hệ báo giá</div>
                                <?php endif; ?>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card-actions-v11 d-flex gap-2">
                                <button type="button" class="btn-add-cart-v11 flex-grow-1" data-product-id="<?php echo esc_attr($pid); ?>" title="Thêm vào giỏ">
                                    <i class="fa-solid fa-basket-shopping me-1"></i> Thêm giỏ hàng
                                </button>
                                <a href="<?php echo esc_url($permalink); ?>" class="btn-detail-v11" title="Chi tiết tác phẩm">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
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
    </div>

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

/* Filter Bar */
.shop-filter-bar {
    border: 1px solid rgba(224, 89, 42, 0.15);
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
}
.filter-label {
    font-size: 0.95rem;
    color: #1a1f2c;
}
.glaze-chip {
    background: #f7f4ee;
    border: 1px solid rgba(0,0,0,0.08);
    padding: 0.4rem 0.9rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #4a453f;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.45rem;
    transition: all 0.25s ease;
}
.glaze-chip:hover, .glaze-chip.active {
    background: #1a1f2c;
    color: #ffffff;
    border-color: #1a1f2c;
    box-shadow: 0 4px 12px rgba(26, 31, 44, 0.2);
}
.chip-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}
.chip-all { background: conic-gradient(#0b89e7, #78350f, #d97706, #059669, #475569); }
.chip-sapphire { background: #1e3a8a; }
.chip-canh-gian { background: #5c3a21; }
.chip-gam-vang { background: #d97706; }
.chip-hoa-bien { background: #0284c7; }
.chip-reu { background: #3f6212; }
.chip-ngoc-trai { background: #14b8a6; }
.chip-nau-tuyet { background: #78350f; }

.cat-pill {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.1);
    padding: 0.35rem 0.9rem;
    border-radius: 999px;
    font-size: 0.85rem;
    color: #666;
    cursor: pointer;
    transition: all 0.2s;
}
.cat-pill:hover, .cat-pill.active {
    background: #e0592a;
    color: #fff;
    border-color: #e0592a;
}

/* Ceramic Product Card */
.ceramic-card-v11 {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.25rem;
    border: 1px solid rgba(224, 89, 42, 0.12);
    box-shadow: 0 8px 24px rgba(160, 120, 80, 0.06);
    transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}
.ceramic-card-v11:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(224, 89, 42, 0.12);
    border-color: rgba(224, 89, 42, 0.3);
}

.card-badges {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    top: 1rem;
    left: 1rem;
    right: 1rem;
    z-index: 2;
}
.badge-glaze {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(4px);
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    color: #1a1f2c;
    border: 1px solid rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
.badge-glaze .badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #e0592a;
}
.badge-temp {
    background: #1a1f2c;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 0.55rem;
    border-radius: 999px;
}

.card-img-anchor {
    display: block;
    text-decoration: none;
    margin-bottom: 0.75rem;
}
.card-img-wrap {
    background: radial-gradient(circle, rgba(254, 245, 238, 0.9) 0%, rgba(255, 255, 255, 0.2) 75%);
    border-radius: 16px;
    padding: 1.5rem 1rem;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.product-clay-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
    filter: drop-shadow(0 10px 14px rgba(0,0,0,0.1));
}
.ceramic-card-v11:hover .product-clay-img {
    transform: scale(1.06);
}

.card-body-v11 {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.card-rating-row {
    font-size: 0.78rem;
    color: #928b84;
}
.card-rating-row .stars {
    color: #f59e0b;
    font-size: 0.7rem;
}
.product-title-v11 {
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.45;
    margin-bottom: 0.5rem;
}
.product-title-v11 a {
    color: #1a1f2c;
    text-decoration: none;
    transition: color 0.2s;
}
.product-title-v11 a:hover {
    color: #e0592a;
}

.product-desc-brief {
    font-size: 0.85rem;
    line-height: 1.5;
    color: #6e6761;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.price-row-v11 {
    margin-top: auto;
}
.price-box {
    font-size: 1.15rem;
    font-weight: 800;
    color: #e0592a;
}
.price-box del {
    font-size: 0.85rem;
    color: #9ca3af;
    font-weight: 400;
    margin-right: 0.4rem;
}
.price-box ins {
    text-decoration: none;
}
.price-contact {
    font-size: 0.95rem;
    font-weight: 700;
    color: #b3471e;
}

.btn-add-cart-v11 {
    background: #e0592a;
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding: 0.55rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}
.btn-add-cart-v11:hover {
    background: #c4471b;
    box-shadow: 0 4px 14px rgba(224, 89, 42, 0.35);
}
.btn-add-cart-v11.loading {
    opacity: 0.7;
    pointer-events: none;
}
.btn-detail-v11 {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f7f4ee;
    color: #4a453f;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 0.85rem;
    border: 1px solid rgba(0,0,0,0.06);
    transition: all 0.2s;
}
.btn-detail-v11:hover {
    background: #1a1f2c;
    color: #fff;
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
    const glazeChips = document.querySelectorAll('#glazeFilter .glaze-chip');
    const catPills = document.querySelectorAll('#categoryFilter .cat-pill');
    const sortSelect = document.getElementById('shopSort');
    const cards = Array.from(document.querySelectorAll('.product-card-col'));
    const grid = document.getElementById('productGrid');
    const countEl = document.getElementById('productCount');
    const emptyAlert = document.getElementById('noProductsAlert');

    let currentGlaze = 'all';
    let currentCat = 'all';

    function applyFilters() {
        let visibleCount = 0;

        cards.forEach(card => {
            const cardGlaze = card.getAttribute('data-glaze');
            const cardCats = card.getAttribute('data-cat') || '';

            const glazeMatch = (currentGlaze === 'all' || cardGlaze === currentGlaze);
            const catMatch = (currentCat === 'all' || cardCats.includes(currentCat));

            if (glazeMatch && catMatch) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });

        if (countEl) countEl.textContent = visibleCount;
        if (emptyAlert) {
            if (visibleCount === 0) emptyAlert.classList.remove('d-none');
            else emptyAlert.classList.add('d-none');
        }
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

    window.resetFilters = function() {
        glazeChips.forEach(c => c.classList.remove('active'));
        if (glazeChips[0]) glazeChips[0].classList.add('active');
        catPills.forEach(p => p.classList.remove('active'));
        if (catPills[0]) catPills[0].classList.add('active');
        currentGlaze = 'all';
        currentCat = 'all';
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
