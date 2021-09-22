<?php
/**
 * @package Dummy_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'dummy_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dummy_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Dummy Theme, use a find and replace
		 * to change 'dummy-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'dummy-theme', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'dummy-theme' ),
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

		// Register post formats
		function dummy_post_formats()  {
			// Add theme support for Post Formats
			add_theme_support( 'post-formats', array( 'status', 'quote', 'gallery', 'image', 'video' ) );
		}
		add_action( 'after_setup_theme', 'dummy_post_formats' );

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
endif;
add_action( 'after_setup_theme', 'dummy_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dummy_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dummy_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'dummy_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dummy_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'dummy-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'dummy-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dummy_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dummy_theme_scripts() {
	wp_enqueue_style( 'dummy-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'dummy-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'dummy-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dummy_theme_scripts' );

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

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load option page class.
 */
	require get_template_directory() . '/inc/RationalOptionPages.php';

// add options page
$pages = array(
	'option-page'	=> array(
		'page_title'	=> __( 'Dummy Option Page', 'dummy-theme' ),
		'sections'		=> array(
			'section-one'	=> array(
				'title'			=> __( 'Standard Inputs', 'dummy-theme' ),
				'fields'		=> array(
					'default'		=> array(
						'title'			=> __( 'Default (text)', 'dummy-theme' ),
						'text'			=> __( 'Text attributes are used as help text for most input types.' ),
					),
					'date'			=> array(
						'title'			=> __( 'Date', 'dummy-theme' ),
						'type'			=> 'date',
						'value'			=> 'now',
					),
					'datetime'		=> array(
						'title'			=> __( 'Datetime-Local', 'dummy-theme' ),
						'type'			=> 'datetime-local',
						'value'			=> 'now',
					),
					'datetime-local' => array(
						'title'			=> __( 'Datetime-Local', 'dummy-theme' ),
						'type'			=> 'datetime-local',
						'value'			=> 'now',
					),
					'email'			=> array(
						'title'			=> __( 'Email', 'dummy-theme' ),
						'type'			=> 'email',
						'placeholder'	=> 'email.address@domain.com',
					),
					'month'			=> array(
						'title'			=> __( 'Month', 'dummy-theme' ),
						'type'			=> 'month',
						'value'			=> 'now',
					),
					'number'		=> array(
						'title'			=> __( 'Number', 'dummy-theme' ),
						'type'			=> 'number',
						'value'			=> 42,
					),
					'password'		=> array(
						'title'			=> __( 'Password', 'dummy-theme' ),
						'type'			=> 'password',
					),
					'search'		=> array(
						'title'			=> __( 'Search', 'dummy-theme' ),
						'type'			=> 'search',
						'placeholder'	=> __( 'Keywords or terms&hellip;', 'dummy-theme' ),
					),
					'tel'			=> array(
						'title'			=> __( 'Telephone', 'dummy-theme' ),
						'type'			=> 'tel',
						'placeholder'	=> '(555) 555-5555',
					),
					'time'			=> array(
						'title'			=> __( 'Time', 'dummy-theme' ),
						'type'			=> 'time',
						'value'			=> 'now',
					),
					'url'			=> array(
						'title'			=> __( 'URL', 'dummy-theme' ),
						'type'			=> 'url',
						'placeholder'	=> 'http://jeremyhixon.com',
					),
					'week'			=> array(
						'title'			=> __( 'Week', 'dummy-theme' ),
						'type'			=> 'week',
						'value'			=> 'now',
					),
				),
			),
			'section-two'	=> array(
				'title'			=> __( 'Non-standard Input', 'dummy-theme' ),
				'fields'		=> array(
					'checkbox'		=> array(
						'title'			=> __( 'Checkbox', 'dummy-theme' ),
						'type'			=> 'checkbox',
						'text'			=> __( 'Text attributes are used as labels for checkboxes' ),
					),
					'color'			=> array(
						'title'			=> __( 'Color', 'dummy-theme' ),
						'type'			=> 'color',
						'value'			=> '#cc0000',
					),
					'media'			=> array(
						'title'			=> __( 'Media', 'dummy-theme' ),
						'type'			=> 'media',
						'value'			=> 'http://your-domain.com/wp-content/uploads/2016/01/sample.jpg',
					),
					'radio'			=> array(
						'title'			=> __( 'Radio', 'dummy-theme' ),
						'type'			=> 'radio',
						'value'			=> 'option-two',
						'choices'		=> array(
							'option-one'	=> __( 'Option One', 'dummy-theme' ),
							'option-two'	=> __( 'Option Two', 'dummy-theme' ),
						),
					),
					'range'			=> array(
						'title'			=> __( 'Range', 'dummy-theme' ),
						'type'			=> 'range',
						'value'			=> 75,
					),
					'select'		=> array(
						'title'			=> __( 'Select', 'dummy-theme' ),
						'type'			=> 'select',
						'value'			=> 'option-two',
						'choices'		=> array(
							'option-one'	=> __( 'Option One', 'dummy-theme' ),
							'option-two'	=> __( 'Option Two', 'dummy-theme' ),
						),
					),
					'select-multiple'		=> array(
						'title'			=> __( 'Select multiple', 'dummy-theme' ),
						'type'			=> 'select',
						'value' => array(
							'option-two'
						),
						'choices' => array(
							'option-one' => __( 'Option One', 'dummy-theme' ),
							'option-two' => __( 'Option Two', 'dummy-theme' ),
							'option-three' => __( 'Option Three', 'dummy-theme' ),
						),
						'attributes' => array(
							'multiple' => 'multiple'
						),
						'sanitize' => true
					),
					'textarea'		=> array(
						'title'			=> __( 'Textarea', 'dummy-theme' ),
						'type'			=> 'textarea',
						'value'			=> 'Pellentesque consectetur volutpat lectus, ac molestie lorem molestie nec. Vestibulum in auctor massa. Vivamus convallis nunc quis lacus maximus, non ultricies risus gravida. Praesent ac diam imperdiet, volutpat nisi sed, semper eros. In nec orci hendrerit, laoreet nunc eu, semper magna. Curabitur eu lorem a enim sodales consequat. Vestibulum eros nunc, congue sed blandit in, maximus eu tellus.',
					),
					'wp_editor'		=> array(
						'title'			=> __( 'WP Editor', 'dummy-theme' ),
						'type'			=> 'wp_editor',
						'value'			=> 'Pellentesque consectetur volutpat lectus, ac molestie lorem molestie nec. Vestibulum in auctor massa. Vivamus convallis nunc quis lacus maximus, non ultricies risus gravida. Praesent ac diam imperdiet, volutpat nisi sed, semper eros. In nec orci hendrerit, laoreet nunc eu, semper magna. Curabitur eu lorem a enim sodales consequat. Vestibulum eros nunc, congue sed blandit in, maximus eu tellus.',
					),
				),
			),
		),
	),
);

$option_page = new RationalOptionPages( $pages );


/**
 * Add a dashboard widget.
 */
function dummy_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'dummy_dashboard_widget',                          // Widget slug.
        esc_html__( 'Thanks for downloading!', 'wporg' ), // Title.
        'dummy_dashboard_widget_render'                    // Display function.
    ); 
}
add_action( 'wp_dashboard_setup', 'dummy_add_dashboard_widgets' );

function dummy_dashboard_widget_render() {
    // Display whatever you want to show.
    esc_html_e( "A custom dashboard widget is a great way to convey tidbits of information. I like using them to list my contact information for clients to keep on hand. Check out my website: www.jvkrakowski.com", "dummy" );
}

// add pending review post status 

if ( ! function_exists('pending_review_status') ) {

	// Register Custom Status
	function pending_review_status() {
	
		$args = array(
			'label'                     => _x( 'Pending', 'Status General Name', 'dummy-theme' ),
			'label_count'               => _n_noop( 'Pending (%s)',  'Pending (%s)', 'dummy-theme' ), 
			'public'                    => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => true,
		);
		register_post_status( 'pending', $args );
	
	}
	add_action( 'init', 'pending_review_status', 0 );
	

	
	
	}