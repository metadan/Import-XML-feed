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


            $count = $this->xmlnodes[$value->getName()]['count'] + 1;
            $this->xmlnodes[$value->getName()] = array(
                'count' =>  $count,
                'name'  =>  $value->getName(),
                'key'   =>  $parent . "/" . (string)$key
            );
            // no childern, aka "leaf node"
            if( Moove_Importer_Controller::moove_recurse_xml( $value , $parent . "/" . $key ) == 0 ) {
                $this->xmlreturn[] = array(
                    'key'   =>  $parent . "/" . (string)$key,
                    'value' =>  (string)$value
                );
                $this->xmlnodes[$value->getName()] = array(
                    'count' =>  $count,
                    'name'  =>  $value->getName(),
                    'key'   =>  $parent . "/" . (string)$key
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
            $selected_node = $args['node'];
            if ( $xml->getNamespaces(true) ) :
                $xml->registerXpathNamespace('atom' , 'http://www.w3.org/2005/Atom');
                $selected_node = str_replace("/","/atom:",$selected_node);
            endif;
            $xml = $xml->xpath( "$selected_node" );
            if ( count( $xml ) ) :
                ob_start();
                echo "<hr><h4>Node count: ". count( $xml )."</h4>";
                if ( count( $xml ) > 1 ) :
                    echo "<a href='#' class='moove-xml-preview-pagination button-previous moove-hidden'>Previous</a>";
                    echo "<a href='#' class='moove-xml-preview-pagination button-next'>Next</a>";
                endif;
                echo "<hr>";
                $i == 0;
                $return_keys = array();
                foreach ( $xml as $key => $value ) :
                    $i++;
                    Moove_Importer_Controller::moove_recurse_xml( $value );
                    if ( $i > 1 ) : $hidden_class = 'moove-hidden'; else : $hidden_class = 'moove-active'; endif;
                    echo "<div class='moove-importer-readed-feed $hidden_class' data-total='".count( $xml )."' data-no='$i'>";
                    if ( count( $value->attributes() ) ) :
                        echo "<p>Attributes:<br/>";
                        foreach ( $value->attributes() as $attrkey => $attrval ) :
                            $return_keys[] = $attrkey;
                            $_attributes = implode( ', ', json_decode( json_encode( $attrval ), true ) );
                            echo "<i><strong>".$attrkey.": </strong><span>".$_attributes."</span></i><br />";
                        endforeach;
                        echo "</p>";
                    endif;

                    foreach ($this->xmlreturn as $xmlvalue) {
                        $return_keys[] = $xmlvalue['key'];
                    ?>
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
                $return_keys = array_unique( $return_keys );
                if ( count( $return_keys ) ) :
                    $select_options = "<option value='0'>Select a field</option>";
                    foreach ($return_keys as $select_value) {
                        $select_options .= "<option value='".$select_value."'>".$select_value."</option>";
                    }
                endif;
                return json_encode( array('content' => ob_get_clean(), 'select_option' => $select_options ) );
            endif;
        elseif ( $args['xmlaction'] === 'getnodes' ) :
            $this->xmlnodes[$xml->getName()] = array(
                'count' =>  $this->xmlnodes[$xml->getName()]['count'] + 1,
                'name'  =>  $xml->getName(),
                'key'   =>  $parent . "/" . $xml->getName()
            );
            $parent = $parent . "/" . $xml->getName();
            Moove_Importer_Controller::moove_recurse_xml( $xml, $parent );
            // $this->xmlnodes = array_unique( $this->xmlnodes );
            ob_start(); ?>
            <h4>Select your repeated XML element you want to import</h4>
             <select name="moove-xml-nodes" id="moove-xml-nodes" class="moove-xml-nodes">
                <?php foreach ($this->xmlnodes as $nodekey => $nodecount) : ?>
                    <option value="<?php echo $nodecount['key']; ?>"> <?php echo $nodekey.' ('.$nodecount['count'].') '.$nodecount['key'].''; ?> </option>
                <?php endforeach; ?>
            </select>
            <br / >
            <br / >
            <?php
            return ob_get_clean();
        endif;
    }
    public function moove_create_post( $args ) {
        return json_encode($args);
    }
}
$moove_importer_controller = new Moove_Importer_Controller();