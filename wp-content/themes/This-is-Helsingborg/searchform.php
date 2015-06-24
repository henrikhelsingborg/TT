<form class="<?php echo (is_front_page()) ? 'hero-search center-vertical' : 'sidebar-search'; ?>" method="get" role="search" action="/">
    <?php echo (is_front_page()) ? '<div class="inline-block">' : ''; ?>
    <div class="input-group">
        <div class="form-element">
            <input class="form-control" type="search" name="s" placeholder="Här kan du skriva vad du letar efter…" value="<?php echo (isset($_GET['s']) && strlen($_GET['s']) > 0) ? $_GET['s'] : ''; ?>">
        </div>
        <div class="form-element">
            <button class="form-control btn btn-submit" type="submit"><?php echo (is_front_page()) ? '<i class="fa fa-search"></i>' : 'Sök'; ?></button>
        </div>
    </div>
    <?php echo (is_front_page()) ? '</div>' : ''; ?>
</form>