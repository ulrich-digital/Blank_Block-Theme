<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php ud_schema_type(); ?>>

<head>
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
    <?php header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    ?>
    <!--
    <meta http-equiv="content-language" content="de">
-->
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

    <?php wp_head(); ?>

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
    
    
    <!-- DEV -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">

</head>
<?php 
$cursor_url = get_template_directory_uri() . "/images/cursor_round.png";
//cursor: url(/wp-content/uploads/2020/06/cursor-round.png),auto!important;

$my_body_classes = "";



/* =============================================================== *\ 
 	 Farbschema wählen 
\* =============================================================== */ 

// Farbschema aus Pages wählen
if(get_field("farbschema_wahlen")):
    $my_body_classes = get_field("farbschema_wahlen");
    $my_body_classes = $my_body_classes . " ";
endif;



$my_color_scheme = "";
// Farbschema bei Single wählen
if( is_single() || is_tag() || is_archive() || is_search()):
    if("post" == get_post_type()):
        $my_color_scheme = "color_scheme_" . get_option('color_scheme_for_posts'). " ";
    elseif("projekt" == get_post_type()):
        $my_color_scheme = "color_scheme_" . get_option('color_scheme_for_projects'). " ";
    elseif(is_search() == true):
        $my_color_scheme = "color_scheme_" . get_option('color_scheme_for_search_results'). " ";
        
    endif;
endif;

$my_body_classes .= $my_color_scheme;
?>

<body <?php body_class($my_body_classes); ?>>
    <?php wp_body_open(); ?>

<?php // Beim Farbschema SKY div einfügen
if( ('color_scheme_parrot ' == $my_body_classes) || ("color_scheme_sky " == $my_body_classes) ): ?>
    <div class="sky"></div>
<?php endif;
?>

    <div id="wrapper" class="hfeed">
        <div class="header-wrapper">
            <header id="header">
                <div id="branding">
                    <div id="site-title">
                        <?php if (is_front_page() || is_home() || (is_front_page() && is_home())) {
                            echo '<h1>';
                        } ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_html(get_bloginfo('name')); ?>" rel="home">
                        <?php echo esc_html(get_bloginfo('name')); ?></a>
                        <?php if (is_front_page() || is_home() || (is_front_page() && is_home())) {
                            echo '</h1>';
                        } ?>
                    </div>
                    <div id="site-description"><?php bloginfo('description'); ?></div>
                </div>
                <!-- wp:navigation {"ref":2486} /-->
            
                <!-- wp:navigation {"layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right"}} -->
<!--
                <nav id="main_menu_container" class="menu">            
                    <button class="hamburger hamburger--slider" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>  
                    <?php 
                    wp_nav_menu(array(
                        'container' => '', // ohne Container
                        'theme_location'  => 'main-menu',
                        'menu_id' => 'main_menu',
                        'menu_class' => 'animate__slideOutRight',
                        
                        )); ?>
                </nav>
-->            
            </header>
        </div><!-- .header-wrapper -->
        <div id="container">