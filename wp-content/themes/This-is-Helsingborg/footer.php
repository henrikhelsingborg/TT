        <section class="creamy">
            <div class="container">
                <ul class="row teasers">
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-comment-o"></i>
                        <h3>Tyck till</h3>
                        <p>Hjälp oss att bli bättre genom att lämna dina synpunkter till oss.</p>
                        <button class="btn btn-plain">Skicka in synpunkter</button>
                    </li>
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-wrench"></i>
                        <h3>Felanmälan</h3>
                        <p>Ett trevligare Helsingborg. Här kan du annmäla fel på gator, torg och parker.</p>
                        <button class="btn btn-plain">Gör en felanmälan</button>
                    </li>
                    <li class="columns large-4 medium-4 small-12">
                        <i class="fa fa-map-marker"></i>
                        <h3>Helsingborgskartan</h3>
                        <p>Hitta kommunala verksamheter och service i Helsingborg.</p>
                        <button class="btn btn-plain">Visa kartan</button>
                    </li>
                </ul>
            </div>
        </section>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <div class="site-footer-fun-facts">
                            <div class="row hide-for-medium-only hide-for-small-only">
                                <div class="left columns large-3 medium-3">
                                    <div class="fun-fact">
                                        <div class="fun-fact-title">
                                            <i class="fa fa-home"></i> 136 002
                                        </div>
                                        <div class="fun-fact-caption">Personer är folkbokförda i Helsingborgs kommun (2015-03-31)</div>
                                    </div>
                                </div>
                                <div class="left columns large-3 medium-3">
                                    <div class="fun-fact">
                                        <div class="fun-fact-title">
                                            <i class="fa fa-bicycle"></i> 712
                                        </div>
                                        <div class="fun-fact-caption">Cyklar som passerat mätaren vid Knutpunkten idag.</div>
                                    </div>
                                </div>
                                <div class="left columns large-3 medium-3">
                                    <div class="fun-fact">
                                        <div class="fun-fact-title">
                                            <i class="fa fa-child"></i> 79%
                                        </div>
                                        <div class="fun-fact-caption">Elever i åk. 9 som uppnått målen i alla ämnen år 2014.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <?php
                            if (is_active_sidebar('footer-area')) {
                                dynamic_sidebar('footer-area');
                            }
                        ?>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>