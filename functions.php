<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

// ADDS A SPAN TAG AFTER THE GRAVITY FORMS BUTTON
// aria-hidden is added for accessibility (hides the icon from screen readers)
add_filter( 'gform_submit_button', 'dw_add_span_tags', 10, 2 );
function dw_add_span_tags ( $button, $form ) {

return $button .= "<span aria-hidden='true'></span>";

}


