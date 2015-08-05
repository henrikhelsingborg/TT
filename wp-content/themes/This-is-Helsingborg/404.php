<?php

    $searchKeyword = $_SERVER['REQUEST_URI'];
    $searchKeyword = str_replace('/', ' ', $searchKeyword);
    $searchKeyword = trim($searchKeyword);
    $_GET['s'] = $searchKeyword;

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Helsingborg stad</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="pubdate" content="<?php echo the_time('d M Y'); ?>">
    <meta name="moddate" content="<?php echo the_modified_time('d M Y'); ?>">

    <meta name="google-translate-customization" content="10edc883cb199c91-cbfc59690263b16d-gf15574b8983c6459-12">

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-precomposed.png">

    <script>
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var query = '<?php echo $searchKeyword; ?>';
    </script>

    <?php wp_head(); ?>
</head>
<body id="page-not-found">
    <header>
        <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad"></a>
    </header>

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
                        <li class="event-times-loading"><i class="hbg-loading">Letar efter sidor…</i></li>
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
</body>
</html>