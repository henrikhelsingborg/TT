<p>
    <label for="<?php echo $this->get_field_id('question'); ?>">Fråga att ställa:</label>
    <textarea name="<?php echo $this->get_field_name('question'); ?>" id="<?php echo $this->get_field_id('question'); ?>" cols="30" rows="10" class="widefat"><?php echo (isset($instance['question']) && strlen($instance['question']) > 0) ? $instance['question'] : ''; ?></textarea>
</p>