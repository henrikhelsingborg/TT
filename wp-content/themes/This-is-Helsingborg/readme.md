# HELSINGBORG 2.0

This is the official theme of Helsingborg Stad.

The theme is built on the Foundation framework (http://foundation.zurb.com/).

## Getting started
To get started you'll need to install node and bower components. To install these components you will need to have Node.js installed on your system.

```
$ cd [THEME-DIR]
$ npm install
$ bower install
```

## Coding standards
For PHP, use PSR-2 and PSR-4 where applicable.

## Dependencies and components
We manage our dependencies and components with npm and bower. Please check the `package.json` file to see Node dependencies and check the `bower.json`to see the Bower components.

## Gulp
We use Gulp to compile, concatenate and minify SASS and JavaScript.
The compiling of SASS will also automatically add vendor-prefixes where needed.

To compile both js and sass and start the "watch" mode in one command, run the following command from the theme directory:
```
$ gulp
```

#### Available Gulp tasks

All these commands should be run from the theme directory with:

```
$ gulp [TASK]
```

* `jquery-core`     Fetch and compile latest jQuery release from bower_components
* `jquery-ui`       Fetch and compile latest jQuery-UI release from bower_components
* `jquery`          Runs both `jquery-core` and `jquery-ui`
* `sass-dist`       Compiles SASS
* `sass-admin-dist` Compiles admin SASS
* `scripts-dist`    Runs all scripts-* tasks at once
* `scripts-dev`     Compiles JS inside the assets/src/js/dev directory
* `scripts-search`  Compiles JS inside the assets/src/js/search directory
* `scripts-event`   Compiles JS inside the assets/src/js/event directory
* `scripts-alarm`   Compiles JS inside the assets/src/js/alarm directory
* `scripts-admin`   Compiles JS inside the assets/src/js/admin directory
* `scripts-copy`    Copies given bower_components to the assets/js/dist directory
* `watch`           Watches for changes and compiles in assets/src/js and assets/src/css
* `default`         Compiles everything

## Widget areas

These are the widget areas available in the Helsingborg 2.0 theme.

##### Top/slider area (id: slider-area)
* Only displayed on the front page

##### Content area (id: content-area)
* Display underneeth the page/post body
* Same column width as the page/post body

##### Content area bottom: (id: content-area-bottom)
* Displayed last in the main container
* Fills the main container width

##### Left sidebar (id: left-sidebar)
* Displayed over the left side menu

##### Left sidebar bottom (id: left-sidebar-bottom)
* Displayed underneeth the left side menu

##### Right sidebar (id: right-sidebar)
* Displayed to the right on posts/pages

##### Service area (id: service-area)
* Displayed underneeth the "Content area bottom"

##### Fun facts (id: fun-facts-area)
* Displayed underneeth the "service area"

##### Footer (id: footer-area)
* Displayed on the bottom of the page