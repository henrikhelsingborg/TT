<p>
    <label for="<?php echo $this->get_field_id('question'); ?>">Huvudfråga (typ: hittade du informationen du sökte?):</label>
    <textarea name="<?php echo $this->get_field_name('question'); ?>" id="<?php echo $this->get_field_id('question'); ?>" cols="30" rows="10" class="widefat"><?php echo (isset($instance['question']) && strlen($instance['question']) > 0) ? $instance['question'] : ''; ?></textarea>
</p>
<p>
    <label for="<?php echo $this->get_field_id('question_feedback'); ?>">Feedback-fråga (ställs om man svara "nej" på huvudfrågan):</label>
    <textarea name="<?php echo $this->get_field_name('question_feedback'); ?>" id="<?php echo $this->get_field_id('question_feedback'); ?>" cols="30" rows="10" class="widefat"><?php echo (isset($instance['question_feedback']) && strlen($instance['question_feedback']) > 0) ? $instance['question_feedback'] : ''; ?></textarea>
</p>