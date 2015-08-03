Helsingborg = Helsingborg || {};
Helsingborg.Prompt = Helsingborg.Prompt || {};

Helsingborg.Prompt.Alert = (function ($) {

    var _animationSpeed = 300;
    var _wrapperSelector = '[data-prompt-wrapper="alert"]';
    var _message = 'Alert';

    function Alert() {
        $(function(){

            this.handleEvents();

            // Show cookies alert if not accepted
            if (window.localStorage.getItem('accept-cookies') != 'true') {
                this.show('info',
                    'Helsingborg.se använder cookies för att förbättra din upplevelse på siten. Genom att surfa vidare accepterar du dessa cookies.<br><a href="#">Läs mer om cookies här »</a>',
                    [
                        {
                            label: 'Ok, jag förstår',
                            class: 'btn-submit',
                            action: 'accept-cookies'
                        }
                    ]
                );
            }

        }.bind(this));
    }

    /**
     * Displays an alert
     * @param  {string} type    The class name of the alert
     * @param  {string} text    The text of the alert
     * @param  {object} buttons Buttons to place in the alert
     * @return {void}
     */
    Alert.prototype.show = function(type, text, buttons) {
        buttons = typeof buttons !== 'undefined' ? buttons : null;

        // Append alert container
        $('<div class="alert"><div class="container"><div class="row"></div></div></div>').prependTo(_wrapperSelector);

        // If we have a type set, append the class to the alert container
        if (type != null) {
            $(_wrapperSelector).find('.alert:first-child').addClass('alert-' + type);
        }

        // Add alert text
        $(_wrapperSelector).find('.alert:first-child .row').append('<div class="columns large-9 medium-9">' + text + '</div>');

        // Add alert button contaioner
        $(_wrapperSelector).find('.alert:first-child .row').append('<div class="buttons columns large-3 medium-3"></div>');

        // Add close button or add defined buttons
        if (buttons == null) {
            $(_wrapperSelector).find('.alert:first-child .columns:last-child').append('<button class="btn btn-alert-close" data-action="alert-close"><i class="fa fa-times"></i></button>');
        } else {
            $.each(buttons, function (index, item) {
                $(_wrapperSelector).find('.alert:first-child .columns:last-child').append('<button class="btn ' + item.class +'" data-action="' + item.action + '">' + item.label + '</button>')
            });
        }

        $(_wrapperSelector).find('.alert:first-child').slideDown(_animationSpeed);
    }

    /**
     * Accept use of cookies (store answer in html5localstorage)
     * @return {string} Success message
     */
    Alert.prototype.acceptCookies = function() {
        window.localStorage.setItem('accept-cookies', true);
        return 'Use of cookies was accepted.';
    }

    /**
     * Clear the saved "acceptCookies" value from html5localstorage
     * @return {string} Success message
     */
    Alert.prototype.clearAcceptCookies = function() {
        window.localStorage.removeItem('accept-cookies');
        return 'Cleard the "accept cookies" setting.';
    }

    /**
     * Hides and removes a specific alert
     * @param  {object} element The element to hide/remove
     * @return {void}
     */
    Alert.prototype.hide = function(element) {
        $(element).closest('.alert').slideUp(_animationSpeed,   function() {
            $(this).remove();
        });
    }

    /**
     * Keeps track of events
     * @return {void}
     */
    Alert.prototype.handleEvents = function() {

        $(document).on('click', '[data-action="alert-close"]', function (e) {
            this.hide(e.target);
        }.bind(this));

        $(document).on('click', '[data-action="accept-cookies"]', function (e) {
            this.acceptCookies();
            this.hide(e.target);
        }.bind(this));

    }

    return new Alert();

})(jQuery);