<?php echo $before_widget; ?>
<div class="box box-outlined">
    <h3 class="widget-title"><?php echo $title; ?></h3>
    <div class="box-content" id="widget-<?php echo $args['widget_id']; ?>">
        <ul class="event-list list list-events">
            <?php if ($featured) : ?>
            <li class="event-item-featured">
                <a href="<?php echo get_permalink($featured->ID); ?>" class="event-item featured">
                    <?php if ($featuredImage) : ?>
                    <div class="columns large-4 medium-4 small-12 featured-image">
                        <img src="<?php echo $featuredImage[0]; ?>" class="responsive">
                    </div>
                    <?php endif; ?>
                    <div class="columns <?php if ($featuredImage) : ?>large-8 medium-8 small-12<?php else : ?>large-12 medium-12 small-12<?php endif; ?>">
                        <?php echo $featured->post_title; ?>
                        <span class="link-item link-item-light"><?php echo $instance['link-text']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <?php endif; ?>
            <li class="event-loading"><i class="hbg-loading">Läser in evenemang</i></li>
            <li><a href="<?php echo $reference; ?>" class="list-more"><?php echo $link_text; ?></a></li>
        </ul>

        <?php
            /**
             * Get the modal window markup
             */
            get_template_part('templates/partials/modal', 'event');
        ?>

        <script>
            var events = {};
            var defaultImagePath = '<?php echo get_template_directory_uri(); ?>/assets/images/event-placeholder.jpg';

            jQuery(document).ready(function() {
                var data = { action: 'update_event_calendar', amount: '<?php echo $amount; ?>', ids: '<?php echo $administration_ids; ?>' };

                jQuery.post(ajaxurl, data, function(response) {
                    var obj = JSON.parse(response);
                    events = obj.events;
                    jQuery('#widget-<?php echo $args['widget_id']; ?> .event-loading').remove();
                    if (jQuery('#widget-<?php echo $args['widget_id']; ?> .event-list li:first').hasClass('event-item-featured')) {
                        jQuery('#widget-<?php echo $args['widget_id']; ?> .event-list .event-item-featured').after(obj.list);
                    } else {
                        jQuery('#widget-<?php echo $args['widget_id']; ?> .event-list').prepend(obj.list);
                    }
                });

                jQuery(document).on('click', '.event-item', function(event) {
                    event.preventDefault();

                    var image = $('.modal-image');
                    var title = $('.modal-title');
                    var link = $('.modal-link');
                    var date = $('.modal-date');
                    var description = $('.modal-description');
                    var time_list = $('#time-modal');
                    var organizer_list = $('#organizer-modal');

                    document.getElementById('event-times').style.display = 'block';
                    jQuery('.event-times-loading').show();
                    jQuery('.event-times-item').remove();
                    document.getElementById('event-organizers').style.display = 'none';

                    var result;
                    for (var i = 0; i < events.length; i++) {
                        if (events[i].EventID === this.id) {
                            result = events[i];
                            break;
                        }
                    }

                    var dates_data = { action: 'load_event_dates', id: this.id, location: result.Location };
                    jQuery.post(ajaxurl, dates_data, function(response) {
                        html = "";
                        var dates = JSON.parse(response);

                        for (var i=0;i<dates.length;i++) {
                            html += '<li class="event-times-item">';
                            html += '<span class="event-date"><i class="fa fa-clock-o"></i> ' + dates[i].Date;
                            if (dates[i].Time) html += ' kl. ' + dates[i].Time;
                            html += '</span><span class="event-location">' + dates_data.location + '</span>';
                            html += '</li>';
                        }

                        jQuery('#time-modal').prepend(html);
                        jQuery('.event-times-loading').hide();

                        if (dates.length == 0) {
                            document.getElementById('event-times').style.display = 'none';
                        }
                    });

                    var organizers_data = { action: 'load_event_organizers', id: this.id };

                    jQuery.post(ajaxurl, organizers_data, function(response) {
                        var organizers = JSON.parse(response); html = '';

                        for (var i=0;i<organizers.length;i++) {
                            html += '<li><span>' + organizers[i].Name + '</span></li>';
                        }

                        jQuery('#organizer-modal').html(html);
                        if (organizers.length > 0) {
                            document.getElementById('event-organizers').style.display = 'block';
                        } else {
                            document.getElementById('event-times').className = '';
                        }
                    });

                    if (result.ImagePath) {
                        jQuery(image).attr("src", result.ImagePath);
                    } else {
                        jQuery(image).attr("src", defaultImagePath);
                    }
                    jQuery(title).html(result.Name);

                    if (result.Link) {
                        jQuery(link).html('<a class="link-item" href="' + result.Link + '" target="blank">' + result.Link + '</a>').show();
                    } else {
                        jQuery(link).hide();
                    }

                    jQuery(date).html(result.Date);
                    jQuery(description).html(nl2br(result.Description));
                });
            });

            function nl2br (str, is_xhtml) {
                var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
            }
        </script>
    </div>
</div>
<?php echo $after_widget; ?>