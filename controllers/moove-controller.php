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

        if ( $args['xmlaction'] === 'check' ) :

            $return_array = array();
            if ( $args['type'] === 'url' ) :
                $xml = simplexml_load_file( $args['data'] );
            else :
                $xml = simplexml_load_string( wp_unslash($args['data']) );
            endif;

            return ( $xml ) ? "true" : "false";

        elseif ( $args['action'] === 'import' ) :
            $return_array['node_count'] = count( $xml );
            if ( count( $xml ) ) :
                foreach ( $xml as $key => $value ) :
                    // ATTRIBUTES
                    if ( count( $value->attributes() ) ) :
                        foreach ( $value->attributes() as $attrkey => $attrval ) :
                            $_attributes = explode( ' ', implode( ', ', json_decode( json_encode( $attrval ), true ) ) );
                        endforeach;
                        $return_array['data'][$key][]['attributes'] = array(
                            'key'       => $attrkey,
                            'values'    => $_attributes,
                        );
                    endif;

                    //VALUES
                    //
                endforeach;
            endif;
            return json_encode($return_array) ;
        endif;
    }
}
$moove_importer_tracking_provider = new Moove_Importer_Controller();
