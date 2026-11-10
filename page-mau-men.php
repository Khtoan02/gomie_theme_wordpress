<?php
/**
 * Template Name: Nghệ Thuật Màu Men - Gomie Ceramic V11
 * Description: Editorial Collection & SEO V11 - Khám phá 9 sắc men độc bản
 *
 * @package Gomie
 * @version 1.1.0
 */

defined('ABSPATH') || exit;

get_header();

// Helper to get local or production filter URL
$shop_base = function_exists('wc_get_page_permalink') && wc_get_page_permalink('shop') ? wc_get_page_permalink('shop') : home_url('/san-pham-2/');
$get_glaze_url = function($slug) use ($shop_base) {
    return esc_url(add_query_arg(array('swoof' => '1', 'pa_mau-sac' => $slug), $shop_base));
};

// SEO FAQ Structured Data
$faq_schema = array(
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array(
        array(
            '@type'          => 'Question',
            'name'           => 'Màu men gốm sứ là gì?',
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => 'Màu men là màu sắc thể hiện qua lớp men được nung trên bề mặt gốm sứ. Hiệu ứng nhìn thấy có thể chịu ảnh hưởng bởi công thức men, độ dày lớp men, nhiệt độ và môi trường nung.'
            )
        ),
        array(
            '@type'          => 'Question',
            'name'           => 'Vì sao màu men trên ảnh có thể khác sản phẩm thực tế?',
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => 'Ánh sáng khi chụp, thiết bị hiển thị và góc nhìn có thể làm màu sắc trông khác nhau. Khi cần phối đồng bộ nhiều món, bạn nên tham khảo thêm ảnh thực tế và thông tin sản phẩm trước khi lựa chọn.'
            )
        ),
        array(
            '@type'          => 'Question',
            'name'           => 'Men hỏa biến có gì đặc biệt?',
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => 'Hỏa biến thường được dùng để mô tả hiệu ứng sắc men biến đổi trong quá trình nung, có thể tạo sự chuyển sắc hoặc những vùng màu khác nhau. Mức độ biến thiên phụ thuộc dòng men và quy trình sản xuất; không nên mặc định mọi sản phẩm đều có hoa văn giống nhau.'
            )
        ),
        array(
            '@type'          => 'Question',
            'name'           => 'Nên chọn màu men nào cho bàn ăn hằng ngày?',
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => 'Bạn có thể bắt đầu bằng một gam sáng hoặc trung tính nếu muốn dễ phối với nhiều món ăn và vật dụng. Nếu thích tạo điểm nhấn, hãy thử kết hợp một vài món men xanh đậm, men Rêu hoặc Gấm Vàng cùng các sắc men nhẹ hơn.'
            )
        ),
        array(
            '@type'          => 'Question',
            'name'           => 'Có thể phối nhiều màu men trong một bộ bát đĩa không?',
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => 'Có. Một cách dễ áp dụng là chọn một nhóm sắc nền làm chủ đạo, sau đó bổ sung một hoặc hai sắc men tạo điểm nhấn. Cân nhắc cả kiểu dáng và tỷ lệ món đồ để bộ bàn ăn vẫn hài hòa.'
            )
        )
    )
);

// Lấy danh sách sắc men động từ hệ thống WooCommerce
$dynamic_glazes = function_exists('gomie_get_active_glazes') ? gomie_get_active_glazes() : array();
$glaze_names_list = !empty($dynamic_glazes) 
    ? implode(', ', wp_list_pluck($dynamic_glazes, 'name')) 
    : 'Men Sapphire, Men Cánh Gián, Men Gấm Vàng, Men Xanh Hỏa Biến, Men Rêu, Men Ngọc Trai, Men Hồng Tuyết, Men Nâu Tuyết, Men Xanh Thiên Thanh';
$glaze_count = count($dynamic_glazes);
$glaze_count_desc = $glaze_count > 0 ? "{$glaze_count} sắc men" : "các sắc men";

$collection_schema = array(
    '@context'    => 'https://schema.org',
    '@type'       => 'CollectionPage',
    'name'        => 'Khám Phá Nghệ Thuật Màu Men Gốm Sứ Gomie Ceramic',
    'description' => "Bộ sưu tập {$glaze_count_desc} gốm thủ công Bát Tràng độc bản của Gomie Ceramic: {$glaze_names_list}.",
    'url'         => home_url('/mau-men/'),
    'publisher'   => array(
        '@type' => 'Organization',
        'name'  => 'Gomie Ceramic Vietnam',
        'url'   => home_url('/')
    )
);
?>

<!-- Schema.org Structured Data -->
<script type="application/ld+json">
<?php echo json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
<script type="application/ld+json">
<?php echo json_encode($collection_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>

<style>
/* GOMIE CERAMIC | Editorial Collection & SEO V11 */
.gomie-v11, .gomie-v11 * { box-sizing: border-box; }
.gomie-v11 {
  --orange: #f47a20;
  --orange-deep: #e86b14;
  --blue: #168fd2;
  --blue-deep: #0873b6;
  --ink: #252c32;
  --muted: #667078;
  --warm: #fcfaf7;
  --line: #e9edf0;
  font-family: inherit;
  color: var(--ink);
  background-color: #fffdf9 !important;
  background-image: url('<?php echo esc_url(get_template_directory_uri() . "/assets/images/glazes/Background-1.png"); ?>') !important;
  background-position: top center !important;
  background-size: 100% auto !important;
  background-repeat: no-repeat !important;
  overflow: hidden;
}
.gomie-v11 a { text-decoration: none !important; }
.gomie-v11 .wrap { max-width: 1350px; margin: auto; padding-inline: clamp(20px, 4vw, 64px); }

/* Hero Section */
.gomie-v11 .hero {
  position: relative;
  isolation: isolate;
  min-height: clamp(420px, 49vw, 630px);
  display: flex;
  align-items: center;
  color: #fff;
  background: #243e4d url('https://vj-prod-website-cms.s3.ap-southeast-1.amazonaws.com/y3-1716004301782.jpg') center 53% / cover no-repeat;
}
.gomie-v11 .hero:before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  background: linear-gradient(90deg, rgba(26,39,49,.77), rgba(28,48,60,.39) 56%, rgba(22,37,47,.08));
}
.gomie-v11 .hero-inner { padding-block: 86px 100px; width: 100%; }
.gomie-v11 .eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: .2em;
  font-weight: 700;
  margin: 0 0 26px;
  color: #f5f8fb;
}
.gomie-v11 .eyebrow:before { content: ""; width: 38px; height: 3px; background: var(--orange); }
.gomie-v11 .hero h1 {
  color: white !important;
  font-weight: 750;
  font-size: clamp(46px, 7vw, 91px);
  line-height: 1.06;
  letter-spacing: -.055em;
  margin: 0 0 23px !important;
}
.gomie-v11 .hero-sub {
  font-size: clamp(15px, 1.65vw, 18px);
  max-width: 490px;
  line-height: 1.8;
  color: #f5f8fb;
  margin: 0 0 32px;
}
.gomie-v11 .hero-btn {
  display: inline-flex;
  align-items: center;
  gap: 24px;
  background: var(--blue);
  color: white !important;
  padding: 16px 28px;
  border-radius: 99px;
  font-weight: 700;
  font-size: 14px;
  transition: background .3s, transform .3s;
}
.gomie-v11 .hero-btn span { font-size: 22px; line-height: 1; font-weight: 400; }
.gomie-v11 .hero-btn:hover { background: var(--blue-deep); transform: translateY(-2px); }
.gomie-v11 .hero-btn:focus-visible { outline: 3px solid #fff; outline-offset: 4px; }

/* Intro Section */
.gomie-v11 .intro {
  padding-top: clamp(45px, 6vw, 75px);
  padding-bottom: clamp(15px, 2vw, 25px);
  background: transparent;
}
.gomie-v11 .intro-inner {
  display: grid;
  grid-template-columns: .87fr 1.13fr;
  align-items: start;
  gap: clamp(40px, 8vw, 125px);
}
.gomie-v11 .kicker {
  font-size: 12px;
  color: var(--orange-deep);
  font-weight: 800;
  letter-spacing: .16em;
  text-transform: uppercase;
  margin: 0 0 16px;
}
.gomie-v11 .intro h2 {
  font-size: clamp(33px, 4vw, 57px);
  font-weight: 740;
  line-height: 1.17;
  letter-spacing: -.045em;
  color: var(--ink) !important;
  margin: 0 !important;
}
.gomie-v11 .intro h2 em { font-style: normal; color: var(--orange); }
.gomie-v11 .intro-copy { padding-top: 4px; }
.gomie-v11 .intro-copy p {
  font-size: 15.5px;
  line-height: 1.96;
  color: #5f6a72;
  margin: 0 0 18px;
  text-align: left;
}
.gomie-v11 .intro-copy strong { color: #293239; }
.gomie-v11 .intro-copy p:last-child { margin-bottom: 0; }

/* Catalog Section */
.gomie-v11 .catalog {
  background: transparent;
  padding-top: clamp(15px, 2vw, 25px);
  padding-bottom: clamp(60px, 7vw, 100px);
}
.gomie-v11 .catalog-head {
  margin: 0 0 35px;
  display: flex;
  align-items: end;
  justify-content: space-between;
  gap: 30px;
}
.gomie-v11 .catalog-head h2 {
  font-size: clamp(32px, 4vw, 52px);
  line-height: 1.2;
  letter-spacing: -.045em;
  color: var(--ink) !important;
  margin: 0 !important;
}
.gomie-v11 .catalog-head h2:after {
  content: "";
  display: block;
  width: 56px;
  height: 3px;
  margin-top: 20px;
  background: var(--orange);
  border-radius: 3px;
}
.gomie-v11 .catalog-aside {
  max-width: 270px;
  color: #667078;
  font-size: 14px;
  line-height: 1.7;
  text-align: right;
  margin: 0;
}

/* Glaze Collection Grid styles are encapsulated inside template-parts/glaze-collection-grid.php */

/* Editorial Knowledge Section */
.gomie-v11 .knowledge {
  background: transparent;
  padding: clamp(50px, 6vw, 80px) 0 0;
}
.gomie-v11 .knowledge-lead {
  display: grid;
  grid-template-columns: .8fr 1.2fr;
  gap: clamp(28px, 6vw, 110px);
  align-items: start;
  padding-bottom: clamp(40px, 6vw, 80px);
}
.gomie-v11 .knowledge h2 {
  font-size: clamp(33px, 4.25vw, 54px);
  line-height: 1.18;
  letter-spacing: -.04em;
  margin: 0 !important;
  color: #252c32 !important;
}
.gomie-v11 .knowledge h2 em { font-style: normal; color: var(--orange); }
.gomie-v11 .knowledge p { font-size: 15px; line-height: 1.95; color: #56636c; margin: 0 0 17px; }
.gomie-v11 .knowledge .lead-copy { font-size: 17px; line-height: 1.85; color: #46545d; }

.gomie-v11 .editorial-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 20px;
  margin-bottom: 60px;
}
.gomie-v11 .editorial-tile {
  padding: clamp(26px, 3.3vw, 48px);
  background: #faf9f7;
  position: relative;
  min-width: 0;
  border-radius: 18px;
}
.gomie-v11 .editorial-tile:nth-child(2) { background: #f5f9fc; }
.gomie-v11 .editorial-tile:nth-child(3) { background: #f8f9fa; }
.gomie-v11 .editorial-tile:nth-child(4) { background: #fff7f0; }
.gomie-v11 .editorial-tile .tile-tag {
  font-size: 11px;
  color: var(--orange-deep);
  letter-spacing: .12em;
  text-transform: uppercase;
  font-weight: 800;
  margin: 0 0 17px;
}
.gomie-v11 .editorial-tile:nth-child(2) .tile-tag { color: var(--blue-deep); }
.gomie-v11 .editorial-tile h3 {
  font-size: clamp(21px, 2.25vw, 29px);
  line-height: 1.3;
  letter-spacing: -.025em;
  color: #26323a !important;
  margin: 0 0 20px !important;
}
.gomie-v11 .editorial-tile p:last-child { margin-bottom: 0; }
.gomie-v11 .editorial-tile a { color: var(--blue-deep) !important; text-decoration: underline !important; text-underline-offset: 3px; }

/* FAQ Section */
.gomie-v11 .faq {
  background: transparent;
  padding: clamp(50px, 6vw, 85px) 0;
}
.gomie-v11 .faq-layout {
  display: grid;
  grid-template-columns: .78fr 1.22fr;
  gap: clamp(32px, 7vw, 105px);
}
.gomie-v11 .faq h2 {
  font-size: clamp(31px, 4vw, 46px);
  line-height: 1.2;
  letter-spacing: -.03em;
  color: #252c32 !important;
  margin: 0 !important;
}
.gomie-v11 .faq-intro {
  font-size: 14px;
  color: #657078;
  line-height: 1.85;
  max-width: 330px;
  margin: 19px 0 0;
}
.gomie-v11 .faq-list { border-top: 1px solid #dfe4e8; }
.gomie-v11 .faq details { border-bottom: 1px solid #dfe4e8; padding: 0; }
.gomie-v11 .faq summary {
  cursor: pointer;
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  font-weight: 650;
  color: #293741;
  line-height: 1.6;
  font-size: 16px;
  padding: 24px 2px;
}
.gomie-v11 .faq summary::-webkit-details-marker { display: none; }
.gomie-v11 .faq summary::marker { display: none; }
.gomie-v11 .faq summary:after {
  content: '+';
  font-size: 24px;
  line-height: 1;
  color: var(--blue);
  font-weight: 400;
  flex: none;
}
.gomie-v11 .faq details[open] summary:after { content: '−'; }
.gomie-v11 .faq details p { margin: -2px 38px 26px 2px; font-size: 14px; line-height: 1.9; color: #5c6870; }
.gomie-v11 .faq summary:focus-visible { outline: 3px solid var(--blue); outline-offset: 3px; }

/* Final CTA */
.gomie-v11 .final-cta {
  background: transparent;
  padding: 70px 0 78px;
  text-align: center;
}
.gomie-v11 .final-cta h2 {
  font-size: clamp(26px, 3.4vw, 43px);
  line-height: 1.25;
  letter-spacing: -.03em;
  color: #27343b !important;
  margin: 0 0 22px !important;
}
.gomie-v11 .final-cta a {
  display: inline-flex;
  padding: 15px 32px;
  border-radius: 99px;
  background: var(--blue);
  color: white !important;
  font-size: 14px;
  font-weight: 750;
  transition: background .25s;
}
.gomie-v11 .final-cta a:hover { background: var(--blue-deep); }

/* Responsive Breakpoints */
@media (max-width: 1024px) {
  .gomie-v11 .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
  .gomie-v11 .details { padding: 18px 20px 22px; }
}
@media (max-width: 800px) {
  .gomie-v11 .knowledge-lead,
  .gomie-v11 .faq-layout { grid-template-columns: 1fr; gap: 25px; }
  .gomie-v11 .editorial-grid { grid-template-columns: 1fr; }
  .gomie-v11 .editorial-tile { padding: 32px 27px; }
  .gomie-v11 .faq-intro { max-width: none; }
}
@media (max-width: 720px) {
  .gomie-v11 .hero { min-height: 440px; background-position: 62% center; }
  .gomie-v11 .hero:before { background: linear-gradient(90deg, rgba(24,40,51,.84), rgba(24,40,51,.30)); }
  .gomie-v11 .hero-inner { padding-block: 65px 76px; }
  .gomie-v11 .intro-inner { grid-template-columns: 1fr; gap: 28px; }
  .gomie-v11 .catalog-head { align-items: start; flex-direction: column; gap: 12px; }
  .gomie-v11 .catalog-aside { text-align: left; }
  .gomie-v11 .grid { gap: 18px; }
  .gomie-v11 .details { padding: 20px 18px 22px; }
  .gomie-v11 .name { font-size: 21px; }
  .gomie-v11 .description { font-size: 13px; line-height: 1.75; }
}
@media (max-width: 620px) {
  .gomie-v11 .grid { grid-template-columns: 1fr; gap: 22px; }
  .gomie-v11 .photo { aspect-ratio: 1 / 1; }
  .gomie-v11 .catalog-head { margin-bottom: 28px; }
}
@media (max-width: 480px) {
  .gomie-v11 .knowledge p { font-size: 14px; line-height: 1.87; }
  .gomie-v11 .knowledge .lead-copy { font-size: 15px; }
  .gomie-v11 .faq summary { font-size: 15px; padding: 20px 0; }
}
@media (prefers-reduced-motion: reduce) {
  .gomie-v11 * { transition: none !important; }
}

/* Full-width breakout within WordPress content containers */
.gomie-v11 {
  display: block !important;
  width: 100vw !important;
  max-width: 100vw !important;
  position: relative !important;
  left: calc(50% - 50vw) !important;
  margin: 0 !important;
  padding: 0 !important;
  clear: both;
  overflow: hidden;
}
.gomie-v11 .wrap {
  max-width: 1350px !important;
  width: 100% !important;
  margin-inline: auto;
  padding-inline: clamp(16px, 3.5vw, 72px);
}
</style>

<main class="gomie-v11">

  <!-- SECTION 1: HERO -->
  <section aria-labelledby="gomie-v11-hero" class="hero">
    <div class="wrap hero-inner">
      <p class="eyebrow">GOMIE CERAMIC · NGHỆ THUẬT SẮC MEN</p>
      <h1 id="gomie-v11-hero">KHÁM PHÁ<br />MÀU MEN</h1>
      <p class="hero-sub">Có những vẻ đẹp không cần cất lời. Chỉ một sắc men cũng đủ gợi lên cả một miền cảm xúc.</p>
      <a class="hero-btn" href="#gomie-v11-collection">Khám phá bộ sưu tập <span aria-hidden="true">↓</span></a>
    </div>
  </section>

  <!-- SECTION 2: INTRO -->
  <section aria-labelledby="gomie-v11-intro" class="intro">
    <div class="wrap intro-inner">
      <div>
        <p class="kicker">Vẻ đẹp từ lớp men</p>
        <h2 id="gomie-v11-intro">Khi sắc men<br />kể <em>một câu chuyện.</em></h2>
      </div>
      <div class="intro-copy">
        <p>Màu men là một trong những yếu tố tạo nên vẻ đẹp và dấu ấn riêng của mỗi sản phẩm gốm sứ. Không chỉ làm nổi bật hình dáng, đường nét, lớp men còn góp phần thể hiện phong cách thiết kế và mang đến sự hài hòa cho không gian sử dụng. Tại <strong>Gomie Ceramic</strong>, bộ sưu tập màu men gốm sứ được phát triển với nhiều sắc thái đa dạng, từ gam nâu trầm ấm, vàng tinh tế đến xanh sâu hiện đại và những màu men chuyển sắc độc đáo. Mỗi dòng men mang một vẻ đẹp riêng, phù hợp với nhiều phong cách bàn ăn, từ mộc mạc, gần gũi đến trang nhã và đương đại.</p>
        <p>Hãy cùng khám phá đặc điểm từng màu men và lựa chọn những sản phẩm bát gốm sứ phù hợp với nhu cầu sử dụng cũng như phong cách không gian của bạn.</p>
      </div>
    </div>
  </section>

  <!-- SECTION 3: CATALOG (9 SẮC MEN) -->
  <section aria-labelledby="gomie-v11-catalog" class="catalog" id="gomie-v11-collection">
    <div class="wrap">
      <header class="catalog-head">
        <div>
          <p class="kicker">GOMIE CERAMIC · BỘ SƯU TẬP MÀU MEN</p>
          <h2 id="gomie-v11-catalog">Mỗi sắc men, một dấu ấn.</h2>
        </div>
        <p class="catalog-aside">Khám phá sắc men đồng điệu với cảm xúc và không gian sống của bạn.</p>
      </header>

      <?php get_template_part('template-parts/glaze-collection-grid'); ?>
    </div>
  </section>

  <!-- SECTION 4: KIẾN THỨC MÀU MEN -->
  <section aria-labelledby="gomie-v11-knowledge" class="knowledge">
    <div class="wrap">
      <div class="knowledge-lead">
        <div>
          <p class="kicker">GOMIE CERAMIC · CẨM NANG SẮC MEN</p>
          <h2 id="gomie-v11-knowledge">Nghệ thuật của <em>những sắc men.</em></h2>
        </div>
        <div>
          <p class="lead-copy">Màu men gốm sứ không chỉ là lớp màu nhìn thấy trên bề mặt. Đó còn là cảm nhận về ánh sáng, chất liệu và đường nét — những chi tiết tạo nên phong cách riêng cho một chiếc bát, chiếc đĩa hay một bàn ăn được chăm chút.</p>
          <p>Từ những gam trung tính kín đáo đến màu sắc nổi bật, mỗi lựa chọn đều có khả năng thay đổi cảm giác của không gian. Hiểu về men gốm và cách phối sắc men giúp bạn tìm được những món đồ phù hợp với thói quen sử dụng cũng như gu thẩm mỹ của mình.</p>
        </div>
      </div>

      <div class="editorial-grid">
        <article class="editorial-tile">
          <p class="tile-tag">Hiểu về chất liệu</p>
          <h3>Màu men gốm sứ là gì?</h3>
          <p>Men gốm là lớp phủ được nung trên bề mặt sản phẩm gốm sứ. Thành phần men, kỹ thuật tráng men và điều kiện nung có thể ảnh hưởng đến màu sắc, độ bóng và hiệu ứng bề mặt của thành phẩm. Vì vậy, khi nói đến màu men, ta không chỉ nhắc tới một gam màu mà còn nói về cách gam màu ấy hiện lên trên dáng gốm.</p>
          <p>Một sắc men sáng có thể làm nổi bật đường cong mềm mại; một gam đậm lại tạo chiều sâu và sự tương phản. Sự kết hợp giữa dáng gốm và bề mặt men là điều khiến mỗi món đồ có sức hút riêng.</p>
        </article>

        <article class="editorial-tile">
          <p class="tile-tag">Dấu ấn của mỗi sắc men</p>
          <h3>Điều gì làm nên vẻ đẹp khác biệt?</h3>
          <p>Cùng thuộc một nhóm màu, các lớp men vẫn có thể đem tới cảm nhận khác nhau. Sắc độ sáng hay trầm, độ trong hay độ đục, bề mặt bóng hoặc mờ, sự chuyển màu dưới ánh sáng — tất cả đều góp phần tạo nên diện mạo của sản phẩm.</p>
          <p>Những dòng men có hiệu ứng chuyển sắc thường gợi cảm giác giàu chuyển động. Trong khi đó, các màu men đồng nhất dễ mang lại vẻ thanh lịch, tĩnh tại. Không có sắc men đẹp nhất cho mọi không gian; chỉ có sắc men hài hòa với sở thích và cách bạn muốn bày trí.</p>
        </article>

        <article class="editorial-tile">
          <p class="tile-tag">Gợi ý lựa chọn</p>
          <h3>Chọn màu men cho từng phong cách bàn ăn</h3>
          <p>Với bàn ăn tối giản, những sắc men sáng và nhẹ như Ngọc Trai hoặc Hồng Tuyết tạo cảm giác thông thoáng, mềm mại. Nếu yêu vẻ ấm cúng, Cánh Gián, Nâu Tuyết hay Gấm Vàng có thể trở thành điểm tựa thị giác gần gũi.</p>
          <p>Men Rêu phù hợp với những phối cảnh gợi thiên nhiên, gỗ và chất liệu mộc. Sapphire hoặc Xanh Hỏa Biến đem đến điểm nhấn mạnh hơn cho bàn ăn đương đại. Bạn cũng có thể phối một màu nền trung tính với vài món mang sắc đậm để tạo nhịp điệu mà không làm tổng thể trở nên rối mắt.</p>
        </article>

        <article class="editorial-tile">
          <p class="tile-tag">Khám phá cùng Gomie</p>
          <h3>Để mỗi bữa ăn có một sắc thái riêng</h3>
          <p>Ở bộ sưu tập màu men Gomie Ceramic, mỗi sắc men được giới thiệu qua hình ảnh sản phẩm và một câu chuyện thẩm mỹ riêng. Bạn có thể bắt đầu từ màu mình yêu thích, sau đó cân nhắc cách màu men tương tác với ánh sáng, màu khăn trải bàn, mặt bàn và những vật dụng đang có.</p>
          <p>Hãy xem ảnh từng màu men trong <a href="#gomie-v11-collection">bộ sưu tập phía trên</a> và chọn trực tiếp một thẻ để khám phá những sản phẩm tương ứng. Màu hiển thị trên màn hình có thể khác đôi chút so với sản phẩm thực tế do thiết bị và điều kiện ánh sáng.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- SECTION 5: FAQ SEMANTIC DETAILS -->
  <section aria-labelledby="gomie-v11-faq" class="faq">
    <div class="wrap faq-layout">
      <div>
        <p class="kicker">GIẢI ĐÁP CÙNG GOMIE</p>
        <h2 id="gomie-v11-faq">Những điều bạn có thể muốn biết.</h2>
        <p class="faq-intro">Một vài lưu ý nhỏ để cảm nhận và lựa chọn màu men gốm sứ tự tin hơn.</p>
      </div>
      <div class="faq-list">
        <details>
          <summary>Màu men gốm sứ là gì?</summary>
          <p>Màu men là màu sắc thể hiện qua lớp men được nung trên bề mặt gốm sứ. Hiệu ứng nhìn thấy có thể chịu ảnh hưởng bởi công thức men, độ dày lớp men, nhiệt độ và môi trường nung.</p>
        </details>
        <details>
          <summary>Vì sao màu men trên ảnh có thể khác sản phẩm thực tế?</summary>
          <p>Ánh sáng khi chụp, thiết bị hiển thị và góc nhìn có thể làm màu sắc trông khác nhau. Khi cần phối đồng bộ nhiều món, bạn nên tham khảo thêm ảnh thực tế và thông tin sản phẩm trước khi lựa chọn.</p>
        </details>
        <details>
          <summary>Men hỏa biến có gì đặc biệt?</summary>
          <p>Hỏa biến thường được dùng để mô tả hiệu ứng sắc men biến đổi trong quá trình nung, có thể tạo sự chuyển sắc hoặc những vùng màu khác nhau. Mức độ biến thiên phụ thuộc dòng men và quy trình sản xuất; không nên mặc định mọi sản phẩm đều có hoa văn giống nhau.</p>
        </details>
        <details>
          <summary>Nên chọn màu men nào cho bàn ăn hằng ngày?</summary>
          <p>Bạn có thể bắt đầu bằng một gam sáng hoặc trung tính nếu muốn dễ phối với nhiều món ăn và vật dụng. Nếu thích tạo điểm nhấn, hãy thử kết hợp một vài món men xanh đậm, men Rêu hoặc Gấm Vàng cùng các sắc men nhẹ hơn.</p>
        </details>
        <details>
          <summary>Có thể phối nhiều màu men trong một bộ bát đĩa không?</summary>
          <p>Có. Một cách dễ áp dụng là chọn một nhóm sắc nền làm chủ đạo, sau đó bổ sung một hoặc hai sắc men tạo điểm nhấn. Cân nhắc cả kiểu dáng và tỷ lệ món đồ để bộ bàn ăn vẫn hài hòa.</p>
        </details>
      </div>
    </div>
  </section>

  <!-- SECTION 6: FINAL CTA -->
  <section aria-labelledby="gomie-v11-end" class="final-cta">
    <div class="wrap">
      <p class="kicker">GOMIE CERAMIC</p>
      <h2 id="gomie-v11-end">Một sắc men hợp ý, một bàn ăn thêm cảm hứng.</h2>
      <a href="#gomie-v11-collection">Trở lại bộ sưu tập ↑</a>
    </div>
  </section>

</main>

<?php
get_footer();
