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
    private $xmlreturn = null;

	function __construct() {
        $this->xmlreturn = array();
        $this->xmlnodes = array();
	}
    private function moove_recurse_xml_nodes( $xml ) {
       $child_count = 0;

       foreach($xml as $child) {
            $child_count++;

            $this->xmlnodes[$child->getName()] = $this->xmlnodes[$child->getName()] + 1;
            // no childern, aka "leaf node"
            if( Moove_Importer_Controller::moove_recurse_xml_nodes( $child ) == 0 ) {
                //$this->xmlnodes[$child->getName()] = $this->xmlnodes[$child->getName()] + 1;
            }
       }
       return $child_count;
    }


    private function moove_recurse_xml( $xml , $parent = "" ) {
       $child_count = 0;
       foreach($xml as $key => $value) {
            $child_count++;
            // no childern, aka "leaf node"
            if( Moove_Importer_Controller::moove_recurse_xml( $value , $parent . "~" . $key ) == 0 ) {
                $this->xmlreturn[] = array(
                    'key'   =>  $parent . "~" . (string)$key,
                    'value' =>  (string)$value
                );
            }
       }
       return $child_count;
    }

    public function moove_read_xml( $args ) {

        $return_array = array();

        if ( $args['type'] === 'url' ) :
            $xml = simplexml_load_file( $args['data'] );
        else :
            $xml = simplexml_load_string( wp_unslash($args['data']) );
        endif;

        if ( $args['xmlaction'] === 'check' ) :

            return ( $xml ) ? "true" : "false";

        elseif ( $args['xmlaction'] === 'import' ) :
            $return_array['node_count'] = count( $xml );
            if ( count( $xml->children() ) ) :
                foreach ( $xml->children() as $key => $value ) :
                    Moove_Importer_Controller::moove_recurse_xml( $value );
                    $return_array['data'][]= $this->xmlreturn;
                    $this->xmlreturn = array();
                endforeach;
            endif;
            return true;
        elseif ( $args['xmlaction'] === 'preview' ) :

            if ( count( $xml->children() ) ) :
                ob_start();
                echo "<hr><h4>Node count: ". count( $xml->children() )."</h4>";
                if ( count( $xml->children() ) > 1 ) :
                    echo "<a href='#' class='moove-xml-preview-pagination button-previous moove-hidden'>Previous</a><br>";
                    echo "<a href='#' class='moove-xml-preview-pagination button-next'>Next</a>";
                endif;
                echo "<hr>";
                $i == 0;

                foreach ( $xml->children() as $key => $value ) :
                    $i++;
                    Moove_Importer_Controller::moove_recurse_xml( $value );
                    if ( $i > 1 ) : $hidden_class = 'moove-hidden'; else : $hidden_class = 'moove-active'; endif;
                    echo "<div class='moove-importer-readed-feed $hidden_class' data-total='".count( $xml->children() )."' data-no='$i'>";
                    if ( count( $value->attributes() ) ) :
                        echo "<p>Attributes:<br/>";
                        foreach ( $value->attributes() as $attrkey => $attrval ) :

                            $_attributes = implode( ', ', json_decode( json_encode( $attrval ), true ) );
                            echo "<i><strong>".$attrkey.": </strong><span>".$_attributes."</span></i><br />";
                        endforeach;
                        echo "</p>";
                    endif;

                    foreach ($this->xmlreturn as $xmlvalue) { ?>
                        <p>
                            <strong>
                                <?php echo $xmlvalue['key']; ?>:
                            </strong>
                            <?php echo $xmlvalue['value']; ?>
                        </p>

                    <?php } //foreach
                    $this->xmlreturn = null;
                    echo "</div>";
                endforeach;

                return ob_get_clean();
            endif;
        elseif ( $args['xmlaction'] === 'getnodes' ) :
            //var_dump($xml);
            //
            $this->xmlnodes[$xml->getName()] = $this->xmlnodes[$xml->getName()] + 1;
            Moove_Importer_Controller::moove_recurse_xml_nodes( $xml );
           // $this->xmlnodes = array_unique( $this->xmlnodes );
            ob_start(); ?>
            <h4>Select your repeated XML element you want to import</h4>
             <select name="moove-xml-nodes" id="moove-xml-nodes" class="moove-xml-nodes">
                <?php foreach ($this->xmlnodes as $nodekey => $nodecount) : ?>
                    <option value="<?php echo $nodekey; ?>"> <?php echo $nodekey.' ('.$nodecount.')'; ?> </option>
                <?php endforeach; ?>
            </select>
            <br / >
            <br / >
            <?php
            return ob_get_clean();
        endif;
    }
}
$moove_importer_controller = new Moove_Importer_Controller();