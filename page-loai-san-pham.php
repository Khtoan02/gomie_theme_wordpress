<?php
/**
 * Template Name: Loại Sản Phẩm - Gomie Ceramic
 * Description: Trình bày tất cả các loại sản phẩm phân loại theo danh mục
 *
 * @package Gomie
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

get_header();

// Grouping ceramic categories for clean UX
$category_groups = array(
    'dining' => array(
        'title' => 'Bộ Đồ Ăn & Bàn Bếp',
        'icon'  => 'fa-solid fa-bowl-food',
        'desc'  => 'Các sản phẩm chén đĩa nung 1.300°C khử chì, an toàn cho máy rửa bát và lò vi sóng gia đình.',
        'items' => array(
            'bat-an'      => array('name' => 'Bát ăn', 'desc' => 'Bát cơm gia đình, chén chấm thủ công', 'icon' => 'fa-solid fa-bowl-rice'),
            'bat-to'      => array('name' => 'Bát tô', 'desc' => 'Tô canh, tô súp men hỏa biến & men ngọc', 'icon' => 'fa-solid fa-bowl-food'),
            'dia-an'      => array('name' => 'Đĩa ăn', 'desc' => 'Đĩa tròn, đĩa vuông, đĩa tiệc men mờ sang trọng', 'icon' => 'fa-solid fa-plate-wheat'),
            'khay-gia-vi' => array('name' => 'Khay gia vị', 'desc' => 'Bộ hũ gia vị, khay đựng sốt tinh tế', 'icon' => 'fa-solid fa-jar'),
            'thia'        => array('name' => 'Thìa', 'desc' => 'Thìa gốm sứ tráng men mượt mà', 'icon' => 'fa-solid fa-utensils'),
            'gac-dua'     => array('name' => 'Gác đũa', 'desc' => 'Kê đũa hoa sen, cá chép gốm mỹ nghệ', 'icon' => 'fa-solid fa-grip-lines'),
            'an-uong'     => array('name' => 'Ăn uống', 'desc' => 'Tổng hợp các vật phẩm bàn ăn cao cấp', 'icon' => 'fa-solid fa-champagne-glasses'),
        )
    ),
    'tea' => array(
        'title' => 'Trà Đạo, Cà Phê & Cốc Ly',
        'icon'  => 'fa-solid fa-mug-saucer',
        'desc'  => 'Đánh thức hương vị tinh túy của từng ngụm trà và cà phê qua những tuyệt phẩm gốm Bát Tràng.',
        'items' => array(
            'bo-am-chen'  => array('name' => 'Bộ ấm chén', 'desc' => 'Bộ ấm chén hỏa biến, men rạn cổ, tử sa', 'icon' => 'fa-solid fa-mug-saucer'),
            'am'          => array('name' => 'Ấm', 'desc' => 'Ấm pha trà dáng độc bản, giữ nhiệt lâu', 'icon' => 'fa-solid fa-teapot'),
            'hu-dung-tra' => array('name' => 'Hũ đựng trà', 'desc' => 'Hũ kín khí giữ trọn hương trà thơm', 'icon' => 'fa-solid fa-box-archive'),
            'coc'         => array('name' => 'Cốc', 'desc' => 'Cốc sứ văn phòng, ly dưỡng sinh cao cấp', 'icon' => 'fa-solid fa-mug-hot'),
            'phin-ca-phe' => array('name' => 'Phin cà phê', 'desc' => 'Phin sứ Bát Tràng giữ nhiệt pha cà phê đậm đà', 'icon' => 'fa-solid fa-coffee'),
        )
    ),
    'gifts' => array(
        'title' => 'Bộ Quà Tặng & Doanh Nghiệp',
        'icon'  => 'fa-solid fa-gift',
        'desc'  => 'Quà tặng tân gia, quà sự kiện, set quà ngoại giao in logo thương hiệu chuẩn mực.',
        'items' => array(
            'bo-qua-tang'           => array('name' => 'Bộ quà tặng', 'desc' => 'Hộp quà cao cấp lót lụa sang trọng', 'icon' => 'fa-solid fa-gifts'),
            'qua-tang-doanh-nghiep' => array('name' => 'Quà tặng Doanh Nghiệp', 'desc' => 'In logo, khắc chữ vàng theo yêu cầu số lượng lớn', 'icon' => 'fa-solid fa-briefcase'),
            'qua-tang-ca-nhan'      => array('name' => 'Quà tặng cá nhân', 'desc' => 'Món quà ý nghĩa dành tặng người thân, bạn bè', 'icon' => 'fa-solid fa-heart'),
        )
    ),
    'decor' => array(
        'title' => 'Bình Hoa & Gốm Trang Trí',
        'icon'  => 'fa-solid fa-seedling',
        'desc'  => 'Điểm nhấn nghệ thuật thanh nhã nâng tầm không gian phòng khách, trà thất và văn phòng.',
        'items' => array(
            'lo-hoa'            => array('name' => 'Lọ hoa', 'desc' => 'Bình hoa dáng cổ, lọ hoa hỏa biến nghệ thuật', 'icon' => 'fa-solid fa-seedling'),
            'trang-tri'         => array('name' => 'Trang trí', 'desc' => 'Gốm phong thủy, tượng mỹ nghệ thủ công', 'icon' => 'fa-solid fa-palette'),
            'do-trang-tri-khac' => array('name' => 'Đồ trang trí khác', 'desc' => 'Vật phẩm decor phong cách Zen & hiện đại', 'icon' => 'fa-solid fa-icons'),
        )
    )
);

// Schema.org CollectionPage JSON-LD
$schema_data = array(
    '@context'    => 'https://schema.org',
    '@type'       => 'CollectionPage',
    'name'        => 'Phân Loại Sản Phẩm Gốm Sứ Gomie',
    'description' => 'Trình bày đầy đủ các loại sản phẩm gốm sứ Gomie theo từng nhóm danh mục: Bát ăn, đĩa, bộ ấm chén, ly cốc, quà tặng, lọ hoa.',
    'url'         => home_url('/loai-san-pham/'),
    'publisher'   => array(
        '@type' => 'Organization',
        'name'  => 'Gomie Ceramic',
        'url'   => home_url()
    )
);
?>

<script type="application/ld+json">
<?php echo json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>

<div class="gomie-product-types-page py-5">
    <div class="container">
        
        <!-- Breadcrumb -->
        <nav class="gomie-breadcrumb mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Loại sản phẩm</li>
            </ol>
        </nav>

        <!-- Hero Header -->
        <header class="types-hero-header text-center mb-5">
            <span class="types-eyebrow text-uppercase fw-bold text-secondary letter-spacing-1">
                <i class="fa-solid fa-shapes me-1"></i> Danh Mục Phân Loại Gomie Ceramic
            </span>
            <h1 class="types-title fw-bold text-dark mt-2 mb-3">
                Tất Cả Loại Sản Phẩm Gốm Sứ Thủ Công
            </h1>
            <p class="types-subtitle text-muted mx-auto" style="max-width: 720px;">
                Mỗi tuyệt tác gốm sứ Gomie đều được nung ở 1.300°C khử sạch tạp chất. Chọn theo phân loại dưới đây để tìm đúng kiểu dáng, công năng và phong cách bài trí ưng ý nhất cho gia đình bạn.
            </p>

            <!-- Quick Jump Pills -->
            <div class="types-filter-pills d-flex flex-wrap justify-content-center gap-2 mt-4">
                <a href="#group-dining" class="type-pill-btn"><i class="fa-solid fa-bowl-food me-1"></i> Bộ đồ ăn & Bếp</a>
                <a href="#group-tea" class="type-pill-btn"><i class="fa-solid fa-mug-saucer me-1"></i> Trà đạo & Cốc ly</a>
                <a href="#group-gifts" class="type-pill-btn"><i class="fa-solid fa-gift me-1"></i> Quà tặng doanh nghiệp</a>
                <a href="#group-decor" class="type-pill-btn"><i class="fa-solid fa-seedling me-1"></i> Bình hoa & Trang trí</a>
                <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="type-pill-btn type-pill-highlight"><i class="fa-solid fa-palette me-1"></i> Xem bảng màu men Gomie</a>
            </div>
        </header>

        <!-- Main Category Groups -->
        <div class="category-groups-wrapper">
            <?php foreach ($category_groups as $group_key => $group) : ?>
                <section id="group-<?php echo esc_attr($group_key); ?>" class="category-group-section mb-5">
                    
                    <!-- Group Header -->
                    <div class="group-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 pb-2 border-bottom border-light-subtle">
                        <div class="d-flex align-items-center gap-3">
                            <div class="group-icon-box text-secondary fs-3">
                                <i class="<?php echo esc_attr($group['icon']); ?>"></i>
                            </div>
                            <div>
                                <h2 class="group-title fs-3 fw-bold text-dark mb-1"><?php echo esc_html($group['title']); ?></h2>
                                <p class="group-desc text-muted small mb-0"><?php echo esc_html($group['desc']); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Category Cards Grid -->
                    <div class="row g-3 g-md-4">
                        <?php foreach ($group['items'] as $cat_slug => $cat_data) :
                            $term = get_term_by('slug', $cat_slug, 'product_cat');
                            $cat_url = $term ? get_term_link($term) : home_url('/san-pham-2/?category=' . $cat_slug);
                            $product_count = $term ? $term->count : 0;
                        ?>
                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                <a href="<?php echo esc_url($cat_url); ?>" class="category-item-card d-block p-4 rounded-4 bg-white border border-light-subtle h-100 text-decoration-none">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="cat-icon-circle text-primary">
                                            <i class="<?php echo esc_attr($cat_data['icon']); ?>"></i>
                                        </div>
                                        <span class="cat-count-badge small text-muted">
                                            <?php echo $product_count > 0 ? $product_count . ' sản phẩm' : 'Đang cập nhật'; ?>
                                        </span>
                                    </div>
                                    <h4 class="cat-item-title fw-bold text-dark mb-1"><?php echo esc_html($cat_data['name']); ?></h4>
                                    <p class="cat-item-desc small text-muted mb-3"><?php echo esc_html($cat_data['desc']); ?></p>
                                    <span class="cat-explore-btn small fw-bold text-secondary">
                                        Xem chi tiết <i class="fa-solid fa-arrow-right ms-1"></i>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </section>
            <?php endforeach; ?>
        </div>

        <!-- Featured Products Preview Section -->
        <section class="types-products-preview my-5 pt-4 border-top border-light-subtle">
            <div class="text-center mb-4">
                <span class="text-uppercase small fw-bold text-secondary letter-spacing-1">Sản Phẩm Tiêu Biểu</span>
                <h3 class="fs-2 fw-bold text-dark mt-1">Gợi Ý Sản Phẩm Gomie Được Yêu Thích Nhất</h3>
                <div class="divider-line mx-auto" style="width: 48px; height: 3px; background: #ef661a; border-radius: 2px; margin-top: 10px;"></div>
            </div>

            <div class="row g-3 g-md-4 justify-content-center">
                <?php
                $featured_query = new WP_Query(array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ));

                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                        $p = wc_get_product(get_the_ID());
                        if (!$p) continue;
                        echo '<div class="col-6 col-md-4 col-lg-3">';
                        gomie_render_product_card($p);
                        echo '</div>';
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo esc_url(home_url('/san-pham-2/')); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold">
                    Xem Tất Cả Sản Phẩm Gomie <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>
        </section>

        <!-- Glaze Teaser Banner -->
        <section class="glaze-teaser-card p-4 p-md-5 rounded-4 text-white text-center mt-5" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <span class="text-uppercase small text-warning fw-bold letter-spacing-1 d-block mb-2">Đặc Quyền Chế Tác Gomie</span>
            <h3 class="fw-bold mb-3">Khám Phá Nghệ Thuật 9 Sắc Men Độc Bản Bát Tràng</h3>
            <p class="text-white-50 mx-auto mb-4" style="max-width: 600px;">
                Từ Men Xanh Thiên Thanh, Men Hỏa Biến Sapphire đến Men Cánh Gián, Men Gấm Vàng – Từng sắc men là vũ khúc kỳ diệu của đất, nước và ngọn lửa 1.300°C.
            </p>
            <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">
                <i class="fa-solid fa-palette me-2"></i> Khám Phá Trang Màu Men
            </a>
        </section>

    </div>
</div>

<?php
get_footer();
