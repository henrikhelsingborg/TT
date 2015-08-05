<form class="search" method="get" role="search" action="/">
    <div class="form-container">
        <h2><strong>Hej,</strong> vad letar du efter?</h2>
        <div class="input-group">
            <div class="form-element">
                <input <?php if (is_front_page()) echo 'data-autocomplete="pages"'; ?> autocomplete="off" class="form-control" type="search" name="s" placeholder="<?php echo (is_front_page()) ? 'Här kan du skriva vad du letar efter…' : 'Vad letar du efter?'; ?>" value="<?php echo (isset($_GET['s']) && strlen($_GET['s']) > 0) ? urldecode($_GET['s']) : ''; ?>">
                <?php if (is_front_page()) : ?>
                    <div class="hbg-loading hbg-loading-sm"></div>
                    <ul class="autocomplete"></ul>
                <?php endif; ?>
            </div>
            <div class="form-element">
                <button class="form-control btn btn-submit" type="submit"><i class="fa fa-search"></i>Sök</button>
            </div>
        </div>
    </div>
</form>