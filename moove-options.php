<?php
/**
 * Moove_Importer_Options File Doc Comment
 *
 * @category  Moove_Importer_Options
 * @package   moove-feed-importer
 * @author    Gaspar Nemes
 */

/**
 * Moove_Importer_Options Class Doc Comment
 *
 * @category Class
 * @package  Moove_Importer_Options
 * @author   Gaspar Nemes
 */
class Moove_Importer_Options {
	/**
	 * Construct
	 */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'moove_importer_admin_menu' ) );
	}

	/**
	 * Moove feed importer page added to settings
	 *
	 * @return  void
	 */
	function moove_importer_admin_menu() {
		add_options_page(
			'Feed importer',
			'Moove feed importer',
			'manage_options',
			'moove-importer',
			array( &$this, 'moove_importer_settings_page' )
		);
	}
	/**
	 * Settings page registration
	 *
	 * @return void
	 */
	function moove_importer_settings_page() {
		$post_types = get_post_types( array( 'public' => true ) );
		unset( $post_types['attachment'] );
		$data = array();
		if ( count( $post_types ) ) :
			foreach ( $post_types as $cpt ) :
				$taxonomies = get_object_taxonomies( $cpt, 'object' );
				$data[ $cpt ] = array(
					'post_type'		=> $cpt,
					'taxonomies'	=> $taxonomies,
				);
			endforeach;
		endif;
		echo Moove_Importer_View::load( 'moove.admin.settings.settings_page', $data );
	}
}
$moove_importer_options = new Moove_Importer_Options();
