<div id="eventModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" data-action="modal-close" aria-label="Stäng fönstret">
            <i class="fa fa-times-circle"></i>
        </button>
        <div class="row">
            <div class="columns large-4">
                <img class="modal-image responsive"
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/event-placeholder.jpg" alt="event">
                    
                <div id="event-times" class="box">
                    <div class="box-content">
                        <ul class="list list-event-times" id="time-modal">
                            <li class="event-times-loading"><i class="hbg-loading">Läser in datum &amp; tider</i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="columns large-8">
                <article>
                    <h1 class="modal-title">Event title</h1>
                    <span class="modal-ics"><a href="#" class="link-item">Lägg till i din kalender</a></span>
                    
                    <p class="modal-description"></p>
                    <p class="modal-link"></p>
                </article>
                <div id="event-organizers">
                    <ul class="list" id="organizer-modal"></ul>
                </div>
            </div>
        </div>
    </div>
</div>