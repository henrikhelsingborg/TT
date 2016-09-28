<?php

    /**
     * Adds static menu items to the main menu
     * @return string The menu wrapper
     */
    function sidebarMenuStaticItems() {

        /**
         * Set up split test
         * @var hbgSplitTest
         */
        /*
        $splitTest = new hbgSplitTest();
        $splitTest
            ->addVariation('a', '<i class="fa fa-search"></i>')
            ->addVariation('b', '<i class="fa fa-search-plus"></i>');
        */

        /**
         * Get the split test Google Experiment code
         * @var [type]
         */
        //$script = $splitTest->getScript('103617170-1');

        // <a href="#" onclick="ga(\'send\', \'event\', \'Search Toggle\', \'Click\', \'Opened search\');">' . $splitTest->getVariation() . '</a>

        $wrap = '<ul class="%2$s">';
        $wrap .= '%3$s';
        $wrap .= '<li class="item-search">
                    <a href="#"><i class="fa fa-search"></i></a>
                    <div class="search-container">
                        <form id="searchform" class="search-inputs" action="' . get_site_url() . '/" method="get" role="search">
                            <div class="row collapse">
                                <div class="small-10 columns">
                                    <input id="s" class="input-field" type="text" placeholder="Vad letar du efter?" name="s" value="">
                                </div>
                                <div class="small-2 columns">
                                    <button id="searchsubmit" class="button search" type="submit">Sök</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </li>';

        $wrap .= '<li class="item-translate">
                        <a href="#translate"><i class="fa fa-globe"></i></a>
                        <div id="translate" class="translate-container google-translate google-translate-fold target-toggle">
                            <h3>Translate</h3>
                            <p>
                                You can use Google Translate to translate the contents of this site. To do that, select the language you would like to translate into in the lost below.
                            </p>
                            <div id="google-translate-element" class="gutter gutter-vertical"></div>
                        </div>
                    </li>';


        $wrap .= '</ul>';

        return $wrap;
    }

    /**
     * Adds static menu items to the mobile menu
     * @return string The menu wrapper
     */
    function mobileMenuStaticItems() {
        $wrap = '<ul class="%2$s">';
        $wrap .= '%3$s';
        $wrap .= '</ul>';

        return $wrap;
    }
