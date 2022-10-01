<?php 

/* =============================================================== *\ 

 	 Titel 

\* =============================================================== */ 
  

$classes = ['block_teammitglied'];
if( !empty( $block['className'] ) )
    $classes = array_merge( $classes, explode( ' ', $block['className'] ) );

$anchor = '';
if( !empty( $block['anchor'] ) )
	$anchor = ' id="' . sanitize_title( $block['anchor'] ) . '"';

$allowed_blocks = array( 'core/heading', 'core/image' );

$template = array(
	array('core/image'),
	array('core/heading', array(
		'level' => 2,
		'content' => 'Vorname und Name',
	)),
	array('core/heading', array(
		'level' => 3,
		'content' => 'Funktion',
	)),
	
);

echo '<div class="' . join( ' ', $classes ) . '"' . $anchor . '>';
	echo '<InnerBlocks allowedBlocks="' . esc_attr( wp_json_encode( $allowed_blocks ) ) . '" template="' . esc_attr( wp_json_encode( $template ) ) . '" />';
	$form_id = get_option( 'options_be_release_info_form' );
	if( !empty( $form_id ) && function_exists( 'wpforms_display' ) )
		wpforms_display( $form_id, true, true );
echo '</div>';
?>