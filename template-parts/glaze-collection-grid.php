<?php
/**
 * Component: Glaze Collection Grid (Bộ sưu tập Màu Men)
 * Dùng chung đồng nhất giữa Trang chủ (front-page.php) và Chuyên trang Màu Men (page-mau-men.php).
 * Thiết kế tinh giản: Hình ảnh gốm sứ tách nền nổi tự nhiên phía trên khối nội dung miêu tả (.details).
 */
if (!defined('ABSPATH')) {
    exit;
}

$glaze_shop_base = function_exists('wc_get_page_permalink') && wc_get_page_permalink('shop')
    ? wc_get_page_permalink('shop')
    : home_url('/san-pham-2/');

$gomie_get_glaze_url = function ($slug) use ($glaze_shop_base) {
    return esc_url(add_query_arg(array('swoof' => '1', 'pa_mau-sac' => $slug), $glaze_shop_base));
};

// Danh sách 9 sắc men kèm thông số căn chỉnh quang học (Optical Calibration) để đồng nhất 100% chiều cao & đường chân đế
$gomie_glaze_collection = isset($args['items']) && is_array($args['items']) ? $args['items'] : array(
    array(
        'name'      => 'Men Sapphire',
        'slug'      => 'men-sapphire',
        'img'       => 'Gomie-men-saphire.png',
        'scale'     => '1.05',
        'shift_y'   => '13px',
        'storyline' => 'Một khoảng xanh sâu thẳm và kiêu hãnh',
        'desc'      => 'Sapphire mang sắc xanh thẫm đầy cuốn hút, gợi mặt biển khi chiều buông và bầu trời trước giờ lên đèn. Vừa tĩnh tại vừa có cá tính, sắc men đem tới nét sang trọng riêng cho bàn ăn mang tinh thần đương đại.',
    ),
    array(
        'name'      => 'Men Cánh Gián',
        'slug'      => 'men-canh-gian',
        'img'       => 'Gomie-men-canh-gian.png',
        'scale'     => '1.086',
        'shift_y'   => '23px',
        'storyline' => 'Nét trầm ấm của những điều thân thuộc',
        'desc'      => 'Trong sắc nâu sóng sánh của men Cánh Gián là cảm giác thân quen như gian bếp chiều muộn. Vẻ đẹp mộc mạc, có chiều sâu ấy khiến những món gốm trở nên gần gũi, như đã thuộc về mỗi bữa cơm nhà từ lâu.',
    ),
    array(
        'name'      => 'Men Gấm Vàng',
        'slug'      => 'men-gam-vang',
        'img'       => 'Gomie-men-gam-vang.png',
        'scale'     => '0.98',
        'shift_y'   => '10.5px',
        'storyline' => 'Ánh vàng nâng niu những cuộc sum vầy',
        'desc'      => 'Gấm Vàng gợi sắc nắng dịu trải trên mặt bàn, vừa rạng rỡ vừa đằm thắm. Sắc men đem lại nét trang nhã cho từng món gốm, để cả bữa ăn thường ngày cũng có chút dư vị của một dịp đặc biệt.',
    ),
    array(
        'name'      => 'Men Xanh Hỏa Biến',
        'slug'      => 'xanh-song-bien',
        'img'       => 'Gomie-men-xanh-song-bien.png',
        'scale'     => '1.01',
        'shift_y'   => '15px',
        'storyline' => 'Bản hòa sắc không ngừng biến chuyển',
        'desc'      => 'Xanh Hỏa Biến cuốn hút bởi những lớp xanh chuyển sắc mềm mại, gợi dòng nước luôn đổi thay dưới ánh sáng. Vẻ đẹp ấy không nằm ở sự đồng nhất, mà ở những biến chuyển đầy ngẫu hứng khiến mỗi lần ngắm nhìn lại có một cảm nhận khác.',
    ),
    array(
        'name'      => 'Men Rêu',
        'slug'      => 'men-reu',
        'img'       => 'Gomie-men-reu.png',
        'scale'     => '0.903',
        'shift_y'   => '-11px',
        'storyline' => 'Mang bình yên của thiên nhiên vào nhà',
        'desc'      => 'Sắc Rêu như mảng xanh lặng lẽ giữa khu vườn sau mưa, trầm dịu và đầy sức sống. Trên mỗi món gốm, màu men gợi một nhịp sống thư thả, nơi những khoảnh khắc thường nhật cũng đáng để dừng lại thưởng thức.',
    ),
    array(
        'name'      => 'Men Ngọc Trai',
        'slug'      => 'men-ngoc-trai',
        'img'       => 'xanh-ngoc-tach-nen-955x800.png',
        'scale'     => '0.933',
        'shift_y'   => '2px',
        'storyline' => 'Sự thanh khiết trong từng khoảnh khắc',
        'desc'      => 'Ngọc Trai tựa ánh sáng dịu trên bề mặt gốm, trong trẻo mà không lạnh lẽo. Sự tinh giản của sắc men nhường chỗ cho dáng gốm lên tiếng, mang đến vẻ thanh lịch bền lâu cho những bàn ăn yêu nét nhẹ nhàng.',
    ),
    array(
        'name'      => 'Men Hồng Tuyết',
        'slug'      => 'men-hong-tuyet',
        'img'       => 'Bo-hong-tuyet-mh-955x800.png',
        'scale'     => '0.915',
        'shift_y'   => '1px',
        'storyline' => 'Dịu dàng như một lời thì thầm',
        'desc'      => 'Hồng Tuyết mang vẻ thanh tao của sắc hồng phớt nhẹ, êm như cánh hoa vừa chạm sương. Không tìm cách nổi bật, màu men tạo nên một nét duyên kín đáo, đủ làm không gian bàn ăn mềm mại và tinh tế hơn.',
    ),
    array(
        'name'      => 'Men Nâu Tuyết',
        'slug'      => 'men-nau-tuyet',
        'img'       => 'Gomie-men-nau-tuyet.png',
        'scale'     => '1.00',
        'shift_y'   => '15.5px',
        'storyline' => 'Vẻ đẹp lắng lại cùng thời gian',
        'desc'      => 'Nâu Tuyết gợi những gam đất bình yên, nơi màu sắc không phô bày mà lặng lẽ lưu giữ cảm xúc. Có chút trầm mặc, chút ấm áp, sắc men làm nổi bật nét đẹp giản dị và chiều sâu của những món gốm được nâng niu mỗi ngày.',
    ),
    array(
        'name'      => 'Men Xanh Thiên Thanh',
        'slug'      => 'men-xanh-thien-thanh',
        'img'       => 'bo-mau-men-955x800.png',
        'scale'     => '0.916',
        'shift_y'   => '1.5px',
        'storyline' => 'Sắc xanh dịu mát của bầu trời',
        'desc'      => 'Men Xanh Thiên Thanh gợi cảm giác trong trẻo, nhẹ nhàng như sắc trời thanh bình. Gam xanh dịu mát đem đến điểm nhấn tươi sáng cho bàn ăn, đồng thời dễ kết hợp với những sắc men trung tính để tạo nên tổng thể hài hòa.',
    ),
);

if (!defined('GOMIE_GLAZE_GRID_COMPONENT_STYLE_LOADED')) :
    define('GOMIE_GLAZE_GRID_COMPONENT_STYLE_LOADED', true);
?>
<style id="gomie-glaze-grid-component-css">
  /* Component: Glaze Collection Grid — Hình ảnh tách nền nằm trên khối text miêu tả */
  .gomie-v11 .glaze-component-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    column-gap: clamp(22px, 2.4vw, 32px);
    row-gap: clamp(32px, 3.6vw, 48px);
    align-items: stretch;
  }

  /* Reset triệt để Bootstrap .card để ảnh tách nền nằm tự do trên nền lụa họa tiết */
  .gomie-v11 .glaze-component-grid .card {
    min-width: 0;
    display: flex;
    background: transparent !important;
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: visible !important;
  }

  .gomie-v11 .glaze-component-grid .card > a {
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    color: inherit !important;
    text-decoration: none !important;
  }

  /* Sân khấu ảnh tách nền cố định chiều cao tuyệt đối giúp 3 cột thẳng hàng 100% */
  .gomie-v11 .glaze-component-grid .photo {
    position: relative;
    z-index: 2;
    height: 275px !important;
    min-height: 275px !important;
    max-height: 275px !important;
    width: 100% !important;
    flex: 0 0 275px !important;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    margin: 0 auto 8px !important;
    padding: 0 !important;
    border: none !important;
    background: transparent !important;
    overflow: visible;
  }

  .gomie-v11 .glaze-component-grid .photo img {
    display: block;
    width: 100% !important;
    height: 275px !important;
    max-width: 410px !important;
    max-height: 275px !important;
    object-fit: contain !important;
    object-position: center bottom !important;
    margin: 0 auto !important;
    mix-blend-mode: normal !important;
    filter: drop-shadow(0 16px 26px rgba(45, 30, 15, 0.12));
    transform-origin: center bottom;
    transform: translateY(var(--img-y, 0px)) scale(var(--img-scale, 1));
    transition: transform .45s cubic-bezier(.2, .8, .2, 1), filter .45s ease;
    will-change: transform;
  }

  /* Khối text miêu tả phía dưới ảnh */
  .gomie-v11 .glaze-component-grid .details {
    position: relative;
    z-index: 1;
    display: flex;
    flex: 1;
    flex-direction: column;
    align-items: flex-start;
    padding: 24px 26px 26px !important;
    min-height: 0;
    background: rgba(255, 255, 255, 0.86) !important;
    backdrop-filter: blur(16px) saturate(180%);
    -webkit-backdrop-filter: blur(16px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.95) !important;
    border-radius: 22px !important;
    box-shadow: 0 12px 32px rgba(45, 30, 15, 0.06), inset 0 1px 1px rgba(255, 255, 255, 0.95) !important;
    transition: transform .35s cubic-bezier(.2, .8, .2, 1), box-shadow .35s cubic-bezier(.2, .8, .2, 1), border-color .35s ease, background .35s ease;
  }

  .gomie-v11 .glaze-component-grid .name {
    margin: 0 0 8px !important;
    font-size: clamp(19px, 1.75vw, 23px) !important;
    font-weight: 750 !important;
    line-height: 1.25 !important;
    letter-spacing: -.025em !important;
    color: #252e35 !important;
    transition: color .3s ease;
  }

  .gomie-v11 .glaze-component-grid .storyline {
    font-size: 13.5px !important;
    font-weight: 700 !important;
    letter-spacing: .01em !important;
    color: var(--orange-deep, #db6109) !important;
    margin: 0 0 12px !important;
    line-height: 1.45 !important;
  }

  .gomie-v11 .glaze-component-grid .description {
    font-size: 13.8px !important;
    line-height: 1.8 !important;
    color: #5d6870 !important;
    margin: 0 !important;
    flex: 1;
  }

  .gomie-v11 .glaze-component-grid .card a:active .details {
    transform: translateY(-1px);
  }

  .gomie-v11 .glaze-component-grid .card a:focus-visible .details {
    outline: 3px solid var(--blue, #046bd2);
    outline-offset: 4px;
  }

  @media (hover: hover) and (pointer: fine) {
    .gomie-v11 .glaze-component-grid .card a:hover .photo img {
      transform: translateY(calc(var(--img-y, 0px) - 8px)) scale(calc(var(--img-scale, 1) * 1.045));
      filter: drop-shadow(0 22px 32px rgba(45, 30, 15, 0.17));
    }
    .gomie-v11 .glaze-component-grid .card a:hover .details {
      transform: translateY(-4px);
      background: rgba(255, 255, 255, 0.96) !important;
      box-shadow: 0 22px 46px rgba(45, 30, 15, 0.11), inset 0 1px 2px rgba(255, 255, 255, 1) !important;
      border-color: rgba(244, 122, 32, 0.45) !important;
    }
    .gomie-v11 .glaze-component-grid .card a:hover .name {
      color: var(--blue, #046bd2) !important;
    }
  }

  @media (max-width: 980px) {
    .gomie-v11 .glaze-component-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 640px) {
    .gomie-v11 .glaze-component-grid {
      grid-template-columns: 1fr;
    }
    .gomie-v11 .glaze-component-grid .photo,
    .gomie-v11 .glaze-component-grid .photo img {
      height: 240px !important;
      min-height: 240px !important;
      max-height: 240px !important;
      flex-basis: 240px !important;
    }
  }
</style>
<?php endif; ?>

<div class="grid glaze-component-grid">
  <?php foreach ($gomie_glaze_collection as $glaze) : ?>
    <article class="card">
      <a aria-label="Khám phá bộ sưu tập <?php echo esc_attr($glaze['name']); ?>" href="<?php echo $gomie_get_glaze_url($glaze['slug']); ?>">
        <div class="photo" style="--img-scale: <?php echo esc_attr($glaze['scale']); ?>; --img-y: <?php echo esc_attr($glaze['shift_y']); ?>;">
          <img alt="Bát gốm sứ <?php echo esc_attr($glaze['name']); ?> Gomie Ceramic" decoding="async" loading="lazy" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/glazes/' . $glaze['img']); ?>" />
        </div>
        <div class="details">
          <h3 class="name"><?php echo esc_html($glaze['name']); ?></h3>
          <p class="storyline"><?php echo esc_html($glaze['storyline']); ?></p>
          <p class="description"><?php echo esc_html($glaze['desc']); ?></p>
        </div>
      </a>
    </article>
  <?php endforeach; ?>
</div>
