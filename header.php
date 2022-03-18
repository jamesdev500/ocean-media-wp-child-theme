<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php $viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' ); ?>
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="shortcut icon" href="https://www.oceanmediainc.com/wp-content/uploads/2021/08/OMfavicon.ico" type="image/x-icon" />

	<?php if (!is_user_logged_in()) {
		if (class_exists('CF_Geoplugin')) {
			$client_IP = do_shortcode('[cfgeo return="ip"]');
			$client_continent = do_shortcode('[cfgeo_continent_code]');
			if ($client_continent !== 'EU') {
				?>
					<script> console.log('CF_Geoplugin head: <?= $client_IP ?> is not in EU'); </script>
					<!-- Global site tag (gtag.js) - Google Analytics -->
					<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3696878-1"></script>
					<script>
						console.log('GA tracking 1 loaded...');
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
			} else {
				?>
					<script> console.log('CF_Geoplugin head: <?= $client_IP ?> is in EU'); </script>
				<?php
			}
		}
		
		?>
		<!-- USER NOT LOGGED IN -->
		<script> console.log('User NOT logged in...'); </script>
	<?php } else { ?>
		<!-- USER LOGGED IN -->
		<script> console.log('User IS LOGGED IN...'); </script>
	<?php } ?>

	<?php wp_head(); ?>
	

</head>

	
<body <?php body_class(); ?>>

<?php if (!is_user_logged_in()) {
		if (class_exists('CF_Geoplugin')) {
			$client_IP = do_shortcode('[cfgeo return="ip"]');
			$client_continent = do_shortcode('[cfgeo_continent_code]');
			if ($client_continent !== 'EU') {
				?>
					<script> console.log('CF_Geoplugin body: <?= $client_IP ?> is not in EU'); </script>
					<!-- Google Tag Manager (noscript) snippet added by Site Kit -->
					<noscript>
						<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K76W5G" height="0" width="0" style="display:none;visibility:hidden"></iframe>
					</noscript>
					<!-- End Google Tag Manager (noscript) snippet added by Site Kit -->
				<?php
			} else {
				?>
					<script> console.log('CF_Geoplugin body: <?= $client_IP ?> is in EU'); </script>
				<?php
			}
		}
		
		?>
	<?php } ?>
<?php
hello_elementor_body_open();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	get_template_part( 'template-parts/header' );
}