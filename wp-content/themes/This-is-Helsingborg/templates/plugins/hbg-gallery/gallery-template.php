<ul class="small-block-grid-1 medium-block-grid-2">
    <?php foreach ($galleryItems as $item) : $item = (object) $item; ?>
    <li style="background-image: url('<?php echo $item->image_url?>');">
        <a
            data-reveal="gallery-modal-<?php echo $attr[0]; ?>"
            href="#"
            class="hbg-gallery-item hbg-gallery-item-<?php echo $item->media; ?>"
            data-title="<?php echo $item->title; ?>"
            data-description="<?php echo $item->title; ?>"
            <?php if ($item->media == 'youtube') : ?>data-youtube="<?php echo $item->url; ?>"<?php endif; ?>
            <?php if ($item->media == 'image') : ?>data-image="<?php echo $item->image_url; ?>"<?php endif; ?>
        >
            <?php if ($item->media == 'youtube') : ?>
                <i class="hbg-gallery-media-icon fa fa-youtube-play"></i>
            <?php elseif ($item->media == 'image') : ?>
                <i class="hbg-gallery-media-icon fa fa-picture-o"></i>
            <?php endif; ?>
        </a>
    </li>
    <?php endforeach; ?>
</ul>

<div id="gallery-modal-<?php echo $attr[0]; ?>" class="modal">
    <div class="modal-content">
        <button class="modal-close" data-action="modal-close"><i class="fa fa-times-circle"></i></button>
        <div class="modal-media"></div>
        <div class="modal-text"></div>
    </div>
</div>