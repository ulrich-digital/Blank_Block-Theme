<?php 
if ( ! function_exists( 'ud_theme_support' ) ) :
	function ud_theme_support() {
		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );
		
		
		add_editor_style(
			array(
				'style-shared.css',
				'style-admin.css'
			)
		);
		//style-shared.css
		//style-admin.css
	}
endif;
add_action( 'after_setup_theme', 'ud_theme_support' );



function ud_blocks_enqueue_styles() {
	wp_enqueue_style( 'ud-blocks-style-shared', get_template_directory_uri() . '/style-shared.css', array(), wp_get_theme()->get( 'Version' ) );
	//wp_enqueue_style( 'tt1-blocks-blocks', get_template_directory_uri() . '/assets/css/blocks.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'ud_blocks_enqueue_styles' );


/* =============================================================== *\

 	 Frontend

\* =============================================================== */

/* =============================================================== *\
 	 Frontend JavaScripts + CSS
\* =============================================================== */

function ud_enqueue_frontend_scripts(){
	//wp_enqueue_style( 'main', get_stylesheet_directory_uri() . "/style.css", [], filemtime( get_stylesheet_directory() . "/style.css" ) );
	wp_enqueue_style('font_awesome', get_stylesheet_directory_uri() . '/css/all.css', [], filemtime( get_stylesheet_directory() . "/css/all.css" ) );
	wp_enqueue_style('slick_slider', get_stylesheet_directory_uri() . '/css/slick.min.css', [], filemtime( get_stylesheet_directory() . "/css/slick.min.css" ) );
	//wp_enqueue_style('slick_theme', get_stylesheet_directory_uri() . '/css/slick-theme.min.css', [], filemtime( get_stylesheet_directory() . "css/slick-theme.min.css" ) );

    /*
    wp_register_style('slick',  get_stylesheet_directory_uri() . '/css/slick.min.css', array(), '1.0', 'all');
    wp_register_style('slick-theme',  get_stylesheet_directory_uri() . '/css/slick-theme.min.css', array(), '1.0', 'all');
    */

	$gsdu = get_stylesheet_directory_uri();
	$gtd = get_template_directory();
	
	$path_h0 = '/js/jquery-ui.min.js';
	$path_h1 = '/js/gsap.min.js';
    $path_h2 = '/js/ScrollTrigger.min.js';
    $path_h3 = '/js/MorphSVGPlugin.min.js';
	$path_h4 = '/js/SplitText.min.js';
	$path_h4b = '/js/TextPlugin.min.js';
    $path_h5 = '/js/ulrich_digital.js';
	$path_h6 = '/js/jquery.validate.min.js';
	$path_h7 = '/js/slick.min.js';

    //wp_enqueue_script( 'eigener_Name', pfad_zum_js, abhaengigkeit (zb jquery zuerst laden), versionsnummer, bool (true=erst im footer laden) );
	wp_enqueue_script('jquery');
	/*wp_enqueue_script( 'jquery_ui', $gsdu . $path_h0, array('jquery'), filemtime( $gtd. $path_h0 ), false );
	wp_enqueue_script( 'gsap', $gsdu . $path_h1, array('jquery'), filemtime( $gtd. $path_h1 ), true );
	wp_enqueue_script( 'scrollTrigger',  $gsdu . $path_h2, array('jquery'), filemtime( $gtd. $path_h2 ), true );
	wp_enqueue_script( 'MorphSVGPlugin',  $gsdu . $path_h3, array('jquery'), filemtime( $gtd. $path_h3 ), true );
	wp_enqueue_script( 'SplitText', $gsdu . $path_h4, array('jquery'), filemtime( $gtd. $path_h4 ), true );
	wp_enqueue_script( 'TextPlugin', $gsdu . $path_h4b, array('jquery'), filemtime( $gtd. $path_h4b ), true );
	*/
	wp_enqueue_script( 'ulrich_digital',  $gsdu . $path_h5, array('jquery'),1, true );
	/*wp_enqueue_script( 'jquery_validate', $gsdu . $path_h6, array('jquery'), filemtime( $gtd. $path_h6 ), true );
	wp_enqueue_script( 'slick_slider', $gsdu . $path_h7, array('jquery'), filemtime( $gtd. $path_h7 ), true );
*/
}
add_action('wp_enqueue_scripts', 'ud_enqueue_frontend_scripts');








/* =============================================================== *\
   add schema links
   > header.php
\* =============================================================== */

function ud_schema_type(){
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . $schema . $type . '"';
}

?>