<?php

namespace Helsingborg\Metabox;

class PageParent
{
    public function __construct()
    {
        add_action('admin_menu', '\Helsingborg\Metabox\PageParent::removeMetaBoxes');
        add_action('add_meta_boxes', '\Helsingborg\Metabox\PageParent::addCustomPageParentDivMetaBox');
    }

    /**
     * Remove unwanted metaboxes
     * @return void
     */
    public static function removeMetaBoxes()
    {
        remove_meta_box('pageparentdiv', 'page', 'side');
    }

    /**
     * Add custom page parent div metabox
     */
    public static function addCustomPageParentDivMetaBox()
    {
        add_meta_box(
            'pageparentdiv',
            __('Page Attributes'),
            '\Helsingborg\Metabox\PageParent::customPageParentDivMetaBox',
            'page',
            'side'
        );
    }

    /**
     * Custom page parent div metabox content
     * @param  array $post The current post/page
     * @return void
     */
    public static function customPageParentDivMetaBox($post)
    {
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
}
