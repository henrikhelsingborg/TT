<?php

if (!class_exists('HbgHelpWidget')) {
class HbgHelpWidget extends WP_Widget {

    /**
     * The path to templates
     * @var string
     */
    protected $_viewsPath;

    /**
     * The default question text
     * @var string
     */
    public $_defaultQuestion = 'Hittade du den information du sökte?';
    public $_defaultQuestionFeedback = 'Hur kan vi förbättra vår information?';

    /**
     * Constructor
     * Set the views path and register the widget
     */
    public function __construct()
    {
        $this->_viewsPath = HBGHELP_PATH . 'views/';

        parent::__construct(
            'HbgHelpWidget',
            '* Hjälpenkät',
            array(
                "description" => __('Fråga besökaren om den fick hjälp av innehållet på sidan.')
            )
        );

        // Handle submitComment ajax
        add_action('wp_ajax_submit_comment', array($this, 'submitComment'));
        add_action('wp_ajax_nopriv_submit_comment', array($this, 'submitComment'));

        // Handle submitResponse ajax
        add_action('wp_ajax_submit_response', array($this, 'submitResponse'));
        add_action('wp_ajax_nopriv_submit_response', array($this, 'submitResponse'));
    }

    /**
     * Renders the text widget form
     * @param  object $instance The current widget instance
     * @return void
     */
    public function form($instance)
    {
        if (!isset($instance['question']) || (isset($instance['question']) && strlen($instance['question']) == 0)) {
            $instance['question'] = $this->_defaultQuestion;
        }

        if (!isset($instance['question_feedback']) || (isset($instance['question_feedback']) && strlen($instance['question_feedback']) == 0)) {
            $instance['question_feedback'] = $this->_defaultQuestionFeedback;
        }

        require($this->_viewsPath . 'widget-form.php');
    }

    /**
    * Prepare widget options for save
    * @param  array $newInstance The new widget options
    * @param  array $oldInstance The old widget options
    * @return array              The merged instande of new and old to be saved
    */
    public function update($newInstance, $oldInstance)
    {
        $instance = array_merge($oldInstance, $newInstance);
        if (!isset($instance['question']) || (isset($instance['question']) && strlen($instance['question']) == 0)) {
            $instance['question'] = $this->_defaultQuestion;
        }

        if (!isset($instance['question_feedback']) || (isset($instance['question_feedback']) && strlen($instance['question_feedback']) == 0)) {
            $instance['question_feedback'] = $this->_defaultQuestionFeedback;
        }
        
        return $instance;
    }

    /**
     * Outputs the widget on front end
     * @param  array $args       Arguments
     * @param  array $instance   Instance
     * @return void
     */
    public function widget($args, $instance)
    {
        extract($args);

        wp_enqueue_script('hbg-help-widget', HBGHELP_URL . '/assets/hbg-help-widget.js');

        $view = 'widget-question.php';
        if ($templatePath = locate_template('templates/plugins/hbg-help-widget/' . $view)) {
            require($templatePath);
        } else {
            require($this->_viewsPath . $view);
        }
    }

    /**
     * Saves the "Yes" or "No" response as counters in metadata
     * @return integer The last inserted id from db
     */
    public function submitResponse()
    {
        global $hbgHelpDb;

        $insertedID = false;
        $postID = (isset($_POST['postid']) && is_numeric($_POST['postid'])) ? $_POST['postid'] : null;
        $answer = (isset($_POST['answer']) && strlen($_POST['answer']) > 0) ? $_POST['answer'] : null;

        if ($postID && $answer) {
            $insertedID = $hbgHelpDb->saveAnswer($_SERVER['remote_addr'], $postID, $answer);
        }

        echo $insertedID;
        wp_die();
    }

    /**
     * Save a comment response as metadata for the page commented on
     * @return string Always returns "true" as a string
     */
    public function submitComment()
    {
        global $hbgHelpDb;

        $answerID = (isset($_POST['answerid']) && is_numeric($_POST['answerid'])) ? $_POST['answerid'] : null;
        $postID = (isset($_POST['postid']) && is_numeric($_POST['postid'])) ? $_POST['postid'] : null;
        $comment = (isset($_POST['comment']) && strlen($_POST['comment']) > 0) ? $_POST['comment'] : null;
        $commentType = (isset($_POST['commenttype']) && strlen($_POST['commenttype']) > 0) ? $_POST['commenttype'] : null;

        if ($answerID && $postID) {
            $hbgHelpDb->addCommentToAnswer($answerID, $comment, $commentType);
        }
        
        echo 'true';
        wp_die();
    }

}
}