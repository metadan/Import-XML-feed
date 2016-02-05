<?php
/**
 *  Contributors: mooveagency, gaspar.nemes
 *  Stable tag:
 *  Plugin Name: Moove Feed Importer
 *  Plugin URI: http://www.mooveagency.com
 *  Description: This plugin adds the ability to import content from an external XML/RSS file, or from an uploaded XML/RSS and add the content to any post type in your
 *  Version: 1.0.0
 *  Author: Gaspar Nemes
 *  Author URI: http://www.mooveagency.com
 *  License: GPLv2
 *  Text Domain: moove
 */

register_activation_hook( __FILE__ , 'moove_importer_activate' );
register_deactivation_hook( __FILE__ , 'moove_importer_deactivate' );

/**
 * Functions on plugin activation, create relevant pages and defaults for settings page.
 */
function moove_importer_activate() {

}

/**
 * Function on plugin deactivation. It removes the pages created before.
 */
function moove_importer_deactivate() {

}

include_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '/third-party/simple_html_dom-master/simple_html_dom.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-view.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-content.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-options.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-controller.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-actions.php' );
include_once( dirname( __FILE__ ).DIRECTORY_SEPARATOR.'moove-shortcodes.php' );

