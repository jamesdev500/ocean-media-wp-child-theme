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

// START: Disable all cookies when in EU using CF_Geoplugin

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function prefix_footer_code() {
    ?>
	<script>
        document.addEventListener("DOMContentLoaded", function(){
            console.log('prefix_footer_code loaded...');
        });
    </script>
    <?php
}
function unsetAllCookies() {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
}
function remove_cookies_on_eu() {
    if (class_exists('CF_Geoplugin') && !is_admin() ) {
        $client_IP = do_shortcode( '[cfgeo return="ip"]' );
        $client_continent = do_shortcode( '[cfgeo_continent_code]' );
        echo console_log('client IP: ' . $client_IP);
        echo console_log('client continent: ' . $client_continent);
        if ($client_continent === 'EU') {
            ini_set('session.use_cookies', '0');
            unsetAllCookies();
            echo console_log('client continent is in EU, all cookies disabled');
            add_action( 'wp_footer', 'prefix_footer_code' );
        }
    } else {
        echo console_log('CF_Geoplugin NOT INSTALLED / currently in Admin');
    }
}
add_action( 'wp_loaded','remove_cookies_on_eu' );

// END: Disable all cookies when in EU using CF_Geoplugin