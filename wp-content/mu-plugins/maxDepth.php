<?php 

/*
Plugin Name: Max page depth
Description: Adds a warning to the admin panel if pages are too deeply nested. 
Version:     1.0
Author:      Sebastian Thulin, Helsingborg Stad
*/

namespace MaxDepth;

class MaxPageDepth
{
  private $maxDepth = 5;

  /**
   * Init plugin
   *
   * @return void
   */
  public function __construct()
  {
      add_action('admin_notices', array($this, 'printAdminNotice'));
  }

  /**
   * Print error message
   *
   * @return void
   */
  public function printAdminNotice() {

    if(!$this->isPageDepthTooHigh()) {
      return; 
    }

    $heading = __("Page depth is above limit!"); 
    $message  = __("The page depth is above the recommended limit. Please use maximum depth of five levels on the site."); 
    $class    = 'notice notice-error';

    printf( 
      '
        <div class="%1$s">
          <h2>%2$s</h2>
          <p>%3$s</p>
        </div>
      ',
      esc_attr($class), 
      esc_html($heading),
      esc_html($message) 
    );

    $this->getCurrentPageDepth();  
  }

  /**
   * Determine if the page depth is too high
   *
   * @return boolean
   */
  private function isPageDepthTooHigh() {
    if($this->getCurrentPageDepth() > $this->maxDepth) {
      return true; 
    }
    return false; 
  }

  /**
   * Get the current depth of the page
   *
   * @return bool The current depth
   */
  private function getCurrentPageDepth() {
    if(isset($_GET['post']) && is_numeric($_GET['post'])) {
      $object     = get_post($_GET['post']); 
      $parentId   = $object->post_parent;
      $depth      = 0;
      while($parentId > 0){
          $post     = get_post($parentId);
          $parentId = $post->post_parent;
          $depth++;
      }
      return $depth;
    }
    return 0; 
  }
}

new MaxPageDepth(); 