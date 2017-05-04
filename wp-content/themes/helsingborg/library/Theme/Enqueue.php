<?php

namespace Helsingborg\Theme;

class Enqueue
{
    public function __construct()
    {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'script'));
    }

    /**
     * Enqueue scripts
     * @return void
     */
    public function script()
    {
        wp_enqueue_script('google-translate', 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', array(), '1.0', true);
        wp_add_inline_script('google-translate', 'function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:"sv",autoDisplay:false,gaTrack:true,gaId:"UA-16678811-1"},"google-translate-element");}');
        wp_enqueue_script('google-translate');

    }
}
