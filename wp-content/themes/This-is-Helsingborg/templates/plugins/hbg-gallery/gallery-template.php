<ul class="small-block-grid-1 medium-block-grid-2 hbg-gallery-container">
    <?php foreach ($galleryItems as $item) : $item = (object) $item; ?>
    <li style="background-image: url('<?php echo $item->image_url?>');" class="hbg-gallery-item hbg-gallery-item-<?php echo $item->media; ?>" <?php if ($item->media == 'youtube') : ?>data-youtube="<?php echo $item->url; ?>"<?php endif; ?>>
        <?php if ($item->media == 'youtube') : ?>
            <i class="hbg-gallery-media-icon fa fa-youtube-play"></i>
        <?php elseif ($item->media == 'image') : ?>
            <i class="hbg-gallery-media-icon fa fa-plus-circle"></i>
        <?php endif; ?>

        <button class="modal-close" data-action="gallery-zoom-out"><i class="fa fa-times-circle"></i></button>
    </li>
    <?php endforeach; ?>
</ul>