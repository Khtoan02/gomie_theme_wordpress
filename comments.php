<?php
/**
 * The template for displaying comments
 *
 * @package Gomie
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area glass-card p-4 p-md-5 my-5">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title mb-4">
            <i class="far fa-comments text-primary me-2"></i>
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('Một bình luận cho &ldquo;%1$s&rdquo;', 'gomie-theme'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s bình luận cho &ldquo;%2$s&rdquo;', '%1$s bình luận cho &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'gomie-theme')),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h3>

        <ol class="comment-list list-unstyled">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 54,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '<i class="fas fa-chevron-left me-1"></i> ' . esc_html__('Bình luận cũ hơn', 'gomie-theme'),
            'next_text' => esc_html__('Bình luận mới hơn', 'gomie-theme') . ' <i class="fas fa-chevron-right ms-1"></i>',
        ));

        if (!comments_open()) :
            ?>
            <p class="no-comments text-muted text-center py-3">
                <i class="fas fa-lock me-1"></i> <?php esc_html_e('Bình luận đã đóng cho bài viết này.', 'gomie-theme'); ?>
            </p>
        <?php
        endif;

    endif; // have_comments()

    comment_form(array(
        'class_form'           => 'comment-form mt-4',
        'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title fs-4 fw-bold mb-3"><i class="fas fa-pen-nib text-secondary me-2"></i>',
        'title_reply_after'    => '</h4>',
        'class_submit'         => 'glass-button btn-primary px-4 py-2 rounded-pill fw-bold text-white',
        'comment_notes_before' => '<p class="comment-notes small text-muted mb-3">' . esc_html__('Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu *', 'gomie-theme') . '</p>',
    ));
    ?>

</div><!-- #comments -->
