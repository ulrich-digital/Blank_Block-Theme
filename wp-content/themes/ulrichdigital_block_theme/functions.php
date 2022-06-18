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

 	 Google Fonts 

\* =============================================================== */ 
  

add_action('wp_head', function(){ ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CXL7DFWQH9"></script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-CXL7DFWQH9');
    </script>
	
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	

	<meta name="zipcode" content="6430">
	<meta name="city" content="Schwyz">
	<meta name="country" content="CH">

	<meta name="author" content="ulrich.digital">
	<meta name="publisher" content="Matthias Ulrich">
	<meta name="copyright" content="ulrich.digital">
	<meta name="keywords" content="Webagentur, Webdesign, Website, Internetagentur, Webseite, Design, Schwyz">
	<meta name="page-topic" content="Dienstleistung">
	<meta name="page-type" content="Produktinfo">
	<meta name="audience" content="Profis">
	<meta name="DC.Creator" content="ulrich.digital">
	<meta name="DC.Publisher" content="Matthias Ulrich">
	<meta name="DC.Rights" content="ulrich.digital">
	<meta name="DC.Description" content="Webagentur für Webdesign, WordPress, WooCommerce, Online Shops und SEO | Digitalagentur & Webagentur Schwyz | Hier entsteht Ihre Webseite mit ♥">
	<meta name="DC.Language" content="de">
	<meta name="robots" content="index, follow">
	<!--
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
	-->
	<?php
	
});

/* =============================================================== *\ 

 	 Custom-Logo 

\* =============================================================== */ 
  add_theme_support( 'custom-logo' );
  function themename_custom_logo_setup() {
    $defaults = array(
        'height'               => 100,
        'width'                => 400,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => false, 
    );
 
    add_theme_support( 'custom-logo', $defaults );
}
 
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );

function get_custom_logo_callback( $html ) {
    if ( has_custom_logo() ) {
        return $html;
    } else {
        return '<h3>Logo</h3>';
    }
}

add_filter( 'get_custom_logo', 'get_custom_logo_callback' );


/* =============================================================== *\
   Enable SVG
\* =============================================================== */

function ud_add_svg_to_upload_mimes($upload_mimes){
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
}
add_filter('upload_mimes', 'ud_add_svg_to_upload_mimes');
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
