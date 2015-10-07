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
    protected $_showResponsesInAdmin = false;

    /**
     * Registers the metabox if set to do
     */
    public function __construct()
    {
        $this->_viewsPath = HBGHELP_PATH . 'views/';

        // Action to show/add resport metabox
        if ($this->_showResponsesInAdmin) {
            add_action('add_meta_boxes', array($this, 'addReportingMetabox'));
        }
    }

    /**
     * Adds the reporting metabox to the admin edit page/post
     * @return void
     */
    public function addReportingMetabox()
    {
        global $post;
        global $hbgHelpDb;

        // Which screens to display the report on
        $screens = array('posts', 'page');

        // Get answer count
        $answers = array(
            'yes' => $hbgHelpDb->countAnswers($post->ID, 'yes'),
            'no'  => $hbgHelpDb->countAnswers($post->ID, 'no')
        );

        // Only show metabox if there's any answers
        if (is_array($answers) && ($answers['yes'] > 0 || $answers['no'] > 0)) {
            foreach ($screens as $screen) {
                add_meta_box( 'hbg_help_report', 'Resultat: Hittade du innehållet du sökte?', array($this, 'reportingMetaboxContent'), $screen, 'normal', 'default');
            }
        }
    }

    /**
     * Putputs the content to the reporting metabox
     * @param  object $post The post object
     * @return void
     */
    public function reportingMetaboxContent($post)
    {
        global $hbgHelpDb;

        // Get answers
        $answers = array(
            'yes' => $hbgHelpDb->countAnswers($post->ID, 'yes'),
            'no'  => $hbgHelpDb->countAnswers($post->ID, 'no')
        );

        // Get comments
        $comments = $hbgHelpDb->getComments($post->ID);

        // Get and require the view
        $view = 'metabox-report.php';
        if ($templatePath = locate_template('templates/plugins/hbg-help-widget/' . $view)) {
            require($templatePath);
        } else {
            require($this->_viewsPath . $view);
        }
    }

}