<?php
/**
 * The template for displaying search results pages in Gomie Ceramic Editorial V11.
 * Categorizes and displays both Products (WooCommerce) and Articles (Posts) seamlessly.
 *
 * @package Gomie
 */

get_header();

$keyword = trim(get_search_query());
$current_tab = isset($_GET['type']) ? sanitize_key($_GET['type']) : 'all';

// 1. Query Products (WooCommerce)
$paged_prod = isset($_GET['paged_prod']) ? max(1, intval($_GET['paged_prod'])) : 1;
$prod_args = array(
    's'              => $keyword,
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => ($current_tab === 'products') ? 16 : 8,
    'paged'          => $paged_prod,
);
$prod_query = new WP_Query($prod_args);
$num_prods  = $prod_query->found_posts;

// 2. Query Articles (Blog Posts)
$paged_post = isset($_GET['paged_post']) ? max(1, intval($_GET['paged_post'])) : 1;
$post_args = array(
    's'              => $keyword,
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => ($current_tab === 'articles') ? 12 : 6,
    'paged'          => $paged_post,
);
$post_query = new WP_Query($post_args);
$num_posts  = $post_query->found_posts;

$total_results = $num_prods + $num_posts;
?>

<main id="primary" class="site-main gomie-search-page">
    <div class="gomie-v11">

        <!-- 1. Search Header Banner -->
        <section class="search-hero-banner">
            <div class="gomie-search-container">
                <!-- Breadcrumbs -->
                <nav class="search-breadcrumbs" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                    <span class="sep">/</span>
                    <span class="current">Kết quả tìm kiếm</span>
                </nav>

                <div class="search-kicker-badge">
                    <span>GOMIE CERAMIC · TÌM KIẾM ĐA NĂNG</span>
                </div>

                <h1 class="search-hero-title">
                    <?php if (!empty($keyword)) : ?>
                        Kết quả tìm kiếm cho: <span class="search-keyword-highlight">“<?php echo esc_html($keyword); ?>”</span>
                    <?php else : ?>
                        Khám phá tác phẩm &amp; cẩm nang gốm sứ
                    <?php endif; ?>
                </h1>

                <p class="search-results-summary">
                    <?php if (!empty($keyword)) : ?>
                        Tìm thấy <strong class="text-orange"><?php echo number_format($total_results); ?></strong> kết quả phù hợp (gồm <strong><?php echo number_format($num_prods); ?></strong> sản phẩm gốm sứ và <strong><?php echo number_format($num_posts); ?></strong> bài viết cẩm nang)
                    <?php else : ?>
                        Nhập từ khóa bên dưới để tìm kiếm sản phẩm gốm sứ Bát Tràng và các bài viết cẩm nang
                    <?php endif; ?>
                </p>

                <!-- Search Form Box -->
                <div class="search-form-hero-wrap">
                    <?php get_search_form(); ?>
                </div>

                <!-- Popular Suggestions Quick Pills -->
                <div class="search-quick-tags">
                    <span class="quick-tags-label">Gợi ý từ khóa:</span>
                    <div class="quick-tags-list">
                        <a href="<?php echo esc_url(home_url('/?s=Bát+đĩa')); ?>" class="quick-tag-pill">Bát đĩa bàn tiệc</a>
                        <a href="<?php echo esc_url(home_url('/?s=Ấm+chén')); ?>" class="quick-tag-pill">Bộ ấm chén trà</a>
                        <a href="<?php echo esc_url(home_url('/?s=Men+hỏa+biến')); ?>" class="quick-tag-pill">Men hỏa biến 1.300°C</a>
                        <a href="<?php echo esc_url(home_url('/?s=Men+sapphire')); ?>" class="quick-tag-pill">Men Sapphire</a>
                        <a href="<?php echo esc_url(home_url('/?s=Quà+tặng')); ?>" class="quick-tag-pill">Quà tặng doanh nghiệp</a>
                        <a href="<?php echo esc_url(home_url('/?s=Nhà+hàng')); ?>" class="quick-tag-pill">Gốm nhà hàng - khách sạn</a>
                    </div>
                </div>

            </div><!-- /.gomie-search-container -->
        </section><!-- /.search-hero-banner -->

        <!-- 2. Search Navigation Tabs & Content Canvas -->
        <section class="search-results-canvas">
            <div class="gomie-search-container">

                <?php if ($total_results > 0) : ?>

                    <!-- Filter Tabs -->
                    <div class="search-tabs-strip">
                        <button type="button" class="search-tab-btn active" data-tab="tab-all">
                            <span>Tất cả kết quả</span>
                            <span class="tab-counter"><?php echo number_format($total_results); ?></span>
                        </button>
                        <button type="button" class="search-tab-btn" data-tab="tab-products">
                            <i class="fa-solid fa-fire me-1 text-orange"></i>
                            <span>Sản phẩm gốm sứ</span>
                            <span class="tab-counter"><?php echo number_format($num_prods); ?></span>
                        </button>
                        <button type="button" class="search-tab-btn" data-tab="tab-articles">
                            <i class="fa-solid fa-newspaper me-1 text-orange"></i>
                            <span>Bài viết &amp; Cẩm nang</span>
                            <span class="tab-counter"><?php echo number_format($num_posts); ?></span>
                        </button>
                    </div>

                    <!-- TAB 1: ALL RESULTS (Both Products & Posts) -->
                    <div id="tab-all" class="search-tab-panel active">

                        <!-- Section A: Products in All Tab -->
                        <?php if ($num_prods > 0) : ?>
                            <div class="search-section-block">
                                <div class="section-block-header d-flex justify-content-between align-items-center">
                                    <div class="section-title-wrap">
                                        <h2 class="section-block-title">
                                            <i class="fa-solid fa-fire text-orange me-2"></i>
                                            Tác phẩm gốm sứ liên quan
                                        </h2>
                                        <span class="section-sub-badge">Chế tác thủ công Bát Tràng</span>
                                    </div>
                                    <?php if ($num_prods > 8) : ?>
                                        <button type="button" class="btn-jump-tab" onclick="document.querySelector('[data-tab=\'tab-products\']').click(); window.scrollTo({ top: 380, behavior: 'smooth'});">
                                            Xem tất cả <?php echo number_format($num_prods); ?> sản phẩm <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="gomie-product-grid">
                                    <?php
                                    while ($prod_query->have_posts()) :
                                        $prod_query->the_post();
                                        $product = wc_get_product(get_the_ID());
                                        if ($product && function_exists('gomie_render_product_card')) {
                                            gomie_render_product_card($product);
                                        }
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>

                                <?php if ($num_prods > 8) : ?>
                                    <div class="text-center mt-4 pt-2">
                                        <button type="button" class="btn-more-tab-action" onclick="document.querySelector('[data-tab=\'tab-products\']').click(); window.scrollTo({ top: 380, behavior: 'smooth'});">
                                            Xem thêm <?php echo ($num_prods - 8); ?> sản phẩm gốm sứ khác <i class="fa-solid fa-chevron-down ms-1"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Section B: Articles in All Tab -->
                        <?php if ($num_posts > 0) : ?>
                            <div class="search-section-block mt-5 pt-3">
                                <div class="section-block-header d-flex justify-content-between align-items-center">
                                    <div class="section-title-wrap">
                                        <h2 class="section-block-title">
                                            <i class="fa-solid fa-newspaper text-orange me-2"></i>
                                            Bài viết &amp; Cẩm nang gốm sứ
                                        </h2>
                                        <span class="section-sub-badge">Góc chia sẻ nghệ thuật</span>
                                    </div>
                                    <?php if ($num_posts > 6) : ?>
                                        <button type="button" class="btn-jump-tab" onclick="document.querySelector('[data-tab=\'tab-articles\']').click(); window.scrollTo({ top: 380, behavior: 'smooth'});">
                                            Xem tất cả <?php echo number_format($num_posts); ?> bài viết <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <div class="search-articles-grid">
                                    <?php
                                    while ($post_query->have_posts()) :
                                        $post_query->the_post();
                                        $art_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
                                        $art_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
                                        $art_img_url = !empty($art_img) ? esc_url(get_template_directory_uri() . '/assets/images/stories/' . $art_img) : (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg'));
                                    ?>
                                        <article class="search-article-card">
                                            <a href="<?php the_permalink(); ?>" class="card-media-stage">
                                                <img src="<?php echo $art_img_url; ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                            </a>
                                            <div class="card-text-body">
                                                <div class="card-category-tag">
                                                    <?php echo esc_html(!empty($art_tag) ? $art_tag : 'CẨM NANG GỐM'); ?>
                                                </div>
                                                <h3 class="card-article-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
                                                <p class="card-article-excerpt">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                                </p>
                                                <div class="card-footer-meta">
                                                    <span class="card-date"><i class="fa-regular fa-calendar-days me-1"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                                                    <a href="<?php the_permalink(); ?>" class="card-readmore-link">
                                                        Đọc tiếp <i class="fa-solid fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- /#tab-all -->

                    <!-- TAB 2: PRODUCTS ONLY -->
                    <div id="tab-products" class="search-tab-panel d-none">
                        <?php if ($num_prods > 0) : ?>
                            <div class="section-block-header d-flex justify-content-between align-items-center mb-4">
                                <h2 class="section-block-title">
                                    <i class="fa-solid fa-fire text-orange me-2"></i>
                                    Danh sách sản phẩm gốm sứ (<?php echo number_format($num_prods); ?>)
                                </h2>
                            </div>

                            <div class="gomie-product-grid">
                                <?php
                                // Re-query products for full products tab
                                $all_prod_query = new WP_Query(array(
                                    's'              => $keyword,
                                    'post_type'      => 'product',
                                    'post_status'    => 'publish',
                                    'posts_per_page' => 16,
                                    'paged'          => $paged_prod,
                                ));
                                while ($all_prod_query->have_posts()) :
                                    $all_prod_query->the_post();
                                    $product = wc_get_product(get_the_ID());
                                    if ($product && function_exists('gomie_render_product_card')) {
                                        gomie_render_product_card($product);
                                    }
                                endwhile;
                                ?>
                            </div>

                            <!-- Product Pagination -->
                            <?php if ($all_prod_query->max_num_pages > 1) : ?>
                                <div class="search-pagination-wrap mt-5 text-center">
                                    <?php
                                    echo paginate_links(array(
                                        'total'     => $all_prod_query->max_num_pages,
                                        'current'   => $paged_prod,
                                        'format'    => '?paged_prod=%#%&type=products',
                                        'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Trước',
                                        'next_text' => 'Sau <i class="fa-solid fa-chevron-right"></i>',
                                    ));
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>

                        <?php else : ?>
                            <div class="search-empty-tab text-center py-5">
                                <div class="empty-icon-seal mb-3"><i class="fa-solid fa-bowl-food"></i></div>
                                <h4>Không có sản phẩm nào khớp với từ khóa</h4>
                                <p class="text-muted">Bạn có thể tham khảo các bài viết cẩm nang hoặc tìm theo từ khóa khác.</p>
                            </div>
                        <?php endif; ?>
                    </div><!-- /#tab-products -->

                    <!-- TAB 3: ARTICLES ONLY -->
                    <div id="tab-articles" class="search-tab-panel d-none">
                        <?php if ($num_posts > 0) : ?>
                            <div class="section-block-header d-flex justify-content-between align-items-center mb-4">
                                <h2 class="section-block-title">
                                    <i class="fa-solid fa-newspaper text-orange me-2"></i>
                                    Danh sách bài viết &amp; cẩm nang (<?php echo number_format($num_posts); ?>)
                                </h2>
                            </div>

                            <div class="search-articles-grid">
                                <?php
                                $all_post_query = new WP_Query(array(
                                    's'              => $keyword,
                                    'post_type'      => 'post',
                                    'post_status'    => 'publish',
                                    'posts_per_page' => 12,
                                    'paged'          => $paged_post,
                                ));
                                while ($all_post_query->have_posts()) :
                                    $all_post_query->the_post();
                                    $art_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
                                    $art_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
                                    $art_img_url = !empty($art_img) ? esc_url(get_template_directory_uri() . '/assets/images/stories/' . $art_img) : (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium') : esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg'));
                                ?>
                                    <article class="search-article-card">
                                        <a href="<?php the_permalink(); ?>" class="card-media-stage">
                                            <img src="<?php echo $art_img_url; ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                        </a>
                                        <div class="card-text-body">
                                            <div class="card-category-tag">
                                                <?php echo esc_html(!empty($art_tag) ? $art_tag : 'CẨM NANG GỐM'); ?>
                                            </div>
                                            <h3 class="card-article-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <p class="card-article-excerpt">
                                                <?php echo wp_trim_words(get_the_excerpt(), 22, '...'); ?>
                                            </p>
                                            <div class="card-footer-meta">
                                                <span class="card-date"><i class="fa-regular fa-calendar-days me-1"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                                                <a href="<?php the_permalink(); ?>" class="card-readmore-link">
                                                    Đọc tiếp <i class="fa-solid fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                <?php
                                endwhile;
                                ?>
                            </div>

                            <!-- Article Pagination -->
                            <?php if ($all_post_query->max_num_pages > 1) : ?>
                                <div class="search-pagination-wrap mt-5 text-center">
                                    <?php
                                    echo paginate_links(array(
                                        'total'     => $all_post_query->max_num_pages,
                                        'current'   => $paged_post,
                                        'format'    => '?paged_post=%#%&type=articles',
                                        'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Trước',
                                        'next_text' => 'Sau <i class="fa-solid fa-chevron-right"></i>',
                                    ));
                                    ?>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_postdata(); ?>

                        <?php else : ?>
                            <div class="search-empty-tab text-center py-5">
                                <div class="empty-icon-seal mb-3"><i class="fa-solid fa-book-open"></i></div>
                                <h4>Không có bài viết nào khớp với từ khóa</h4>
                                <p class="text-muted">Bạn có thể xem các sản phẩm gốm sứ hoặc tìm kiếm với từ khóa khác.</p>
                            </div>
                        <?php endif; ?>
                    </div><!-- /#tab-articles -->

                <?php else : ?>

                    <!-- 3. Zero Results State -->
                    <div class="search-no-results-box">
                        <div class="no-results-icon-wrap">
                            <div class="seal-icon-lg">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                        <h2 class="no-results-title">Không tìm thấy kết quả phù hợp</h2>
                        <p class="no-results-desc">
                            Rất tiếc, Gomie không tìm thấy sản phẩm hay bài viết nào cho từ khóa <strong>“<?php echo esc_html($keyword); ?>”</strong>.
                        </p>

                        <div class="no-results-tips-card">
                            <h4 class="tips-heading"><i class="fa-solid fa-lightbulb text-orange me-2"></i> Gợi ý tìm kiếm hữu ích:</h4>
                            <ul class="tips-list">
                                <li>Kiểm tra lại chính tả của từ khóa đã nhập.</li>
                                <li>Thử tìm kiếm với từ khóa ngắn hoặc phổ biến hơn (ví dụ: <em>bát</em>, <em>đĩa</em>, <em>ấm chén</em>, <em>men hỏa biến</em>).</li>
                                <li>Khám phá nhanh các chuyên mục nổi bật của Gomie Ceramic dưới đây:</li>
                            </ul>
                            <div class="quick-explore-buttons d-flex flex-wrap justify-content-center gap-3 mt-4">
                                <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-explore-pill btn-primary-pill">
                                    <i class="fa-solid fa-bowl-food me-1"></i> Toàn bộ sản phẩm gốm
                                </a>
                                <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="btn-explore-pill btn-secondary-pill">
                                    <i class="fa-solid fa-palette me-1"></i> Bảng 9 sắc men gốm
                                </a>
                                <a href="<?php echo esc_url(home_url('/chia-se/')); ?>" class="btn-explore-pill btn-secondary-pill">
                                    <i class="fa-solid fa-newspaper me-1"></i> Góc chia sẻ cẩm nang
                                </a>
                                <a href="<?php echo esc_url(home_url('/bao-gia/')); ?>" class="btn-explore-pill btn-secondary-pill">
                                    <i class="fa-solid fa-file-invoice me-1"></i> Báo giá dự án HoReCa
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

                <!-- 4. Consultation & Custom Order Assistance Banner -->
                <div class="search-consultation-banner mt-5">
                    <div class="consultation-banner-inner d-flex flex-column flex-lg-row align-items-center justify-content-between gap-4">
                        <div class="banner-text-content">
                            <span class="banner-kicker">CHẾ TÁC ĐỘC BẢN THEO YÊU CẦU</span>
                            <h3 class="banner-heading">Chưa tìm thấy mẫu gốm sứ đúng ý tưởng của bạn?</h3>
                            <p class="banner-desc mb-0">
                                Gomie Ceramic nhận thiết kế, khắc logo và nung nhiệt độ cao 1.300°C khử chì độc tố cho các chuỗi nhà hàng, khách sạn cao cấp &amp; quà tặng doanh nghiệp.
                            </p>
                        </div>
                        <div class="banner-action-buttons d-flex flex-wrap align-items-center gap-3">
                            <a href="tel:0335059889" class="btn-hotline-pill">
                                <i class="fa-solid fa-phone-volume me-2"></i> 0335 059 889
                            </a>
                            <a href="<?php echo esc_url(home_url('/bao-gia/')); ?>" class="btn-quote-pill">
                                Nhận báo giá dự án <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div><!-- /.gomie-search-container -->
        </section><!-- /.search-results-canvas -->

    </div><!-- /.gomie-v11 -->
</main>

<style id="gomie-search-page-css">
/* ==========================================================================
   CSS Search Results Page - Gomie Ceramic Editorial V11 Standard
   ========================================================================== */
body.search,
.site-main.gomie-search-page {
    background-color: #fffdf9 !important;
    background-image: none !important;
    min-height: 100vh;
}

.gomie-search-page .gomie-v11 {
    background-color: #fffdf9 !important;
    background-image: none !important;
    padding-bottom: 90px;
}

.gomie-search-container {
    max-width: 1280px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: clamp(16px, 2.5vw, 32px) !important;
    padding-right: clamp(16px, 2.5vw, 32px) !important;
    box-sizing: border-box !important;
}

/* 1. Search Hero Banner */
.search-hero-banner {
    padding-top: clamp(36px, 4.5vw, 64px);
    padding-bottom: clamp(32px, 4vw, 56px);
    text-align: center;
    background: radial-gradient(circle at 50% 0%, rgba(244, 122, 32, 0.06) 0%, transparent 70%);
    border-bottom: 1px solid rgba(235, 222, 206, 0.6);
}

.search-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #7b8893;
    margin-bottom: 18px;
    flex-wrap: wrap;
    justify-content: center;
}

.search-breadcrumbs a {
    color: #63707c !important;
    text-decoration: none !important;
    transition: color 0.2s;
}

.search-breadcrumbs a:hover {
    color: var(--orange, #f47a20) !important;
}

.search-breadcrumbs .sep {
    color: #b0bac3;
}

.search-breadcrumbs .current {
    color: #2b3640;
    font-weight: 600;
}

.search-kicker-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(235, 222, 206, 0.9);
    box-shadow: 0 4px 12px rgba(45, 30, 15, 0.04);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--orange-deep, #db6109);
    margin-bottom: 18px;
}

.search-hero-title {
    font-size: clamp(26px, 3.4vw, 42px) !important;
    font-weight: 800 !important;
    line-height: 1.3 !important;
    letter-spacing: -0.02em !important;
    color: #1e2830 !important;
    margin: 0 auto 16px auto !important;
    max-width: 960px;
    text-align: center;
}

.search-keyword-highlight {
    color: var(--orange, #f47a20);
    position: relative;
    display: inline-block;
}

.search-results-summary {
    font-size: clamp(14px, 1.5vw, 16px);
    color: #64748b;
    margin: 0 auto 30px auto;
    max-width: 760px;
    line-height: 1.6;
}

.search-results-summary strong.text-orange {
    color: var(--orange-deep, #db6109);
}

.search-form-hero-wrap {
    max-width: 680px;
    margin: 0 auto 24px auto;
}

/* Quick Tags */
.search-quick-tags {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    max-width: 820px;
    margin: 0 auto;
}

.quick-tags-label {
    font-size: 12.5px;
    font-weight: 750;
    color: #7b8893;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.quick-tags-list {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.quick-tag-pill,
.badge-suggestion-pill {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 999px;
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    color: #475569 !important;
    font-size: 12.5px;
    font-weight: 650;
    text-decoration: none !important;
    box-shadow: 0 2px 6px rgba(45, 30, 15, 0.03);
    transition: all 0.22s ease;
}

.quick-tag-pill:hover,
.badge-suggestion-pill:hover {
    background: #fdf6ed;
    border-color: rgba(244, 122, 32, 0.4);
    color: var(--orange-deep, #db6109) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(244, 122, 32, 0.12);
}

/* 2. Results Canvas & Tabs */
.search-results-canvas {
    padding-top: clamp(32px, 4vw, 50px);
}

.search-tabs-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: clamp(30px, 4vw, 44px);
    flex-wrap: wrap;
    border-bottom: 1px solid rgba(235, 222, 206, 0.7);
    padding-bottom: 18px;
}

.search-tab-btn {
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    color: #475569;
    padding: 10px 22px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 750;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(45, 30, 15, 0.03);
}

.search-tab-btn:hover {
    border-color: rgba(244, 122, 32, 0.4);
    color: var(--orange-deep, #db6109);
    transform: translateY(-1px);
}

.search-tab-btn.active {
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    border-color: transparent;
    color: #ffffff !important;
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.35);
}

.search-tab-btn.active .tab-counter {
    background: rgba(255, 255, 255, 0.25);
    color: #ffffff;
}

.search-tab-btn.active i {
    color: #ffffff !important;
}

.tab-counter {
    font-size: 11.5px;
    font-weight: 850;
    background: #f1f5f9;
    color: #64748b;
    padding: 2px 8px;
    border-radius: 999px;
    transition: all 0.25s ease;
}

/* Section Block Header */
.section-block-header {
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 14px;
}

.section-block-title {
    font-size: clamp(20px, 2.2vw, 26px) !important;
    font-weight: 800 !important;
    color: #1e2830 !important;
    margin: 0 0 4px 0 !important;
    display: flex;
    align-items: center;
}

.section-sub-badge {
    font-size: 12px;
    color: #8c97a0;
    font-weight: 650;
}

.btn-jump-tab {
    background: transparent;
    border: none;
    color: var(--orange-deep, #db6109);
    font-size: 13.5px;
    font-weight: 750;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.btn-jump-tab:hover {
    color: var(--orange, #f47a20);
    transform: translateX(3px);
}

.btn-more-tab-action {
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    color: var(--orange-deep, #db6109);
    padding: 12px 28px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 750;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(45, 30, 15, 0.04);
    transition: all 0.25s ease;
}

.btn-more-tab-action:hover {
    background: var(--orange, #f47a20);
    border-color: var(--orange, #f47a20);
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.3);
    transform: translateY(-2px);
}

/* Editorial Articles Grid */
.search-articles-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: clamp(20px, 2.2vw, 30px);
}

.search-article-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid rgba(235, 222, 206, 0.85);
    box-shadow: 0 10px 28px rgba(45, 30, 15, 0.04);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.search-article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 40px rgba(45, 30, 15, 0.09);
    border-color: rgba(244, 122, 32, 0.35);
}

.card-media-stage {
    display: block;
    width: 100%;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: #f2eee8;
}

.card-media-stage img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.search-article-card:hover .card-media-stage img {
    transform: scale(1.06);
}

.card-text-body {
    padding: 22px 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-category-tag {
    font-size: 11px;
    font-weight: 850;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--orange-deep, #db6109);
    margin-bottom: 8px;
}

.card-article-title {
    font-size: 17px !important;
    font-weight: 750 !important;
    line-height: 1.4 !important;
    color: #1e2830 !important;
    margin: 0 0 10px 0 !important;
}

.card-article-title a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color 0.2s;
}

.search-article-card:hover .card-article-title a {
    color: var(--orange, #f47a20) !important;
}

.card-article-excerpt {
    font-size: 13.5px;
    line-height: 1.65;
    color: #64748b;
    margin: 0 0 18px 0;
    flex: 1;
}

.card-footer-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 14px;
    border-top: 1px solid rgba(235, 222, 206, 0.6);
}

.card-date {
    font-size: 12px;
    color: #94a3b8;
}

.card-readmore-link {
    font-size: 13px;
    font-weight: 750;
    color: var(--blue, #046bd2) !important;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}

.card-readmore-link:hover {
    color: var(--orange, #f47a20) !important;
    transform: translateX(3px);
}

/* 3. Empty Results State */
.search-no-results-box {
    max-width: 760px;
    margin: 30px auto 60px auto;
    background: #ffffff;
    border-radius: 28px;
    border: 1px solid rgba(235, 222, 206, 0.85);
    box-shadow: 0 16px 42px rgba(45, 30, 15, 0.05);
    padding: clamp(32px, 5vw, 60px) clamp(24px, 4vw, 50px);
    text-align: center;
}

.empty-icon-seal,
.seal-icon-lg {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: #fdf6ed;
    color: var(--orange, #f47a20);
    font-size: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    border: 1px solid rgba(244, 122, 32, 0.2);
}

.no-results-title {
    font-size: clamp(22px, 2.5vw, 28px);
    font-weight: 800;
    color: #1e2830;
    margin-bottom: 12px;
}

.no-results-desc {
    font-size: 15.5px;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 28px;
}

.no-results-tips-card {
    background: #faf7f2;
    border-radius: 20px;
    padding: 24px 28px;
    text-align: left;
    border: 1px solid rgba(235, 222, 206, 0.8);
}

.tips-heading {
    font-size: 15px;
    font-weight: 800;
    color: #1e2830;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}

.tips-list {
    margin: 0;
    padding-left: 20px;
    color: #475569;
    font-size: 14px;
    line-height: 1.8;
}

.btn-explore-pill {
    padding: 10px 22px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 750;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    transition: all 0.25s ease;
}

.btn-primary-pill {
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(244, 122, 32, 0.3);
}

.btn-primary-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.45);
}

.btn-secondary-pill {
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    color: #334155 !important;
}

.btn-secondary-pill:hover {
    background: #fdf6ed;
    border-color: rgba(244, 122, 32, 0.4);
    color: var(--orange-deep, #db6109) !important;
    transform: translateY(-2px);
}

/* 4. Consultation & Custom Order Banner */
.search-consultation-banner {
    background: linear-gradient(135deg, #1e2830 0%, #2b3640 100%);
    border-radius: 26px;
    padding: clamp(30px, 4vw, 44px) clamp(24px, 4vw, 48px);
    color: #ffffff;
    border: 1px solid rgba(244, 122, 32, 0.35);
    box-shadow: 0 16px 42px rgba(20, 26, 32, 0.15);
}

.banner-kicker {
    display: inline-block;
    padding: 4px 14px;
    border-radius: 999px;
    background: rgba(244, 122, 32, 0.2);
    border: 1px solid rgba(244, 122, 32, 0.4);
    color: #ff9d47;
    font-size: 10.5px;
    font-weight: 850;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 12px;
}

.banner-heading {
    font-size: clamp(20px, 2.4vw, 26px);
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 10px;
    line-height: 1.35;
}

.banner-desc {
    font-size: 14px;
    line-height: 1.65;
    color: #cbd5e1;
    max-width: 680px;
}

.btn-hotline-pill {
    padding: 12px 24px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    transition: all 0.25s ease;
}

.btn-hotline-pill:hover {
    background: rgba(255, 255, 255, 0.18);
    transform: translateY(-2px);
}

.btn-quote-pill {
    padding: 12px 28px;
    border-radius: 999px;
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.4);
    transition: all 0.25s ease;
}

.btn-quote-pill:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(244, 122, 32, 0.55);
}

/* Pagination */
.search-pagination-wrap .page-numbers {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    margin: 0 4px;
    border-radius: 999px;
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    color: #475569;
    font-size: 14px;
    font-weight: 750;
    text-decoration: none !important;
    transition: all 0.22s ease;
}

.search-pagination-wrap .page-numbers:hover {
    border-color: var(--orange, #f47a20);
    color: var(--orange, #f47a20);
    transform: translateY(-2px);
}

.search-pagination-wrap .page-numbers.current {
    background: var(--orange, #f47a20);
    border-color: var(--orange, #f47a20);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(244, 122, 32, 0.3);
}

/* Responsive */
@media (max-width: 1040px) {
    .search-articles-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .search-articles-grid {
        grid-template-columns: 1fr;
    }
    .search-tab-btn {
        padding: 8px 16px;
        font-size: 13px;
    }
    .search-hero-title {
        font-size: 22px !important;
    }
    .btn-hotline-pill,
    .btn-quote-pill {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Search Tabs Interactive Switcher
    const tabButtons = document.querySelectorAll('.search-tab-btn');
    const tabPanels = document.querySelectorAll('.search-tab-panel');

    function activateTab(targetTabId) {
        tabButtons.forEach(btn => {
            if (btn.dataset.tab === targetTabId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanels.forEach(panel => {
            if (panel.id === targetTabId) {
                panel.classList.remove('d-none');
                panel.classList.add('active');
            } else {
                panel.classList.add('d-none');
                panel.classList.remove('active');
            }
        });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.dataset.tab;
            activateTab(target);
        });
    });

    // Handle URL type parameter on load (e.g. ?type=products or ?type=articles)
    const urlParams = new URLSearchParams(window.location.search);
    const typeParam = urlParams.get('type');
    if (typeParam === 'products') {
        activateTab('tab-products');
    } else if (typeParam === 'articles') {
        activateTab('tab-articles');
    }
});
</script>

<?php
get_footer();
