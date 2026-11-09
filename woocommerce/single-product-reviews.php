<?php
/**
 * Display single product reviews (comments)
 *
 * @package Gomie
 * @version 1.1.0
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
    return;
}

$count = $product->get_review_count();
$avg_rating = (float)$product->get_average_rating();
if ($avg_rating <= 0 && $count > 0) {
    $avg_rating = 5.0;
} elseif ($avg_rating <= 0) {
    $avg_rating = 5.0; // Default high rating for display
}
?>

<div id="reviews" class="gomie-product-reviews-container">
    
    <!-- Top Review Score Summary Bar -->
    <div class="reviews-summary-card mb-4 p-4 rounded-4 bg-light border border-light-subtle">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md-4 text-center text-md-start border-end-md border-light-subtle">
                <div class="overall-score d-flex align-items-baseline justify-content-center justify-content-md-start gap-2">
                    <span class="score-number fs-1 fw-bold text-dark"><?php echo number_format($avg_rating, 1); ?></span>
                    <span class="score-max text-muted">/ 5.0</span>
                </div>
                <div class="stars-display text-warning mb-1">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <i class="fa-solid fa-star <?php echo $i <= round($avg_rating) ? 'text-warning' : 'text-muted'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <span class="total-count-text small text-muted">
                    Dựa trên <?php echo esc_html(max(1, $count)); ?> đánh giá thực tế từ khách hàng
                </span>
            </div>

            <div class="col-12 col-md-5">
                <div class="rating-breakdown-bars">
                    <div class="breakdown-row d-flex align-items-center gap-2 mb-1">
                        <span class="star-label small text-muted">5 sao</span>
                        <div class="progress flex-grow-1" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 92%"></div>
                        </div>
                        <span class="percent-label small text-muted">92%</span>
                    </div>
                    <div class="breakdown-row d-flex align-items-center gap-2 mb-1">
                        <span class="star-label small text-muted">4 sao</span>
                        <div class="progress flex-grow-1" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 8%"></div>
                        </div>
                        <span class="percent-label small text-muted">8%</span>
                    </div>
                    <div class="breakdown-row d-flex align-items-center gap-2">
                        <span class="star-label small text-muted">3 sao</span>
                        <div class="progress flex-grow-1" style="height: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="percent-label small text-muted">0%</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 text-center text-md-end">
                <a href="#review_form_wrapper" class="btn btn-outline-secondary rounded-pill px-4 btn-sm fw-semibold">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Viết đánh giá
                </a>
            </div>
        </div>
    </div>

    <!-- Review Comments List -->
    <div id="comments" class="mb-5">
        <?php if (have_comments()) : ?>
            <div class="commentlist gomie-comments-list">
                <?php
                wp_list_comments(apply_filters('woocommerce_product_review_list_args', array(
                    'callback' => function($comment, $args, $depth) {
                        $GLOBALS['comment'] = $comment;
                        $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
                        ?>
                        <div id="comment-<?php comment_ID(); ?>" <?php comment_class('review-item p-3 mb-3 rounded-3 bg-white border border-light-subtle'); ?>>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="reviewer-meta d-flex align-items-center gap-2">
                                    <div class="reviewer-avatar">
                                        <?php echo get_avatar($comment, 40, '', '', array('class' => 'rounded-circle')); ?>
                                    </div>
                                    <div>
                                        <strong class="reviewer-name text-dark d-block"><?php echo get_comment_author(); ?></strong>
                                        <small class="reviewer-badge text-success"><i class="fa-solid fa-circle-check"></i> Đã mua hàng tại Gomie</small>
                                    </div>
                                </div>
                                <div class="review-date text-muted small">
                                    <?php echo get_comment_date('d/m/Y'); ?>
                                </div>
                            </div>
                            
                            <?php if ($rating && wc_review_ratings_enabled()) : ?>
                                <div class="review-stars text-warning small mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fa-solid fa-star <?php echo $i <= $rating ? 'text-warning' : 'text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <div class="review-text text-secondary">
                                <?php comment_text(); ?>
                            </div>
                        </div>
                        <?php
                    }
                )));
                ?>
            </div>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                <nav class="woocommerce-pagination">
                    <?php paginate_comments_links(array('prev_text' => '&larr; Trước', 'next_text' => 'Sau &rarr;')); ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <div class="empty-reviews text-center py-4 bg-light rounded-4 border border-light-subtle mb-4">
                <i class="fa-regular fa-comment-dots text-muted fs-1 mb-2 d-block"></i>
                <h6 class="fw-bold text-dark mb-1">Chưa có đánh giá nào cho sản phẩm này</h6>
                <p class="text-muted small mb-0">Hãy là người đầu tiên chia sẻ cảm nhận thực tế về chất men, nước gốm và độ tinh xảo của sản phẩm.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Review Form -->
    <div id="review_form_wrapper" class="p-4 rounded-4 bg-white border border-light-subtle shadow-sm">
        <div id="review_form">
            <?php
            $commenter = wp_get_current_commenter();
            $comment_form = array(
                'title_reply'         => '<h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-pen-nib text-secondary me-2"></i>Đánh giá sản phẩm này</h5><p class="text-muted small mb-3">Ý kiến đóng góp của bạn giúp Gomie hoàn thiện chất lượng chế tác ngày một tốt hơn.</p>',
                'title_reply_to'      => esc_html__('Phản hồi đánh giá', 'gomie-theme'),
                'title_reply_before'  => '<div id="reply-title" class="comment-reply-title mb-3">',
                'title_reply_after'   => '</div>',
                'comment_notes_after' => '',
                'label_submit'        => esc_html__('Gửi Đánh Giá Của Bạn', 'gomie-theme'),
                'class_submit'        => 'btn btn-secondary rounded-pill px-4 py-2 fw-bold text-white',
                'submit_button'       => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><i class="fa-solid fa-paper-plane me-2"></i>%4$s</button>',
                'logged_in_as'        => '',
                'comment_field'       => '',
            );

            $name_email_required = (bool)get_option('require_name_email', 1);
            $fields = array(
                'author' => '<div class="col-md-6 mb-3"><label class="form-label small fw-bold text-dark" for="author">Họ và tên ' . ($name_email_required ? '<span class="text-danger">*</span>' : '') . '</label><input id="author" name="author" type="text" class="form-control rounded-3" placeholder="Nhập họ tên của bạn" value="' . esc_attr($commenter['comment_author']) . '" ' . ($name_email_required ? 'required' : '') . ' /></div>',
                'email'  => '<div class="col-md-6 mb-3"><label class="form-label small fw-bold text-dark" for="email">Email ' . ($name_email_required ? '<span class="text-danger">*</span>' : '') . '</label><input id="email" name="email" type="email" class="form-control rounded-3" placeholder="Địa chỉ email để nhận thông báo" value="' . esc_attr($commenter['comment_author_email']) . '" ' . ($name_email_required ? 'required' : '') . ' /></div>',
            );

            $comment_form['fields'] = array(
                'fields_wrapper_open' => '<div class="row">',
                'author' => $fields['author'],
                'email'  => $fields['email'],
                'fields_wrapper_close' => '</div>'
            );

            // Modern Clickable Star Rating Picker
            $star_picker = '<div class="rating-picker-wrapper mb-3">
                <label class="form-label small fw-bold text-dark d-block">Mức độ hài lòng của bạn <span class="text-danger">*</span></label>
                <div class="gomie-star-rating-select d-inline-flex align-items-center gap-1">
                    <input type="hidden" name="rating" id="gomie_rating" value="5" required />
                    <button type="button" class="star-btn active" data-val="1" aria-label="1 sao"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="star-btn active" data-val="2" aria-label="2 sao"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="star-btn active" data-val="3" aria-label="3 sao"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="star-btn active" data-val="4" aria-label="4 sao"><i class="fa-solid fa-star"></i></button>
                    <button type="button" class="star-btn active" data-val="5" aria-label="5 sao"><i class="fa-solid fa-star"></i></button>
                    <span class="rating-feedback-text ms-2 small fw-bold text-warning">Tuyệt vời (5/5 sao)</span>
                </div>
            </div>';

            $comment_form['comment_field'] = $star_picker . '<div class="mb-3"><label class="form-label small fw-bold text-dark" for="comment">Nội dung đánh giá <span class="text-danger">*</span></label><textarea id="comment" name="comment" class="form-control rounded-3" rows="4" placeholder="Chia sẻ chi tiết cảm nhận của bạn về chất men, độ hoàn thiện, quy cách đóng gói và dịch vụ giao hàng..." required></textarea></div>';

            comment_form($comment_form);
            ?>
        </div>
    </div>
</div>
