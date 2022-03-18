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
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);


if (!is_user_logged_in()) {

    //START: Disable all cookies when in EU using CF_Geoplugin
    function unsetAllCookies() {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', 1);
                setcookie($name, '', 1, '/');
            }
        }
    }

    function remove_cookies_on_eu() {
        if (class_exists('CF_Geoplugin')) {
            $client_IP = do_shortcode('[cfgeo return="ip"]');
            $client_continent = do_shortcode('[cfgeo_continent_code]');
            if ($client_continent === 'EU') {
                echo '<!-- CF_Geoplugin: user is in EU -->';
                ini_set('session.use_cookies', '0');
                unsetAllCookies();
            } else {
                echo '<!-- CF_Geoplugin: user NOT in EU -->';
            }
        } else {
            echo '<!--CF_Geoplugin NOT present -->';
        }
    }

    add_action('wp_loaded', 'remove_cookies_on_eu');


    // END: Disable all cookies when in EU using CF_Geoplugin

}
