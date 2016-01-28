<?php
/**
 * Moove_Controller File Doc Comment
 *
 * @category  Moove_Controller
 * @package   moove-feed-importer
 * @author    Gaspar Nemes
 */

/**
 * Moove_Controller Class Doc Comment
 *
 * @category Class
 * @package  Moove_Controller
 * @author   Gaspar Nemes
 */
class Moove_Importer_Controller {
	/**
	 * Construct function
	 */
	public function __construct() {

	}

    public function moove_read_xml( $args ) {
        // header("Content-type: text/xml; charset=utf-8");
        // $content = file_get_contents( $args['data'] );
        if ( $args['type'] === 'url' ) :
            $rss = simplexml_load_file( $args['data'] );
        else :
            $rss = simplexml_load_string( wp_unslash( $args['data'] ) );

        endif;

        return json_encode($rss);
    }
}
$moove_importer_tracking_provider = new Moove_Importer_Controller();
