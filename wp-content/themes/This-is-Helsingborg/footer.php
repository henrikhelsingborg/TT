        </main>

        <?php if (is_active_sidebar('service-area')) : ?>
        <section class="creamy service-area">
            <div class="container">
                <div class="row">
                <?php dynamic_sidebar('service-area'); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <footer class="site-footer print-hidden">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <?php get_template_part('templates/partials/footer', 'fun-facts'); ?>
                    </div>
                </div>
            </div>
            <div class="site-footer-content">
                <?php get_template_part('templates/partials/stripe'); ?>
                <div class="container">
                    <div class="row">
                        <div class="columns large-3">
                            <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg-neg.svg" alt="Helsingborg Stad" width="239" height="68"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="columns large-8 medium-8">
                            <div class="row">
                            <?php
                                if (is_active_sidebar('footer-area')) {
                                    dynamic_sidebar('footer-area');
                                }
                            ?>
                            </div>
                        </div>
                        <div class="columns large-3 medium-4 right footer-help">
                            <?php
                                /**
                                 * Displays the main menu navigation
                                 */
                                wp_nav_menu(array(
                                    'theme_location'  => 'footer-menu',
                                    'container'       => null,
                                    'container_class' => null,
                                    'items_wrap'      => '<ul class="nav nav-block-list nav-footer-menu">%3$s</ul>',
                                    'depth'           => 1
                                ));
                            ?>
                            <div id="google-translate-element"></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
    <?php wp_footer(); ?>

    <script type="text/javascript">function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:"sv",autoDisplay:false,gaTrack:true,gaId:"UA-16678811-1"},"google-translate-element");}</script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PVK49V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>
        // GA
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-16678811-1', 'auto');
        ga('send', 'pageview');

        // TM
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PVK49V');
    </script>
</body>
</html>