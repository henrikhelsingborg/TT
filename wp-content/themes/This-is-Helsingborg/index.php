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

    <?php wp_head(); ?>
</head>
<body>
    <div class="site-wrapper">

        <header class="site-header">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad"></a>
                        <nav class="navbar">
                            <ul class="nav">
                                <li><a href="#">Arbeta</a></li>
                                <li><a href="#">Bo, bygga &amp; miljö</a></li>
                                <li><a href="#">Förskola &amp; utbildning</a></li>
                                <li><a href="#">Kommun &amp; politik</a></li>
                                <li><a href="#">Omsorg &amp; stöd</a></li>
                                <li><a href="#">Trafik &amp; stadsplanering</a></li>
                                <li><a href="#">Uppleva &amp; göra</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <div class="hero" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/hero-example.jpg);">
            <div class="stripe"></div>
            <form class="hero-search center-vertical" method="post" action="#">
                <h2><strong>Hej,</strong> vad letar du efter?</h2>
                <div class="input-group">
                    <input type="search" name="q" placeholder="Här kan du skriva vad du letar efter…">
                    <button type="submit" class="btn btn-submit">Sök</button>
                </div>
            </form>
        </div>

        <section class="section-featured creamy">
            <div class="container">
                <div class="row">

                    <div class="columns large-6">
                        <div class="box widget">
                            <h3><i class="fa fa-dot-circle-o"></i> Genvägar</h3>
                            <div class="box-content">
                                <ul class="list list-links">
                                    <li><a class="link-item" href="#">Sommarlovsaktiviteter 2015</a></li>
                                    <li><a class="link-item" href="#">Ansökan om bygglov</a></li>
                                    <li><a class="link-item" href="#">Ansökan till förskola</a></li>
                                    <li><a class="link-item" href="#">Felanmäl fel på gator, torg och parker</a></li>
                                    <li><a class="link-item" href="#">Tider för studentutspringet 2015</a></li>
                                    <li><a class="link-item" href="#">Barnets tider/schema på fritids</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="columns large-6">
                        <div class="box">
                            <h3><i class="fa fa-phone"></i> Helsingborgs Kontaktcenter</h3>
                            <div class="box-content">
                                <ul class="list">
                                    <li>
                                        <label>Telefonnummer</label>
                                        <span class="text-lg">042-10 50 00</span>
                                    </li>
                                    <li>
                                        <label>E-postadress</label>
                                        kontaktcenter@helsingborg.se
                                    </li>
                                    <li>
                                        <label>Öppettider</label>
                                        Mån–tor 07:00–19:00, Fre 07:00–17:00, Lör 10:00–15:00
                                    </li>
                                    <li>
                                        <label>Besöksadress</label>
                                        Stortorget 17, Helsingborg
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

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
                        <div class="columns large-4 medium-6">
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
                </div>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>