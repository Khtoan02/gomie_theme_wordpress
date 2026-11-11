<?php
/**
 * The template for displaying all single posts in Gomie Ceramic Editorial V11 style.
 * 2-Column High-End Editorial Layout: Content (Left) + Multi-Widget Sticky Sidebar (Right).
 *
 * @package Gomie
 */

get_header();
?>

<main id="primary" class="site-main gomie-single-article">
  <!-- Reading Progress Bar -->
  <div id="readingProgressBar" class="reading-progress-bar"></div>

  <div class="gomie-v11">

    <?php while (have_posts()) : the_post();
      gomie_set_post_views();
      $custom_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
      $article_tag = !empty($custom_tag) ? $custom_tag : 'GOMIE CERAMIC · CẨM NANG GỐM SỨ';
      
      // Determine article hero image
      $custom_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
      $hero_img_url = '';
      if (!empty($custom_img)) {
        $hero_img_url = esc_url(get_template_directory_uri() . '/assets/images/stories/' . $custom_img);
      } elseif (has_post_thumbnail()) {
        $hero_img_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
      } else {
        $hero_img_url = esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg');
      }
    ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class('editorial-single-entry'); ?>>

        <!-- Main Two-Column Editorial Canvas (Content Left + Sidebar Right) -->
        <div class="gomie-single-article-container">
          <div class="article-layout-grid">

            <!-- LEFT COLUMN: Main Post Content & Discussion -->
            <div class="article-main-content">

              <!-- 1. Editorial Header (Breadcrumbs, Tag, Headline & Meta Row) -->
              <header class="article-header">
                <nav class="article-breadcrumbs" aria-label="Breadcrumb">
                  <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
                  <span class="sep">/</span>
                  <a href="<?php echo esc_url(home_url('/chia-se/')); ?>">Góc chia sẻ</a>
                  <span class="sep">/</span>
                  <span class="current"><?php the_title(); ?></span>
                </nav>

                <div class="article-tag-badge">
                  <span><?php echo esc_html($article_tag); ?></span>
                </div>

                <h1 class="article-headline"><?php the_title(); ?></h1>

                <div class="article-meta-row">
                  <div class="meta-author">
                    <span class="author-avatar-seal">G</span>
                    <div>
                      <span class="author-name">Gomie Art Studio</span>
                      <span class="author-role">Nghệ nhân Bát Tràng</span>
                    </div>
                  </div>
                  <div class="meta-divider"></div>
                  <div class="meta-item">
                    <span class="meta-label">Ngày xuất bản</span>
                    <span class="meta-val"><?php echo get_the_date('d/m/Y'); ?></span>
                  </div>
                  <div class="meta-divider"></div>
                  <div class="meta-item">
                    <span class="meta-label">Thời gian đọc</span>
                    <span class="meta-val"><?php echo gomie_reading_time(); ?></span>
                  </div>
                  <div class="meta-divider"></div>
                  <div class="meta-item">
                    <span class="meta-label">Lượt xem</span>
                    <span class="meta-val"><?php echo number_format(gomie_get_post_views(get_the_ID()), 0, ',', '.'); ?> view</span>
                  </div>
                </div>
              </header>

              <!-- Hero Featured Photography -->
              <?php if (!empty($hero_img_url)) : ?>
                <div class="article-hero-media">
                  <div class="hero-image-stage">
                    <img src="<?php echo $hero_img_url; ?>" alt="<?php the_title_attribute(); ?>" />
                    <div class="hero-image-watermark">Gomie Ceramic · Bát Tràng</div>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Mobile Table of Contents (visible only on screens <= 1040px) -->
              <div id="mobileTOCBox" class="mobile-toc-accordion d-none">
                <button type="button" class="btn-toggle-mobile-toc" id="btnToggleMobileTOC" aria-expanded="false">
                  <span><i class="fa-solid fa-list-ul me-2" style="color: var(--orange, #f47a20);"></i> Mục lục bài viết</span>
                  <i class="fa-solid fa-chevron-down chevron-icon"></i>
                </button>
                <div class="mobile-toc-content d-none" id="mobileTocContent">
                  <ul class="mobile-toc-list" id="mobileTocList"></ul>
                </div>
              </div>

              <!-- Article Core Body -->
              <div class="article-body-wrapper">
                <?php if (has_excerpt()) : ?>
                  <div class="article-lead-paragraph">
                    <?php echo get_the_excerpt(); ?>
                  </div>
                <?php endif; ?>

                <div class="article-rich-text">
                  <?php the_content(); ?>
                </div>

                <!-- Tags & Social Share Toolbar -->
                <footer class="article-footer-toolbar">
                  <div class="article-tags-cluster">
                    <span class="tags-title">Chủ đề:</span>
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                      foreach ($tags as $tag) {
                        echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-pill">' . esc_html($tag->name) . '</a>';
                      }
                    } else {
                      echo '<span class="tag-pill">Gốm Bát Tràng</span><span class="tag-pill">Nghệ thuật Sắc Men</span><span class="tag-pill">Bàn Tiệc Đương Đại</span>';
                    }
                    ?>
                  </div>

                  <div class="article-share-strip">
                    <span class="share-title">Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Chia sẻ lên Facebook" title="Chia sẻ lên Facebook">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Chia sẻ lên Twitter" title="Chia sẻ lên Twitter">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <button type="button" class="share-btn copy-url-btn" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã sao chép liên kết bài viết!');" aria-label="Sao chép link" title="Sao chép liên kết">
                      <i class="fas fa-link"></i>
                    </button>
                  </div>
                </footer>

                <!-- Author Bio Card -->
                <div class="article-author-card">
                  <div class="author-badge-large">G</div>
                  <div class="author-details">
                    <h4>Gomie Ceramic · Heart of Craftsmanship</h4>
                    <p>
                      Được nuôi dưỡng từ làng gốm Bát Tràng hơn 500 năm tuổi, Gomie kết hợp kỹ nghệ vuốt nặn truyền thống với thiết kế đương đại và chuẩn an toàn quốc tế HoReCa nung ở 1.300°C.
                    </p>
                    <a href="<?php echo esc_url(home_url('/cau-chuyen/')); ?>" class="author-more-link">Đọc câu chuyện thương hiệu Gomie →</a>
                  </div>
                </div>

              </div><!-- /.article-body-wrapper -->

              <!-- Comments Section -->
              <?php if (comments_open() || get_comments_number()) : ?>
                <section class="article-comments-section">
                  <div class="comments-card-box">
                    <?php comments_template(); ?>
                  </div>
                </section>
              <?php endif; ?>

            </div><!-- /.article-main-content -->

            <!-- RIGHT COLUMN: Sticky Multi-Widget Editorial Sidebar -->
            <aside class="article-sidebar-widget">
              <div class="sidebar-sticky-inner">

                <!-- Widget 1: Mục Lục Bài Viết (Table of Contents) -->
                <div id="sidebarTOCWidget" class="editorial-widget-card toc-widget d-none">
                  <div class="widget-header">
                    <h3 class="widget-title">
                      <i class="fa-solid fa-list-ul"></i> Mục lục bài viết
                    </h3>
                    <button type="button" class="btn-toggle-toc" id="btnToggleTOC" aria-expanded="true" title="Thu gọn/Mở rộng">
                      <i class="fa-solid fa-chevron-up"></i>
                    </button>
                  </div>
                  <div class="widget-body" id="tocListWrap">
                    <ul class="sidebar-toc-list" id="sidebarTocList">
                      <!-- Dynamically populated from H2, H3 with ScrollSpy -->
                    </ul>
                  </div>
                </div>

                <!-- Widget 2: Tác Phẩm Gốm Sứ Đề Xuất (Sản phẩm nổi bật / liên quan) -->
                <div class="editorial-widget-card products-widget">
                  <div class="widget-header">
                    <h3 class="widget-title">
                      <i class="fa-solid fa-fire"></i> Tác phẩm gốm sứ
                    </h3>
                    <span class="widget-badge">Chế tác thủ công</span>
                  </div>
                  <div class="widget-body">
                    <div class="sidebar-products-list">
                      <?php
                      // Query 3 authentic ceramic WooCommerce products
                      $ceramic_cats = array('bat-an', 'bat-dia', 'bat-to', 'bo-am-chen', 'am-chen', 'bo-qua-tang', 'dia-an', 'khach-san', 'nha-hang', 'qua-tang', 'an-uong');
                      $prod_query = new WP_Query(array(
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => 3,
                        'orderby'        => 'rand',
                        'tax_query'      => array(
                          array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => $ceramic_cats,
                            'operator' => 'IN',
                          )
                        )
                      ));
                      if (!$prod_query->have_posts()) {
                        $prod_query = new WP_Query(array(
                          'post_type'      => 'product',
                          'post_status'    => 'publish',
                          'posts_per_page' => 3,
                          'orderby'        => 'date',
                          'order'          => 'DESC',
                        ));
                      }
                      if ($prod_query->have_posts()) :
                        while ($prod_query->have_posts()) : $prod_query->the_post();
                          $prod = wc_get_product(get_the_ID());
                          if (!$prod) continue;
                          $p_img = wp_get_attachment_image_url($prod->get_image_id(), 'medium');
                          if (!$p_img) {
                            $p_img = esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg');
                          }
                      ?>
                        <a href="<?php the_permalink(); ?>" class="sidebar-product-item">
                          <div class="prod-thumb">
                            <img src="<?php echo esc_url($p_img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                          </div>
                          <div class="prod-info">
                            <h4 class="prod-title"><?php the_title(); ?></h4>
                            <div class="prod-price"><?php echo $prod->get_price_html(); ?></div>
                            <span class="prod-cta">Xem chi tiết <i class="fa-solid fa-arrow-right"></i></span>
                          </div>
                        </a>
                      <?php
                        endwhile;
                        wp_reset_postdata();
                      else :
                      ?>
                        <p class="text-muted small">Đang cập nhật sản phẩm nổi bật...</p>
                      <?php endif; ?>
                    </div>
                    <div class="widget-footer-action">
                      <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-widget-more">
                        Khám phá toàn bộ sưu tập <i class="fa-solid fa-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Widget 3: Bài Viết Cùng Chuyên Mục (Bài viết liên quan) -->
                <div class="editorial-widget-card articles-widget">
                  <div class="widget-header">
                    <h3 class="widget-title">
                      <i class="fa-solid fa-newspaper"></i> Bài viết liên quan
                    </h3>
                    <span class="widget-badge">Góc chia sẻ</span>
                  </div>
                  <div class="widget-body">
                    <div class="sidebar-articles-list">
                      <?php
                      // Query 3 related posts (excluding current)
                      $cat_ids = wp_get_post_categories(get_the_ID());
                      $rel_args = array(
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'posts_per_page' => 3,
                        'post__not_in'   => array(get_the_ID()),
                      );
                      if (!empty($cat_ids)) {
                        $rel_args['category__in'] = $cat_ids;
                      }
                      $sidebar_rel = new WP_Query($rel_args);
                      if (!$sidebar_rel->have_posts()) {
                        unset($rel_args['category__in']);
                        $sidebar_rel = new WP_Query($rel_args);
                      }
                      if ($sidebar_rel->have_posts()) :
                        while ($sidebar_rel->have_posts()) : $sidebar_rel->the_post();
                          $rel_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                          if (!$rel_thumb) {
                            $custom_rel_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
                            $rel_thumb = !empty($custom_rel_img) ? esc_url(get_template_directory_uri() . '/assets/images/stories/' . $custom_rel_img) : esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg');
                          }
                      ?>
                        <a href="<?php the_permalink(); ?>" class="sidebar-article-item">
                          <div class="art-thumb">
                            <img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                          </div>
                          <div class="art-info">
                            <h4 class="art-title"><?php the_title(); ?></h4>
                            <div class="art-meta">
                              <span><i class="fa-regular fa-calendar-days"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                              <span class="dot-sep">·</span>
                              <span><?php echo gomie_reading_time(); ?></span>
                            </div>
                          </div>
                        </a>
                      <?php
                        endwhile;
                        wp_reset_postdata();
                      else :
                      ?>
                        <p class="text-muted small">Đang cập nhật bài viết liên quan...</p>
                      <?php endif; ?>
                    </div>
                    <div class="widget-footer-action">
                      <a href="<?php echo esc_url(home_url('/chia-se/')); ?>" class="btn-widget-more">
                        Xem tất cả góc chia sẻ <i class="fa-solid fa-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Widget 4: Box Tư Vấn Dự Án & Quà Tặng Doanh Nghiệp (HoReCa / B2B) -->
                <div class="editorial-widget-card consult-widget">
                  <div class="consult-widget-inner">
                    <div class="consult-badge">HoReCa & B2B</div>
                    <h4 class="consult-title">Tư vấn chế tác gốm sứ độc bản</h4>
                    <p class="consult-desc">
                      Cung ứng trọn gói chén đĩa cho nhà hàng, khách sạn & quà tặng doanh nghiệp in logo nung bền vĩnh cửu 1.300°C.
                    </p>
                    <div class="consult-hotline-strip">
                      <span class="hotline-label">Hotline tư vấn dự án:</span>
                      <a href="tel:0335059889" class="hotline-number">
                        <i class="fa-solid fa-phone-volume"></i> 0335 059 889
                      </a>
                    </div>
                    <a href="<?php echo esc_url(home_url('/bao-gia/')); ?>" class="btn-consult-quote">
                      Nhận báo giá dự án <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>

              </div><!-- /.sidebar-sticky-inner -->
            </aside><!-- /.article-sidebar-widget -->

          </div><!-- /.article-layout-grid -->
        </div><!-- /.gomie-single-article-container -->

      </article>

    <?php endwhile; ?>

  </div>
</main>

<style id="gomie-single-article-css">
  /* CSS Single Post - Gomie Ceramic Editorial V11 2-Column Standard */
  .gomie-single-article {
    width: 100%;
    margin: 0;
    padding: 0;
    background-color: #fffdf9 !important;
    background-image: none !important;
    overflow-x: hidden !important;
  }

  .gomie-single-article .gomie-v11 {
    background-color: #fffdf9 !important;
    background-image: none !important;
    min-height: 100vh;
    padding-bottom: 90px;
    overflow-x: hidden !important;
  }

  /* Full Website Container Width (matches 1280px-1320px website standard) */
  .gomie-single-article-container {
    max-width: 1280px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: clamp(16px, 2.5vw, 32px) !important;
    padding-right: clamp(16px, 2.5vw, 32px) !important;
    box-sizing: border-box !important;
  }

  /* 1. Article Header */
  .article-header {
    padding-top: clamp(24px, 3.5vw, 42px);
    padding-bottom: clamp(20px, 3vw, 32px);
    text-align: left;
    width: 100%;
    box-sizing: border-box;
  }

  .article-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #7b8893;
    margin-bottom: 18px;
    flex-wrap: wrap;
    justify-content: flex-start;
    max-width: 100%;
    word-break: break-word;
  }

  .article-breadcrumbs a {
    color: #63707c !important;
    text-decoration: none !important;
    transition: color .2s;
  }

  .article-breadcrumbs a:hover {
    color: var(--orange, #f47a20) !important;
  }

  .article-breadcrumbs .sep {
    color: #b0bac3;
  }

  .article-breadcrumbs .current {
    color: #2b3640;
    font-weight: 600;
    max-width: 100%;
    word-break: break-word;
  }

  .article-tag-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .95);
    border: 1px solid rgba(235, 222, 206, .9);
    box-shadow: 0 4px 12px rgba(45, 30, 15, .04);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--orange-deep, #db6109);
    margin-bottom: 18px;
    max-width: 100%;
    box-sizing: border-box;
    word-break: break-word;
  }

  .article-headline {
    font-size: clamp(24px, 3vw, 38px) !important;
    font-weight: 800 !important;
    line-height: 1.3 !important;
    letter-spacing: -.02em !important;
    color: #1e2830 !important;
    margin: 0 0 20px 0 !important;
    max-width: 100%;
    width: 100%;
    text-align: left;
    word-break: break-word;
    box-sizing: border-box;
  }

  .article-meta-row {
    display: inline-flex;
    align-items: center;
    justify-content: flex-start;
    gap: 16px;
    flex-wrap: wrap;
    padding: 8px 20px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .85);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(238, 228, 214, .85);
    box-shadow: 0 4px 14px rgba(45, 30, 15, .03);
    max-width: 100%;
    box-sizing: border-box;
  }

  .meta-author {
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
  }

  .author-avatar-seal {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff;
    font-weight: 850;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(244, 122, 32, .3);
  }

  .author-name {
    display: block;
    font-size: 13px;
    font-weight: 750;
    color: #252e35;
    line-height: 1.2;
  }

  .author-role {
    display: block;
    font-size: 11px;
    color: #7b8893;
    line-height: 1.2;
  }

  .meta-divider {
    width: 1px;
    height: 24px;
    background: rgba(45, 30, 15, .12);
  }

  .meta-item {
    text-align: left;
  }

  .meta-label {
    display: block;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #8c97a0;
    line-height: 1.2;
  }

  .meta-val {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #3b464f;
    line-height: 1.2;
  }

  /* 2. Main Two-Column Layout Grid */
  .article-layout-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: clamp(28px, 3.2vw, 44px);
    align-items: start;
    margin-top: 10px;
  }

  .article-main-content {
    min-width: 0;
    width: 100%;
  }

  /* Reading Progress Bar */
  .reading-progress-bar {
    position: fixed;
    top: 0;
    left: 0;
    height: 3.5px;
    width: 0%;
    background: linear-gradient(90deg, #e0592a 0%, #f59e0b 50%, #e0592a 100%);
    z-index: 999999;
    transition: width 0.1s ease-out;
    box-shadow: 0 1px 6px rgba(224, 89, 42, 0.4);
  }

  /* Hero Media */
  .article-hero-media {
    margin-bottom: 28px;
  }

  .hero-image-stage {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(45, 30, 15, .08);
    border: 1px solid rgba(255, 255, 255, .95);
    background: #f2eee8;
  }

  .hero-image-stage img {
    display: block;
    width: 100%;
    aspect-ratio: 16 / 9;
    max-height: 480px;
    object-fit: cover;
    object-position: center;
    image-rendering: -webkit-optimize-contrast;
  }

  .hero-image-watermark {
    position: absolute;
    bottom: 18px;
    right: 22px;
    background: rgba(0, 0, 0, .48);
    backdrop-filter: blur(8px);
    color: rgba(255, 255, 255, .92);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 999px;
  }

  /* Mobile TOC Accordion */
  .mobile-toc-accordion {
    background: #ffffff;
    border: 1px solid rgba(235, 222, 206, 0.9);
    border-radius: 16px;
    padding: 12px 18px;
    margin-bottom: 24px;
    box-shadow: 0 4px 16px rgba(45, 30, 15, 0.04);
  }
  .btn-toggle-mobile-toc {
    width: 100%;
    background: none;
    border: none;
    padding: 6px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 750;
    color: #1e2830;
    cursor: pointer;
  }
  .mobile-toc-content {
    padding-top: 12px;
    margin-top: 8px;
    border-top: 1px dashed rgba(235, 222, 206, 0.85);
  }
  .mobile-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .mobile-toc-list li a {
    color: #4a5568;
    text-decoration: none;
    font-size: 13.5px;
    line-height: 1.5;
    display: flex;
    align-items: baseline;
    gap: 8px;
  }
  .mobile-toc-list li a:hover {
    color: var(--orange, #f47a20);
  }

  /* Core Body Content Box */
  .article-body-wrapper {
    background: rgba(255, 255, 255, .98);
    backdrop-filter: blur(18px);
    border-radius: 26px;
    border: 1px solid rgba(235, 222, 206, .7);
    box-shadow: 0 16px 42px rgba(45, 30, 15, .05);
    padding: clamp(28px, 4.2vw, 56px) clamp(22px, 3.8vw, 48px);
    margin-bottom: 40px;
    overflow: hidden !important;
    box-sizing: border-box !important;
    width: 100% !important;
  }

  .article-lead-paragraph {
    font-size: clamp(17px, 1.8vw, 19.5px);
    line-height: 1.85;
    color: #2b3640;
    font-weight: 500;
    font-style: italic;
    border-left: 4px solid var(--orange, #f47a20);
    padding-left: 22px;
    margin-bottom: 34px;
  }

  .article-rich-text {
    font-size: 16px;
    line-height: 1.95;
    color: #48545e;
    max-width: 100% !important;
    width: 100% !important;
    box-sizing: border-box !important;
    overflow-wrap: break-word !important;
    word-break: normal !important;
  }

  /* Drop Cap for first paragraph */
  .article-rich-text > p:first-of-type::first-letter {
    float: left;
    font-size: 2.75rem;
    line-height: 0.85;
    font-weight: 700;
    color: var(--orange, #f47a20);
    padding-top: 3px;
    padding-right: 10px;
    padding-bottom: 2px;
    font-family: inherit;
  }

  .article-rich-text p {
    font-size: 15.5px;
    line-height: 1.82;
    color: #4b5563;
    margin-bottom: 20px;
  }

  .article-rich-text strong {
    color: #1e2830;
    font-weight: 650;
  }

  .article-rich-text h2,
  .article-rich-text h3,
  .article-rich-text h4 {
    color: #1e2830;
    letter-spacing: -.015em;
    line-height: 1.4;
    scroll-margin-top: 100px;
  }

  .article-rich-text h2 {
    font-size: clamp(20px, 2.1vw, 24px) !important;
    font-weight: 750 !important;
    margin-top: 40px !important;
    margin-bottom: 16px !important;
    padding-left: 12px;
    border-left: 3.5px solid var(--orange, #f47a20);
    position: relative;
  }

  .article-rich-text h3 {
    font-size: clamp(16.5px, 1.7vw, 19px) !important;
    font-weight: 650 !important;
    margin-top: 28px !important;
    margin-bottom: 12px !important;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .article-rich-text h3::before {
    content: '';
    display: inline-block;
    width: 7px;
    height: 7px;
    background: var(--orange, #f47a20);
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* Robust Gutenberg Images Layout */
  .article-rich-text figure,
  .article-rich-text .wp-block-image,
  .article-rich-text figure.wp-block-image,
  .article-rich-text .wp-block-image figure {
    display: block !important;
    max-width: 100% !important;
    width: 100% !important;
    margin: 32px auto 24px auto !important;
    padding: 0 !important;
    box-sizing: border-box !important;
    float: none !important;
    clear: both !important;
  }

  .article-rich-text img,
  .article-rich-text figure img,
  .article-rich-text .wp-block-image img,
  .article-rich-text p img {
    display: block !important;
    max-width: 100% !important;
    width: 100% !important;
    height: auto !important;
    margin: 0 auto !important;
    border-radius: 18px !important;
    box-shadow: 0 12px 32px rgba(45, 30, 15, 0.08) !important;
    border: 1px solid rgba(235, 222, 206, 0.9) !important;
    box-sizing: border-box !important;
    object-fit: cover !important;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .article-rich-text img:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 40px rgba(45, 30, 15, 0.12) !important;
  }

  .article-rich-text figcaption,
  .article-rich-text .wp-element-caption {
    display: block !important;
    font-size: 13px !important;
    line-height: 1.6 !important;
    color: #7b8893 !important;
    text-align: center !important;
    margin-top: 10px !important;
    font-style: italic !important;
  }

  /* Blockquote */
  .article-rich-text blockquote {
    margin: 32px 0;
    padding: 22px 28px;
    background: #faf6f0;
    border-left: 4px solid var(--orange, #f47a20);
    border-radius: 0 18px 18px 0;
    font-style: italic;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #2b3640;
    box-shadow: 0 4px 16px rgba(45, 30, 15, 0.03);
  }

  /* Lists inside article */
  .article-rich-text ul {
    list-style: none;
    padding-left: 0;
    margin: 18px 0 26px 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .article-rich-text ul li {
    position: relative;
    padding-left: 28px;
    line-height: 1.78;
    color: #3f4a54;
  }
  .article-rich-text ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 2px;
    width: 18px;
    height: 18px;
    background: rgba(224, 89, 42, 0.12);
    color: var(--orange, #f47a20);
    border-radius: 50%;
    font-size: 11px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  /* Toolbar */
  .article-footer-toolbar {
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid rgba(235, 222, 206, .85);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    flex-wrap: wrap;
  }

  .article-tags-cluster {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .tags-title,
  .share-title {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #7b8893;
  }

  .tag-pill {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 999px;
    background: #fdf6ed;
    border: 1px solid rgba(244, 122, 32, .2);
    color: var(--orange-deep, #db6109) !important;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .tag-pill:hover {
    background: var(--orange, #f47a20);
    color: #ffffff !important;
    transform: translateY(-2px);
  }

  .article-share-strip {
    display: flex;
    align-items: center;
    gap: 9px;
  }

  .share-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f7f3ee;
    border: 1px solid rgba(226, 214, 198, .85);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #4b5862;
    text-decoration: none !important;
    cursor: pointer;
    transition: all .25s ease;
  }

  .share-btn:hover {
    background: var(--orange, #f47a20);
    border-color: var(--orange, #f47a20);
    color: #ffffff;
    transform: translateY(-2px);
  }

  /* Author Card */
  .article-author-card {
    display: flex;
    align-items: center;
    gap: 22px;
    margin-top: 36px;
    padding: 24px 28px;
    background: #faf6f0;
    border-radius: 20px;
    border: 1px solid rgba(235, 222, 206, .9);
  }

  .author-badge-large {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff;
    font-size: 26px;
    font-weight: 850;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(244, 122, 32, .3);
  }

  .author-details h4 {
    font-size: 17px;
    font-weight: 800;
    color: #1e2830;
    margin: 0 0 6px;
  }

  .author-details p {
    font-size: 14px;
    line-height: 1.7;
    color: #5d6a74;
    margin: 0 0 10px;
  }

  .author-more-link {
    font-size: 13px;
    font-weight: 750;
    color: var(--blue, #046bd2) !important;
    text-decoration: none !important;
    transition: color .2s;
  }

  .author-more-link:hover {
    color: var(--orange, #f47a20) !important;
  }

  /* Comments */
  .comments-card-box {
    background: rgba(255, 255, 255, .95);
    backdrop-filter: blur(16px);
    border-radius: 24px;
    border: 1px solid rgba(235, 222, 206, .7);
    box-shadow: 0 14px 38px rgba(45, 30, 15, .05);
    padding: clamp(28px, 4vw, 44px);
    margin-bottom: 30px;
  }

  .comments-card-box .comment-respond h3 {
    font-size: 22px;
    font-weight: 800;
    color: #1e2830;
    margin-bottom: 16px;
  }

  .comments-card-box textarea,
  .comments-card-box input[type="text"],
  .comments-card-box input[type="email"],
  .comments-card-box input[type="url"] {
    width: 100%;
    padding: 13px 16px;
    border-radius: 12px;
    border: 1px solid rgba(226, 214, 198, .9);
    background: #faf7f2;
    font-size: 14.5px;
    color: #252e35;
    outline: none;
    transition: all .25s ease;
  }

  .comments-card-box textarea:focus,
  .comments-card-box input:focus {
    border-color: var(--orange, #f47a20);
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(244, 122, 32, .15);
  }

  .comments-card-box input[type="submit"] {
    background: var(--orange, #f47a20);
    color: #ffffff;
    border: none;
    border-radius: 999px;
    padding: 12px 30px;
    font-weight: 750;
    font-size: 13.5px;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(244, 122, 32, .25);
    transition: all .28s ease;
  }

  .comments-card-box input[type="submit"]:hover {
    background: var(--orange-deep, #db6109);
    transform: translateY(-2px);
  }

  /* ==========================================================================
     3. RIGHT COLUMN: Sticky Multi-Widget Sidebar
     ========================================================================== */
  .article-sidebar-widget {
    width: 100%;
    min-width: 0;
  }

  @media (min-width: 1041px) {
    .sidebar-sticky-inner {
      position: sticky;
      top: 90px;
      max-height: calc(100vh - 105px);
      overflow-y: auto;
      overscroll-behavior: contain;
      padding-right: 4px;
      scrollbar-width: thin;
      scrollbar-color: rgba(244, 122, 32, 0.3) transparent;
    }
    .sidebar-sticky-inner::-webkit-scrollbar {
      width: 4px;
    }
    .sidebar-sticky-inner::-webkit-scrollbar-thumb {
      background: rgba(244, 122, 32, 0.3);
      border-radius: 999px;
    }
  }

  /* Generic Editorial Widget Card */
  .editorial-widget-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid rgba(235, 222, 206, 0.85);
    box-shadow: 0 8px 24px rgba(45, 30, 15, 0.04);
    padding: 20px 22px;
    margin-bottom: 22px;
    transition: box-shadow 0.25s ease, border-color 0.25s ease;
  }

  .editorial-widget-card:hover {
    box-shadow: 0 12px 30px rgba(45, 30, 15, 0.07);
    border-color: rgba(244, 122, 32, 0.35);
  }

  .editorial-widget-card .widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 12px;
    margin-bottom: 14px;
    border-bottom: 1px solid rgba(238, 228, 214, 0.85);
  }

  .editorial-widget-card .widget-title {
    font-size: 13.5px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #1e2830;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .editorial-widget-card .widget-title i {
    color: var(--orange, #f47a20);
    font-size: 14px;
  }

  .editorial-widget-card .widget-badge {
    font-size: 10px;
    font-weight: 750;
    color: var(--orange-deep, #db6109);
    background: #fff4ea;
    padding: 3px 9px;
    border-radius: 999px;
    letter-spacing: 0.02em;
  }

  /* Widget 1: TOC in Sidebar */
  .toc-widget {
    background: #faf7f2;
    border-color: #ebdcd0;
  }

  .btn-toggle-toc {
    background: transparent;
    border: none;
    color: #8c827a;
    font-size: 12px;
    cursor: pointer;
    padding: 4px;
    transition: color 0.2s;
  }

  .btn-toggle-toc:hover {
    color: var(--orange, #f47a20);
  }

  .sidebar-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .sidebar-toc-list li a {
    color: #4a5568;
    text-decoration: none;
    font-size: 13.5px;
    line-height: 1.5;
    display: flex;
    align-items: baseline;
    gap: 8px;
    padding: 6px 10px;
    border-radius: 8px;
    transition: all 0.2s ease;
  }

  .sidebar-toc-list li a:hover {
    color: var(--orange, #f47a20);
    background: rgba(244, 122, 32, 0.08);
    transform: translateX(3px);
  }

  .sidebar-toc-list li a.active {
    color: var(--orange-deep, #db6109);
    font-weight: 750;
    background: rgba(244, 122, 32, 0.12);
  }

  .sidebar-toc-list li a .toc-num {
    font-size: 11px;
    font-weight: 850;
    color: var(--orange, #f47a20);
    min-width: 18px;
  }

  .sidebar-toc-list li.toc-level-3 {
    padding-left: 14px;
  }
  .sidebar-toc-list li.toc-level-3 a {
    font-size: 12.5px;
  }

  /* Widget 2: Products List */
  .sidebar-products-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .sidebar-product-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px;
    border-radius: 14px;
    background: #faf7f2;
    border: 1px solid rgba(235, 222, 206, 0.7);
    text-decoration: none !important;
    transition: all 0.25s ease;
  }

  .sidebar-product-item:hover {
    background: #ffffff;
    border-color: rgba(244, 122, 32, 0.4);
    box-shadow: 0 6px 16px rgba(45, 30, 15, 0.06);
    transform: translateY(-2px);
  }

  .sidebar-product-item .prod-thumb {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f2eee8;
    border: 1px solid rgba(0, 0, 0, 0.04);
  }

  .sidebar-product-item .prod-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
  }

  .sidebar-product-item:hover .prod-thumb img {
    transform: scale(1.08);
  }

  .sidebar-product-item .prod-info {
    flex: 1;
    min-width: 0;
  }

  .sidebar-product-item .prod-title {
    font-size: 13.5px;
    font-weight: 750;
    color: #1e2830;
    line-height: 1.35;
    margin: 0 0 4px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
  }

  .sidebar-product-item:hover .prod-title {
    color: var(--orange, #f47a20);
  }

  .sidebar-product-item .prod-price {
    font-size: 13.5px;
    font-weight: 800;
    color: var(--orange-deep, #db6109);
    margin-bottom: 3px;
  }

  .sidebar-product-item .prod-price ins {
    text-decoration: none;
    color: var(--orange-deep, #db6109);
  }
  .sidebar-product-item .prod-price del {
    font-size: 11.5px;
    color: #9aa4ae;
    margin-right: 5px;
  }

  .sidebar-product-item .prod-cta {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--blue, #046bd2);
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap 0.2s;
  }

  .sidebar-product-item:hover .prod-cta {
    gap: 7px;
  }

  /* Widget 3: Articles List */
  .sidebar-articles-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .sidebar-article-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px;
    border-radius: 12px;
    text-decoration: none !important;
    transition: all 0.2s ease;
  }

  .sidebar-article-item:hover {
    background: #faf7f2;
    transform: translateX(3px);
  }

  .sidebar-article-item .art-thumb {
    width: 74px;
    height: 56px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f2eee8;
  }

  .sidebar-article-item .art-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
  }

  .sidebar-article-item:hover .art-thumb img {
    transform: scale(1.06);
  }

  .sidebar-article-item .art-info {
    flex: 1;
    min-width: 0;
  }

  .sidebar-article-item .art-title {
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
    color: #202b33;
    margin: 0 0 4px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
  }

  .sidebar-article-item:hover .art-title {
    color: var(--orange, #f47a20);
  }

  .sidebar-article-item .art-meta {
    font-size: 11px;
    color: #8c97a0;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .sidebar-article-item .dot-sep {
    color: #cbd5e1;
  }

  /* Widget Footer Action Button */
  .widget-footer-action {
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px dashed rgba(235, 222, 206, 0.85);
    text-align: center;
  }

  .btn-widget-more {
    font-size: 12.5px;
    font-weight: 750;
    color: var(--orange-deep, #db6109) !important;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
  }

  .btn-widget-more:hover {
    color: var(--orange, #f47a20) !important;
    transform: translateX(3px);
  }

  /* Widget 4: Consultation HoReCa Box */
  .consult-widget {
    background: linear-gradient(135deg, #1e2830 0%, #2b3640 100%);
    border: 1px solid rgba(244, 122, 32, 0.35);
    color: #ffffff;
    box-shadow: 0 12px 32px rgba(20, 26, 32, 0.15);
  }

  .consult-widget-inner {
    text-align: center;
  }

  .consult-badge {
    display: inline-block;
    padding: 3px 12px;
    border-radius: 999px;
    background: rgba(244, 122, 32, 0.2);
    border: 1px solid rgba(244, 122, 32, 0.4);
    color: #ff9d47;
    font-size: 10px;
    font-weight: 850;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 10px;
  }

  .consult-title {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 8px 0;
    line-height: 1.35;
  }

  .consult-desc {
    font-size: 12.5px;
    line-height: 1.6;
    color: #b0bac3;
    margin: 0 0 16px 0;
  }

  .consult-hotline-strip {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 14px;
  }

  .hotline-label {
    display: block;
    font-size: 10.5px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 2px;
  }

  .hotline-number {
    font-size: 16px;
    font-weight: 850;
    color: #ff9d47 !important;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: transform 0.2s;
  }

  .hotline-number:hover {
    transform: scale(1.04);
  }

  .btn-consult-quote {
    display: block;
    width: 100%;
    padding: 11px 18px;
    border-radius: 999px;
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff !important;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none !important;
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.35);
    transition: all 0.25s ease;
  }

  .btn-consult-quote:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(244, 122, 32, 0.5);
  }

  /* Responsive Breakpoints */
  @media (max-width: 1040px) {
    .article-layout-grid {
      grid-template-columns: 1fr;
      gap: 32px;
    }
    .mobile-toc-accordion {
      display: block !important;
    }
    #sidebarTOCWidget {
      display: none !important;
    }
  }

  @media (max-width: 768px) {
    .article-header {
      padding-top: 24px;
      padding-bottom: 20px;
      text-align: center;
    }
    .article-breadcrumbs {
      font-size: 12px;
      gap: 6px;
      margin-bottom: 14px;
    }
    .article-headline {
      font-size: 22px !important;
      line-height: 1.35 !important;
      margin-bottom: 16px !important;
    }
    .article-meta-row {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      max-width: 100%;
      gap: 8px;
      border-radius: 18px;
      padding: 14px 18px;
      box-sizing: border-box;
    }
    .meta-author {
      justify-content: center;
    }
    .meta-divider {
      width: 40px;
      height: 1px;
      background: rgba(45, 30, 15, .08);
    }
    .meta-item {
      text-align: center;
    }
    .article-author-card {
      flex-direction: column;
      text-align: center;
    }
    .article-body-wrapper {
      padding: 24px 18px !important;
      border-radius: 20px !important;
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // 1. Reading Progress Bar
  window.addEventListener('scroll', function() {
    var winScroll = document.documentElement.scrollTop || document.body.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = height > 0 ? (winScroll / height) * 100 : 0;
    var bar = document.getElementById('readingProgressBar');
    if (bar) bar.style.width = scrolled + '%';
  });

  // 2. Build Dynamic Table of Contents (TOC) for Sidebar and Mobile
  var headings = document.querySelectorAll('.article-rich-text h2, .article-rich-text h3');
  var sidebarTOC = document.getElementById('sidebarTOCWidget');
  var sidebarList = document.getElementById('sidebarTocList');
  var mobileTOCBox = document.getElementById('mobileTOCBox');
  var mobileList = document.getElementById('mobileTocList');

  if (headings.length >= 1 && sidebarTOC && sidebarList) {
    headings.forEach(function(h, idx) {
      var id = h.id || 'sec-' + (idx + 1);
      h.id = id;
      var isH3 = h.tagName.toLowerCase() === 'h3';
      var numStr = (idx + 1 < 10 ? '0' : '') + (idx + 1);
      var text = h.textContent.replace(/^[\d\.\s]+/, '').trim();

      // Sidebar link
      var li = document.createElement('li');
      if (isH3) li.className = 'toc-level-3';
      var a = document.createElement('a');
      a.href = '#' + id;
      a.className = 'sidebar-toc-link';
      a.dataset.targetId = id;
      a.innerHTML = '<span class="toc-num">' + numStr + '</span><span class="toc-title-text">' + text + '</span>';
      
      a.addEventListener('click', function(e) {
        e.preventDefault();
        var target = document.getElementById(id);
        if (target) {
          var offset = 95;
          var bodyRect = document.body.getBoundingClientRect().top;
          var elementRect = target.getBoundingClientRect().top;
          var elementPosition = elementRect - bodyRect;
          var offsetPosition = elementPosition - offset;
          window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }
      });
      li.appendChild(a);
      sidebarList.appendChild(li);

      // Mobile link
      if (mobileList) {
        var mLi = document.createElement('li');
        var mA = document.createElement('a');
        mA.href = '#' + id;
        mA.innerHTML = '<span style="color: var(--orange, #f47a20); font-weight: 800; min-width: 18px;">' + numStr + '.</span> <span>' + text + '</span>';
        mA.addEventListener('click', function(e) {
          e.preventDefault();
          var target = document.getElementById(id);
          if (target) {
            var offset = 95;
            var bodyRect = document.body.getBoundingClientRect().top;
            var elementRect = target.getBoundingClientRect().top;
            var elementPosition = elementRect - bodyRect;
            window.scrollTo({ top: elementPosition - offset, behavior: 'smooth' });
            var content = document.getElementById('mobileTocContent');
            if (content) content.classList.add('d-none');
          }
        });
        mLi.appendChild(mA);
        mobileList.appendChild(mLi);
      }
    });

    sidebarTOC.classList.remove('d-none');
    if (mobileTOCBox && window.innerWidth <= 1040) {
      mobileTOCBox.classList.remove('d-none');
    }

    // ScrollSpy: highlight active TOC item when scrolling
    var tocLinks = document.querySelectorAll('.sidebar-toc-link');
    window.addEventListener('scroll', function() {
      var scrollPos = window.scrollY + 140;
      var activeFound = false;

      for (var i = headings.length - 1; i >= 0; i--) {
        var h = headings[i];
        if (h.offsetTop <= scrollPos) {
          var targetId = h.id;
          tocLinks.forEach(function(link) {
            if (link.dataset.targetId === targetId) {
              link.classList.add('active');
            } else {
              link.classList.remove('active');
            }
          });
          activeFound = true;
          break;
        }
      }
      if (!activeFound && tocLinks.length > 0) {
        tocLinks.forEach(function(l) { l.classList.remove('active'); });
      }
    });
  }

  // Sidebar TOC Toggle button
  var btnToggle = document.getElementById('btnToggleTOC');
  var listWrap = document.getElementById('tocListWrap');
  if (btnToggle && listWrap) {
    btnToggle.addEventListener('click', function() {
      var isHidden = listWrap.classList.toggle('d-none');
      btnToggle.querySelector('i').className = isHidden ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-up';
    });
  }

  // Mobile TOC Toggle button
  var btnMobileToggle = document.getElementById('btnToggleMobileTOC');
  var mobileTocContent = document.getElementById('mobileTocContent');
  if (btnMobileToggle && mobileTocContent) {
    btnMobileToggle.addEventListener('click', function() {
      var isHidden = mobileTocContent.classList.toggle('d-none');
      var chevron = btnMobileToggle.querySelector('.chevron-icon');
      if (chevron) {
        chevron.className = isHidden ? 'fa-solid fa-chevron-down chevron-icon' : 'fa-solid fa-chevron-up chevron-icon';
      }
    });
  }
});
</script>

<?php
get_footer();
