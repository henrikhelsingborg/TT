<p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Rubrik:</label>
    <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" <?php if (isset($instance['title'])) : ?>value="<?php echo $instance['title']; ?>"<?php endif; ?>>
</p>
<p>
    <label for="<?php echo $this->get_field_id('post_type'); ?>">Innehållstyp:</label>
    <select data-inherit-posttype name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>" class="widefat">
        <option value="hbgInheristPosts" <?php selected($instance['post_type'], 'hbgInheristPosts'); ?>>Textinnehåll</option>
        <option value="hbgInheritHours" <?php selected($instance['post_type'], 'hbgInheritHours'); ?>>Öppettider</option>
        <option value="hbgInheritContact" <?php selected($instance['post_type'], 'hbgInheritContact'); ?>>Kontaktuppgifter</option>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('q'); ?>">Sök efter innehåll:</label><br>
    <input data-inherit-q type="text" name="<?php echo $this->get_field_name('q'); ?>" id="<?php echo $this->get_field_id('q'); ?>" class="widefat" style="width:80%">
    <button data-action="search-post-type-content" class="button" style="width:19.3%">Sök</button>
</p>
<p <?php if (!isset($instance['post_id'])) : ?>style="display:none;"<?php endif; ?>>
    <label for="<?php echo $this->get_field_id('post_id'); ?>">Välj innehåll att visa:</label>
    <select name="<?php echo $this->get_field_name('post_id'); ?>" id="<?php echo $this->get_field_id('post_id'); ?>" class="widefat" data-inherit-content>
        <?php if (isset($instance['post_id'])) : ?><option value="<?php echo $instance['post_id']; ?>"><?php echo get_the_title($instance['post_id']); ?> (<?php echo $instance['post_id']; ?>)</option><?php endif; ?>
    </select>
</p>