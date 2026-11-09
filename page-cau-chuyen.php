<?php
/**
 * Template Name: Chuyện Của Gomie (Brand Story)
 * Template Post Type: page
 *
 * Trang Câu Chuyện Thương Hiệu Gomie Ceramic theo chuẩn Editorial V11.
 * Dựa trên tài liệu và hình ảnh chuẩn hóa: "Chạm vào hồn đất, thổi lửa đam mê" & "Trao gửi yêu thương, gắn kết cộng đồng".
 *
 * @package Gomie
 */

get_header();
?>

<main id="primary" class="site-main gomie-story-page">
  <div class="gomie-v11">

    <!-- HERO HEADER: CHUYỆN CỦA GOMIE -->
    <header class="story-hero-section">
      <div class="wrap">
        <div class="story-hero-inner">
          <p class="story-kicker">GOMIE CERAMIC · DI SẢN BÁT TRÀNG</p>
          <h1 class="story-main-title">CHUYỆN CỦA <span class="brand-highlight">GOMIE</span></h1>
          <p class="story-lead-quote">
            Khởi nguồn từ mạch đất phù sa ngàn năm bên dòng sông Hồng, Gomie Ceramic kể câu chuyện về sự giao hòa giữa đất sét nguyên bản, ngọn lửa 1.300°C và trái tim đầy nhiệt huyết của những người con làng gốm Bát Tràng.
          </p>
        </div>
      </div>
    </header>

    <!-- STORY SECTION 1: CHẠM VÀO HỒN ĐẤT, THỔI LỬA ĐAM MÊ -->
    <section class="story-chapter-section chapter-earth" aria-labelledby="story-chapter-1">
      <div class="wrap">
        <div class="story-split-grid">
          
          <!-- Text Column -->
          <div class="story-text-col">
            <div class="chapter-badge">
              <span class="badge-icon" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2v8"/><path d="m4.93 10.93 1.41 1.41"/><path d="M2 18h2"/><path d="M20 18h2"/><path d="m19.07 10.93-1.41 1.41"/><path d="M22 22H2"/><path d="m8 22 4-10 4 10"/>
                </svg>
              </span>
              <span class="badge-label">TÂM HUYẾT NGHỆ NHÂN BÁT TRÀNG</span>
            </div>

            <h2 id="story-chapter-1" class="chapter-title">
              Chạm vào hồn đất, thổi lửa đam mê
            </h2>

            <div class="chapter-prose">
              <p>
                Làng gốm Bát Tràng, một làng nghề cổ kính nằm bên sông Hồng, đã từ lâu nổi tiếng với những sản phẩm gốm sứ tinh xảo, mang đậm hồn quê Việt. Tại đây, giữa những ngõ nhỏ quanh co, tiếng bàn xoay vo vo, tiếng lửa reo vui trong lò nung, và hình ảnh những người thợ gốm cần mẫn, miệt mài bên từng sản phẩm đã trở nên quen thuộc.
              </p>
              <p>
                <strong>Gomie Ceramic</strong> sinh ra từ chính mảnh đất nghệ thuật này, mang trong mình trái tim nồng nàn yêu gốm và mong muốn gìn giữ, phát huy tinh hoa gốm sứ Bát Tràng trong nhịp sống đương đại.
              </p>
              <p>
                Chúng tôi tin rằng, mỗi sản phẩm gốm sứ không chỉ là vật dụng thường nhật mà còn là một tác phẩm nghệ thuật, chứa đựng hồn đất, men lửa và tâm huyết gửi gắm của người nghệ nhân.
              </p>
              <p>
                Từ việc tuyển chọn nguồn đất sét tinh khiết, nhào nặn tỉ mỉ trên bàn xoay, đến quá trình nung luyện hai lần ở nhiệt độ khắt khe <strong>1.300°C</strong>, mỗi công đoạn đều được thực hiện với sự chăm chút và tận tâm cao nhất.
              </p>
            </div>

            <!-- Highlight Quote Box -->
            <div class="story-highlight-card">
              <div class="quote-mark" aria-hidden="true">“</div>
              <p class="quote-content">
                Đặc biệt, <strong>men hỏa biến</strong> – niềm tự hào của Gomie – được tạo nên từ bí quyết gia truyền, tạo ra những hoa văn độc đáo, không thể sao chép, biến mỗi sản phẩm thành một kiệt tác duy nhất.
              </p>
            </div>
          </div>

          <!-- Image Column -->
          <div class="story-image-col">
            <div class="story-media-frame">
              <img 
                src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/stories/chuyen-gomie-dat-set.jpg'); ?>" 
                alt="Đôi bàn tay nghệ nhân Bát Tràng vuốt nặn đất sét trên bàn xoay gốm Gomie Ceramic" 
                loading="lazy" 
                decoding="async" 
              />
              <div class="media-caption-tag">
                <span>01 · BÀN XOAY THỦ CÔNG</span>
                <span>ĐẤT SÉT NGUYÊN BẢN</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- METRICS STRIP: CAM KẾT CHẾ TÁC GOMIE -->
    <section class="story-metrics-strip" aria-label="Cam kết chất lượng chế tác Gomie">
      <div class="wrap">
        <div class="metrics-grid">
          <div class="metric-card">
            <span class="metric-num">500+</span>
            <span class="metric-name">NĂM DI SẢN</span>
            <span class="metric-desc">Tinh hoa kỹ nghệ vuốt nặn Bát Tràng</span>
          </div>
          <div class="metric-card">
            <span class="metric-num">1.300°C</span>
            <span class="metric-name">NHIỆT ĐỘ NUNG LÒ</span>
            <span class="metric-desc">Kết khối đanh chắc, khử sạch hoàn toàn chì</span>
          </div>
          <div class="metric-card">
            <span class="metric-num">100%</span>
            <span class="metric-name">THỦ CÔNG VIỆT</span>
            <span class="metric-desc">Chế tác thủ công bởi nghệ nhân bản địa</span>
          </div>
          <div class="metric-card">
            <span class="metric-num">HoReCa</span>
            <span class="metric-name">CHUẨN QUỐC TẾ</span>
            <span class="metric-desc">An toàn máy rửa chén, lò vi sóng &amp; đại tiệc</span>
          </div>
        </div>
      </div>
    </section>

    <!-- STORY SECTION 2: TRAO GỬI YÊU THƯƠNG, GẮN KẾT CỘNG ĐỒNG -->
    <section class="story-chapter-section chapter-community" aria-labelledby="story-chapter-2">
      <div class="wrap">
        <div class="story-split-grid reverse-on-desktop">
          
          <!-- Image Column (Left on Desktop) -->
          <div class="story-image-col">
            <div class="story-media-frame">
              <img 
                src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/stories/chuyen-gomie-men-hoa-bien.jpg'); ?>" 
                alt="Bộ bát đĩa men xanh hỏa biến Gomie Ceramic trên bàn ăn gia đình" 
                loading="lazy" 
                decoding="async" 
              />
              <div class="media-caption-tag">
                <span>02 · KIỆT TÁC SẮC MEN</span>
                <span>HỎA BIẾN ĐỘC BẢN</span>
              </div>
            </div>
          </div>

          <!-- Text Column (Right on Desktop) -->
          <div class="story-text-col">
            <div class="chapter-badge">
              <span class="badge-icon" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
              </span>
              <span class="badge-label">KẾT NỐI VĂN HÓA &amp; CON NGƯỜI</span>
            </div>

            <h2 id="story-chapter-2" class="chapter-title">
              Trao gửi yêu thương, gắn kết cộng đồng
            </h2>

            <div class="chapter-prose">
              <p>
                Gomie không chỉ là gốm sứ, mà còn là sự kết nối. Kết nối giữa con người với đất, với lửa, với truyền thống làng nghề. Kết nối giữa những người thân yêu quanh bàn ăn ấm cúng, bên tách trà thơm ngát. Mỗi sản phẩm Gomie đều mang một câu chuyện riêng, gửi gắm yêu thương và kết nối những giá trị văn hóa tinh thần sâu sắc.
              </p>
              <p>
                Chúng tôi mong muốn mang đến cho bạn những trải nghiệm đẳng cấp và khác biệt. Từ bộ đồ ăn tinh tế cho những bữa tiệc sang trọng, đến bộ ấm chén thanh tao cho những giây phút thư giãn tĩnh tại sau ngày dài làm việc.
              </p>
              <p>
                Và hơn cả một thương hiệu gốm sứ, Gomie còn mang trên mình trách nhiệm với cộng đồng. Mỗi sản phẩm Gomie bán ra không chỉ mang lại giá trị kinh tế mà còn góp phần duy trì và phát triển làng nghề gốm sứ Bát Tràng, đảm bảo công ăn việc làm cho người dân địa phương, giúp họ có cuộc sống ổn định và tiếp tục truyền ngọn lửa nghề cho thế hệ mai sau.
              </p>
            </div>

            <div class="story-action-row">
              <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-story-primary">
                <span>Khám phá các sản phẩm Gomie</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </a>
              <a href="<?php echo esc_url(home_url('/mau-men/')); ?>" class="btn-story-secondary">
                <span>Xem Nghệ thuật Màu Men →</span>
              </a>
            </div>

          </div>

        </div>
      </div>
    </section>

    <!-- FINAL SECTION: TRÍCH DẪN & CTA -->
    <section class="story-final-cta" aria-labelledby="story-final-heading">
      <div class="wrap">
        <div class="story-final-box">
          <p class="story-kicker">GOMIE CERAMIC · HEART OF CRAFTSMANSHIP</p>
          <h2 id="story-final-heading">Mỗi dáng gốm là một tác phẩm, mỗi bữa ăn là một kỷ niệm.</h2>
          <p class="final-desc">
            Cùng Gomie kiến tạo không gian sống đậm chất nghệ thuật với những tác phẩm gốm sứ thủ công Bát Tràng tinh tuyển.
          </p>
          <div class="final-cta-btns">
            <a href="<?php echo esc_url(home_url('/san-pham/')); ?>" class="btn-story-primary">Xem bộ sưu tập sản phẩm</a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-story-outline">Liên hệ đặt chế tác riêng</a>
          </div>
        </div>
      </div>
    </section>

  </div>
</main>

<style id="gomie-story-page-css">
  /* CSS Trang Câu Chuyện Thương Hiệu Gomie Ceramic (Editorial V11) */
  .gomie-story-page {
    width: 100%;
    margin: 0;
    padding: 0;
    background: #fffdf9;
  }

  .gomie-story-page .gomie-v11 {
    background-color: #fffdf9 !important;
    background-image: url('<?php echo esc_url(get_template_directory_uri() . "/assets/images/glazes/Background-1.png"); ?>') !important;
    background-position: 47% 0% !important;
    background-size: 100% auto !important;
    background-repeat: repeat-y !important;
    min-height: 100vh;
    padding-bottom: 80px;
  }

  .gomie-story-page .wrap {
    max-width: 1360px !important;
    width: 100% !important;
    margin-inline: auto !important;
    padding-left: clamp(20px, 3vw, 36px) !important;
    padding-right: clamp(20px, 3vw, 36px) !important;
  }

  /* 1. Story Hero */
  .story-hero-section {
    padding-top: clamp(60px, 7vw, 95px);
    padding-bottom: clamp(40px, 5vw, 65px);
    text-align: center;
  }

  .story-hero-inner {
    max-width: 860px;
    margin-inline: auto;
  }

  .story-kicker {
    font-size: 12.5px !important;
    color: var(--orange-deep, #db6109) !important;
    font-weight: 850 !important;
    letter-spacing: .18em !important;
    text-transform: uppercase !important;
    margin: 0 0 16px !important;
  }

  .story-main-title {
    font-size: clamp(38px, 5vw, 66px) !important;
    font-weight: 850 !important;
    line-height: 1.15 !important;
    letter-spacing: -.035em !important;
    color: #1f2830 !important;
    margin: 0 0 24px !important;
  }

  .story-main-title .brand-highlight {
    color: var(--orange, #f47a20);
    position: relative;
    display: inline-block;
  }

  .story-main-title:after {
    content: "";
    display: block;
    width: 68px;
    height: 3.5px;
    margin: 24px auto 24px;
    background: var(--orange, #f47a20);
    border-radius: 4px;
  }

  .story-lead-quote {
    font-size: clamp(16px, 1.8vw, 19.5px);
    line-height: 1.88;
    color: #4b5862;
    margin: 0 auto;
    max-width: 780px;
  }

  /* 2. Story Chapters (Ziczac Split) */
  .story-chapter-section {
    padding-top: clamp(40px, 5vw, 70px);
    padding-bottom: clamp(50px, 6vw, 85px);
  }

  .story-split-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: clamp(36px, 5vw, 75px);
    align-items: center;
  }

  .story-split-grid.reverse-on-desktop {
    grid-template-columns: 1fr 1fr;
  }

  .chapter-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 7px 16px 7px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .92);
    border: 1px solid rgba(235, 222, 206, .9);
    box-shadow: 0 4px 14px rgba(45, 30, 15, .05);
    margin-bottom: 20px;
  }

  .chapter-badge .badge-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--orange-deep, #db6109);
  }

  .chapter-badge .badge-label {
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #48545e;
  }

  .chapter-title {
    font-size: clamp(28px, 3.2vw, 42px) !important;
    font-weight: 800 !important;
    line-height: 1.25 !important;
    letter-spacing: -.03em !important;
    color: #202b33 !important;
    margin: 0 0 22px !important;
  }

  .chapter-prose p {
    font-size: 15.8px;
    line-height: 1.9;
    color: #515e68;
    margin: 0 0 18px;
  }

  .chapter-prose p strong {
    color: #202b33;
    font-weight: 750;
  }

  /* Story Highlight Quote Card */
  .story-highlight-card {
    position: relative;
    margin-top: 26px;
    padding: 24px 28px 24px 34px;
    background: rgba(255, 255, 255, .92);
    backdrop-filter: blur(14px);
    border-radius: 20px;
    border-left: 4.5px solid var(--orange, #f47a20);
    box-shadow: 0 12px 32px rgba(45, 30, 15, .06), inset 0 1px 1px rgba(255, 255, 255, 1);
  }

  .story-highlight-card .quote-mark {
    position: absolute;
    top: 4px;
    left: 14px;
    font-size: 40px;
    line-height: 1;
    font-family: Georgia, serif;
    color: rgba(244, 122, 32, .25);
    pointer-events: none;
  }

  .story-highlight-card .quote-content {
    font-size: 15px;
    line-height: 1.82;
    color: #3b4750;
    margin: 0;
    font-style: italic;
  }

  /* Media Frame */
  .story-media-frame {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 24px 56px rgba(45, 30, 15, .12), 0 2px 6px rgba(45, 30, 15, .04);
    border: 1px solid rgba(255, 255, 255, .95);
    transition: transform .45s cubic-bezier(.2,.8,.2,1), box-shadow .45s ease;
  }

  .story-media-frame:hover {
    transform: translateY(-6px);
    box-shadow: 0 32px 68px rgba(45, 30, 15, .16);
  }

  .story-media-frame img {
    display: block;
    width: 100%;
    height: auto;
    aspect-ratio: 4 / 3.8;
    object-fit: cover;
    object-position: center;
    transition: transform .7s cubic-bezier(.2,.8,.2,1);
  }

  .story-media-frame:hover img {
    transform: scale(1.04);
  }

  .media-caption-tag {
    position: absolute;
    bottom: 16px;
    left: 18px;
    right: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 18px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .92);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, .95);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    color: #2b3640;
    text-transform: uppercase;
    box-shadow: 0 6px 20px rgba(0,0,0,.08);
  }

  /* 3. Metrics Strip */
  .story-metrics-strip {
    padding: clamp(35px, 4.5vw, 60px) 0;
    background: rgba(255, 255, 255, .65);
    backdrop-filter: blur(16px);
    border-top: 1px solid rgba(235, 222, 206, .7);
    border-bottom: 1px solid rgba(235, 222, 206, .7);
  }

  .metrics-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: clamp(20px, 3vw, 40px);
    text-align: center;
  }

  .metric-card {
    padding: 18px 12px;
  }

  .metric-num {
    display: block;
    font-size: clamp(32px, 3.6vw, 46px);
    font-weight: 850;
    letter-spacing: -.03em;
    color: var(--orange, #f47a20);
    line-height: 1.1;
    margin-bottom: 6px;
  }

  .metric-name {
    display: block;
    font-size: 12px;
    font-weight: 850;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #242f38;
    margin-bottom: 6px;
  }

  .metric-desc {
    display: block;
    font-size: 13px;
    line-height: 1.6;
    color: #65727d;
  }

  /* 4. Action Row */
  .story-action-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
    margin-top: 32px;
  }

  .btn-story-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--orange, #f47a20);
    color: #ffffff !important;
    padding: 14px 28px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 750;
    letter-spacing: .02em;
    text-decoration: none !important;
    box-shadow: 0 8px 24px rgba(244, 122, 32, .28);
    transition: all .32s cubic-bezier(.2,.8,.2,1);
  }

  .btn-story-primary:hover {
    background: var(--orange-deep, #db6109);
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(244, 122, 32, .38);
    color: #ffffff !important;
  }

  .btn-story-secondary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--blue, #046bd2) !important;
    font-size: 14px;
    font-weight: 750;
    text-decoration: none !important;
    transition: all .25s ease;
  }

  .btn-story-secondary:hover {
    color: var(--blue-deep, #024b94) !important;
    transform: translateX(3px);
  }

  /* 5. Final CTA */
  .story-final-cta {
    padding-top: clamp(50px, 6vw, 85px);
  }

  .story-final-box {
    max-width: 960px;
    margin-inline: auto;
    padding: clamp(40px, 5vw, 64px) clamp(28px, 4vw, 56px);
    text-align: center;
    background: rgba(255, 255, 255, .90);
    backdrop-filter: blur(18px);
    border-radius: 32px;
    border: 1px solid rgba(255, 255, 255, .98);
    box-shadow: 0 20px 48px rgba(45, 30, 15, .08);
  }

  .story-final-box h2 {
    font-size: clamp(26px, 3.2vw, 40px) !important;
    font-weight: 800 !important;
    line-height: 1.25 !important;
    letter-spacing: -.03em !important;
    color: #202b33 !important;
    margin: 0 0 18px !important;
  }

  .story-final-box .final-desc {
    font-size: 16px;
    line-height: 1.85;
    color: #586570;
    max-width: 660px;
    margin: 0 auto 32px;
  }

  .final-cta-btns {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 16px;
  }

  .btn-story-outline {
    display: inline-flex;
    align-items: center;
    background: transparent;
    color: #2b3640 !important;
    border: 1.5px solid rgba(45, 30, 15, .2);
    padding: 13px 26px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 750;
    text-decoration: none !important;
    transition: all .28s ease;
  }

  .btn-story-outline:hover {
    border-color: var(--orange, #f47a20);
    color: var(--orange, #f47a20) !important;
    transform: translateY(-2px);
  }

  @media (max-width: 960px) {
    .story-split-grid,
    .story-split-grid.reverse-on-desktop {
      grid-template-columns: 1fr;
      gap: 36px;
    }
    .metrics-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 24px;
    }
  }

  @media (max-width: 600px) {
    .metrics-grid {
      grid-template-columns: 1fr;
    }
    .media-caption-tag {
      flex-direction: column;
      gap: 4px;
      text-align: center;
    }
  }
</style>

<?php
get_footer();
