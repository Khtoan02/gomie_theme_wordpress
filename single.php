<?php
/**
 * The template for displaying all single posts in Gomie Ceramic Editorial V11 style.
 *
 * @package Gomie
 */

get_header();
?>

<main id="primary" class="site-main gomie-single-article">
  <div class="gomie-v11">

    <?php while (have_posts()) : the_post();
      gomie_set_post_views();
      $custom_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
      $article_tag = !empty($custom_tag) ? $custom_tag : 'GOMIE CERAMIC · CẨM NANG GỐM SỨ';
      
      // Determine article image
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
        
        <!-- 1. Editorial Header -->
        <header class="article-header">
          <div class="wrap-narrow">
            <nav class="article-breadcrumbs" aria-label="Breadcrumb">
              <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
              <span class="sep">/</span>
              <a href="<?php echo esc_url(home_url('/blog/')); ?>">Cẩm nang gốm sứ</a>
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
            </div>
          </div>
        </header>

        <!-- 2. Hero Featured Photography -->
        <?php if (!empty($hero_img_url)) : ?>
          <div class="article-hero-media wrap-wide">
            <div class="hero-image-stage">
              <img src="<?php echo $hero_img_url; ?>" alt="<?php the_title_attribute(); ?>" />
              <div class="hero-image-watermark">Gomie Ceramic · Bát Tràng</div>
            </div>
          </div>
        <?php endif; ?>

        <!-- 3. Article Core Body Content -->
        <div class="article-body-wrapper wrap-narrow">
          <?php if (has_excerpt()) : ?>
            <div class="article-lead-paragraph">
              <?php echo get_the_excerpt(); ?>
            </div>
          <?php endif; ?>

          <div class="article-rich-text">
            <?php the_content(); ?>
          </div>

          <!-- Tags & Social Share -->
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
                echo '<span class="tag-pill">Gốm Bát Tràng</span><span class="tag-pill">Nghệ thuật Sắc Men</span>';
              }
              ?>
            </div>

            <div class="article-share-strip">
              <span class="share-title">Chia sẻ:</span>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Chia sẻ lên Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Chia sẻ lên Twitter">
                <i class="fab fa-twitter"></i>
              </a>
              <button type="button" class="share-btn copy-url-btn" onclick="navigator.clipboard.writeText(window.location.href); alert('Đã sao chép liên kết bài viết!');" aria-label="Sao chép link">
                <i class="fas fa-link"></i>
              </button>
            </div>
          </footer>

          <!-- Author Bio Box -->
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

        <!-- 4. Related Ceramic Stories -->
        <?php
          $related = new WP_Query(array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'post__not_in'   => array(get_the_ID()),
          ));
          if ($related->have_posts()) :
        ?>
          <section class="related-stories-section wrap-wide" aria-labelledby="related-heading">
            <div class="related-head">
              <div>
                <p class="story-kicker">CÙNG CHUYÊN MỤC · GÓC NHÌN GOMIE</p>
                <h3 id="related-heading">Những câu chuyện tiếp theo</h3>
              </div>
              <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="view-all-link">Xem tất cả bài viết →</a>
            </div>

            <div class="related-grid-3">
              <?php while ($related->have_posts()) : $related->the_post();
                $rel_tag = get_post_meta(get_the_ID(), '_gomie_editorial_tag', true);
                $rel_img = get_post_meta(get_the_ID(), '_gomie_editorial_img', true);
                $rel_img_url = !empty($rel_img) ? esc_url(get_template_directory_uri() . '/assets/images/stories/' . $rel_img) : esc_url(get_template_directory_uri() . '/assets/images/stories/gomie-story-ban-tiec.jpg');
              ?>
                <article class="related-card">
                  <a href="<?php the_permalink(); ?>" class="related-card-media">
                    <img src="<?php echo $rel_img_url; ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                  </a>
                  <div class="related-card-content">
                    <p class="card-tag"><?php echo esc_html(!empty($rel_tag) ? $rel_tag : 'CẨM NANG GOMIE'); ?></p>
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p class="card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                    <a href="<?php the_permalink(); ?>" class="card-link">Đọc tiếp →</a>
                  </div>
                </article>
              <?php endwhile; wp_reset_postdata(); ?>
            </div>
          </section>
        <?php endif; ?>

        <!-- 5. Comments Section -->
        <?php if (comments_open() || get_comments_number()) : ?>
          <section class="article-comments-section wrap-narrow">
            <div class="comments-card-box">
              <?php comments_template(); ?>
            </div>
          </section>
        <?php endif; ?>

      </article>

    <?php endwhile; ?>

  </div>
</main>

<style id="gomie-single-article-css">
  /* CSS Single Post - Gomie Ceramic Editorial V11 */
  .gomie-single-article {
    width: 100%;
    margin: 0;
    padding: 0;
    background: #fffdf9;
  }

  .gomie-single-article .gomie-v11 {
    background-color: #fffdf9 !important;
    background-image: url('<?php echo esc_url(get_template_directory_uri() . "/assets/images/glazes/Background-1.png"); ?>') !important;
    background-position: 47% 0% !important;
    background-size: 100% auto !important;
    background-repeat: repeat-y !important;
    min-height: 100vh;
    padding-bottom: 90px;
  }

  .wrap-narrow {
    max-width: 860px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: clamp(20px, 3vw, 36px) !important;
    padding-right: clamp(20px, 3vw, 36px) !important;
  }

  .wrap-wide {
    max-width: 1240px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: clamp(20px, 3vw, 36px) !important;
    padding-right: clamp(20px, 3vw, 36px) !important;
  }

  /* 1. Article Header */
  .article-header {
    padding-top: clamp(45px, 5.5vw, 75px);
    padding-bottom: clamp(30px, 4vw, 50px);
    text-align: center;
  }

  .article-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #7b8893;
    margin-bottom: 22px;
    flex-wrap: wrap;
    justify-content: center;
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
  }

  .article-tag-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .92);
    border: 1px solid rgba(235, 222, 206, .9);
    box-shadow: 0 4px 12px rgba(45, 30, 15, .04);
    font-size: 11px;
    font-weight: 850;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--orange-deep, #db6109);
    margin-bottom: 20px;
  }

  .article-headline {
    font-size: clamp(32px, 3.8vw, 50px) !important;
    font-weight: 850 !important;
    line-height: 1.22 !important;
    letter-spacing: -.03em !important;
    color: #1e2830 !important;
    margin: 0 0 28px !important;
    text-align: center;
  }

  .article-meta-row {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    padding: 10px 24px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .75);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(238, 228, 214, .8);
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
    background: rgba(45, 30, 15, .1);
  }

  .meta-item {
    text-align: left;
  }

  .meta-label {
    display: block;
    font-size: 10.5px;
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

  /* 2. Hero Media */
  .article-hero-media {
    margin-bottom: clamp(40px, 5vw, 65px);
  }

  .hero-image-stage {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(45, 30, 15, .12);
    border: 1px solid rgba(255, 255, 255, .95);
    background: #f2eee8;
  }

  .hero-image-stage img {
    display: block;
    width: 100%;
    height: auto;
    max-height: 600px;
    object-fit: cover;
    object-position: center;
  }

  .hero-image-watermark {
    position: absolute;
    bottom: 18px;
    right: 22px;
    background: rgba(0, 0, 0, .45);
    backdrop-filter: blur(8px);
    color: rgba(255, 255, 255, .92);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 999px;
  }

  /* 3. Core Body Content */
  .article-body-wrapper {
    background: rgba(255, 255, 255, .92);
    backdrop-filter: blur(18px);
    border-radius: 32px;
    border: 1px solid rgba(255, 255, 255, .98);
    box-shadow: 0 20px 48px rgba(45, 30, 15, .06);
    padding: clamp(36px, 4.8vw, 64px) clamp(28px, 4.5vw, 58px);
    margin-bottom: clamp(50px, 6vw, 85px);
  }

  .article-lead-paragraph {
    font-size: clamp(17px, 1.85vw, 20px);
    line-height: 1.85;
    color: #2b3640;
    font-weight: 500;
    font-style: italic;
    border-left: 4px solid var(--orange, #f47a20);
    padding-left: 24px;
    margin-bottom: 36px;
  }

  .article-rich-text {
    font-size: 16.5px;
    line-height: 1.95;
    color: #48545e;
  }

  .article-rich-text p {
    margin-bottom: 24px;
  }

  .article-rich-text strong {
    color: #1e2830;
    font-weight: 750;
  }

  .article-rich-text h2,
  .article-rich-text h3 {
    color: #1e2830;
    font-weight: 800;
    letter-spacing: -.025em;
    margin-top: 40px;
    margin-bottom: 18px;
    line-height: 1.3;
  }

  .article-rich-text h2 {
    font-size: clamp(24px, 2.8vw, 32px);
  }

  .article-rich-text h3 {
    font-size: clamp(20px, 2.2vw, 26px);
  }

  /* Toolbar */
  .article-footer-toolbar {
    margin-top: 44px;
    padding-top: 28px;
    border-top: 1px solid rgba(235, 222, 206, .85);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
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
    font-size: 12.5px;
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
    gap: 10px;
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
    transition: all .28s ease;
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
    gap: 24px;
    margin-top: 40px;
    padding: 28px 32px;
    background: #faf6f0;
    border-radius: 24px;
    border: 1px solid rgba(235, 222, 206, .9);
  }

  .author-badge-large {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff;
    font-size: 28px;
    font-weight: 850;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(244, 122, 32, .3);
  }

  .author-details h4 {
    font-size: 18px;
    font-weight: 800;
    color: #1e2830;
    margin: 0 0 8px;
  }

  .author-details p {
    font-size: 14.5px;
    line-height: 1.75;
    color: #5d6a74;
    margin: 0 0 12px;
  }

  .author-more-link {
    font-size: 13.5px;
    font-weight: 750;
    color: var(--blue, #046bd2) !important;
    text-decoration: none !important;
    transition: color .2s;
  }

  .author-more-link:hover {
    color: var(--orange, #f47a20) !important;
  }

  /* 4. Related Stories */
  .related-stories-section {
    margin-bottom: clamp(50px, 6vw, 85px);
  }

  .related-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 32px;
  }

  .related-head h3 {
    font-size: clamp(26px, 3vw, 36px) !important;
    font-weight: 800 !important;
    color: #1e2830 !important;
    margin: 0 !important;
  }

  .view-all-link {
    font-size: 14px;
    font-weight: 750;
    color: var(--blue, #046bd2) !important;
    text-decoration: none !important;
    transition: all .2s;
  }

  .view-all-link:hover {
    color: var(--orange, #f47a20) !important;
    transform: translateX(3px);
  }

  .related-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: clamp(20px, 2.4vw, 30px);
  }

  .related-card {
    display: flex;
    flex-direction: column;
    background: rgba(255, 255, 255, .90);
    backdrop-filter: blur(16px);
    border-radius: 22px;
    border: 1px solid rgba(255, 255, 255, .96);
    box-shadow: 0 12px 32px rgba(45, 30, 15, .06);
    overflow: hidden;
    transition: transform .35s ease, box-shadow .35s ease;
  }

  .related-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 44px rgba(45, 30, 15, .11);
  }

  .related-card-media {
    width: 100%;
    height: 200px;
    overflow: hidden;
    display: block;
    background: #f2eee8;
  }

  .related-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
  }

  .related-card:hover .related-card-media img {
    transform: scale(1.06);
  }

  .related-card-content {
    padding: 22px 24px;
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-start;
  }

  .card-tag {
    font-size: 11px !important;
    font-weight: 800 !important;
    letter-spacing: .1em !important;
    text-transform: uppercase !important;
    color: var(--orange-deep, #db6109) !important;
    margin: 0 0 10px !important;
  }

  .related-card h4 {
    font-size: 17.5px !important;
    font-weight: 750 !important;
    line-height: 1.35 !important;
    color: #202b33 !important;
    margin: 0 0 10px !important;
  }

  .related-card h4 a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color .2s;
  }

  .related-card:hover h4 a {
    color: var(--blue, #046bd2) !important;
  }

  .card-excerpt {
    font-size: 13.5px !important;
    line-height: 1.7 !important;
    color: #63717d !important;
    margin: 0 0 16px !important;
    flex: 1;
  }

  .card-link {
    font-size: 13px;
    font-weight: 750;
    color: var(--blue, #046bd2) !important;
    text-decoration: none !important;
    margin-top: auto;
  }

  /* 5. Comments */
  .comments-card-box {
    background: rgba(255, 255, 255, .90);
    backdrop-filter: blur(16px);
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, .98);
    box-shadow: 0 16px 40px rgba(45, 30, 15, .06);
    padding: clamp(32px, 4vw, 50px);
  }

  .comments-card-box .comment-respond h3 {
    font-size: 24px;
    font-weight: 800;
    color: #1e2830;
    margin-bottom: 18px;
  }

  .comments-card-box textarea,
  .comments-card-box input[type="text"],
  .comments-card-box input[type="email"],
  .comments-card-box input[type="url"] {
    width: 100%;
    padding: 14px 18px;
    border-radius: 14px;
    border: 1px solid rgba(226, 214, 198, .9);
    background: #faf7f2;
    font-size: 15px;
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
    padding: 13px 32px;
    font-weight: 750;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(244, 122, 32, .25);
    transition: all .28s ease;
  }

  .comments-card-box input[type="submit"]:hover {
    background: var(--orange-deep, #db6109);
    transform: translateY(-2px);
  }

  @media (max-width: 900px) {
    .related-grid-3 {
      grid-template-columns: 1fr;
    }
    .article-author-card {
      flex-direction: column;
      text-align: center;
    }
  }
</style>

<?php
get_footer();
