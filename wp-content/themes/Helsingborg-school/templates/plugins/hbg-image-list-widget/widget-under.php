<?php echo $before_widget; ?>
    <ul class="block-list news-block large-block-grid-<?php echo $grid_size; ?> medium-block-grid-<?php echo $grid_size; ?> small-block-grid-2">
        <?php foreach ($items as $num => $item) : ?>
            <li>
                <a href="<?php echo $item_links[$num]; ?>"><img src="<?php echo $item_imageurl[$num]; ?>" alt="<?php echo $item_alts[$num]; ?>" /></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php echo $after_widget; ?>