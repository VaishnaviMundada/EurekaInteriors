<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "body-content-wrapper" div.
 *
 * @subpackage fInteriorDesign
 * @author tishonator
 * @since fInteriorDesign 1.0.0
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="body-content-wrapper">
			
			<header id="header-main">

				<div id="header-content-wrapper">

					<div id="header-logo">
						<?php finteriordesign_show_website_logo_image_and_title(); ?>
					</div><!-- #header-logo -->

				</div><!-- #header-content-wrapper -->

				<div class="clear"></div>

			</header><!-- #header-main -->

			<nav id="navmain">
				<?php wp_nav_menu( array( 'theme_location' => 'primary',
										  'fallback_cb'    => 'wp_page_menu',
										  
										  ) ); ?>
			</nav><!-- #navmain -->
			
			<div class="clear">
			</div><!-- .clear -->

			<?php if ( is_front_page() && get_theme_mod('finteriordesign_slider_display', 0) == 1 ) :
			
						finteriordesign_display_slider();
			
				  endif; ?>
