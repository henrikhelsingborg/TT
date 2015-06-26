<?php

/**
 * Override of Page Attribute meta box
 * This is because the load time of wp_dropdown_pages(), which is removed in our version.
 * (original: page_attributes_meta_box() in wp-admin/includes/meta-boxes.php)
 */

// Remove the original meta box
function helsingborg_remove_meta_box(){
    remove_meta_box('pageparentdiv', 'page', 'side');
}
add_action('admin_menu', 'helsingborg_remove_meta_box');

// Add our own meta box instead
function helsingborg_add_meta_box() {
    add_meta_box('pageparentdiv', __('Page Attributes') , 'helsingborg_page_attributes_meta_box', 'page', 'side');
}
add_action('add_meta_boxes', 'helsingborg_add_meta_box');

// Use custom page attributes meta box, no need to load dropdown with pages!
function helsingborg_page_attributes_meta_box($post) {
    if ('page' == $post->post_type && 0 != count(get_page_templates($post))) :
        $template = !empty($post->page_template) ? $post->page_template : false;
?>
        <p><strong><?php _e('Template') ?></strong></p>
        <label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label><select name="page_template" id="page_template">
        <option value='default'><?php _e('Default Template'); ?></option>
        <?php page_template_dropdown($template); ?>
        </select>
    <?php endif; ?>

    <p><strong><?php _e('Order') ?></strong></p>
    <p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
    <p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.' ); ?></p>
<?php
}
?>