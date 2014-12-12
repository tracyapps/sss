<?php
/**
 * Select Spine & Sport functions
 */


// Supporting code
require_once( 'class-fm-data-structures.php' );

/**
 * theme options / global site information
 */

if ( !class_exists( 'FM_SSS_Context_Submenu' ) ) :

	class FM_SSS_Context_Submenu {

		private static $instance;

		private function __construct() {
			/* Don't do anything, needs to be initialized via instance() method */
		}

		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new FM_SSS_Context_Submenu;
				self::$instance->setup();
			}
			return self::$instance;
		}

		public function setup() {
			fm_register_submenu_page( 'option_fields', 'options-general.php', 'Global content' );
			add_action( 'fm_submenu_option_fields', array( $this, 'options_init' ) );
		}

		public function options_init() {
			$fm = new Fieldmanager_Group( array(
				'name'           => 'option_fields',
				'limit'          => 1,
				'label'          => 'Global site information',
				'children'       => array(
					'tagline'         	=> new Fieldmanager_Textfield( 'Tagline' ),
					'additional-intro'	=> new Fieldmanager_TextArea( 'Additional intro text' ),
					'phone'				=> new Fieldmanager_Textfield( 'Phone number' ),
					'facebook'			=> new Fieldmanager_Textfield( 'Facebook page link' ),
					'twitter'			=> new Fieldmanager_Textfield( 'Twitter account name' ),
					'address'			=> new Fieldmanager_TextArea( 'Address' ),
					)
				)
			);
			$fm->activate_submenu_page();

		}
	}

	FM_SSS_Context_Submenu::instance();

endif;

/**
 * meta fields just for home page
 */

if ( class_exists( 'Fieldmanager_Field' ) ) :
	function sss_home_page_meta_fields() {
		// Only display these fields for the homepage
		$page_id = false;
		if ( ! empty( $_GET['post'] ) ) {
			$page_id = intval( $_GET['post'] );
		} elseif ( ! empty( $_POST['post_ID'] ) ) {
			$page_id = intval( $_POST['post_ID'] );
		}
		if ( $page_id ) {
			$front_page = intval( get_option( 'page_on_front' ) );
			if ( $front_page == $page_id ) {

				$fm = new Fieldmanager_Group( array(
					'name'           => 'homepage_slideshow',
					'limit'          => 0,
					'add_more_label' => 'Add another slide',
					'sortable'       => true,
					'label'          => 'Slide',
					'collapsible'    => true,
					'label_macro'    => array( 'Slide: %s', 'slide_title' ),
					'description'	=> 'Add an image for the slide. Add an optional caption (to be displayed under the image). The title is just for your own reference and is not displayed',
					'children'       => array(
						'media_field' => new Fieldmanager_Media( 'Slide image' ),
						'slide_title' => new Fieldmanager_Textfield( 'Slide title' ),
						'slide_caption' => new Fieldmanager_Textfield( 'Slide caption' ),
					)
				) );
				$fm->add_meta_box( 'Homepage slideshow', 'page' );

				$the_icon_path = get_template_directory() . '/assets/img/icons/png/';
				$the_icon_array = glob( $the_icon_path . '*.png', GLOB_BRACE );

				$fm = new Fieldmanager_group( array(
						'name'				=> 'homepage_service_box',
						'limit'				=> 0,
						'add_more_label' 	=> 'Add another service',
						'sortable'			=> true,
						'label'				=> 'Service',
						'label_macro'    	=> array( 'Service: %s', 'service_title' ),
						'collapsible'    	=> true,
						'children'			=> array(
							'service_title' => new Fieldmanager_Textfield( 'Service title' ),
							'service_icon'	=> new Fieldmanager_Radios( false, array(
										'label'				=> 'Select an icon',
										'options_template'	=> get_template_directory() . '/lib/icon_template.php',
										'options'			=> array(
											'datasource'		=> $the_icon_array
										)
									)
								),
							'service_description'	=> new Fieldmanager_RichTextArea( 'Service description' ),
						),
					)
				);
				$fm->add_meta_box( 'Services', 'page' );

			}
		}
	}
	add_action( 'fm_post_page', 'sss_home_page_meta_fields' );

endif;


/**
 * quick and dirty function to fix formatting of the custom meta boxes in admin area.
 */

add_action('admin_head', 'fix_meta_box_formatting');

function fix_meta_box_formatting() {
	echo '<style>
    	.fm-service_icon-wrapper {overflow: hidden; float: none; display: block; padding: 5px 0px;}
	</style>';
}

/**
 * adding a slideshow image size, cropped
 */

add_image_size( 'homepage-slide', 600, 250, true ); // (cropped)