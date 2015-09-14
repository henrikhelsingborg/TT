<?php
if (!class_exists('AlarmList')) {
  class AlarmList
  {
    /**
     * Constructor
     */
    public function __construct()
    {
      add_action( 'widgets_init', array( $this, 'add_widgets' ) );
    }

    /**
     * Add widget
     */
    public function add_widgets()
    {
      register_widget( 'AlarmListWidget' );
    }
  }
}

if (!class_exists('AlarmListWidget')) {
  class AlarmListWidget extends WP_Widget {

    protected $_viewsPath;

    /** constructor */
    function AlarmListWidget() {
      parent::WP_Widget(false, '* Alarmlista', array('description' => 'Skapar en lista med senaste alarmen.'));
      $this->_viewsPath = plugin_dir_path(plugin_dir_path(__FILE__)) . 'views/';
    }

    public function widget( $args, $instance ) {
      extract($args);

      $title     = empty($instance['title'])     ? __('Aktuella larm') : $instance['title'];
      $link      = empty($instance['link'])      ? '#'                 : $instance['link'];
      $amount    = empty($instance['amount'])    ? 10                  : $instance['amount'];

      $rss_link  = $instance['rss_link'];

      if (strlen($rss_link) > 0) {
        $title .= '<a href="' . $rss_link . '" class="rss-link"><span class="icon"></span></a>';

        $widget_class = "alarm-widget ";
        $before_widget = str_replace('widget', $widget_class . 'widget', $before_widget);
      }

      // Get the default values
      $json = file_get_contents('http://alarmservice.helsingborg.se/AlarmServices.svc/GetLatestAlarms');
      $alarms = json_decode($json)->GetLatestAlarmsResult;

      $view = 'widget-view.php';
      if ($templatePath = locate_template('templates/plugins/hbg-helsingborg-alarm/' . $view)) {
        require($templatePath);
      } else {
        require($this->_viewsPath . $view);
      }
    }

    public function update( $new_instance, $old_instance) {
      $instance['title']     = strip_tags($new_instance['title']);
      $instance['link']      = strip_tags($new_instance['link']);
      $amount                = $new_instance['amount'];
      $instance['amount']    = $amount;
      $instance['rss_link']  = $new_instance['rss_link'];
      return $instance;
    }

    public function form( $instance ) {
      $instance  = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'link' => '' ) );
      $title     = strip_tags($instance['title']);
      $link      = strip_tags($instance['link']);
      $amount    = empty($instance['amount']) ? 10 : $instance['amount'];
      $rss_link = $instance['rss_link'];
  ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

      <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Arkivlänk:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>

      <p><label for="<?php echo $this->get_field_id('amount'); ?>"><?php _e('Antal alarm:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" type="number" value="<?php echo esc_attr($amount); ?>" /></p>

      <p><label for="<?php echo $this->get_field_id('rss_link'); ?>"><?php _e('RSS Länk:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('rss_link'); ?>" name="<?php echo $this->get_field_name('rss_link'); ?>" type="text" value="<?php echo esc_attr($rss_link); ?>" /></p>
<?php
    }
  }
}
