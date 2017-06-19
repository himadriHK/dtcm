<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * @package	   TGM-Plugin-Activation
 * @subpackage Plugins
 * @author	   Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author	   Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license	   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
tokopress_require_file( THEME_DIR . '/inc/libs/tgm/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'tokopress_register_required_plugins' );
function tokopress_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		/* Required Plugin */
		array(
			'name'		=> 'The Events Calendar',
			'slug'		=> 'the-events-calendar',
			'version' 	=> '4.1',
			'required'	=> true,
		),

		/* Recommended Plugin */
		array(
			'name'		=> 'The Events Calendar - Frontend Submission',
			'slug'		=> 'tec-frontend-submission',
			'source'   	=> get_template_directory() . '/inc/plugins/tec-frontend-submission-v1.3.1.zip',
			'version' 	=> '1.3.1',
			'required' 	=> false,
		),

		array(
			'name'     	=> 'Visual Composer',
			'slug'     	=> 'js_composer',
			'source'   	=> get_template_directory() . '/inc/plugins/js_composer-v4.12.zip',
			'version' 	=> '4.12',
			'required' 	=> false,
		),

		array(
			'name'     	=> 'Eventica Visual Composer & Shortcodes',
			'slug'     	=> 'eventica-visual-composer-shortcode',
			'source'   	=> get_template_directory() . '/inc/plugins/eventica-visual-composer-shortcode-v1.10.0.zip',
			'version' 	=> '1.10.0',
			'required' 	=> false,
		),

		array(
			'name'		=> 'MailChimp for WordPress',
			'slug'		=> 'mailchimp-for-wp',
			'required'	=> false,
		),

		array(
			'name'		=> 'WooCommerce',
			'slug'		=> 'woocommerce',
			'required'	=> false,
		),

		array(
			'name'     => 'Testimonials Plugin For Eventica',
			'slug'     => 'eventica-testimonials',
			'source'   => get_template_directory() .'/inc/plugins/eventica-testimonials_v1.0.zip',
			'required' => false
		),
		
		array(
			'name'		=> 'WordPress Importer',
			'slug'		=> 'wordpress-importer',
			'source'   	=> get_template_directory() . '/inc/plugins/wordpress-importer-v2.0.zip',
			'version' 	=> '2.0',
			'required' 	=> false,
		),
		
		array(
			'name'		=> 'Widget Importer Exporter',
			'slug'		=> 'widget-importer-exporter',
			'required'	=> false,
		),
		
		array(
			'name'		=> 'Regenerate Thumbnails',
			'slug'		=> 'regenerate-thumbnails',
			'required'	=> false,
		),

	);

	if ( function_exists( 'xt_tec_frontend_submission_shortcode' ) ) {
		$plugins[] = array(
			'name'		=> 'CMB2 - Metabox',
			'slug'		=> 'cmb2',
			'version' 	=> '2.2.1',
			'required'	=> true,
		);
	}
	else {
		$plugins[] = array(
			'name'		=> 'CMB2 - Metabox',
			'slug'		=> 'cmb2',
			'version' 	=> '2.2.1',
			'required'	=> false,
		);
	}

	$config = array(
		'id'           => 'toko-tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'toko-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );

}

if ( !of_get_option( 'tokopress_enable_vc_license' ) ) {
	/* Set Visual Composer as Theme part and disable Visual Composer Updater */
	add_action( 'vc_before_init', 'toko_vc_set_as_theme', 9 );
	function toko_vc_set_as_theme() {
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme(true);
			vc_manager()->disableUpdater(true);
		}
	}
}

add_filter('vc_load_default_templates','tokopress_load_vc_templates');
function tokopress_load_vc_templates( $args ) {
	$args2 = array ( 
		array(
			'name'=> '1. '.__('Eventica - Home','tokopress'),
			'image_path'=> THEME_URI . '/img/vc-homepage.png', 
			'content'=>'[vc_row full_width="stretch_row_content_no_spaces" css=".vc_custom_1425161144334{margin-bottom: 0px !important;}"][vc_column width="1/1"][eventica_events_slider per_page="4" container="yes"][/vc_column][/vc_row][vc_row css=".vc_custom_1425351223401{margin-bottom: 0px !important;}"][vc_column width="1/1"][eventica_events_search][/vc_column][/vc_row][vc_row css=".vc_custom_1425353909117{margin-bottom: 0px !important;padding-top: 30px !important;background-color: #cccccc !important;}" full_width="stretch_row"][vc_column width="1/1"][eventica_upcoming_events numbers="3" columns="3" columns_tablet="2" title_hide="no" title_color="#ffffff"][/vc_column][/vc_row][vc_row css=".vc_custom_1425351865698{margin-bottom: 0px !important;}"][vc_column width="1/3" css=".vc_custom_1425353892342{padding-top: 30px !important;}"][eventica_recent_posts numbers="3" columns="1" columns_tablet="2" title_hide="no"][/vc_column][vc_column width="2/3" css=".vc_custom_1425351892447{margin-bottom: 0px !important;}"][eventica_featured_event title_hide="no" columns="1"][eventica_subscribe_form][/vc_column][/vc_row][vc_row css=".vc_custom_1425351905476{margin-bottom: 0px !important;}"][vc_column width="1/1"][eventica_testimonials numbers="" title_hide="no" title_text=""][/vc_column][/vc_row][vc_row css=".vc_custom_1425351917990{margin-bottom: 0px !important;}"][vc_column width="1/1"][eventica_brand_sponsors title_hide="no"][/vc_column][/vc_row]', 
		),
	);
	return array_merge( $args, $args2 );
}
