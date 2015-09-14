<?php
    get_header();
    $query = $_GET['s'];
?>

<script>
    var query = '<?php echo urldecode($query); ?>';
</script>

<section class="section-featured section-featured-search creamy">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php get_search_form(); ?>
                <div class="search-hits-info"></div>
            </div>
        </div>
    </div>
</section>

<section class="section-search-result">
    <div class="container">
        <?php if (strlen($query) > 0) : ?>
        <div class="row">
            <div class="columns large-12">
                <ul class="pagination" role="menubar" arial-label="pagination">
                    <li><a href="#" data-action="prev-page">&laquo; Föregående</a></li>
                    <li><a href="#" data-action="next-page">Nästa &raquo;</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="columns large-12">
                <ul class="search-result">
                    <li class="loading-results"><i class="hbg-loading">Läser in resultat…</i></li>
                </ul>
            </div>
        </div>

        <div class="row infinite-scroll-load-more" style="display:none;">
            <div class="columns large-12">
                <button class="btn btn-submit btn-block" data-action="infinite-scroll-more">Läs in fler resultat…</button>
            </div>
        </div>

        <div class="row">
            <div class="columns large-12">
                <ul class="pagination" role="menubar" arial-label="pagination">
                    <li><a href="#" data-action="prev-page">&laquo; Föregående</a></li>
                    <li><a href="#" data-action="next-page">Nästa &raquo;</a></li>
                </ul>
            </div>
        </div>
        <?php else : ?>
        <div class="row">
            <div class="columns large-12">Skriv vad du letar efter i sökrutan ovan och klicka på knappen "sök" för att visa resultat.</div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>