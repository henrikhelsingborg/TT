<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <?php if (get_comments_number() <> 1) : ?>
        <h2 class="comments-title"><?php echo get_comments_number(); ?> kommentarer till "<?php echo get_the_title(); ?>"</h2>
        <?php else : ?>
        <h2 class="comments-title"><?php echo get_comments_number(); ?> kommentar till "<?php echo get_the_title(); ?>"</h2>
        <?php endif; ?>

        <ol class="comment-list">
            <?php
                wp_list_comments(array(
                    'style'       => 'ul',
                    'short_ping'  => false,
                    'avatar_size' => 56,
                    'callback' => 'custom_comment_markup'
                ));
            ?>
        </ol>
    <?php endif; // have_comments() ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'helsingborg' ); ?></p>
    <?php endif; ?>

    <?php
        comment_form(array(
            'class_submit' => 'button',
            'comment_notes_after' => ''
        ));
    ?>
</div><!-- .comments-area -->
