<?php echo $before_widget; ?>
<div class="widget-content-holder">
    <?php echo $before_title . $title . $after_title; ?>

    <div>
        <select id="municipality_multiselect">
            <option value="Bjuv">Bjuv</option>
            <option value="Helsingborg">Helsingborg</option>
            <option value="Höganäs">Höganäs</option>
            <option value="Klippan">Klippan</option>
            <option value="Landskrona">Landskrona</option>
            <option value="Åstorp">Åstorp</option>
            <option value="Ängelholm">Ängelholm</option>
            <option value="Örkelljunga">Örkelljunga</option>
        </select>
    </div>

    <ul class="alarm-list quick-links-list">
        <?php
            $today = date('Y-m-d');
            $number_of_alarms = count($alarms);
            $show = $number_of_alarms > $amount ? $amount : $number_of_alarms;

            for($i=0;$i<$show; $i++) :
        ?>
        <li>
            <a href="#" class="modalLinkAlarm" id="<?php echo $alarms[$i]->ID ?>" data-reveal="alarmModal">
               <span class="date"><?php echo date_i18n(get_option('date_format'), strtotime($alarms[$i]->SentTime)) . ' kl. ' . date('H:i', strtotime($alarms[$i]->SentTime)); ?></span>
               <span><?php echo $alarms[$i]->HtText ?></span>
            </a>
        </li>
        <?php endfor; ?>

        <input type="text" id="selectedMunicipality" style="display: none;" />
    </ul>

    <a href="<?php echo $link; ?>" class="list-more" title="Visa fler alarm">Fler alarm</a>
</div>

<script>
    var _amount = <?php echo $amount; ?>;
    var _alarms = <?php echo json_encode($alarms); ?>;
</script>

<?php
    /**
     * Get the modal window markup
     */
    get_template_part('templates/partials/modal', 'alarm');
?>

<?php echo $after_widget; ?>