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
            if ($client_continent === 'EU') {
                ini_set('session.use_cookies', '0');
                unsetAllCookies();
                add_action('wp_footer', 'prefix_footer_code');
            } 
        }
    }
    add_action('wp_loaded', 'remove_cookies_on_eu');


    function non_eu_ga_tracking() {
        if (class_exists('CF_Geoplugin')) {
            $client_continent = do_shortcode('[cfgeo_continent_code]');
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

                <!-- Google Analytics snippet added by Site Kit -->
                    <script type='text/javascript' src='https://www.googletagmanager.com/gtag/js?id=UA-3696878-1' id='google_gtagjs-js'
                        async></script>
                    <script type='text/javascript' id='google_gtagjs-js-after'>
                        window.dataLayer = window.dataLayer || []; function gtag() { dataLayer.push(arguments); }
                        gtag('set', 'linker', { "domains": ["www.oceanmediainc.com"] });
                        gtag("js", new Date());
                        gtag("set", "developer_id.dZTNiMT", true);
                        gtag("config", "UA-3696878-1", { "anonymize_ip": true });
                        gtag("config", "G-398J33BRPJ");
                    </script>

                    <!-- End Google Analytics snippet added by Site Kit -->


                    <!-- Google Tag Manager snippet added by Site Kit -->
                    <script type="text/javascript">
                        (function (w, d, s, l, i) {
                            w[l] = w[l] || [];
                            w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
                            var f = d.getElementsByTagName(s)[0],
                                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                            j.async = true;
                            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                            f.parentNode.insertBefore(j, f);
                        })(window, document, 'script', 'dataLayer', 'GTM-K76W5G');

                    </script>

                    <!-- End Google Tag Manager snippet added by Site Kit -->
    <?php
            }
        }
    }
    add_action('wp_header', 'non_eu_ga_tracking');

    function non_eu_ga_trnon_eu_ga_tracking_iframeacking() {
        if (class_exists('CF_Geoplugin')) {
            $client_continent = do_shortcode('[cfgeo_continent_code]');
            if ($client_continent !== 'EU') {
        ?>
            <!-- Google Tag Manager (noscript) snippet added by Site Kit -->
            <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K76W5G" height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
            <!-- End Google Tag Manager (noscript) snippet added by Site Kit -->
    <?php
            }
        }
    }
    add_action('wp_body_open', 'non_eu_ga_tracking_iframe');


    // END: Disable all cookies when in EU using CF_Geoplugin

}
