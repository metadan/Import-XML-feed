<?php
/**
 * Moove_Importer_Actions File Doc Comment
 *
 * @category  Moove_Importer_Actions
 * @package   moove-feed-importer
 * @author    Gaspar Nemes
 */

/**
 * Moove_Importer_Actions Class Doc Comment
 *
 * @category Class
 * @package  Moove_Importer_Actions
 * @author   Gaspar Nemes
 */
class Moove_Importer_Actions {
	/**
	 * Global cariable used in localization
	 *
	 * @var array
	 */
	var $importer_loc_data;
	/**
	 * Construct
	 */
	function __construct() {
		$this->moove_register_scripts();
		$this->moove_register_ajax_actions();
	}
	/**
	 * Register Front-end / Back-end scripts
	 *
	 * @return void
	 */
	function moove_register_scripts() {
		if ( is_admin() ) :
			add_action( 'admin_enqueue_scripts', array( &$this, 'moove_importer_admin_scripts' ) );
		else :
			add_action( 'wp_enqueue_scripts', array( &$this, 'moove_frontend_importer_scripts' ) );
		endif;
	}
	/**
	 * Register global variables to head, AJAX, Form validation messages
	 *
	 * @param  string $ascript The registered script handle you are attaching the data for.
	 * @return void
	 */
	public function moove_localize_script( $ascript ) {
		$this->importer_loc_data = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( $ascript, 'moove_frontend_importer_scripts', $this->importer_loc_data );
	}
	/**
	 * Registe FRONT-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function moove_frontend_importer_scripts() {
		wp_enqueue_script( 'moove_importer_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/js/moove_importer_frontend.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'moove_importer_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/css/moove_importer_frontend.css' );
		$this->moove_localize_script( 'moove_importer_frontend' );
	}
	/**
	 * Registe BACK-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function moove_importer_admin_scripts() {
		wp_enqueue_script( 'moove_importer_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/js/moove_importer_backend.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'moove_importer_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/assets/css/moove_importer_backend.css' );
	}
	/**
	 * AJAX action used by importer plugin
	 *
	 * @return void
	 */
	public function moove_register_ajax_actions() {
		add_action( 'wp_ajax_moove_read_xml', array( &$this, 'moove_read_xml' ) );
		add_action( 'wp_ajax_nopriv_moove_read_xml', array( &$this, 'moove_read_xml' ) );

		add_action( 'wp_ajax_moove_create_post', array( &$this, 'moove_create_post' ) );
		add_action( 'wp_ajax_nopriv_moove_create_post', array( &$this, 'moove_create_post' ) );
	}
	/**
	 * Read XML function
	 *
	 * @return void
	 */
	public function moove_read_xml() {

		$args = array(
			'data' 		=> esc_sql( wp_unslash( $_POST['data'] ) ),
			'xmlaction'	=> sanitize_text_field( wp_unslash( $_POST['xmlaction'] ) ),
			'type'		=> sanitize_text_field( wp_unslash( $_POST['type'] ) ),
			'node'		=> sanitize_text_field( wp_unslash( $_POST['node'] ) ),
		);
		$move_importer = new Moove_Importer_Controller;
		$read_xml = $move_importer->moove_read_xml( $args );
		echo $read_xml;
		die();
	}
	/**
	 * Create post function
	 *
	 * @return void
	 */
	public function moove_create_post() {
		$args = array(
			'key'			=> sanitize_text_field( esc_sql( $_POST['key'] ) ),
			'value'			=> wp_unslash( $_POST['value'] ),
			'form_data'		=> esc_sql( wp_unslash( $_POST['form_data'] ) ),
		);
		$move_create_post = new Moove_Importer_Controller;
		$create_post = $move_create_post->moove_create_post( $args );
		echo $create_post;
		die();
	}
}
$moove_importer_actions_provider = new Moove_Importer_Actions();

