<?php
    /*
    Template Name: Start
    */

    get_header();
?>

<?php if (is_active_sidebar('slider-area')) : ?>
<section class="section-featured creamy">
    <div class="container">
        <div class="row">
            <?php dynamic_sidebar('slider-area'); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section-news">
    <div class="container">

        <div class="row">
            <div class="columns large-12">
                <h2 class="text-magenta"><i class="fa fa-newspaper-o"></i> Aktuellt i Helsingborg</h2>
            </div>

            <div class="index" data-equalizer>
                <div class="columns large-4 medium-6">
                    <a href="#" class="index-item" data-equalizer-watch>
                        <img src="http://www.helsingborg.se/wp-content/uploads/2014/12/nsr_avfallskarl_300x200_foto_NSR_Rickard_Johansson_Studio-E.jpg">
                        <span class="index-caption">Ändrade dagar för sophämtning i midsommar</span>
                    </a>
                </div>
                <div class="columns large-4 medium-6">
                    <a href="#" class="index-item" data-equalizer-watch>
                        <img src="http://www.helsingborg.se/wp-content/uploads/2015/01/sommarlov-nyhet.jpg">
                        <span class="index-caption">Sommarlovsprogrammet är här</span>
                    </a>
                </div>
                <div class="columns large-4 medium-6 end">
                    <a href="#" class="index-item" data-equalizer-watch>
                        <img src="http://www.helsingborg.se/wp-content/uploads/2015/06/kommunfullmaktige_300.jpg">
                        <span class="index-caption">Kommunfullmäktige beslutar om budgeten</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="columns large-6 medium-6">
                <div class="box box-outlined">
                    <h3>Nyheter</h3>
                    <div class="box-content">
                        <ul class="list list-links">
                            <li><a href="#" class="link-item">Välavägen avstängd från 15 juni</a></li>
                            <li><a href="#" class="link-item">Trafiken i korsning på Malmöleden påverkas från måndag 15 juni</a></li>
                            <li><a href="#" class="link-item">Snart har du tidningen Vår stad i din brevlåda</a></li>
                            <li><a href="#" class="link-item">Upplev Helsingborgs vattenliv i sommar</a></li>
                            <li><a href="#" class="link-item">Busslinjer får nya körvägar när sommartidtabellen börjar gälla</a></li>
                            <li><a href="#" class="link-item">Följ med på båttur med Sabella och titta på Öresunds bottendjur</a></li>
                            <li><a href="#" class="link-item">Energisnålt byggande kan premieras</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="columns large-6 medium-6">
                <div class="box box-outlined">
                    <h3>Evenemang</h3>
                    <div class="box-content">
                        <ul class="list list-events">
                            <li>
                                <a href="#" class="event-item featured">
                                    <div class="columns large-4 medium-4 small-12 featured-image">
                                        <img src="http://www.fredriksdal.se/ImageVaultFiles/id_54706/cf_127/480x270-fredriksdal140_RalfEkvall.PNG" class="responsive">
                                    </div>
                                    <div class="columns large-8 medium-8 small-12">
                                        Välkommen till Helsingborgs officiella nationaldagsfirande på Fredriksdal den 6 juni.
                                        <span class="link-item link-item-light">Läs mer och se programmet här</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="event-item">
                                    <span class="date">
                                        <span class="date-day"><strong>Idag</strong></span>
                                        <span class="date-time">10:00</span>
                                    </span>
                                    <span class="title link-item">Sommarteater i Det Gröna</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="event-item">
                                    <span class="date">
                                        <span class="date-day"><strong>Idag</strong></span>
                                        <span class="date-time">11:00</span>
                                    </span>
                                    <span class="title link-item">Årets utställningar på Råå museum</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="event-item">
                                    <span class="date">
                                        <span class="date-day"><strong>Idag</strong></span>
                                        <span class="date-time">12:00</span>
                                    </span>
                                    <span class="title link-item">"Bomber o Granater" - en gästutställning med Tintin och hans spännande värld på Toy World</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="event-item">
                                    <span class="date">
                                        <span class="date-day"><strong>Idag</strong></span>
                                        <span class="date-time">14:00</span>
                                    </span>
                                    <span class="title link-item">Sommarteater i Det Gröna</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="event-item">
                                    <span class="date">
                                        <span class="date-day">17</span>
                                        <span class="date-month">juni</span>
                                    </span>
                                    <span class="title link-item">Sommarteater i Det Gröna</span>
                                </a>
                            </li>
                            <li><a href="#" class="list-more">Fler evenemang</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>