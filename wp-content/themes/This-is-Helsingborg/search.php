<?php
    get_header();
    $query = $_GET['s'];
?>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
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
                <ul class="search-result">
                    <li class="event-times-loading"><i class="hbg-loading">Söker efter "<?php echo $query; ?>"…</i></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>