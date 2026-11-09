<?php
/**
 * The template for displaying the blog / sharing archive page (Góc Chia Sẻ)
 *
 * @package Gomie
 */

get_header();

// Get categories for filter tabs
$categories = get_categories(array(
    'taxonomy'   => 'category',
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
));
$total_posts_count = wp_count_posts('post')->publish;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<div class="gomie-sharing-page-canvas">
    
    <!-- 1. Breadcrumbs Bar -->
    <div class="gomie-sharing-breadcrumbs">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house-chimney me-1"></i> Trang chủ</a>
            <span class="separator">/</span>
            <span class="current">Góc Chia Sẻ</span>
        </div>
    </div>

    <!-- 2. Hero Section -->
    <section class="gomie-sharing-hero">
        <div class="container">
            <span class="badge-pill">
                <i class="fa-solid fa-feather-pointed"></i> GOMIE CERAMIC · GÓC CHIA SẺ &amp; CẢM HỨNG
            </span>
            <h1 class="hero-title">
                Nghệ Thuật Sống &amp; Tri Kỷ Cùng <span class="highlight">Gốm Thủ Công</span>
            </h1>
            <p class="hero-subtitle">
                Khám phá những câu chuyện từ bàn xoay gốm Bát Tràng hơn 500 năm tuổi, cẩm nang phối sắc men bàn tiệc đương đại, và những góc nhìn nghệ thuật ẩm thực tinh tuyển từ Gomie.
            </p>

            <!-- Category Filter Pills -->
            <div class="gomie-filter-pills">
                <a href="<?php echo esc_url(home_url('/chia-se/')); ?>" class="filter-pill active">
                    <i class="fa-solid fa-layer-group me-2"></i> Tất cả bài viết
                    <span class="count">(<?php echo esc_html($total_posts_count); ?>)</span>
                </a>
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $cat) : ?>
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="filter-pill">
                            <?php echo esc_html($cat->name); ?>
                            <span class="count">(<?php echo esc_html($cat->count); ?>)</span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="container">
        <?php if (have_posts()) : ?>

            <?php
            // If on the first page, highlight the first post as a large Spotlight Bento card
            $post_index = 0;
            if ($paged === 1) :
                the_post();
                $post_index++;
                $spotlight_id = get_the_ID();
                $spotlight_thumb = function_exists('gomie_get_post_thumbnail_src') ? gomie_get_post_thumbnail_src($spotlight_id, 'full') : get_the_post_thumbnail_url($spotlight_id, 'full');
                $spotlight_reading_time = function_exists('gomie_get_reading_time') ? gomie_get_reading_time($spotlight_id) : '4 phút đọc';
                $cats = get_the_category();
                $cat_name = !empty($cats) ? $cats[0]->name : 'Cẩm nang gốm sứ';
                $cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : '#';
                ?>
                <!-- 3. Spotlight / Featured Post Bento Card -->
                <div class="gomie-spotlight-wrapper">
                    <article class="gomie-spotlight-card">
                        <div class="gomie-spotlight-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url($spotlight_thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            </a>
                            <div class="gomie-spotlight-badges">
                                <span class="badge-featured"><i class="fa-solid fa-star me-1"></i> Tiêu điểm</span>
                                <a href="<?php echo esc_url($cat_link); ?>" class="badge-category"><?php echo esc_html($cat_name); ?></a>
                            </div>
                        </div>
                        <div class="gomie-spotlight-content">
                            <div class="gomie-spotlight-meta">
                                <span><i class="fa-regular fa-calendar-days me-1"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                                <span><i class="fa-regular fa-clock me-1"></i> <?php echo esc_html($spotlight_reading_time); ?></span>
                            </div>
                            <h2 class="gomie-spotlight-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="gomie-spotlight-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 38, '...'); ?>
                            </div>
                            <div class="gomie-spotlight-footer">
                                <div class="gomie-spotlight-author">
                                    <div class="avatar-icon"><i class="fa-solid fa-feather"></i></div>
                                    <div>
                                        <div class="author-name">Gomie Ceramic</div>
                                        <span class="author-role">Biên tập văn hóa Bát Tràng</span>
                                    </div>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn-spotlight-read">
                                    <span>Đọc chi tiết</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endif; ?>

            <!-- 4. Section Heading for All Articles -->
            <div class="gomie-section-heading-row">
                <h2 class="section-title">
                    <i class="fa-solid fa-book-open-reader text-danger me-2"></i> 
                    <?php echo ($paged === 1) ? 'Các bài viết mới nhất' : 'Trang ' . esc_html($paged); ?>
                </h2>
                <span class="posts-count">Trang <?php echo esc_html($paged); ?> / <?php echo esc_html($wp_query->max_num_pages); ?></span>
            </div>

            <!-- 5. Articles Grid -->
            <div class="gomie-sharing-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    $p_id = get_the_ID();
                    $thumb_src = function_exists('gomie_get_post_thumbnail_src') ? gomie_get_post_thumbnail_src($p_id, 'full') : get_the_post_thumbnail_url($p_id, 'full');
                    $reading_time = function_exists('gomie_get_reading_time') ? gomie_get_reading_time($p_id) : '3 phút đọc';
                    $post_cats = get_the_category();
                    $p_cat_name = !empty($post_cats) ? $post_cats[0]->name : 'Gốm sứ';
                    $p_cat_link = !empty($post_cats) ? get_category_link($post_cats[0]->term_id) : '#';
                    ?>
                    <article class="gomie-post-card">
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
                <?php endwhile; ?>
            </div>

            <!-- 6. Pagination -->
            <?php
            $pagination = paginate_links(array(
                'total'        => $wp_query->max_num_pages,
                'current'      => $paged,
                'prev_text'    => '<i class="fa-solid fa-chevron-left"></i>',
                'next_text'    => '<i class="fa-solid fa-chevron-right"></i>',
                'type'         => 'plain',
            ));
            if (!empty($pagination)) :
                ?>
                <div class="gomie-sharing-pagination">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <div class="text-center py-5 bg-white rounded-4 shadow-sm my-5 p-4">
                <i class="fa-solid fa-feather display-4 text-muted mb-3"></i>
                <h3>Chưa có bài viết nào</h3>
                <p class="text-muted">Các câu chuyện và cẩm nang mới đang được nghệ nhân Gomie biên soạn.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary mt-2">Về trang chủ</a>
            </div>
        <?php endif; ?>

        <!-- 7. Bottom Inspiration & B2B Consultation Banner -->
        <section class="gomie-sharing-bottom-banner">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <span class="banner-badge">
                        <i class="fa-solid fa-hand-holding-heart me-1"></i> ĐỒNG HÀNH CÙNG KHÔNG GIAN SỐNG &amp; ẨM THỰC
                    </span>
                    <h2 class="banner-title">
                        Kiến Tạo Dấu Ấn Riêng Cho Nhà Hàng, Resort &amp; Doanh Nghiệp
                    </h2>
                    <p class="banner-desc">
                        Gomie không chỉ sẻ chia nghệ thuật gốm, mà còn trực tiếp đồng hành chế tác bộ bát đĩa bàn tiệc theo nhận diện riêng, quà tặng tri ân in logo và giải pháp amenities gốm mộc bền vững nung khử 1.300°C.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="banner-actions justify-content-lg-end">
                        <a href="<?php echo esc_url(home_url('/nha-hang/')); ?>" class="btn-banner-primary">
                            <i class="fa-solid fa-utensils"></i> Giải pháp B2B
                        </a>
                        <a href="tel:0335059889" class="btn-banner-secondary">
                            <i class="fa-solid fa-phone"></i> 0335 059 889
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- .container -->

</div><!-- .gomie-sharing-page-canvas -->

<?php
get_footer();
