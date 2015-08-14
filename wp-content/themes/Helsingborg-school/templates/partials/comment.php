<?php if ($comment->comment_approved) : ?>
<li class="comment">
    <div class="comment-info">
        <span class="comment-author"><?php echo $comment->comment_author; ?></span>, <span class="comment-date"><?php echo date('Y-m-d H:i', strtotime($comment->comment_date)); ?></span>
    </div>
    <div class="comment-text"><?php echo $comment->comment_content; ?></div>
</li>
<?php endif; ?>