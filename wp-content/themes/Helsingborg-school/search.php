<?php
    get_header();
    $query = $_GET['s'];
?>

<div class="content-container">
    <div class="row">
        <div class="main-content columns large-12">
            <article class="article" id="article">
                <header>
                    <h1 class="article-title">Sök: <?php echo $query; ?></h1>
                    <div class="search-hits-info"></div>
                    <?php get_template_part('templates/partials/accessability','menu'); ?>
                </header>

                <ul class="pagination"></ul>
                <ul id="search" class="list search-result"></ul>
                <ul class="pagination"></ul>
            </article>
        </div>
    </div>

    <div class="row infinite-scroll-load-more" style="display:none;">
        <div class="columns large-12">
            <button class="button button-block" data-action="infinite-scroll-more">Läs in fler resultat…</button>
        </div>
    </div>
</div>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    var query = '<?php echo $query; ?>';
</script>

<?php get_footer(); ?>
