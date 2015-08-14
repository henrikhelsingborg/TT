<?php
/**
 * ## WHAT'S THIS?!
 * This class makes it easier to create split tests (A/B tests) in Wordpress together with Google Experiments.
 *
 * ## USAGE INSTRUCTIONS
 * 1. Create a new instance of this class
 *         $splitTest = new hbgSplitTest();
 * 2. Set up your variations
 *         $splitTest->addVariation('a', 'variation A')->addVariation('b', 'variation B');
 * 3. Decide where the variations should output on your page, just echo this where you want it to be displayed
 *         $splitTest->getVariation();
 * 4. Set up Google Experiment
 *         Url to your google experiment variations should be domain.xx/page/?split=<key>
 *         Where <key> is the key you set on addVariation (example: domain.xx/page/?split=a, to use variation A in step 2)
 * 5. Get the script code
 *         $splitTest->getScript('<Your google experiment key>');
 *         - You find the key underneeth the script code when setting up your experiment
 *         - Ecgo the script code above your getVariation() in step #3
 *
 * Don't forget to hook up custom google analytics events that you used in your experiment setup
 *
 * ## CONTACT
 * Any questions about this, please contact kristoffer.svanmark@lexiconitkonsult.se
 *
 */
    class hbgSplitTest {

        /**
         * Holds the different variations
         * @var array
         */
        private $variations = array();

        /**
         * Adds a variation
         * - Remember to add all variations, including the original
         * @param string $key  The name of the variation
         * @param string $data The data of the varitation
         */
        public function addVariation($key, $data) {
            $this->variations[$key] = $data;
            return $this;
        }

        /**
         * Gets either a variation with key specifified as function attribute
         * or gets the variation from querystring
         * @param  string (optional) $variationKey What variation key to get
         * @return void Returns the variation data of the given key
         */
        public function getVariation($variationKey = NULL) {
            if (!$variation) {
                if (isset($_GET['split']) && strlen($_GET['split']) > 0) {
                    return $this->variations[$_GET['split']];
                } else {
                    return reset($this->variations);
                }
            } else {
                return $this->variations[$variationKey];
            }
        }

        /**
         * Outputs the Google Experiment script
         * @param  string $key The experiment key from Google Analytics
         * @return void
         */
        public function getScript($key) {
            return '<!-- Google Analytics Content Experiment code -->
                    <script>function utmx_section(){}function utmx(){}(function(){var
                    k=\'' . $key . '\',d=document,l=d.location,c=d.cookie;
                    if(l.search.indexOf(\'utm_expid=\'+k)>0)return;
                    function f(n){if(c){var i=c.indexOf(n+\'=\');if(i>-1){var j=c.
                    indexOf(\';\',i);return escape(c.substring(i+n.length+1,j<0?c.
                    length:j))}}}var x=f(\'__utmx\'),xx=f(\'__utmxx\'),h=l.hash;d.write(
                    \'<sc\'+\'ript src="\'+\'http\'+(l.protocol==\'https:\'?\'s://ssl\':
                    \'://www\')+\'.google-analytics.com/ga_exp.js?\'+\'utmxkey=\'+k+
                    \'&utmx=\'+(x?x:\'\')+\'&utmxx=\'+(xx?xx:\'\')+\'&utmxtime=\'+new Date().
                    valueOf()+(h?\'&utmxhash=\'+escape(h.substr(1)):\'\')+
                    \'" type="text/javascript" charset="utf-8"><\/sc\'+\'ript>\')})();
                    </script><script>utmx(\'url\',\'A/B\');</script>
                    <!-- End of Google Analytics Content Experiment code -->
                    ';
        }

    }