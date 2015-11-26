<?php
    global $searchFormNode;
    $searchFormNode = ($searchFormNode) ? $searchFormNode+1 : 1;
?>
<form class="search" method="get" action="/">
    <div class="form-container">
        <label for="searchkeyword-<?php echo $searchFormNode; ?>" class="search-label search-label-alt">Sök på Helsingborg.se</label>
        <div class="input-group">
            <div class="form-element">
                <input id="searchkeyword-<?php echo $searchFormNode; ?>" <?php if (is_front_page()) echo 'data-autocomplete="pages"'; ?> autocomplete="off" class="form-control" type="search" name="s" placeholder="Vad letar du efter?" value="<?php echo (isset($_GET['s']) && strlen($_GET['s']) > 0) ? urldecode(stripslashes($_GET['s'])) : ''; ?>">
                <?php if (is_front_page()) : ?>
                    <div class="hbg-loading hbg-loading-sm"></div>
                    <ul class="autocomplete"></ul>
                <?php endif; ?>
            </div>
            <div class="form-element">
                <button class="form-control btn btn-submit" type="submit"><i class="fa fa-search"></i>Sök</button>
            </div>
        </div>

        <?php if (is_front_page()) : ?>
        <div class="search-web-archive"><a href="http://helsingborg.arkivbyran.se/"><i class="fa fa-archive"></i>Du kan också söka i webbarkivet</a></div>
        <?php endif; ?>
    </div>
</form>