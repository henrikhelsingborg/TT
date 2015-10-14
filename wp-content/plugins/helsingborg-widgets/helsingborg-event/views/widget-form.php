<ul class="hbgllw-instructions">
    <li><?php echo __("<b>OBS!</b> Denna widget bör endast användas i <b>Höger area</b> !"); ?></li>
</ul>

<ul class="hbgllw-instructions">
    <li><?php echo __("<b>Titel</b> är det som visas i widgetens header."); ?></li>
    <li><?php echo __("<b>Evenemangslänk</b> är länken till sidan som listar alla evenemang."); ?></li>
    <li><?php echo __("<b>Länktext</b> är texten på länken som går till alla evenemang."); ?></li>
    <li><?php echo __("<b>Antal evenemang</b> är hur många widgeten ska visa"); ?></li>
</ul>

<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Evenemangslänk:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Länktext:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('amount'); ?>"><?php _e('Antal evenemang:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" type="number" value="<?php echo esc_attr($amount); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id('administration_units'); ?>"><?php _e('Förvaltningsenheter:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('administration_units'); ?>" name="<?php echo $this->get_field_name('administration_units'); ?>" type="text" value="<?php echo esc_attr($administration_units); ?>" />
</p>

<div style="background:#f9f9f9;border:1px solid #ddd;padding: 0 15px;margin-bottom: 15px;">
<p class="hbg-event-widget-search-post-id" <?php if (!isset($instance['post_id'])) : ?>style="display:none;"<?php endif; ?>>
    <label for="<?php echo $this->get_field_id('post_id'); ?>">Välj sida att lyfta fram som "utvald":</label><br>
    <select name="<?php echo $this->get_field_name('post_id'); ?>" id="<?php echo $this->get_field_id('post_id'); ?>" class="widefat">
        <option value="">Visa inget</option>
        <?php if (isset($instance['post_id'])) : ?>
        <option value="<?php echo $instance['post_id']; ?>"><?php echo get_the_title($instance['post_id']); ?></option>
        <?php endif; ?>
    </select>
    <input type="hidden" name="<?php echo $this->get_field_name('post_title'); ?>" value="" class="hbg-event-widget-search-post-title">
</p>
<p>
    <label for="<?php echo $this->get_field_id('search'); ?>"><b><?php echo __("Sök efter sida att använda som \"utvald\": "); ?></b></label><br>
    <input style="width: 70%;" id="<?php echo $this->get_field_id('search'); ?>" type="text" class="input-text hbg-event-widget-search-string" />
    <button type="button" class="button-secondary hbg-event-widget-search"><?php echo __("Sök"); ?></button>
</p>
<p>
    <label for="<?php echo $this->get_field_id('link-text'); ?>"><?php _e('"Läs mer" länktext:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('link-text'); ?>" name="<?php echo $this->get_field_name('link-text'); ?>" type="text" value="<?php echo esc_attr($instance['link-text']); ?>" />
</p>
</div>