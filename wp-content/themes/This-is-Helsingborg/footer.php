        <section class="creamy">
            <div class="container">
                <ul class="row teasers">
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-comment-o"></i>
                        <h3>Tyck till</h3>
                        <p>Hjälp oss att bli bättre genom att lämna dina synpunkter till oss.</p>
                        <a href="#" class="btn btn-plain">Skicka in synpunkter</a>
                    </li>
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-wrench"></i>
                        <h3>Felanmälan</h3>
                        <p>Ett trevligare Helsingborg. Här kan du annmäla fel på gator, torg och parker.</p>
                        <a href="#" class="btn btn-plain">Gör en felanmälan</a>
                    </li>
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-map-marker"></i>
                        <h3>Helsingborgskartan</h3>
                        <p>Hitta kommunala verksamheter och service i Helsingborg.</p>
                        <a href="#" class="btn btn-plain">Visa kartan</a>
                    </li>
                </ul>
            </div>
        </section>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <?php get_template_part('templates/partials/footer', 'fun-facts'); ?>
                    </div>
                </div>
            </div>
            <div class="site-footer-content">
                <div class="stripe"></div>
                <div class="container">
                    <div class="row">
                        <div class="columns large-3">
                            <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg-neg.svg" alt="Helsingborg Stad"></a>
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
                        <div class="columns large-3 medium-4 right">
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

    <?php wp_footer(); ?>

    <script type="text/javascript">function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:"sv",autoDisplay:false,gaTrack:true,gaId:"UA-16678811-1"},"google-translate-element");}</script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>