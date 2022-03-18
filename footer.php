<?php

/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('footer')) {
    get_template_part('template-parts/footer');
}
?>

<?php wp_footer(); ?>


<?php if (!is_user_logged_in()) { 

        if (class_exists('CF_Geoplugin')) {
            $client_IP = do_shortcode('[cfgeo return="ip"]');
            $client_continent = do_shortcode('[cfgeo_continent_code]');
            if ($client_continent !== 'EU') {
                ?>
                    <script> console.log('CF_Geoplugin footer: <?= $client_IP ?> is not in EU'); </script>
                <?php
            } else {
                ?>
                    <script> console.log('CF_Geoplugin footer: <?= $client_IP ?> is in EU'); </script>
                    <script>
                        console.log('deleteAllCookies start...');
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
                            }, 500);
                        });
                    </script>
                <?php
            }
        } else {
            ?>
            <script> console.log('CF_Geoplugin NOT installed'); </script>
            <?php
        }
    } 
?>


</body>

</html>