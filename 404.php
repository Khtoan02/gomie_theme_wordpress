<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Gomie
 */

get_header();
?>

<div id="primary" class="content-area gomie-404-page">
    <main id="main" class="site-main">
        <section class="error-404-section py-5">
            <div class="container text-center">
                <div class="error-badge mb-3">
                    <span class="badge px-3 py-2 rounded-pill" style="background: rgba(199, 92, 44, 0.1); color: #C75C2C; font-weight: 600; font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        <i class="fas fa-compass me-1"></i> Trang Không Tìm Thấy
                    </span>
                </div>

                <div class="error-number-wrap mb-2">
                    <h1 class="display-1 fw-bold text-gradient-gomie" style="font-family: 'Plus Jakarta Sans', var(--font-heading); font-size: clamp(5rem, 12vw, 9rem); letter-spacing: -2px; margin-bottom: 0;">404</h1>
                </div>

                <h2 class="h3 fw-bold text-dark mb-3">
                    <?php esc_html_e('Dường Như Bạn Đã Lạc Đến Một Góc Lò Gốm Trống...', 'gomie-theme'); ?>
                </h2>

                <p class="text-muted mx-auto mb-4" style="max-width: 580px; font-size: 1.05rem; line-height: 1.7;">
                    <?php esc_html_e('Tác phẩm hoặc trang bạn đang tìm kiếm có thể đã được thay đổi đường dẫn, hoàn tất xuất xưởng hoặc không còn tồn tại trên hệ thống.', 'gomie-theme'); ?>
                </p>

                <!-- Search form stylized -->
                <div class="error-search-box mx-auto mb-4" style="max-width: 480px;">
                    <form role="search" method="get" class="search-form-404 position-relative" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="input-group p-1 bg-white rounded-pill shadow-sm border">
                            <input type="search" class="form-control border-0 bg-transparent px-4 py-2" placeholder="<?php echo esc_attr_x('Tìm bát đĩa, dòng men, quà tặng...', 'placeholder', 'gomie-theme'); ?>" value="<?php echo get_search_query(); ?>" name="s" style="box-shadow: none; font-size: 0.95rem;">
                            <input type="hidden" name="post_type" value="product">
                            <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #C75C2C; border-color: #C75C2C;">
                                <i class="fas fa-search me-1"></i> <?php esc_html_e('Tìm', 'gomie-theme'); ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Action buttons -->
                <div class="d-flex justify-content-center gap-3 flex-wrap mb-5">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm" style="background: #C75C2C; border-color: #C75C2C;">
                        <i class="fas fa-home me-2"></i><?php esc_html_e('Về Trang Chủ', 'gomie-theme'); ?>
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold" style="border-color: #d1d5db; color: #4b5563;">
                        <i class="fas fa-arrow-left me-2"></i><?php esc_html_e('Trang Trước Đó', 'gomie-theme'); ?>
                    </button>
                </div>

                <!-- Helpful links cards -->
                <div class="helpful-links-wrap mx-auto" style="max-width: 900px;">
                    <div class="text-uppercase text-muted fw-bold small mb-4" style="letter-spacing: 0.1em;">
                        <?php esc_html_e('Khám Phá Các Khu Vực Nổi Bật', 'gomie-theme'); ?>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-6 col-md-3">
                            <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="card h-100 border-0 shadow-sm rounded-4 p-3 text-decoration-none text-dark bg-white transition-all card-hover-lift">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px; background: rgba(199, 92, 44, 0.1); color: #C75C2C; font-size: 1.25rem;">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="fw-bold" style="font-size: 0.95rem;"><?php esc_html_e('Bộ Sưu Tập Gốm', 'gomie-theme'); ?></div>
                                <small class="text-muted" style="font-size: 0.8rem;"><?php esc_html_e('70+ tác phẩm men', 'gomie-theme'); ?></small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="card h-100 border-0 shadow-sm rounded-4 p-3 text-decoration-none text-dark bg-white transition-all card-hover-lift">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px; background: rgba(15, 23, 42, 0.08); color: #0F172A; font-size: 1.25rem;">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <div class="fw-bold" style="font-size: 0.95rem;"><?php esc_html_e('Sắc Men Độc Bản', 'gomie-theme'); ?></div>
                                <small class="text-muted" style="font-size: 0.8rem;"><?php esc_html_e('Hỏa Biến 1.300°C', 'gomie-theme'); ?></small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?php echo esc_url(home_url('/nha-hang/')); ?>" class="card h-100 border-0 shadow-sm rounded-4 p-3 text-decoration-none text-dark bg-white transition-all card-hover-lift">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.12); color: #D97706; font-size: 1.25rem;">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="fw-bold" style="font-size: 0.95rem;"><?php esc_html_e('Horeca Nhà Hàng', 'gomie-theme'); ?></div>
                                <small class="text-muted" style="font-size: 0.8rem;"><?php esc_html_e('Bát đĩa ẩm thực', 'gomie-theme'); ?></small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="<?php echo esc_url(home_url('/lien-he/')); ?>" class="card h-100 border-0 shadow-sm rounded-4 p-3 text-decoration-none text-dark bg-white transition-all card-hover-lift">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.12); color: #059669; font-size: 1.25rem;">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="fw-bold" style="font-size: 0.95rem;"><?php esc_html_e('Hỗ Trợ & Showroom', 'gomie-theme'); ?></div>
                                <small class="text-muted" style="font-size: 0.8rem;"><?php esc_html_e('Hà Nội & TP.HCM', 'gomie-theme'); ?></small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<style>
.gomie-404-page {
    background: linear-gradient(180deg, #FBF8F5 0%, #FFFFFF 100%);
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
}
.text-gradient-gomie {
    background: linear-gradient(135deg, #0F172A 0%, #C75C2C 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.card-hover-lift {
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.card-hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08) !important;
}
</style>

<?php
get_footer();
