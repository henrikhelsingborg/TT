<p>
<label>FontAwesome ikon</label>
<input type="text" class="widefat" value="<?php echo (isset($instance['icon'])) ? $instance['icon'] : 'fa-home'; ?>" name="<?php echo $this->get_field_name('icon'); ?>">
</p>
<p>
<label>Titel</label>
<input type="text" class="widefat" value="<?php echo (isset($instance['title'])) ? $instance['title'] : ''; ?>" name="<?php echo $this->get_field_name('title'); ?>">
</p>
<p>
<label>Text</label>
<textarea class="widefat" name="<?php echo $this->get_field_name('text'); ?>" rows="13"><?php echo (isset($instance['text'])) ? $instance['text'] : ''; ?></textarea>
</p>
<p>
<label>Länktext</label>
<input type="text" class="widefat" name="<?php echo $this->get_field_name('link-text'); ?>" value="<?php echo (isset($instance['link-text'])) ? $instance['link-text'] : ''; ?>">
</p>
<p>
<label>Länkadress</label>
<input type="text" class="widefat" name="<?php echo $this->get_field_name('link-url'); ?>" <?php echo (isset($instance['link-url'])) ? $instance['link-url'] : ''; ?>>
</p>