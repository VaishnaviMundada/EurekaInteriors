<?php
/**
 * fInteriorDesign functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @subpackage fInteriorDesign
 * @author tishonator
 * @since fInteriorDesign 1.0.0
 *
 */

require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

if ( ! function_exists( 'finteriordesign_setup' ) ) :
/**
 * fInteriorDesign setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function finteriordesign_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'finteriordesign', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, true );

	// This theme uses wp_nav_menu() in header menu
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'finteriordesign' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// add the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', get_template_directory_uri() . '/css/font-awesome.min.css' ) );

	// add custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	// add content width
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}

	// add custom header
    add_theme_support( 'custom-header', array (
                       'default-image'          => get_template_directory_uri() . '/images/headerback.jpg',
                       'random-default'         => '',
                       'flex-height'            => true,
                       'flex-width'             => true,
                       'uploads'                => true,
                       'width'                  => 900,
                       'height'                 => 100,
                       'default-text-color'        => '#000000',
                       'wp-head-callback'       => 'finteriordesign_header_style',
                    ) );


    // add custom logo
    add_theme_support( 'custom-logo', array (
                       'width'                  => 145,
                       'height'                 => 36,
                       'flex-height'            => true,
                       'flex-width'             => true,
                    ) );

}
endif; // finteriordesign_setup
add_action( 'after_setup_theme', 'finteriordesign_setup' );

/**
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function finteriordesign_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Register theme settings in the customizer
 */
function finteriordesign_customize_register( $wp_customize ) {

	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'finteriordesign_slider_section',
		array(
			'title'       => __( 'Slider', 'finteriordesign' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add display slider option
	$wp_customize->add_setting(
			'finteriordesign_slider_display',
			array(
					'default'           => 0,
					'sanitize_callback' => 'finteriordesign_sanitize_checkbox',
			)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'finteriordesign_slider_display',
							array(
								'label'          => __( 'Display Homepage Slider', 'finteriordesign' ),
								'section'        => 'finteriordesign_slider_section',
								'settings'       => 'finteriordesign_slider_display',
								'type'           => 'checkbox',
							)
						)
	);

	for ( $i = 1; $i <= 4; ++$i ) {

		// add a slide image
		$wp_customize->add_setting( 'finteriordesign_slide' . $i . '_image',
			array(
				'default' => get_template_directory_uri() . '/images/slider/' . $i . '.jpg',
	    		'sanitize_callback' => 'esc_url_raw'
			)
		);

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'finteriordesign_slide' . $i . '_image',
				array(
					'label'   	 => sprintf( __( 'Slide %s Image', 'finteriordesign' ), $i ),
					'section' 	 => 'finteriordesign_slider_section',
					'settings'   => 'finteriordesign_slide' . $i . '_image',
				) 
			)
		);	
	}

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'finteriordesign_footer_section',
		array(
			'title'       => __( 'Footer', 'finteriordesign' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'finteriordesign_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'finteriordesign_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'finteriordesign' ),
            'section'        => 'finteriordesign_footer_section',
            'settings'       => 'finteriordesign_footer_copyright',
            'type'           => 'text',
            )
        )
	);
}

add_action('customize_register', 'finteriordesign_customize_register');

/**
 * the main function to load scripts in the fInteriorDesign theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function finteriordesign_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'finteriordesign-style', get_stylesheet_uri(), array() );
	
	wp_enqueue_style( 'finteriordesign-fonts', finteriordesign_fonts_url(), array(), null );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// load JavaScript scripts
	wp_enqueue_script( 'finteriordesign-js', get_template_directory_uri() . '/js/utilities.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'finteriordesign_load_scripts' );

/**
 *	Load google font url used in the fInteriorDesign theme
 */
function finteriordesign_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $cantarell = _x( 'on', 'PT Sans font: on or off', 'finteriordesign' );

    if ( 'off' !== $cantarell ) {
        $font_families = array();
 
        $font_families[] = 'PT Sans';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,cyrillic-ext,cyrillic,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display website's logo image
 */
function finteriordesign_show_website_logo_image_and_title() {

	if ( has_custom_logo() ) {

        the_custom_logo();
    }

    $header_text_color = get_header_textcolor();

    if ( 'blank' !== $header_text_color ) {
    
        echo '<div id="site-identity">';
        echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
        echo '<h1>'.get_bloginfo('name').'</h1>';
        echo '</a>';
        echo '<strong>'.get_bloginfo('description').'</strong>';
        echo '</div>';
    }
}

/**
 *	Displays the copyright text.
 */
function finteriordesign_show_copyright_text() {

	$footerText = get_theme_mod('finteriordesign_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function finteriordesign_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'finteriordesign'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'finteriordesign'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );

	// Register Footer Column #1
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #1', 'finteriordesign' ),
							'id' 			 =>  'footer-column-1-widget-area',
							'description'	 =>  __( 'The Footer Column #1 widget area', 'finteriordesign' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #2
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #2', 'finteriordesign' ),
							'id' 			 =>  'footer-column-2-widget-area',
							'description'	 =>  __( 'The Footer Column #2 widget area', 'finteriordesign' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #3
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #3', 'finteriordesign' ),
							'id' 			 =>  'footer-column-3-widget-area',
							'description'	 =>  __( 'The Footer Column #3 widget area', 'finteriordesign' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
}

add_action( 'widgets_init', 'finteriordesign_widgets_init' );

/**
 * Displays the Slider
 */
function finteriordesign_display_slider() {

	$allImages = array();

	for ( $i = 1; $i <= 4; ++$i ) {

		$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';
		$slideImage = get_theme_mod( 'finteriordesign_slide'.$i.'_image', $defaultSlideImage );

		if ( $slideImage != '' ) {

			$allImages[] = $slideImage;
		}
	}

	$allImagesCount = count($allImages);

	// skip displaying of slider if there are NO images
	if ($allImagesCount == 0) {

		return;

	} else if ($allImagesCount == 1) {

		$allImages[] = $allImages[0];
		$allImages[] = $allImages[0];
		$allImages[] = $allImages[0];

	} else if ($allImagesCount == 2) {

		$allImages[] = $allImages[0];
		$allImages[] = $allImages[1];

	} else if ($allImagesCount == 3) {

		$allImages[] = $allImages[0];
	}
?>
	<!-- slider start -->
	<div class="rm_wrapper">
		<div id="rm_container" class="rm_container">
			<ul>
				<li data-images="rm_container_1" data-rotation="-15">
					<img src="<?php echo esc_url( $allImages[ 0 ] ); ?>" />
				</li>
				<li data-images="rm_container_2" data-rotation="-5">
					<img src="<?php echo esc_url( $allImages[ 1 ] ); ?>" />
				</li>
				<li data-images="rm_container_3" data-rotation="5">
					<img src="<?php echo esc_url( $allImages[ 2 ] ); ?>" />
				</li>			
				<li data-images="rm_container_4" data-rotation="15">
					<img src="<?php echo esc_url( $allImages[ 3 ] ); ?>" />
				</li>
			</ul>
			<div id="rm_mask_left" class="rm_mask_left">
			</div>
			<div id="rm_mask_right" class="rm_mask_right">
			</div>
			<div id="rm_corner_left" class="rm_corner_left">
			</div>
			<div id="rm_corner_right" class="rm_corner_right">
			</div>
			<div style="display:none;">
				<div id="rm_container_1">
					<?php
						echo '<img src="' . esc_url( $allImages[ 0 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 1 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 2 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 3 ] ) . '" />';
					?>
				</div>
				<div id="rm_container_2">
					<?php
						echo '<img src="' . esc_url( $allImages[ 1 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 2 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 3 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 0 ] ) . '" />';
					?>
				</div>
				<div id="rm_container_3">
					<?php
						echo '<img src="' . esc_url( $allImages[ 2 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 3 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 0 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 1 ] ) . '" />';
					?>
				</div>
				<div id="rm_container_4">
					<?php
						echo '<img src="' . esc_url( $allImages[ 3 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 0 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 1 ] ) . '" />';
						echo '<img src="' . esc_url( $allImages[ 2 ] ) . '" />';
					?>
				</div>
			</div>
		</div>
		<div class="rm_nav">
			<a id="rm_next" href="#" class="rm_next"></a>
			<a id="rm_prev" href="#" class="rm_prev"></a>
		</div>
	</div>
	<!-- slider end -->
<?php
}

function finteriordesign_header_style() {

    $header_text_color = get_header_textcolor();

    if ( ! has_header_image()
        && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
             || 'blank' === $header_text_color ) ) {

        return;
    }

    $headerImage = get_header_image();
?>
    <style type="text/css">
        <?php if ( has_header_image() ) : ?>

                #header-main {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

        <?php endif; ?>

        <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                    && 'blank' !== $header_text_color ) : ?>

                #header-main {color: #<?php echo esc_attr( $header_text_color ); ?>;}

        <?php endif; ?>
    </style>
<?php
}

?>
