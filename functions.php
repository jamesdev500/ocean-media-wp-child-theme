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

// ADDS A SPAN TAG AFTER THE GRAVITY FORMS BUTTON
// aria-hidden is added for accessibility (hides the icon from screen readers)
add_filter('gform_submit_button', 'dw_add_span_tags', 10, 2);
function dw_add_span_tags($button, $form) {

    return $button .= "<span aria-hidden='true'></span>";
}

// START: Disable all cookies when in EU using CF_Geoplugin

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function prefix_footer_code() {
?>
    <script>
        function deleteAllCookies() {
            var cookies = document.cookie.split("; ");
            for (var c = 0; c < cookies.length; c++) {
                var d = window.location.hostname.split(".");
                while (d.length > 0) {
                    var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
                    var p = location.pathname.split('/');
                    document.cookie = cookieBase + '/';
                    while (p.length > 0) {
                        document.cookie = cookieBase + p.join('/');
                        p.pop();
                    };
                    d.shift();
                }
            }
            console.log('cookies deleted...');
        }

        deleteAllCookies();

        document.addEventListener("DOMContentLoaded", function() {
            const gpdrPopUp = document.getElementById('cookie-law-info-bar');
            gpdrPopUp.remove();
            console.log('gpdrPopUp removed...');

            deleteAllCookies();
            setTimeout(function() {
                deleteAllCookies();
            }, 1000);
        });
    </script>
<?php
}

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
        echo console_log('client IP: ' . $client_IP);
        echo console_log('client continent: ' . $client_continent);
        if ($client_continent === 'EU') {
            if (!is_admin()) {
                ini_set('session.use_cookies', '0');
                unsetAllCookies();
                echo console_log('client continent is in EU, all cookies disabled');
                add_action('wp_footer', 'prefix_footer_code');
            }
        } else {
            echo console_log('client continent is not in EU');
        }
    } else {
        echo console_log('CF_Geoplugin NOT INSTALLED / currently in Admin');
    }
}
add_action('wp_loaded', 'remove_cookies_on_eu');


function non_eu_ga_tracking() {
    if (class_exists('CF_Geoplugin')) {
        $client_continent = do_shortcode('[cfgeo_continent_code]');
        echo console_log('client IP: ' . $client_IP);
        echo console_log('client continent: ' . $client_continent);
        if ($client_continent !== 'EU') {
?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3696878-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-3696878-1');
    </script>
<?php
        }
    }
}
add_action('wp_header', 'non_eu_ga_tracking');



// END: Disable all cookies when in EU using CF_Geoplugin
