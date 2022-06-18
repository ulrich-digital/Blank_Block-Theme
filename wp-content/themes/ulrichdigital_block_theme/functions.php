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


	$gsdu = get_stylesheet_directory_uri() . "/assets/js/";
	$gtd = get_template_directory() . "/assets/js/";
	
	//$path_h0 = 'jquery-ui.min.js';
	$path_h1 = 'gsap.min.js';
    $path_h2 = 'ScrollTrigger.min.js';
    $path_h3 = 'MorphSVGPlugin.min.js';
	$path_h4 = 'SplitText.min.js';
	$path_h4b = 'TextPlugin.min.js';
    $path_h5 = 'ulrich_digital.js';
	$path_h6 = 'jquery.validate.min.js';
	$path_h7 = 'slick.min.js';

    //wp_enqueue_script( 'eigener_Name', pfad_zum_js, abhaengigkeit (zb jquery zuerst laden), versionsnummer, bool (true=erst im footer laden) );
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'gsap',  $gsdu . $path_h1, array('jquery'), filemtime( $gtd. $path_h1 ), false );
	wp_enqueue_script( 'ulrich_digital',  $gsdu . $path_h5, array('jquery', 'gsap'), filemtime( $gtd. $path_h5 ), false );
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
