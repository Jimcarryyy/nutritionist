<?php
/**
 * nutritionist_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nutritionist_theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.9.7' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function nutritionist_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on nutritionist_theme, use a find and replace
		* to change 'nutritionist_theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'nutritionist_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'nutritionist_theme' ),
			'footer' => esc_html__( 'Footer', 'nutritionist_theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'nutritionist_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'nutritionist_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nutritionist_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nutritionist_theme_content_width', 1290 );
}
add_action( 'after_setup_theme', 'nutritionist_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nutritionist_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'nutritionist_theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'nutritionist_theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'nutritionist_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function nutritionist_theme_scripts() {
	// Urbanist (design system font).
	wp_enqueue_style(
		'nutritionist_theme-fonts',
		'https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Font Awesome 6 (UI icons).
	wp_enqueue_style(
		'nutritionist_theme-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
		array(),
		'6.5.1'
	);

	wp_enqueue_style(
		'nutritionist_theme-style',
		get_stylesheet_uri(),
		array( 'nutritionist_theme-fonts', 'nutritionist_theme-fontawesome' ),
		_S_VERSION
	);
	wp_style_add_data( 'nutritionist_theme-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'nutritionist_theme-loader',
		get_template_directory_uri() . '/js/loader.js',
		array(),
		_S_VERSION,
		true
	);

	wp_enqueue_script( 'nutritionist_theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script(
		'nutritionist_theme-site',
		get_template_directory_uri() . '/js/site.js',
		array(),
		_S_VERSION,
		true
	);

	if ( is_page_template( 'page-contact.php' ) || is_page( 'contact' ) ) {
		wp_localize_script(
			'nutritionist_theme-site',
			'nutritionistContact',
			array(
				'restUrl' => esc_url_raw( rest_url( 'nutritionist/v1/contact' ) ),
				'nonce'   => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	if ( is_front_page() ) {
		wp_enqueue_script(
			'nutritionist_theme-home',
			get_template_directory_uri() . '/js/home.js',
			array(),
			_S_VERSION,
			true
		);
	}

	if ( is_page_template( 'page-team.php' ) || is_page( 'team' ) ) {
		wp_enqueue_script(
			'nutritionist_theme-team',
			get_template_directory_uri() . '/js/team.js',
			array(),
			_S_VERSION,
			true
		);
	}

	if ( is_page_template( 'page-pricing.php' ) || is_page( 'pricing' ) ) {
		wp_enqueue_script(
			'nutritionist_theme-pricing',
			get_template_directory_uri() . '/js/pricing.js',
			array(),
			_S_VERSION,
			true
		);
	}

	if ( is_page_template( 'page-blog.php' ) || is_page( 'blog' ) ) {
		wp_enqueue_script(
			'nutritionist_theme-blog',
			get_template_directory_uri() . '/js/blog.js',
			array(),
			_S_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nutritionist_theme_scripts' );

/**
 * Fallback primary menu when no menu is assigned.
 */
function nutritionist_theme_fallback_menu() {
	$pages = array(
		'home'     => __( 'Home', 'nutritionist_theme' ),
		'about'    => __( 'About', 'nutritionist_theme' ),
		'team'     => __( 'Team', 'nutritionist_theme' ),
		'process'  => __( 'Process', 'nutritionist_theme' ),
		'pricing'  => __( 'Pricing', 'nutritionist_theme' ),
		'blog'     => __( 'Blog', 'nutritionist_theme' ),
	);
	echo '<ul id="primary-menu" class="nav-menu">';
	foreach ( $pages as $slug => $label ) {
		$url = ( 'home' === $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Fallback footer menu when no menu is assigned.
 */
function nutritionist_theme_fallback_footer_menu() {
	$pages = array(
		'home'     => __( 'Home', 'nutritionist_theme' ),
		'about'    => __( 'About', 'nutritionist_theme' ),
		'team'     => __( 'Team', 'nutritionist_theme' ),
		'process'  => __( 'Process', 'nutritionist_theme' ),
		'pricing'  => __( 'Pricing', 'nutritionist_theme' ),
		'blog'     => __( 'Blog', 'nutritionist_theme' ),
		'contact'  => __( 'Contact', 'nutritionist_theme' ),
	);
	echo '<ul id="footer-menu" class="menu">';
	foreach ( $pages as $slug => $label ) {
		$url = ( 'home' === $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Helper: theme image URL.
 *
 * @param string $path Relative path under assets/images/.
 * @return string
 */
function nutritionist_theme_image_url( $path ) {
	return get_template_directory_uri() . '/assets/images/' . ltrim( $path, '/' );
}

/**
 * ACF Free field helpers (safe without ACF) and local field groups.
 */
require get_template_directory() . '/inc/acf-helpers.php';
if ( function_exists( 'acf_add_local_field_group' ) ) {
	require get_template_directory() . '/inc/acf-fields.php';
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

