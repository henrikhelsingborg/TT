<?php
    get_header();
    $query = $_GET['s'];
    $index = 1;
    if (isset($_GET['index']) && is_numeric($_GET['index'])) {
        $index = $_GET['index'];
    }

    $search = new Helsingborg\Search\GoogleSearch($query, $index);
    $searchResult = $search->results;
?>

<section class="section-featured section-featured-search creamy">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php get_search_form(); ?>
                <div class="search-hits-info">
                    <span class="search-hits"><?php echo $searchResult->searchInformation->formattedTotalResults; ?></span> träffar på <span class="search-query"><?php echo urldecode(stripslashes($searchResult->queries->request[0]->searchTerms)); ?></span> inom Helsingborg.se
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

                    <?php foreach ($searchResult->items as $item) : ?>
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
                    <?php endforeach; ?>

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