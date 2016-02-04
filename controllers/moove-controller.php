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

    private function moove_recurse_xml( $xml , $parent = "" ) {
        $child_count = 0;
        foreach($xml as $key => $value) {
            $child_count++;
            if ( count($value) ) :
                $count = $this->xmlnodes[$value->getName()]['count'] + 1;
                $this->xmlnodes[$value->getName()] = array(
                    'count' =>  $count,
                    'name'  =>  $value->getName(),
                    'key'   =>  $parent . "/" . (string)$key
                );
            endif;
            // no childern, aka "leaf node"
            if( Moove_Importer_Controller::moove_recurse_xml( $value , $parent . "/" . $key ) == 0 ) {
                $this->xmlreturn[] = array(
                    'key'   =>  $parent . "/" . (string)$key,
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
            if ( $xml ) :
                $parent = $parent . "/" . $xml->getName();
                Moove_Importer_Controller::moove_recurse_xml( $xml, $parent );
                // $this->xmlnodes = array_unique( $this->xmlnodes );
                ob_start(); ?>
                <h4>Select your repeated XML element you want to import</h4>
                <select name="moove-xml-nodes" id="moove-xml-nodes" class="moove-xml-nodes">
                    <?php
                        $first_node_select = "";
                        foreach ($this->xmlnodes as $nodekey => $nodecount) : ?>
                        <?php if ( $first_node_select == '' ) : $first_node_select = $nodecount['key']; endif; ?>
                        <option value="<?php echo $nodecount['key']; ?>"> <?php echo $nodekey.' ('.$nodecount['count'].') '.$nodecount['key'].''; ?> </option>
                    <?php endforeach; ?>
                </select>
                <br / >
                <br / >
                <?php
                return json_encode(
                            array(
                                'select_nodes'      =>  ob_get_clean(),
                                'selected_element'  =>  $first_node_select,
                                'response'          =>  'true'
                            )
                        );
                return ob_get_clean();
            else :
                return json_encode( array( 'response' => 'false' ) );
            endif;

        elseif ( $args['xmlaction'] === 'import' ) :
            $return_array['node_count'] = count( $xml );
            if ( count( $xml ) ) :
                foreach ( $xml as $key => $value ) :
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
                echo "<hr><h4>Node count: ". count( $xml )." <span class='pagination-info'>Current item: 1 / " . count( $xml ) . " </span></h4>";
                if ( count( $xml ) > 1 ) :
                    echo "<span data-current='1'>";
                    echo "<a href='#' class='moove-xml-preview-pagination button-previous moove-hidden'>Previous</a>";
                    echo "<a href='#' class='moove-xml-preview-pagination button-next'>Next</a>";
                    echo "</span>";
                endif;
                echo "<hr>";
                $i == 0;
                $return_keys = array();
                $readed_data = array();
                foreach ( $xml as $key => $value ) :
                    $i++;
                    Moove_Importer_Controller::moove_recurse_xml( $value );
                    if ( $i > 1 ) : $hidden_class = 'moove-hidden'; else : $hidden_class = 'moove-active'; endif;
                    echo "<div class='moove-importer-readed-feed $hidden_class' data-total='".count( $xml )."' data-no='$i'>";
                    if ( count( $value->attributes() ) ) :
                        echo "<p>Attributes:<br/>";
                        foreach ( $value->attributes() as $attrkey => $attrval ) :
                            $return_keys[] = $attrkey;
                            $readed_data[$i]['attr'][] = array(
                                'key'   =>  $attrkey,
                                'value' =>  $attrval
                            );
                            $_attributes = implode( ', ', json_decode( json_encode( $attrval ), true ) );
                            echo "<i><strong>".$attrkey.": </strong><span>".$_attributes."</span></i><br />";
                        endforeach;
                        echo "</p>";
                    endif;

                    foreach ($this->xmlreturn as $xmlvalue) {
                        $return_keys[] = $xmlvalue['key'];
                        $readed_data[$i]['values'][] = array(
                            'key'   =>  $xmlvalue['key'],
                            'value' =>  $xmlvalue['value']
                        );
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
                    $_xml = $xml;
                    foreach ($return_keys as $select_value) {
                        $select_options .= "<option value='".$select_value."'>".$select_value."</option>";
                    }
                endif;
                return json_encode(
                    array(
                        'content'       => ob_get_clean(),
                        'select_option' => $select_options,
                        'xml_json_data'   => json_encode( $readed_data )
                    )
                );
            endif;

        endif;
    }
    /*
     * Searches for $needle in the multidimensional array $haystack.
     *
     * @param mixed $needle The item to search for
     * @param array $haystack The array to search
     * @return array|bool The indices of $needle in $haystack across the
     *  various dimensions. FALSE if $needle was not found.
     */
    private function moove_recursive_array_search($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            if( $needle===$value ) {
                return array($key);
            } else if (is_array($value) && $subkey = Moove_Importer_Controller::moove_recursive_array_search($needle,$value)) {
                array_unshift($subkey, $key);
                return $subkey;
            }
        }
    }
    /**
     * Return an ID of an attachment by searching the database with the file URL.
     *
     * First checks to see if the $url is pointing to a file that exists in
     * the wp-content directory. If so, then we search the database for a
     * partial match consisting of the remaining path AFTER the wp-content
     * directory. Finally, if a match is found the attachment ID will be
     * returned.
     *
     * @param string $url The URL of the image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
     *
     * @return int|null $attachment Returns an attachment ID, or null if no attachment is found
     */
    private function moove_get_attachment_id_from_src( $url ) {
        $attachment_id = 0;
        $dir = wp_upload_dir();

        $file = basename( $url );
        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );
        $query = new WP_Query( $query_args );
        if ( $query->have_posts() ) {
            foreach ( $query->posts as $post_id ) {
                $meta = wp_get_attachment_metadata( $post_id );
                $original_file       = basename( $meta['file'] );
                $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
                if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                    $attachment_id = $post_id;
                    break;
                }
            }
            wp_reset_query();
            wp_reset_postdata();
        }
        return $attachment_id;
    }
    private function moove_set_featured_image( $post_id, $image_url ) {
        // Add Featured Image to Post
        $upload_dir = wp_upload_dir(); // Set upload folder
        $image_data = file_get_contents($image_url); // Get image data
        $filename   = basename($image_url); // Create image file name

        // Check folder permission and define file location
        if( wp_mkdir_p( $upload_dir['path'] ) ) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        if ( $wp_filetype = wp_check_filetype( $filename, null ) ) {
            if( !file_exists( $file ) ) :

                // Create the image  file on the server
                file_put_contents( $file, $image_data );

                // Check image file type
                $wp_filetype = wp_check_filetype( $filename, null );

                // Set attachment data
                $attachment = array(
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title'     => sanitize_file_name( $filename ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );

                // Create the attachment
                $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

                // Include image.php
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                // Define attachment metadata
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

                // Assign metadata to attachment
                wp_update_attachment_metadata( $attach_id, $attach_data );
            else :
                $attach_id = Moove_Importer_Controller::moove_get_attachment_id_from_src( $file );
            endif;
            // And finally assign featured image to post
            set_post_thumbnail( $post_id, $attach_id );
        }
    }
    public function moove_create_post( $args ) {
        $form_data = $args['form_data'];
        $key = json_decode( wp_unslash( $args['key'] ) );
        $xml_data_values = $args['value'];
        $new_form_data = array();
        foreach ($form_data as $form_key => $form_value) :
            if ( $form_value !== '0' && $form_key !== 'post_status' && $form_key !== 'post_type' && $form_key !== 'post_author' && $form_key !== 'post_featured_image' ) :
                if ( $form_key === 'taxonomies' && count( $form_value ) ) :
                    $j = 0;
                    foreach ($form_value as $tax_key => $tax_value) :
                        if ( $tax_value['title'] !== '0' ) :
                            $j++;
                            $_key =  Moove_Importer_Controller::moove_recursive_array_search( $tax_value['title'] , $xml_data_values['values']) ;
                            if ( is_array( $_key ) ) :
                                $tax_title = $xml_data_values['values'][$_key[0]]['value'];
                            endif;

                            $new_form_data[ $form_key ][] = array(
                                'taxonomy'      =>  $tax_value['taxonomy'],
                                'title'         =>  $tax_title,
                            );
                        endif;
                    endforeach;
                else :
                    $_key =  Moove_Importer_Controller::moove_recursive_array_search( $form_value , $xml_data_values['values']) ;
                    if ( is_array( $_key ) ) :
                        $new_form_data[ $form_key ] = $xml_data_values['values'][$_key[0]]['value'];
                    endif;
                endif;
            else :
                if ( $form_key === 'post_status' || $form_key === 'post_type' ) :
                    $new_form_data[ $form_key ] = $form_value;
                elseif ( $form_key === 'post_author' ):
                    $new_form_data[ $form_key ] = intval( $form_value );
                endif;;
            endif;
        endforeach;
        // Create post object
        $new_post = array();
        foreach ( $new_form_data as $form_key => $form_value ) :
            $new_post[ $form_key ] = $form_value;
        endforeach;

        // Insert the post into the database
        $post_id = wp_insert_post( $new_post );

        foreach ($new_form_data['taxonomies'] as $taxonomy_value) :

            if ( $taxonomy_value['title'] !== "0" ) {
                $title = $taxonomy_value['title'];
                $taxonomy = $taxonomy_value['taxonomy'];

                $slug = sanitize_title( $taxonomy_value['title'] );

                wp_set_post_terms( $post_id, $slug, $taxonomy, true );

                $_new_taxonomy = get_term_by( 'name', $slug, $taxonomy );

                wp_update_term($_new_taxonomy->term_id, $taxonomy, array(
                  'name' => $title,
                  'slug' => $slug
                ));
            }
        endforeach;

        Moove_Importer_Controller::moove_set_featured_image( $post_id, $new_form_data[ 'post_featured_image' ] );

        return "true";
    }
}
$moove_importer_controller = new Moove_Importer_Controller();