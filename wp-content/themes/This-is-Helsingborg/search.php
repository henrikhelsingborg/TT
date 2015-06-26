<?php
    get_header();
    $query = $_GET['s'];
?>

<script>
    var query = '<?php echo $query; ?>';
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
                    <li class="event-times-loading"><i class="hbg-loading">Läser in resultat…</i></li>
                </ul>
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