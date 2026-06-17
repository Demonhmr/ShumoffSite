<?php
/**
 * Shumoff Theme - Comments Template
 *
 * @package Shumoff_Theme
 */

if ( post_password_required() ) {
    return;
}
?>

<section class="comments-section" id="comments">
    <div class="container">
        <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ( '1' === $comment_count ) {
                printf(
                    esc_html__( 'Один ответ на "%s"', 'shumoff' ),
                    esc_html( get_the_title() )
                );
            } else {
                printf(
                    esc_html( _nx( '%s ответ', '%s ответа', $comment_count, 'comments title', 'shumoff' ) ),
                    number_format_i18n( $comment_count )
                );
            }
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'callback'   => 'shumoff_comment_callback',
            ) );
            ?>
        </ul>

        <?php
        the_comments_navigation();

        if ( ! comments_open() ) :
        ?>
        <p class="no-comments"><?php _e( 'Комментарии закрыты.', 'shumoff' ); ?></p>
        <?php endif; ?>
        <?php endif; ?>

        <?php
        comment_form( array(
            'title_reply'    => __( 'Оставить комментарий', 'shumoff' ),
            'title_reply_to' => __( 'Ответ на %s', 'shumoff' ),
            'label_submit'   => __( 'Отправить', 'shumoff' ),
            'cancel_reply_link' => __( 'Отменить ответ', 'shumoff' ),
            'class_submit'   => 'btn btn--primary',
        ) );
        ?>
    </div>
</section>
<?php

/**
 * Custom comment callback
 */
function shumoff_comment_callback( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
    <article class="comment-body" id="div-comment-<?php comment_ID(); ?>">
        <div class="comment-author vcard">
            <?php echo get_avatar( $comment, 60 ); ?>
            <div class="comment-author-info">
                <cite class="fn"><?php echo esc_html( get_comment_author() ); ?></cite>
                <span class="comment-date">
                    <?php echo get_comment_date(); ?> в <?php echo get_comment_time(); ?>
                </span>
            </div>
        </div>
        <?php if ( '0' === $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Ваш комментарий ожидает модерации.', 'shumoff' ); ?></em>
        <?php endif; ?>
        <div class="comment-content">
            <?php comment_text(); ?>
        </div>
        <div class="comment-reply-link">
            <?php
            comment_reply_link( array_merge( $args, array(
                'add_below' => 'comment',
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
                'before'    => '<span class="reply">',
                'after'     => '</span>',
            ) ) );
            ?>
        </div>
    </article>
<?php
}
?>
