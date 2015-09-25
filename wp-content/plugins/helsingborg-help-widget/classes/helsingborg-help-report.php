<?php

class HbgHelpReport {

    /**
     * The path to templates
     * @var string
     */
    protected $_viewsPath;

    /**
     * Weather to show response stats in administration or not
     * @var boolean
     */
    protected $_showResponsesInAdmin = true;

    public function __construct()
    {
        $this->_viewsPath = HBGHELP_PATH . 'views/';

        if ($this->_showResponsesInAdmin) {
            add_action('add_meta_boxes', array($this, 'addReportingMetabox'));
        }
    }

    public function addReportingMetabox()
    {
        global $post;
        $screens = array('posts', 'page');

        $answers = get_post_meta($post->ID, 'hbg-help-answers', true);

        if (is_array($answers)) {
            foreach ($screens as $screen) {
                add_meta_box( 'hbg_help_report', 'Resultat: Hittade du innehållet du sökte?', array($this, 'reportingMetaboxContent'), $screen, 'normal', 'default');
            }
        }
    }

    public function reportingMetaboxContent($post)
    {
        global $hbgHelpDb;

        $answers = array(
            'yes' => $hbgHelpDb->countAnswers($post->ID, 'yes'),
            'no'  => $hbgHelpDb->countAnswers($post->ID, 'no')
        );
        $comments = $hbgHelpDb->getComments($post->ID);

        $view = 'metabox-report.php';
        if ($templatePath = locate_template('templates/plugins/hbg-help-widget/' . $view)) {
            require($templatePath);
        } else {
            require($this->_viewsPath . $view);
        }
    }

}