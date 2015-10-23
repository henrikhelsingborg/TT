<?php
    get_header();

    $index = 1;
    if (isset($_GET['index']) && is_numeric($_GET['index'])) {
        $index = $_GET['index'];
    }

    $searchKeyword = $_SERVER['REQUEST_URI'];
    $searchKeyword = str_replace('/', ' ', $searchKeyword);
    $searchKeyword = trim($searchKeyword);
    
    if (!isset($_GET['index'])) {
        $_GET['s'] = $searchKeyword;
    }

    $query = urldecode(stripslashes($_GET['s']));

    $search = new Helsingborg\Search\GoogleSearch($query, $index);
    $searchResult = $search->results;
?>

<section class="creamy message">
    <h1>
        <span class="error-code">404</span>
        <span class="error-message">Sidan hittades inte.</span>
    </h1>
    <p>
        Den sida du vill nå kan inte hittas.
        Vi har nedan försökt hitta andra sidor som kanske kan innehålla den information du letar efter.
    </p>
</section>

<ul class="error-shortcuts">
    <li><a href="/">Gå till startsidan</a></li>
    <li><a href="/?s=">Gå till sök</a></li>
</ul>

<section class="section-featured section-featured-search creamy">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php get_search_form(); ?>
                <div class="search-hits-info">
                    <span class="search-hits">
                        <?php echo $searchResult->searchInformation->formattedTotalResults; ?>
                    </span>
                    träffar på
                    <span class="search-query">
                        <?php echo urldecode(stripslashes($searchResult->queries->request[0]->searchTerms)); ?>
                    </span>
                    inom Helsingborg.se
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-search-result">
    <div class="container">
        <?php if (strlen($query) > 0) : ?>
        <div class="row">
            <div class="columns large-12">
                <?php echo $search->pagination(); ?>
            </div>
        </div>

        <div class="row">
            <div class="columns large-12">
                <ul class="search-result">

                    <?php
                    if (count($searchResult->items) > 0) :
                    foreach ($searchResult->items as $item) :
                    ?>
                    <li class="search-result-item">
                        <div class="search-result-item-content">
                            <span class="search-result-item-date"><?php echo $search->getModifiedDate($item); ?></span>
                            <h3><a href="<?php echo $item->link; ?>" class="<?php echo $search->getFiletypeClass($item->fileFormat); ?>"><?php echo $item->htmlTitle; ?></a></h3>
                            <p><?php echo trim($item->htmlSnippet); ?></p>
                            <div class="search-result-item-info">
                                <span class="search-result-item-url"><i class="fa fa-globe"></i> <a href="<?php echo $item->link; ?>"><?php echo $item->htmlFormattedUrl; ?></a></span>
                            </div>
                        </div>
                    </li>
                    <?php
                    endforeach;
                    else :
                    ?>
                    <li>Din sökning gav inga resultat</li>
                    <?php endif; ?>
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
                <?php echo $search->pagination(); ?>
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