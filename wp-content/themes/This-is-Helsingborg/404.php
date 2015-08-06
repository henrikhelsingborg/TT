<?php

    get_header();

    $searchKeyword = $_SERVER['REQUEST_URI'];
    $searchKeyword = str_replace('/', ' ', $searchKeyword);
    $searchKeyword = trim($searchKeyword);
    $_GET['s'] = $searchKeyword;

?>

    <script>
        var query = '<?php echo urldecode($searchKeyword); ?>';
    </script>

    <section class="creamy message">
        <h1>
            <span class="error-code">404</span>
            <span class="error-message">Sidan hittades inte.</span>
        </h1>
        <p>
            Den sida du vill nå kan inte hittas. Vi har nedan försökt hitta andra sidor som kanske kan innehålla den information du letar efter.
        </p>
    </section>

    <ul class="error-shortcuts">
        <li><a href="/">Gå till startsidan</a></li>
        <li><a href="/?s=">Gå till sök</a></li>
    </ul>

    <section class="section-featured section-featured-search">
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
                        <li class="loading-results"><i class="hbg-loading">Söker…</i></li>
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
        </div>
    </section>

    <?php get_footer(); ?>
</body>
</html>