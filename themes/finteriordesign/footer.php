<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "body-content-wrapper" div and all content after.
 *
 * @subpackage fInteriorDesign
 * @author tishonator
 * @since fInteriorDesign 1.0.0
 *
 */
?>
			<a href="#" class="scrollup"></a>

			<footer id="footer-main">

				<div id="footer-content-wrapper">

					<?php get_sidebar('footer'); ?>

					<div class="clear">
					</div>

					<div id="copyright">

						<p>
						 <?php finteriordesign_show_copyright_text(); ?> <a href="<?php echo esc_url( 'https://tishonator.com/product/finteriordesign' ); ?>" title="<?php esc_attr_e( 'finteriordesign Theme', 'finteriordesign' ); ?>">
							<?php _e('fInteriorDesign Theme', 'finteriordesign'); ?></a> <?php esc_attr_e( 'powered by', 'finteriordesign' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr_e( 'WordPress', 'finteriordesign' ); ?>">
							<?php _e('WordPress', 'finteriordesign'); ?></a>
						</p>
						
					</div><!-- #copyright -->

				</div><!-- #footer-content-wrapper -->

			</footer><!-- #footer-main -->

		</div><!-- #body-content-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>