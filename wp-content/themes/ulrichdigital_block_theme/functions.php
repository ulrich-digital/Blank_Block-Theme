<?php
/* =============================================================== *\
   WP-Head
\* =============================================================== */

add_action('wp_head', function(){ ?>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta name="robots" content="index, follow">

	<!-- Standard SEO -->
	<!--
	<meta name="zipcode" content="6430">
	<meta name="city" content="Schwyz">
	<meta name="country" content="CH">
	<meta name="author" content="ulrich.digital">
	<meta name="publisher" content="Matthias Ulrich">
	<meta name="copyright" content="ulrich.digital">
	<meta name="keywords" content="Webagentur, Webdesign, Website, Internetagentur, Webseite, Design, Schwyz">
	<meta name="title" content="ulrich.digital | Hier entsteht ihre Webseite" />
	<meta name="description" content="Agentur für Webdesign, WordPress, WooCommerce, Online Shops und SEO | Digitalagentur & Webagentur Schwyz | Hier entsteht Ihre Webseite.">
	<meta name="page-topic" content="Webdesign, Webentwicklung, Wordpress-Agentur">
	<meta name="page-type" content="Produktinfo">
	<meta name="audience" content="Profis">
	-->

	<!-- Dublin Core basic info -->
	<!--
	<meta name="DC.Creator" content="ulrich.digital">
	<meta name="DC.Publisher" content="Matthias Ulrich">
	<meta name="DC.Rights" content="ulrich.digital">
	<meta name="DC.Description" content="Webagentur für Webdesign, WordPress, WooCommerce, Online Shops und SEO | Digitalagentur & Webagentur Schwyz | Hier entsteht Ihre Webseite mit ♥">
	<meta name="DC.Language" content="de">
	-->
	<!-- Facebook OpenGraph -->
	<!--
	<meta property="og:type" content="website" />
	<meta property="og:locale" content="de_DE" />
	<meta property="og:title" content="ulrich.digital | Hier entsteht Ihre Webseite" />
	<meta property="og:description" content="Wollen Sie ultimatives Motorräder-Fahrgefühl und einen starken Partner an Ihrer Seite? Kommen Sie bei uns in Ebikon, Luzern vorbei." />
	<meta property="og:site_name" content="ulrich.digital" />
	-->
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
   Google-Analytics only on LiveSite
\* =============================================================== */
if("https://HIER_DIE_LIVE_SITE_URL_EINTRAGEN" == get_home_url()):
	add_action( 'wp_head', 'add_google_analytics_tag');
endif;

function add_google_analytics_tag(){ ?>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HD9HZ7TQTN"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-HD9HZ7TQTN');
	</script>
<?php }

/* =============================================================== *\
   Add Core-Block-Styles
\* =============================================================== */
if ( ! function_exists( 'uldi_add_block_styles' ) ) :
	function uldi_add_block_styles() {
		add_theme_support( 'wp-block-styles' );
	}
endif;
//add_action( 'after_setup_theme', 'uldi_add_block_styles' );

/* =============================================================== *\
   Add Admin-Styles
\* =============================================================== */
if ( ! function_exists( 'uldi_admin_style' ) ) :
	function uldi_admin_style() {
		wp_enqueue_style('admin-styles', get_template_directory_uri().'/style-admin.css');
	}
endif;
add_action('admin_enqueue_scripts', 'uldi_admin_style');

/* =============================================================== *\
   Custom Admin-Logo
\* =============================================================== */
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/BG_logo_rgb.svg);
            padding-bottom: 60px;
            width:320px;
            background-repeat: no-repeat;
            background-size: 250px auto;
        }
    </style>
<?php }

/* =============================================================== *\ 
   Custom Admin-Logo link to Home URL 
\* =============================================================== */

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/* =============================================================== *\
 	 Custom-Logo
\* =============================================================== */
  //add_theme_support( 'custom-logo' );
  function uldi_custom_logo_setup() {
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
add_action( 'after_setup_theme', 'uldi_custom_logo_setup' );

function get_custom_logo_callback( $html ) {
    if ( has_custom_logo() ) {
        return $html;
    } else {
        return '<h3>Logo</h3>';
    }
}
add_filter( 'get_custom_logo', 'get_custom_logo_callback' );


/* =============================================================== *\
   Add Backend Scripts
\* =============================================================== */
function uldi_enqueue_backend_scripts(){
	$gsdu = get_stylesheet_directory_uri() . "/assets/js/";
	$gtd = get_template_directory() . "/assets/js/";

	//$path_h0 = 'jquery-ui.min.js';
    $path_h1 = 'customize_editor.js';
    $path_h4 = 'ulrich_admin.js';

    //wp_enqueue_script( 'eigener_Name', pfad_zum_js, abhaengigkeit (zb jquery zuerst laden), versionsnummer, bool (true=erst im footer laden) );
	wp_enqueue_script( 'customize_editor',  $gsdu . $path_h1, array('jquery'), filemtime( $gtd. $path_h1 ), true );
	wp_enqueue_script( 'ulrich_admin',  $gsdu . $path_h4, array('jquery'), filemtime( $gtd. $path_h4 ), true );
}
add_action( "admin_enqueue_scripts", 'uldi_enqueue_backend_scripts');



/* =============================================================== *\
   Add custom image sizes
\* =============================================================== */

function ud_add_custom_image_sizes() {
	//add_image_size('footer_neufahrzeuge_slider_medium', 800, 600, true);
	//add_image_size('footer_neufahrzeuge_slider_full', 1200, 900, true);
	//add_image_size('neufahrzeuge_loop_medium', 400, 300, true);
}
add_action('after_setup_theme', 'ud_add_custom_image_sizes', 11);




/* =============================================================== *\ 
   Add custom image sizes to backend choose
\* =============================================================== */

function ud_add_custom_image_sizes_to_backend_choose($sizes) {
    $custom_sizes = array(
        'footer_neufahrzeuge_slider_medium' => __('Footer Neufahrzeuge Slider Medium', 'uldi')
        );
    return array_merge($sizes, $custom_sizes);
}
//add_filter('image_size_names_choose', 'ud_add_custom_image_sizes_to_backend_choose');


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
   Regenerate image sizes
\* =============================================================== */
/*
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Put the function in a class to make it more extendable
class GB_regen_media {
    public function gb_regenerate($imageId) {
        $imagePath = wp_get_original_image_path($imageId);
        if ($imagePath && file_exists($imagePath)) {
            wp_generate_attachment_metadata($imageId, $imagePath);
        }
    }
}

function ud_regen_load() {
	$gb_regen_media = new GB_regen_media();
	//$i = imageID
	for($i = 32; $i <= 315; $i++):
		$gb_regen_media->gb_regenerate($i);
	endfor;
}*/
// add_action('init', 'ud_regen_load');


/* =============================================================== *\
   Disable Comments
\* =============================================================== */
/*
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
*/

/* =============================================================== *\
   Clean Up WP-Admin-Bar
\* =============================================================== */
/*
function example_admin_bar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
    $wp_admin_bar->remove_menu( 'comments' );
    $wp_admin_bar->remove_menu( 'new-content' );
    $wp_admin_bar->remove_menu( 'archive' );
       
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );
*/


/* =============================================================== *\ 
   Remove Admin-Menu-Elements
\* =============================================================== */ 
/*
function ud_remove_menus () {
	global $menu;
	$restricted = array(__('Beiträge'), __('Kommentare'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
			unset($menu[key($menu)]);
		}
	}
}
add_action('admin_menu', 'ud_remove_menus');
*/


/* =============================================================== *\
   Custom-Post-Types
\* =============================================================== */
/*add_action('init','ud_register_post_type_neufarzeuge');
function ud_register_post_type_neufarzeuge(){
	$supports = array('title', 'editor', 'thumbnail','post-thumbnails', 'custom-fields', 'revisions');
	$labels = array(
		'menu_name' => 'Neufahrzeuge',
	    'name' => 'Neufahrzeuge',
	    'add_new' => 'Neufahrzeug hinzuf&uuml;gen',
	    'add_new_item' => 'Neufahrzeuge hinzuf&uuml;gen',
		'edit_item' => 'Neufahrzeuge bearbeiten',
		'new_item' => 'Neues Neufahrzeug',
		'view_item' => 'Neufahrzeug anzeigen',
		'search_items' => 'Neufahrzeug suchen',
		'not_found' => 'Kein Neufahrzeug gefunden',
		'not_found_in_trash' => 'Kein Neufahrzeug im Papierkorb',
		);
	$neufahrzeuge_args = array(
	    'supports' => $supports,
	    'labels' => $labels,
	    'description' => 'Post-Type f&uuml;r Neufahrzeuge',
	    'public' => true,
	    'show_in_nav_menus' => true,
	    'show_in_menu' => true,
		'show_in_rest' => true,
	    'has_archive' => true,
	    'query_var' => true,
		'menu_icon' => 'dashicons-bell',
	    'taxonomies' => array('topics', 'category'),
	    'rewrite' => array(
	        'slug' => 'neufahrzeug',
	        'with_front' => true
	   		),
		);
	register_post_type('neufahrzeug', $neufahrzeuge_args);
}
*/

/* =============================================================== *\ 
   Add Custom Block Category to Inserter
\* =============================================================== */
/*
add_filter('block_categories_all', function ($categories) {
    $new_categories = array();
    $new_categories[] = array(
        'slug'  => 'here-comes-the-slug',
        'title' => 'Here comes the Title'
    );
    foreach($categories as $single_categorie):
        $new_categories[] = $single_categorie; // add WP Core default categories
    endforeach;
    return $new_categories;
});
*/
/* =============================================================== *\

   ACF

\* =============================================================== */
/* =============================================================== *\
   ACF-Option Page
\* =============================================================== */
/*
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page();
}
*/

/* =============================================================== *\
   ACF - Blocks
\* =============================================================== */
/*
function uldi_load_blocks(){
	register_block_type(dirname(__FILE__) . '/blocks/acf_seiltrenner');
	//wp_register_style('block-tip', get_template_directory_uri() . '/blocks/acf_seiltrenner.css');
}
add_action('acf/init', 'uldi_load_blocks');
*/

/* =============================================================== *\
   ???
\* =============================================================== */
/*
add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field');
function add_default_value_to_image_field($field) {
	acf_render_field_setting( $field, array(
		'label'			=> 'Default Image',
		'instructions'		=> 'Appears when creating a new post',
		'type'			=> 'image',
		'name'			=> 'default_value',
	));
}
*/

/* =============================================================== *\
   Add ACF Form Head
\* =============================================================== */
/*
add_action( 'init', 'uldi_add_acf_form_head', 10, 1 );
function uldi_add_acf_form_head(){
	if(!is_admin()){
		// wird bei allen Seiten geladen, keine andere Lösung möglich
		acf_form_head();
	}
}
*/

/* =============================================================== *\
   ACF Form
   Overwrite dummy Form-Fields
\* =============================================================== */
/*
function find_the_ID(){
	if (defined('NEUFAHRZEUG_ID')):
    	$post_id = NEUFAHRZEUG_ID;
	else:
		$post_id = get_the_ID();
	endif;
	return $post_id;
}

// Marke
function modify_marke_field($field){
	$blocks = parse_blocks( get_the_content(find_the_ID()) );
	foreach ( $blocks as $block ) :
		if ( 'acf/neufahrzeug-short-card' === $block['blockName'] ) {
			$marke = $block['attrs']['data']['marke'];
			$field['value'] = $marke;
		}
	endforeach;
    return $field;
}
add_filter('acf/prepare_field/key=field_62bdc77f826bd', 'modify_marke_field');
*/



/* =============================================================== *\
   ACF Repeater to array
   https://wphave.de/acf-block-repeater-daten-ohne-acf-funktion/
\* =============================================================== */
/*
// ohne ID
if ( ! function_exists( 'get_acf_block_repeater_with_id' ) ) :
	function get_acf_block_repeater_with_id( $block_name, $repeater_key, $sub_fields, $post_id ) {
		$build_beautiful_array = array();
		$repeater_value = get_acf_block_setting_with_id( $block_name, $repeater_key, $post_id );
		if( $repeater_value ) {
			for( $i=0; $i < $repeater_value; $i++ ) {
				foreach( $sub_fields as $sub_field => $sub_field_value ):
					if( array_key_exists( $sub_field, $sub_fields ) ) {
						$meta_key = $repeater_key . '_' . $i . '_' . $sub_field_value;
						$sub_field_meta = get_acf_block_setting_with_id( $block_name, $meta_key, $post_id );
						if( isset( $sub_field_meta ) ) {
							$build_beautiful_array[$i][$sub_field_value] = $sub_field_meta;
						}
					}
				endforeach;
			}
			return $build_beautiful_array;
		}
	}
endif;

// mit ID
if ( ! function_exists( 'get_acf_block_setting_with_id' ) ) :
	function get_acf_block_setting_with_id( $block_name, $option_name, $post_id ) {

		$post = get_post( $post_id );
		$blocks = parse_blocks( $post->post_content );
		foreach( $blocks as $block ) {
			if( $block['blockName'] !== $block_name ) {
				continue;
			}
			if( $block['blockName'] === $block_name ) {
				if( isset( $block['attrs']['data'][$option_name] ) ) {
					return $block['attrs']['data'][$option_name];
				}
			}
		}
		return;
	}
endif;
*/

/* =============================================================== *\
   ACF ID Hack
\* =============================================================== */
/*
function acf_id_hack($block){
	if(!array_key_exists('id', $block)):
		$block['id'] = 1;
		if(array_key_exists('id', $block['attrs'])):
			$block['id'] = $block['attrs']['id'];
		endif;
	endif;
	return($block);
}
*/

/* =============================================================== *\
   Block-Variations
\* =============================================================== */
/*
function prefix_editor_assets() {
	wp_enqueue_script(
		'prefix-block-variations',
		get_template_directory_uri() . '/assets/block-variations.js',
		array( 'wp-blocks' )
	);
}
add_action( 'enqueue_block_editor_assets', 'prefix_editor_assets' );
*/

/* =============================================================== *\
   Block-Styles
\* =============================================================== */
/*
if (function_exists('register_block_style')) {
    register_block_style(
        'core/media-text',
        array(
            'name'         => 'personal',
            'label'        => 'Patrick stellt sich vor',
        )
    );
}
*/
/* =============================================================== *\
   Block-Pattern
\* =============================================================== */

/* =============================================================== *\
   Page-Template
\* =============================================================== */
/*
function block_template_neufahrzeug() {
	$page_type_object = get_post_type_object( 'neufahrzeug' );
	$page_type_object->template = [
		['acf/impression-images'],
		['acf/neufahrzeug-short-card'],
		['acf/anfragebutton'],
		['core/spacer',['height'=>'10vh']],
		['core/heading',[
			'textAlign' => 'center',
			'placeholder' => "Titel",
			]
		],
		['core/paragraph',['placeholder' => "Short Text"]],
		['acf/model-images'],
		['core/paragraph',['placeholder' => "Short Text"]],
		['acf/neufahrzeug-goodies'],
		['core/paragraph',['placeholder' => "Short Text"]],
		['acf/goodie-images'],
		['core/paragraph',['placeholder' => "Short Text"]],
		['core/spacer',['height'=>'10vh']],
		['acf/anfragebutton'],
		['acf/neufahrzeug-footer-fahrzeuge'],
	];
}
add_action( 'init', 'block_template_neufahrzeug' );
*/

/* =============================================================== *\ 
   Allowed-Blocks
\* =============================================================== */
function whitelist_blocks() {
    return array(
        'acf/slick-slider',
        'acf/touren_auf_startseite',
        'acf/seiltrenner',
        //'acf/seiltrennerheader',
        //'core/archives',
        'core/block',
        //'core/calendar',
        //'core/categories',
        //'core/latest-comments',
        //'core/latest-posts',
        //'core/rss',
        //'core/search',
        //'core/shortcode',
        //'core/social-link',
        //'core/tag-cloud',
        //'core/audio',
        'core/button',
        'core/buttons',
        //'core/freeform',
        //'core/code',
        'core/column',
        'core/columns',
        'core/file',
        //'core/gallery',
        'core/group',
        'core/heading',
        //'core/html',
        //'core/image',
        'core/list',
        'core/list-item',
        'core/media-text',
        //'core/missing',
        //'core/more',
        //'core/nextpage',
        'core/paragraph',
        //'core/preformatted',
        //'core/pullquote',
        //'core/quote',
        //'core/separator',
        //'core/social-links',
        'core/spacer',
        //'core/subhead',
        //'core/table',
        //'core/text-columns',
        //'core/verse',
        //'core/video',
        //'core-embed/youtube',
    );
}
//add_filter('allowed_block_types_all', 'whitelist_blocks');
/* =============================================================== *\

 	 Frontend

\* =============================================================== */

/* =============================================================== *\
   Add Frontend JavaScripts
   Add Frontend CSS
\* =============================================================== */

function ud_enqueue_frontend_scripts(){
    //wp_dequeue_style('global-styles'); // Core-Block-Styles entfernen Achtung, entfernt auch Schrift über theme.json
    // wp_dequeue_style( 'wp-block-columns' ); // einzelne Core-Block-Styles entfernen
    // wp_dequeue_style('wp-block-column');

	//wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Rubik:ital,wght@0,400;0,500;0,700;1,400;1,500;1,600&display=swap', false );
	wp_enqueue_style( 'ud-style-frontend', get_template_directory_uri() . '/style-frontend.css', array(), wp_get_theme()->get( 'Version' ) );
	//wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.css', array(), wp_get_theme()->get( 'Version' ) );
	//wp_enqueue_style( 'main', get_stylesheet_directory_uri() . "/style.css", [], filemtime( get_stylesheet_directory() . "/style.css" ) );
	//wp_enqueue_style('slick_slider', get_stylesheet_directory_uri() . '/assets/slick/slick.min.css', [], filemtime( get_stylesheet_directory() . "/css/slick.min.css" ) );
	//wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/bootstrap-3.4.1/css/bootstrap.min.css', [], filemtime( get_stylesheet_directory() . "/assets/bootstrap-3.4.1/css/bootstrap.min.css" ) );
	//wp_enqueue_style('bootstrap-slider', get_stylesheet_directory_uri() . '/css/bootstrap-slider.min.css', [], filemtime( get_stylesheet_directory() . "/css/bootstrap-slider.min.css" ) );

	$gsdu = get_stylesheet_directory_uri() . "/assets/js/";
	$gtd = get_template_directory() . "/assets/js/";
	//$gsdu_bootstrap = get_stylesheet_directory_uri() . "/assets/bootstrap-3.4.1/js/";
	//$gtd_bootstrap = get_template_directory() . "/assets/bootstrap-3.4.1/js/";
	//$gsdu_bootstrap_slider = get_stylesheet_directory_uri() . "/assets/bootstrap-slider/";
	//$gtd_bootstrap_slider = get_template_directory() . "/assets/bootstrap-slider/";

	//$path_h0 = 'jquery-ui.min.js';
	//$path_h1 = 'isotope.pkgd.min.js';
	$path_h5 = 'ulrich_digital.js';
	//$path_h6 = 'jquery.validate.min.js';
	//$path_h7 = 'slick.min.js';
	//$path_h8 = 'bootstrap.min.js'; // Für Filter-Range
	//$path_h9 = 'bootstrap-slider.min.js'; // für Filter-Range

    //wp_enqueue_script( 'eigener_Name', pfad_zum_js, abhaengigkeit (zb jquery zuerst laden), versionsnummer, bool (true=erst im footer laden) );
	wp_enqueue_script('jquery');
	//wp_enqueue_script( 'gsap',  $gsdu . $path_h1, array('jquery'), filemtime( $gtd. $path_h1 ), false );
	//wp_enqueue_script( 'isotope',  $gsdu . $path_h1, array('jquery'), filemtime( $gtd. $path_h1 ), false );
	//wp_enqueue_script( 'slick',  $gsdu . $path_h7, array('jquery'), filemtime( $gtd. $path_h7 ), false );

	//wp_enqueue_script( 'bootstrap',  $gsdu_bootstrap . $path_h8, array('jquery'), filemtime( $gtd_bootstrap. $path_h8 ), true );
	//wp_enqueue_script( 'bootstrap-slider',  $gsdu_bootstrap_slider . $path_h9, array('jquery'), filemtime( $gtd_bootstrap_slider. $path_h9 ), true );

	// Dummy-Block
	wp_enqueue_script('block_dummy',  get_stylesheet_directory_uri() . "/blocks/dummy-block/dummy.js", array('jquery'), filemtime(get_template_directory() . "/blocks/dummy-block/dummy.js"), true);

	
	wp_enqueue_script( 'ulrich_digital',  $gsdu . $path_h5, array('jquery'), filemtime( $gtd. $path_h5 ), true );
}
add_action('wp_enqueue_scripts', 'ud_enqueue_frontend_scripts');


/* =============================================================== *\
   Umlaute umwandeln
\* =============================================================== */
/*if ( ! function_exists( 'umlauteumwandeln' ) ) :
	function umlauteumwandeln($str){
		$tempstr = Array("Ä" => "AE", "Ö" => "OE", "Ü" => "UE", "ä" => "ae", "ö" => "oe", "ü" => "ue");
		return strtr($str, $tempstr);
	}
endif;
*/

/* =============================================================== *\ 
   Title
\* =============================================================== */
if(!is_admin()):
    add_filter('body_class', function ($classes) {
        return array_merge($classes, array('is_frontend'));
    });
endif;
?>
