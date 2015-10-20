<?php
/*
Template Name: Lista
*/

global $post;

use Helsingborg\Theme;

$listPage = new Theme\ListPage;
$listPage->setPageId($post->ID);
$listItems = $listPage->getList();

$centerClasses = 'large-6 medium-6 small-12';

if (!is_active_sidebar('right-sidebar')) {
    $centerClasses = 'large-9 medium-9 small-12';
}

//var_dump($listPage->headers);

get_header();

?>

<section class="section-article">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php the_breadcrumb(); ?>
            </div>
        </div>

        <div class="row">
            <?php get_template_part('templates/partials/sidebar', 'left'); ?>

            <div class="columns <?php echo $centerClasses; ?>">
                <?php get_template_part('templates/partials/article'); ?>

                <div class="table-list-filter" data-filter-table="#table-list-table" data-filter-table-selector="tbody">
                    <div class="row">
                        <div class="columns large-11">
                            <label class="form-label" for="table-list-filter-input">Sök i listan:</label>
                            <input type="search" data-filter-table-input class="form-control" id="table-list-filter-input">
                        </div>
                    </div>
                </div>
                <table class="table-list" id="table-list-table">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                            $int = 0;

                            foreach ($listPage->headers as $header) {
                                $int++;
                                echo('<th class="header">' . $header . '</th>');
                            }
                            ?>
                        </tr>
                    </thead>

                    <?php $cc = 0; foreach ($listItems as $item) : $cc++; ?>
                    <tbody>
                        <tr class="table-item test-<?php echo $cc; ?>">
                            <?php
                            foreach ($listPage->headerKeys as $key => $value) {
                                echo('<td>' . $item['item' . $key] . '</td>');
                            }
                            ?>
                        </tr>
                        <tr class="table-content">
                            <td colspan="<?php echo count($listPage->headers); ?>"><article class="article"><div class="article-body"><?php echo $item['content']; ?></div></article></td>
                        </tr>
                    </tbody>
                 <?php endforeach; ?>
                </table>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar("content-area"); ?>
                </div>
                <?php endif; ?>

                <?php get_template_part('templates/partials/article', 'share'); ?>
            </div>

            <?php
            if (is_active_sidebar('right-sidebar')) {
                get_template_part('templates/partials/sidebar', 'right');
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>