<?php
    $easyToRead = get_post_meta($post->ID, 'hbg_easy_to_read', TRUE);
?>
<ul class="article-accessibility list list-plain list-horizontal clearfix">
    <li><a href="#" title="Lyssna på innehållet"><i class="fa fa-volume-up"></i> Lyssna</a></li>
    <?php if ($easyToRead) : ?>
    <li><a href="<?php echo $easyToRead; ?>" title="Lättläst version av innehållet"><i class="fa fa-font"></i> Lättläst</a></li>
    <?php endif; ?>
</ul>