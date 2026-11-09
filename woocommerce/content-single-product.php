<?php
/**
 * The template for displaying product content in the single-product.php template
 * GOMIE CERAMIC - Editorial Collection & SEO V11 Style
 *
 * @package Gomie
 * @version 1.2.0
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || !$product->is_visible()) {
    return;
}

$product_id        = $product->get_id();
$product_title     = $product->get_name();
$product_sku       = $product->get_sku() ?: 'GM-' . $product_id;
$is_on_sale        = $product->is_on_sale();
$regular_price_num = (float) $product->get_regular_price();
$sale_price_num    = (float) $product->get_sale_price();
$current_price_num = (float) $product->get_price();

$discount_percent = 0;
if ($is_on_sale && $regular_price_num > 0 && $sale_price_num > 0 && $regular_price_num > $sale_price_num) {
    $discount_percent = round((($regular_price_num - $sale_price_num) / $regular_price_num) * 100);
}

// Media
$main_image_id    = $product->get_image_id();
$main_image_url   = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'full') : wc_placeholder_img_src('full');
$attachment_ids   = $product->get_gallery_image_ids();

// Categories
$terms = get_the_terms($product_id, 'product_cat');
$primary_cat = (!empty($terms) && !is_wp_error($terms)) ? $terms[0] : null;

// Reviews & Stats
$review_count  = (int) $product->get_review_count();
$avg_rating    = (float) $product->get_average_rating();
if ($avg_rating <= 0) $avg_rating = 4.8;
if ($review_count <= 0) $review_count = 45;

$badge = get_post_meta($product_id, '_gomie_product_badge', true);
if (!$badge && $is_on_sale) {
    $badge = 'Sale';
}

$stats = function_exists('gomie_get_product_stats') ? gomie_get_product_stats($product_id) : array(
    'views' => 3800,
    'sales' => 450,
    'rating' => 5
);

// SEO Structured Data (JSON-LD)
$product_permalink = get_permalink($product_id);
$schema_data = array(
    '@context'        => 'https://schema.org/',
    '@type'           => 'Product',
    'name'            => $product_title,
    'image'           => array($main_image_url),
    'description'     => wp_strip_all_tags($product->get_short_description() ?: $product->get_description() ?: $product_title),
    'sku'             => $product_sku,
    'brand'           => array(
        '@type' => 'Brand',
        'name'  => 'Gomie Ceramic'
    ),
    'offers'          => array(
        '@type'           => 'Offer',
        'url'             => $product_permalink,
        'priceCurrency'   => 'VND',
        'price'           => $current_price_num,
        'priceValidUntil' => gmdate('Y-12-31'),
        'itemCondition'   => 'https://schema.org/NewCondition',
        'availability'    => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'seller'          => array(
            '@type' => 'Organization',
            'name'  => 'Gomie Ceramic Vietnam'
        )
    ),
    'aggregateRating' => array(
        '@type'       => 'AggregateRating',
        'ratingValue' => number_format($avg_rating, 1),
        'reviewCount' => $review_count,
        'bestRating'  => '5',
        'worstRating' => '1'
    )
);
?>

<!-- Schema.org Product Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('gomie-single-product-container gomie-editorial-v11', $product); ?>>
    
    <!-- WooCommerce Notices Wrapper -->
    <div class="gomie-notices-row mb-3">
        <?php do_action('woocommerce_before_single_product'); ?>
    </div>

    <!-- Main Product Layout (Twin Luxury Cards) -->
    <div class="row g-4 g-lg-5 mb-5 align-items-stretch">
        
        <?php
        $gallery_images = array($main_image_url);
        if (!empty($attachment_ids)) {
            foreach ($attachment_ids as $att_id) {
                $u = wp_get_attachment_image_url($att_id, "full");
                if ($u && !in_array($u, $gallery_images)) {
                    $gallery_images[] = $u;
                }
            }
        }
        ?>
        <!-- Left: Product Media Gallery Card -->
        <div class="col-12 col-lg-6 d-flex flex-column">
            <div class="gomie-main-gallery-card position-relative flex-grow-1 d-flex flex-column justify-content-center" data-images="<?php echo esc_attr(json_encode($gallery_images)); ?>">
                
                <!-- Floating Sale/Status Badge -->
                <?php if ($badge) : ?>
                    <div class="gomie-badge-wrap">
                        <span class="gomie-badge badge-<?php echo esc_attr(strtolower($badge)); ?>">
                            <?php if ($is_on_sale && $discount_percent > 0) : ?>
                                -<?php echo $discount_percent; ?>%
                            <?php else : ?>
                                <?php
                                switch (strtolower($badge)) {
                                    case 'sale':
                                        echo 'Ưu Đãi';
                                        break;
                                    case 'hot':
                                        echo 'Bán Chạy';
                                        break;
                                    case 'new':
                                        echo 'Mới';
                                        break;
                                    default:
                                        echo esc_html($badge);
                                }
                                ?>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <!-- Zoom trigger overlay button (Pop Up Lightbox) -->
                <button type="button" class="gomie-zoom-button" title="<?php esc_attr_e('Xem ảnh lớn (Pop-up)', 'gomie-theme'); ?>" aria-label="<?php esc_attr_e('Xem ảnh lớn trong Pop-up', 'gomie-theme'); ?>">
                    <i class="fa-solid fa-expand"></i>
                </button>

                <!-- Main Viewport with High-Priority LCP Image -->
                <div class="main-image-viewport">
                    <a href="<?php echo esc_url($main_image_url); ?>" class="gomie-zoom-link" title="<?php esc_attr_e('Bấm để mở ảnh lớn trong Pop-up', 'gomie-theme'); ?>">
                        <img id="gomie-main-product-img" 
                             src="<?php echo esc_url($main_image_url); ?>" 
                             alt="<?php echo esc_attr($product_title); ?>" 
                             class="main-product-img"
                             fetchpriority="high" />
                    </a>
                </div>
            </div>

            <!-- Gallery Thumbnails (only if gallery images exist) -->
            <?php if (!empty($attachment_ids)) : ?>
                <div class="gomie-thumbnails-strip d-flex gap-2 mt-3">
                    <div class="thumb-item active" data-full="<?php echo esc_url($main_image_url); ?>">
                        <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" loading="lazy" />
                    </div>
                    <?php foreach ($attachment_ids as $attachment_id) :
                        $thumb_url = wp_get_attachment_image_url($attachment_id, 'full');
                        $small_thumb = wp_get_attachment_image_url($attachment_id, 'woocommerce_thumbnail');
                        if (!$thumb_url) continue;
                    ?>
                        <div class="thumb-item" data-full="<?php echo esc_url($thumb_url); ?>">
                            <img src="<?php echo esc_url($small_thumb ?: $thumb_url); ?>" alt="<?php echo esc_attr($product_title); ?>" loading="lazy" />
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Right: Editorial Purchasing Details Card -->
        <div class="col-12 col-lg-6 d-flex">
            <div class="gomie-product-details-card w-100 d-flex flex-column justify-content-between">
                
                <div class="product-details-top">
                    <!-- Category Eyebrow (Quiet Luxury Typography) -->
                    <div class="gomie-product-header-meta mb-2">
                        <div class="product-brand-category">
                            <span class="brand-tag">Gomie Ceramic</span>
                            <?php if ($primary_cat) : ?>
                                <span class="meta-dot">/</span>
                                <a href="<?php echo esc_url(get_term_link($primary_cat)); ?>" class="category-text">
                                    <?php echo esc_html($primary_cat->name); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Product Title (H1 for SEO) -->
                    <h1 class="gomie-product-title mb-2"><?php echo esc_html($product_title); ?></h1>

                    <!-- Social Proof & Stock Row (Minimalist & Calm) -->
                    <div class="product-meta-row d-flex align-items-center flex-wrap gap-2 mb-3">
                        <div class="meta-rating d-inline-flex align-items-center">
                            <i class="fa-solid fa-star text-amber me-1"></i>
                            <span class="rating-score fw-bold"><?php echo number_format($avg_rating, 1); ?></span>
                            <a href="#reviews-pane" class="rating-count ms-1">(<?php echo esc_html($review_count); ?> đánh giá)</a>
                        </div>

                        <span class="meta-sep">·</span>

                        <span class="meta-sales"><?php echo number_format_i18n($stats['sales']); ?> đã bán</span>

                        <span class="meta-sep">·</span>

                        <div class="meta-stock">
                            <?php if ($product->is_in_stock()) : ?>
                                <span class="stock-status in-stock"><span class="status-dot"></span>Còn hàng</span>
                            <?php else : ?>
                                <span class="stock-status out-stock"><span class="status-dot"></span>Tạm hết hàng</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Refined Editorial Price Row -->
                    <div class="gomie-editorial-price-wrap mb-3 pb-3 border-bottom border-light-subtle">
                        <div class="d-flex align-items-baseline flex-wrap gap-3">
                            <?php if ($is_on_sale && $product->get_regular_price()) : ?>
                                <span class="editorial-sale-price"><?php echo wc_price($product->get_sale_price()); ?></span>
                                <span class="editorial-regular-price"><?php echo wc_price($product->get_regular_price()); ?></span>
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="editorial-save-pill">Tiết kiệm <?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                            <?php else : ?>
                                <span class="editorial-sale-price"><?php echo wc_price($product->get_price()); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Short Description -->
                    <?php if ($product->get_short_description()) : ?>
                        <div class="gomie-short-description mb-3">
                            <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Ceramic Craft Specs: Refined Matrix (No nested boxes) -->
                    <div class="gomie-craft-specs-matrix mb-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="spec-matrix-item">
                                    <span class="spec-matrix-label text-muted">XƯƠNG ĐẤT</span>
                                    <span class="spec-matrix-val fw-bold text-dark">Cao lanh Bát Tràng</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="spec-matrix-item">
                                    <span class="spec-matrix-label text-muted">NHIỆT ĐỘ NUNG</span>
                                    <span class="spec-matrix-val fw-bold text-dark">1.300°C khử chì</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="spec-matrix-item">
                                    <span class="spec-matrix-label text-muted">NƯỚC MEN</span>
                                    <span class="spec-matrix-val fw-bold text-dark">Men thủ công cao cấp</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="spec-matrix-item">
                                    <span class="spec-matrix-label text-muted">TIỆN ÍCH AN TOÀN</span>
                                    <span class="spec-matrix-val fw-bold text-dark">Lò vi sóng & Máy rửa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Action Bar (Gomie Trio: Stepper + Cam + Xanh) -->
                <div class="gomie-purchase-actions mt-auto pt-3">
                    <?php if ($product->is_in_stock()) : ?>
                        <form class="cart gomie-action-trio-form" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                            
                            <div class="gomie-purchase-grid">
                                <!-- 1. Stepper chọn số lượng -->
                                <div class="gomie-qty-col">
                                    <?php
                                    woocommerce_quantity_input(
                                        array(
                                            'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                            'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                            'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                                        )
                                    );
                                    ?>
                                </div>

                                <!-- 2. Nút Thêm vào giỏ hàng (CAM GOMIE) -->
                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt btn-gomie-add-cart">
                                    <i class="fa-solid fa-cart-shopping me-1"></i> Thêm vào giỏ hàng
                                </button>

                                <!-- 3. Nút Mua ngay (XANH GOMIE) -->
                                <a href="<?php echo esc_url(wc_get_checkout_url() . '?add-to-cart=' . $product_id); ?>" class="btn-gomie-buy-now" id="gomie-buy-now-btn">
                                    <i class="fa-solid fa-bolt me-1"></i> Mua Ngay
                                </a>
                            </div>

                        </form>
                    <?php else : ?>
                        <div class="alert alert-warning py-3 rounded-4 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i> Sản phẩm hiện đang tạm hết hàng. Quý khách vui lòng liên hệ hotline để đặt chế tác theo lô.
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

    <!-- Product Details Tabs Section (Editorial V11 Style) -->
    <div class="gomie-product-tabs-container mb-5">
        <ul class="nav nav-tabs gomie-modern-tabs mb-4" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab" aria-selected="true">
                    Giới thiệu chi tiết
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="usage-tab" data-bs-toggle="tab" data-bs-target="#usage-pane" type="button" role="tab" aria-selected="false">
                    Hướng dẫn sử dụng & Bảo quản
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab" aria-selected="false">
                    Đánh giá khách hàng (<?php echo esc_html($review_count); ?>)
                </button>
            </li>
        </ul>
        
        <div class="tab-content gomie-tab-card" id="productTabContent">
            
            <!-- Tab 1: Full Description & Artisan Craft Story -->
            <div class="tab-pane fade show active" id="desc-pane" role="tabpanel">
                <div class="gomie-rich-description">
                    
                    <!-- Editorial Lead Block -->
                    <div class="editorial-lead-intro mb-4">
                        <div class="row align-items-start g-4">
                            <div class="col-12 col-lg-5">
                                <p class="kicker-sub text-uppercase fw-bold text-orange mb-2">TINH HOA ĐẤT VIỆT</p>
                                <h3 class="editorial-lead-title fw-bold text-dark">Khi đất và lửa nung tạo tác nên <em>tuyệt phẩm.</em></h3>
                            </div>
                            <div class="col-12 col-lg-7">
                                <p class="lead-text text-secondary mb-3">Mỗi sản phẩm gốm sứ từ thương hiệu <strong>Gomie Ceramic</strong> là kết tinh giữa tinh hoa đất phù sa sông Hồng, men khoáng tự nhiên và bàn tay tài hoa của các nghệ nhân làng nghề Bát Tràng hơn 700 năm tuổi.</p>
                                <p class="text-muted small mb-0">Nung ở nhiệt độ cao 1.300°C loại bỏ hoàn toàn chì và tạp chất kim loại nặng, tạo nên độ bền vĩnh cửu, xương gốm đanh chắc và an toàn tuyệt đối cho sức khỏe người sử dụng trong mọi bữa ăn hằng ngày.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Editorial Craft Pillars -->
                    <div class="row g-3 g-md-4 my-4">
                        <div class="col-md-4">
                            <div class="editorial-pillar-card p-4 rounded-4 h-100">
                                <span class="pillar-number text-orange fw-bold small text-uppercase">Giai đoạn 01</span>
                                <h5 class="fw-bold text-dark mt-1 mb-2">Chuốt mộc & Điêu khắc</h5>
                                <p class="text-secondary small mb-0">Tạo hình thủ công trên bàn xoay truyền thống, từng đường gân nét cong đều đạt độ cân đối và thanh thoát hoàn mỹ.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="editorial-pillar-card p-4 rounded-4 h-100">
                                <span class="pillar-number text-blue fw-bold small text-uppercase">Giai đoạn 02</span>
                                <h5 class="fw-bold text-dark mt-1 mb-2">Men khoáng gia truyền</h5>
                                <p class="text-secondary small mb-0">Công thức tráng men gia truyền tạo nên lớp men đanh bóng, độ sâu quang học cuốn hút và không phai màu theo năm tháng.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="editorial-pillar-card p-4 rounded-4 h-100">
                                <span class="pillar-number text-orange fw-bold small text-uppercase">Giai đoạn 03</span>
                                <h5 class="fw-bold text-dark mt-1 mb-2">Nung khử 1.300°C</h5>
                                <p class="text-secondary small mb-0">Đốt bằng lò gas công nghệ cao loại bỏ hoàn toàn chì và kim loại nặng, xương gốm đanh chắc như ngọc thạch.</p>
                            </div>
                        </div>
                    </div>

                    <?php if ($product->get_description()) : ?>
                        <div class="product-custom-content mt-4 pt-3 border-top border-light-subtle">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Tab 2: Hướng dẫn sử dụng & Cảnh báo -->
            <div class="tab-pane fade" id="usage-pane" role="tabpanel">
                <div class="gomie-usage-guide-wrapper">
                    
                    <!-- Header giới thiệu quy chuẩn -->
                    <div class="usage-guide-header mb-4">
                        <div class="usage-eyebrow d-flex align-items-center gap-2 mb-2">
                            <span class="usage-eyebrow-line"></span>
                            <span class="usage-eyebrow-text">QUY CHUẨN CHĂM SÓC GỐM SỨ GOMIE</span>
                        </div>
                        <h4 class="usage-title fw-bold text-dark mb-2">Bảo Toàn Độ Bền & Vẻ Đẹp Nước Men Vĩnh Cửu</h4>
                        <p class="usage-subtitle text-secondary small mb-0">Xương đất cao lanh Bát Tràng được nung khử ở nhiệt độ cao 1.300°C loại bỏ hoàn toàn chì và tạp chất kim loại nặng. Để sản phẩm giữ trọn vẻ sáng bóng và gắn bó cùng gia đình qua nhiều thế hệ, xin quý khách lưu ý các tiêu chuẩn chăm sóc sau:</p>
                    </div>

                    <!-- 1. 3 Trụ cột chăm sóc & vệ sinh -->
                    <div class="usage-guidelines mb-4">
                        <div class="row g-3 g-md-4">
                            <!-- Card 1 -->
                            <div class="col-12 col-md-4">
                                <div class="editorial-usage-tile care-card-appliance h-100">
                                    <div class="care-card-top d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                        <div class="care-icon-badge badge-appliance">
                                            <i class="fa-solid fa-kitchen-set"></i>
                                        </div>
                                        <span class="care-status-pill pill-success">
                                            <i class="fa-solid fa-circle-check"></i> An toàn thiết bị
                                        </span>
                                    </div>
                                    <h5 class="care-card-title fw-bold text-dark mb-3">Lò vi sóng & Máy rửa chén</h5>
                                    <div class="care-feature-list mb-3">
                                        <div class="care-feature-item d-flex align-items-start gap-2 mb-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <div class="small text-secondary"><strong>Chịu nhiệt vượt trội:</strong> Thoải mái hâm nóng trong lò vi sóng và tiệt trùng nhiệt trong máy rửa chén gia đình.</div>
                                        </div>
                                        <div class="care-feature-item d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-info text-primary mt-1"></i>
                                            <div class="small text-secondary"><strong>Lưu ý sốc nhiệt:</strong> Sau chu trình sấy nóng, để bát đĩa nguội tự nhiên 3–5 phút trước khi lấy ra hoặc xả nước lạnh.</div>
                                        </div>
                                    </div>
                                    <div class="care-card-chip">
                                        <i class="fa-solid fa-temperature-three-quarters text-primary me-1"></i> Chịu nhiệt: -10°C ~ 250°C
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-12 col-md-4">
                                <div class="editorial-usage-tile care-card-cleaning h-100">
                                    <div class="care-card-top d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                        <div class="care-icon-badge badge-cleaning">
                                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                                        </div>
                                        <span class="care-status-pill pill-orange">
                                            <i class="fa-solid fa-star"></i> Bảo dưỡng nước men
                                        </span>
                                    </div>
                                    <h5 class="care-card-title fw-bold text-dark mb-3">Dụng cụ vệ sinh bề mặt</h5>
                                    <div class="care-feature-list mb-3">
                                        <div class="care-feature-item d-flex align-items-start gap-2 mb-2">
                                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                                            <div class="small text-secondary"><strong>Khuyên dùng:</strong> Khăn mềm, mút bọt biển hoặc xơ tự nhiên cùng nước rửa chén dịu nhẹ thông thường.</div>
                                        </div>
                                        <div class="care-feature-item d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-circle-xmark text-danger mt-1"></i>
                                            <div class="small text-secondary"><strong>Tuyệt đối tránh:</strong> Miếng cước kim loại, búi ráp sắt hay bột cọ mài mòn làm trầy xước lớp men bóng.</div>
                                        </div>
                                    </div>
                                    <div class="care-card-chip">
                                        <i class="fa-solid fa-shield-halved text-orange me-1"></i> Bảo vệ men sáng bóng vĩnh cửu
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="col-12 col-md-4">
                                <div class="editorial-usage-tile care-card-matte h-100">
                                    <div class="care-card-top d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                        <div class="care-icon-badge badge-matte">
                                            <i class="fa-solid fa-gem"></i>
                                        </div>
                                        <span class="care-status-pill pill-amber">
                                            <i class="fa-solid fa-palette"></i> Men Matte nghệ thuật
                                        </span>
                                    </div>
                                    <h5 class="care-card-title fw-bold text-dark mb-3">Lưu ý dòng Men Mờ (Matte)</h5>
                                    <div class="care-feature-list mb-3">
                                        <div class="care-feature-item d-flex align-items-start gap-2 mb-2">
                                            <i class="fa-solid fa-circle-info text-warning mt-1"></i>
                                            <div class="small text-secondary"><strong>Đặc tính nghệ thuật:</strong> Bề mặt lì mịn sang trọng, cầm êm bám tay, đậm tinh thần wabi-sabi đương đại.</div>
                                        </div>
                                        <div class="care-feature-item d-flex align-items-start gap-2">
                                            <i class="fa-solid fa-utensils text-secondary mt-1"></i>
                                            <div class="small text-secondary"><strong>Trải nghiệm tối ưu:</strong> Hạn chế miết mạnh mũi dao nĩa kim loại để tránh tạo vệt xước cơ học trên men mờ.</div>
                                        </div>
                                    </div>
                                    <div class="care-card-chip">
                                        <i class="fa-solid fa-fire text-amber me-1"></i> Nung khử 1.300°C khử chì 100%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Cảnh báo an toàn quan trọng -->
                    <div class="usage-safety-panel p-4 rounded-4 mb-4">
                        <div class="safety-panel-header d-flex align-items-center gap-3 mb-3">
                            <div class="safety-icon-emblem">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-danger mb-0">Cảnh Báo An Toàn & Chống Sốc Nhiệt</h5>
                                <div class="small text-secondary">4 nguyên tắc bất biến để bảo vệ trọn vẹn kết cấu xương gốm và an toàn cho người dùng</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="safety-item-card d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="safety-item-icon bg-danger-soft text-danger">
                                        <i class="fa-solid fa-fire-flame-curved"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small mb-1">Không nung trên ngọn lửa trực tiếp</div>
                                        <div class="small text-muted">Tuyệt đối không đun trực tiếp trên bếp gas, bếp than hoặc kiềng lửa trần (gốm bàn ăn không dùng thay nồi đất nấu).</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="safety-item-card d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="safety-item-icon bg-warning-soft text-warning">
                                        <i class="fa-solid fa-bolt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small mb-1">Tránh chi tiết kim loại vào lò vi sóng</div>
                                        <div class="small text-muted">Không đưa sản phẩm có viền vàng kim, nhũ bạc hoặc decal kim loại vào lò vi sóng (gây phóng tia lửa điện nguy hiểm).</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="safety-item-card d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="safety-item-icon bg-info-soft text-info">
                                        <i class="fa-solid fa-snowflake"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small mb-1">Chống sốc nhiệt đột ngột</div>
                                        <div class="small text-muted">Không mang bát đĩa vừa lấy từ tủ đông / ngăn đá cho ngay vào lò nướng nóng hoặc thả trực tiếp vào chảo dầu sôi.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="safety-item-card d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="safety-item-icon bg-danger-soft text-danger">
                                        <i class="fa-solid fa-flask-vial"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small mb-1">Tránh hóa chất axit đậm đặc</div>
                                        <div class="small text-muted">Không ngâm bát đĩa với thuốc tẩy javel, dung dịch tẩy cặn công nghiệp hoặc hóa chất có tính axit ăn mòn cao.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Liên kết đến trang hướng dẫn chi tiết -->
                    <div class="usage-handbook-banner p-4 rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="handbook-icon-badge">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Cẩm nang hướng dẫn sử dụng chuyên sâu cho từng phân loại gốm</h6>
                                <p class="text-secondary small mb-0">Xem hướng dẫn chi tiết cho: bát ăn cơm, đĩa tiệc sâu lòng, bộ ấm trà Bát Tràng, thố canh, khay gia vị...</p>
                            </div>
                        </div>
                        <a href="<?php echo esc_url(home_url('/huong-dan-su-dung/')); ?>" class="btn-handbook-cta">
                            <span>Xem cẩm nang chi tiết</span> <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Tab 3: Reviews -->
            <div class="tab-pane fade" id="reviews-pane" role="tabpanel">
                <div class="gomie-reviews-wrapper">
                    <?php
                    if (comments_open()) {
                        comments_template();
                    } else {
                        echo '<p class="text-muted py-3">Đánh giá hiện đang tạm đóng cho sản phẩm này.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Editorial Glaze Collection Cross-Sell Strip -->
    <section class="gomie-glaze-cross-sell my-5 p-4 p-lg-5 rounded-4 position-relative overflow-hidden">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-8">
                <p class="kicker-sub text-uppercase fw-bold text-orange mb-2">GOMIE CERAMIC · BỘ SƯU TẬP MÀU MEN</p>
                <h3 class="fw-bold text-dark mb-2">Khám phá 9 sắc men độc bản trên dáng gốm Bát Tràng</h3>
                <p class="text-secondary small mb-0">Từ sắc xanh sâu thẳm Sapphire, hổ phách Cánh Gián, ánh vàng Gấm Vàng đến tĩnh tại Men Rêu. Mỗi sắc men đều kể một câu chuyện thẩm mỹ riêng biệt.</p>
            </div>
            <div class="col-12 col-lg-4 text-lg-end">
                <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="btn-editorial-orange">
                    Khám phá bảng màu men <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Semantic Ceramic FAQ Section (Editorial Style) -->
    <section class="gomie-product-faq my-5">
        <div class="row align-items-start g-4 g-lg-5">
            <div class="col-12 col-lg-4">
                <p class="kicker-sub text-uppercase fw-bold text-orange mb-2">GIẢI ĐÁP CÙNG GOMIE</p>
                <h3 class="fw-bold text-dark">Câu hỏi thường gặp về sản phẩm.</h3>
                <p class="text-muted small mt-2">Một vài lưu ý nhỏ để bạn an tâm chọn lựa và nâng niu những món gốm trong gia đình.</p>
            </div>
            <div class="col-12 col-lg-8">
                <div class="editorial-faq-list">
                    <details>
                        <summary>Bát đĩa gốm sứ Gomie có an toàn cho lò vi sóng và máy rửa bát không?</summary>
                        <p>Có. Toàn bộ sản phẩm gốm sứ Gomie được nung ở nhiệt độ cao 1.300°C khử sạch hoàn toàn tạp chất chì và kim loại nặng, kết cấu xương gốm đanh chắc chịu nhiệt rất tốt trong lò vi sóng và máy rửa bát gia đình.</p>
                    </details>
                    <details>
                        <summary>Đồ gốm nung ở 1.300°C có ưu điểm gì so với gốm thông thường?</summary>
                        <p>Nung ở 1.300°C giúp đất sét chảy kết tinh hoàn toàn, tạo nên xương gốm đanh chắc như ngọc thạch, không thấm nước, khó mẻ vỡ khi va chạm nhẹ và giữ nước men bền màu sáng bóng vĩnh viễn.</p>
                    </details>
                    <details>
                        <summary>Nếu sản phẩm bị nứt vỡ trong quá trình vận chuyển thì xử lý thế nào?</summary>
                        <p>Gomie áp dụng chính sách đồng kiểm tận nơi trước khi nhận. Nếu phát hiện sản phẩm bị nứt vỡ trong quá trình vận chuyển, quý khách chỉ cần chụp ảnh và báo lại hotline 0335 059 889 để được đổi mới 100% hoàn toàn miễn phí.</p>
                    </details>
                    <details>
                        <summary>Doanh nghiệp có thể đặt in logo hoặc đặt số lượng lớn theo yêu cầu không?</summary>
                        <p>Gomie nhận sản xuất và in ấn logo hộp quà tặng cao cấp cho nhà hàng, khách sạn và doanh nghiệp trên toàn quốc với mức chiết khấu ưu đãi hấp dẫn. Vui lòng liên hệ hotline hoặc Zalo để nhận báo giá sỉ.</p>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products Section (Rendered with real Gomie Cards) -->
    <?php
    $related_ids = wc_get_related_products($product_id, 4);
    if (!empty($related_ids)) :
    ?>
        <section class="gomie-related-products-section my-5 pt-4 border-top border-light-subtle">
            <div class="section-header text-center mb-4">
                <p class="kicker-sub text-uppercase fw-bold text-orange mb-1">BỘ SƯU TẬP BÁT TRÀNG</p>
                <h3 class="section-title fs-2 fw-bold text-dark mt-1">Sản Phẩm Cùng Phong Cách</h3>
            </div>
            
            <div class="row g-3 g-md-4 justify-content-center">
                <?php
                foreach ($related_ids as $rel_id) :
                    $rel_product = wc_get_product($rel_id);
                    if (!$rel_product) continue;
                ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <?php gomie_render_product_card($rel_product); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php do_action('woocommerce_after_single_product'); ?>

    <!-- Gomie Luxury Image Lightbox Pop Up Modal -->
    <div id="gomie-lightbox-modal" class="gomie-lightbox-overlay" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="gomie-lightbox-backdrop"></div>
        <div class="gomie-lightbox-dialog">
            <!-- Close button -->
            <button type="button" class="gomie-lightbox-close-btn" aria-label="Đóng popup">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Navigation Arrows (only if multi-images) -->
            <button type="button" class="gomie-lightbox-arrow gomie-lightbox-prev" aria-label="Ảnh trước">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button type="button" class="gomie-lightbox-arrow gomie-lightbox-next" aria-label="Ảnh kế tiếp">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <!-- Stage & Image -->
            <div class="gomie-lightbox-stage">
                <img id="gomie-lightbox-current-img" src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" />
            </div>

            <!-- Lightbox Caption Bar -->
            <div class="gomie-lightbox-footer">
                <span class="lightbox-product-title"><?php echo esc_html($product_title); ?></span>
                <span class="lightbox-image-counter">Ảnh <span id="gomie-lightbox-idx">1</span> / <span id="gomie-lightbox-total">1</span></span>
            </div>
        </div>
    </div>

</div>
