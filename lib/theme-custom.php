<?php
/**
 * Select Spine & Sport functions
 */

/**
 * CPT
 */

// testimonials post type


add_action('init', 'testimonial_register');

function testimonial_register() {

	$labels = array(
		'name' 				=> _x( 'Testimonials', 'post type general name' ),
		'singular_name' 	=> _x( 'Testimonial', 'post type singular name' ),
		'add_new' 			=> _x( 'Add new', 'slide item' ),
		'add_new_item' 		=> __( 'Add new testimonial' ),
		'edit_item' 		=> __( 'Edit testimonial' ),
		'new_item' 			=> __( 'New testimonial' ),
		'view_item' 		=> __( 'View testimonial' ),
		'search_items' 		=> __( 'Search' ),
		'not_found' 		=> __( 'Not found' ),
		'not_found_in_trash' => __( 'Nothing found in trash' ),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' 				=> $labels,
		'exclude_from_search' 	=> false,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_in_menu' 			=> true,
		'show_ui' 				=> true,
		'query_var' 			=> true,
		'menu_icon' 			=> 'dashicons-testimonial',
		'rewrite' 				=> array(
			'slug' 				=> 'testimonial',
			'with_front' 		=> true
		),
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> 5,
		'supports' 				=> array(
			'title',
			'thumbnail',
			'editor',
			'revisions'
		)
	);

	register_post_type( 'testimonial' , $args );
}


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
					'mailing_address'	=> new Fieldmanager_TextArea( 'Mailing address' ),
					'contact_us_link'	=> new Fieldmanager_Textfield( 'Contact us page link' ),
					'hours'				=> new Fieldmanager_TextArea( 'Hours available' ),
					'facebook'			=> new Fieldmanager_Textfield( 'Facebook page link' ),
					'twitter'			=> new Fieldmanager_Textfield( 'Twitter account name' ),
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
				$the_icon_array = array_diff( scandir( $the_icon_path ), array( '..', '.' ) );
				$the_icon_array = array_map( function( $e ) {
					return pathinfo( $e, PATHINFO_FILENAME );
				}, $the_icon_array );

				$fm = new Fieldmanager_Group( array(
						'name'				=> 'homepage_service_box',
						'limit'				=> 0,
						'add_more_label' 	=> 'Add another service',
						'sortable'			=> true,
						'label'				=> 'Service',
						'label_macro'    	=> array( 'Service: %s', 'service_title' ),
						'collapsible'    	=> true,
						'children'			=> array(
							'service_title' 	=> new Fieldmanager_Textfield( 'Service title' ),
							'service_icon'		=> new Fieldmanager_Radios( false, array(
										'options_template'	=> get_template_directory() . '/lib/icon_template.php',
										'options'			=> $the_icon_array,
									)
								),
							'service_description'	=> new Fieldmanager_RichTextArea( 'Service description' ),
						),
					)
				);
				$fm->add_meta_box( 'Services', 'page' );

				$fm = new Fieldmanager_Group( array(
						'name'			=> 'services_more_button',
						'limit'			=> 1,
						'label'			=> 'Services read more button',
						'children'		=> array(
							'services_more_link'=> new Fieldmanager_Textfield( 'More info button link address' ),
							'services_more_text'=> new Fieldmanager_Textfield( 'More info button text label' ),
						),
					)
				);
				$fm->add_meta_box( 'Services, read more button', 'page' );

				$fm = new Fieldmanager_Group( array(
						'name'			=> 'homepage_locations',
						'limit'			=> 0,
						'add_more_label' => 'Add another location',
						'sortable'		=> true,
						'label'			=> 'Location',
						'label_macro'	=> array( 'Location: %s', 'location_title' ),
						'collapsible'	=> true,
						'children'		=> array(
							'location_title'	=> new Fieldmanager_Textfield( 'Location title' ),
							'location_address'	=> new Fieldmanager_Textfield( 'Location address' ),
							'location_citystate'=> new Fieldmanager_Textfield( 'Location city, state, zip' ),
							'location_lat'		=> new Fieldmanager_Textfield( array(
									'label'				=> 'Location latitude',
									'description'		=> 'found in google maps link, after the /@, first number. format: XX.XXXXXX'
								)
							),
							'location_lng'	=> new Fieldmanager_Textfield( array(
									'label'			=> 'Location longitude',
									'description'	=> 'found in google maps link, after the /@, second number. format: XX.XXXXXX'
								)
							),
							'location_description'	=> new Fieldmanager_RichTextArea( 'Additional location information' ),
						),
					)
				);
				$fm->add_meta_box( 'Locations', 'page' );

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

add_image_size( 'homepage-slide', 600, 310, true ); // (cropped)


/**
 * adding a shortcode to add an SVG icon
 */

function svg_icon_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'icon'	=> 'ambulance-star',
		'size'	=> '100px',
		'align'	=> 'right',
	), $atts, 'sss' ) );

	return sprintf( '<div class="icon icon-%1$s" style="width: %2$s; height: %2$s; float: %3$s; margin:6px;"></div>',
        esc_html( $icon ),
        esc_html( $size ),
		esc_html( $align )
    );
}
add_shortcode( 'icon', 'svg_icon_shortcode' );


/**
 * add icon cheat sheet into page/post content
 */

add_filter( 'mce_external_plugins', 'icon_cheatsheet_add_button' );
function icon_cheatsheet_add_button( $plugins ) {
	$plugins['icon_cheatsheet'] = get_template_directory_uri() . '/assets/js/icon-cheatsheet.js';
	return $plugins;
}

add_filter( 'mce_buttons', 'icon_cheatsheet_register_button' );
function icon_cheatsheet_register_button( $buttons ) {
	array_push( $buttons, 'icon_cheatsheet' );
	return $buttons;
}

add_action( 'wp_ajax_icon_cheatsheet_insert_dialog', 'icon_cheatsheet_insert_dialog' );

function icon_cheatsheet_insert_dialog() {

	die(include get_template_directory() . '/lib/view-icon-cheatsheet.php');

}

