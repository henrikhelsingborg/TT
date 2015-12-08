<?php
$calendarListID = ($calendarListID) ? $calendarListID++ : 1;
echo $before_widget;
?>
<div class="widget-content-holder">
<h2 class="widget-title"><?php echo $title; ?></h2>

<ul class="calendar-list" id="calendar-list-<?php echo $calendarListID; ?>" style="min-height: 30px;">
    <div class="event-list-loader" id="loading-event" style="margin-top: -5px;"></div>
</ul><!-- .calendar-list -->

<script>
    jQuery(document).ajaxComplete(function(event, xhr, settings) {
        $('.calendar-list [data-reveal]').each(function (index, element) {
            $(this).attr('data-reveal-id', 'eventModal-<?php echo $calendarListID; ?>').removeAttr('data-reveal');
        });
    });
</script>

<a href="<?php echo $reference; ?>" class="read-more"><?php echo $link_text; ?></a>

<div id="eventModal-<?php echo $calendarListID; ?>" class="reveal-modal" data-reveal>
    <div class="row">
        <div>
            <img class="modal-image">
        </div>
    </div>

    <div class="row">
        <div class="modal-event-info">
            <h2 class="modal-title"></h2>
            <p class="modal-description"></p>
            <p class="modal-link"></p>
            <!--<p class="modal-date"></p>-->
        </div>
    </div>

    <!-- IF arrangör exist -->
    <div class="row">
        <div id="event-times">
            <h2 class="section-title">Datum, tid och plats</h2>
            <ul class="modal-list" id="time-modal"></ul>
        </div>

        <div id="event-organizers">
            <h2 class="section-title">Arrangör</h2>

            <div class="divider fade">
                <div class="upper-divider"></div>
                <div class="lower-divider"></div>
            </div>

            <ul class="modal-list" id="organizer-modal"></ul>
        </div>
    </div>

    <a class="close-reveal-modal">&#215;</a>
</div>
</div>

<script type="text/javascript">
    var events = {};
    jQuery(document).ready(function() {
        var data = { action: 'update_event_calendar', amount: '<?php echo $amount; ?>', ids: '<?php echo $administration_ids; ?>' };

        jQuery.post(ajaxurl, data, function(response) {
            var obj = JSON.parse(response);
            events = obj.events;

            if (obj.events.length === 0) {
                jQuery('#calendar-list-<?php echo $calendarListID; ?>').closest('.widget').remove();
            } else {
                jQuery('#calendar-list-<?php echo $calendarListID; ?>').html(obj.list);
            }
        });

        jQuery(document).on('click', '#calendar-list-<?php echo $calendarListID; ?> .event-item', function(event) {
            event.preventDefault();
            var image = $('#eventModal-<?php echo $calendarListID; ?> .modal-image');
            var title = $('#eventModal-<?php echo $calendarListID; ?> .modal-title');
            var link = $('#eventModal-<?php echo $calendarListID; ?> .modal-link');
            var date = $('#eventModal-<?php echo $calendarListID; ?> .modal-date');
            var description = $('#eventModal-<?php echo $calendarListID; ?> .modal-description');
            var time_list = $('#eventModal-<?php echo $calendarListID; ?> #time-modal');
            var organizer_list = $('#eventModal-<?php echo $calendarListID; ?> #organizer-modal');

            jQuery('#eventModal-<?php echo $calendarListID; ?> #event-times').hide();
            jQuery('#eventModal-<?php echo $calendarListID; ?> #event-organizers').hide();

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
                    html += '<li>';
                    html += '<span>' + dates[i].Date + '</span>';
                    html += '<span>' + dates[i].Time + '</span>';
                    html += '<span>' + dates_data.location + '</span>';
                    html += '</li>';
                }

                jQuery('#eventModal-<?php echo $calendarListID; ?> #time-modal').html(html);

                if (dates.length > 0) {
                    jQuery('#eventModal-<?php echo $calendarListID; ?> #event-times').show();
                }
            });

            var organizers_data = { action: 'load_event_organizers', id: this.id };

            jQuery.post(ajaxurl, organizers_data, function(response) {
                var organizers = JSON.parse(response); html = '';

                for (var i=0;i<organizers.length;i++) {
                    html += '<li><span>' + organizers[i].Name + '</span></li>';
                }

                jQuery('#eventModal-<?php echo $calendarListID; ?> #organizer-modal').html(html);
                if (organizers.length > 0) {
                    jQuery('#eventModal-<?php echo $calendarListID; ?> #event-organizers').show();
                }
            });

            if (result.ImagePath.length > 0) {
                jQuery(image).attr("src", result.ImagePath).show();
            } else {
                jQuery(image).hide();
            }

            jQuery(title).html(result.Name);

            if (result.Link) {
                jQuery(link).html('<a href="' + result.Link + '" target="blank">' + result.Link + '</a>').show();
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
<?php echo $after_widget; ?>
